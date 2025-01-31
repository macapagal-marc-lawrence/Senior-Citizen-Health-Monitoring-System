<?php
namespace App\Controllers;

use App\Models\HealthRecordModel;
use App\Models\HealthReportModel;
use App\Models\MedicationModel;
use App\Models\SeniorCaregiverModel;
use App\Models\MedicationHistoryModel;
use App\Models\HealthHistoryModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $userModel;
    protected $seniorCaregiverModel;
    protected $medicationHistoryModel;
    protected $healthHistoryModel;


    public function __construct()
    {
        // Initialize models
        $this->userModel = new UserModel();
        $this->seniorCaregiverModel = new SeniorCaregiverModel();
        $this->medicationHistoryModel = new MedicationHistoryModel(); 
        $this->healthHistoryModel = new HealthHistoryModel(); 
    }

    // Display the dashboard with user data
    public function dashboard()
{
    // Get the logged-in user ID from session
    $userId = session()->get('user')['id'];
    
    // Check if the user is logged in and if the role is admin
    if (!$userId || session()->get('user')['role'] != 'admin') {
        return redirect()->to('/login');
    }

    // Load the database connection
    $db = \Config\Database::connect();

    // Fetch the logged-in user's data using the ID
    $loggedInUser = $db->table('users')
        ->where('id', $userId)
        ->get()
        ->getRowArray();  // Get single row data as associative array

    if (!$loggedInUser) {
        return redirect()->to('/login');  // In case no user is found with the given ID
    }

    // Fetch all users to display on the admin dashboard
    $users = $db->table('users')->get()->getResultArray();  // Get users as an array

    // Calculate age for each user
    foreach ($users as &$user) {
        $user['age'] = $this->calculateAge($user['dob']);
    }

    // Return the view with required data
    return view('admin/adminDashboard', [
        'users' => $users,
        'totalUsers' => count($users),
        'seniorCitizensCount' => count(array_filter($users, fn($u) => $u['role'] == 'senior_citizen')),
        'caregiversCount' => count(array_filter($users, fn($u) => $u['role'] == 'caregiver')),
        'loggedInUser' => $loggedInUser,  // Pass logged-in user info to the view
    ]);
}

    // Calculate the age of the user
    private function calculateAge($dob)
    {
        $dob = new \DateTime($dob);
        $now = new \DateTime();
        $interval = $now->diff($dob);
        return $interval->y;
    }

    // Assign caregiver to senior citizen
    public function assignCaregiver($seniorId)
    {
        // Fetch the senior citizen's details
        $senior = $this->userModel->where('id', $seniorId)->where('role', 'senior_citizen')->first();

        // Check if the senior exists
        if (!$senior) {
            return redirect()->to('/admin/adminDashboard')->with('error', 'Senior citizen not found.');
        }

        // Fetch all caregivers
        $caregivers = $this->userModel->where('role', 'caregiver')->findAll();

        // Pass data to the view
        return view('admin/assignCaregiver', [
            'senior' => $senior,
            'caregivers' => $caregivers
        ]);
    }

    // Save caregiver assignment
    public function saveCaregiverAssignment()
    {
        // Retrieve the posted data
        $seniorId = $this->request->getPost('senior_id');
        $caregiverId = $this->request->getPost('caregiver_id');

        // Ensure both senior and caregiver are selected
        if (empty($seniorId) || empty($caregiverId)) {
            return redirect()->back()->with('error', 'Please select both a caregiver and senior citizen.');
        }

        // Check if the senior citizen exists in the users table
        $senior = $this->userModel->find($seniorId);

        if (!$senior || $senior['role'] != 'senior_citizen') {
            return redirect()->back()->with('error', 'Senior citizen not found.');
        }

        // Perform the update or insert operation for the senior_caregiver table
        // Check if the senior citizen is already assigned to a caregiver
        $existingAssignment = $this->seniorCaregiverModel->where('senior_id', $seniorId)->first();
        if ($existingAssignment) {
            // If the senior citizen is already assigned, show an error message
            return redirect()->back()->with('error', 'This senior citizen is already assigned to a caregiver.');
        }

        // Check how many seniors the caregiver is already assigned to
        $caregiverAssignments = $this->seniorCaregiverModel->where('caregiver_id', $caregiverId)->findAll();
        $caregiverAssignmentCount = count($caregiverAssignments);

        if ($caregiverAssignmentCount >= 3) {
            // If the caregiver already has 3 assignments, show an error message
            return redirect()->back()->with('error', 'This caregiver is already assigned to 3 senior citizens.');
        }

        // Now assign the caregiver to the senior citizen
        $this->seniorCaregiverModel->save(['senior_id' => $seniorId, 'caregiver_id' => $caregiverId]);
        session()->setFlashdata('success', 'Caregiver successfully assigned.');

        return redirect()->to('/admin/adminDashboard');
    }

    // Change caregiver for a senior citizen
    public function changeCaregiver($seniorId)
{
    // Get the current senior citizen's data
    $senior = $this->userModel->find($seniorId);
    
    // Get the current caregiver assigned to this senior citizen
    $currentCaregiver = $this->seniorCaregiverModel
        ->join('users', 'users.id = senior_caregiver.caregiver_id')
        ->where('senior_caregiver.senior_id', $seniorId)
        ->first();

    // Get all caregivers
    $caregivers = $this->userModel->where('role', 'caregiver')->findAll();

    // Get the number of seniors each caregiver is assigned to
    $caregiverAssignments = [];
    foreach ($caregivers as $caregiver) {
        $caregiverAssignments[$caregiver['id']] = $this->seniorCaregiverModel->where('caregiver_id', $caregiver['id'])->countAllResults();
    }

    // Pass the data to the view
    return view('admin/changeCaregiver', [
        'senior' => $senior,
        'caregivers' => $caregivers,
        'currentCaregiver' => $currentCaregiver,
        'caregiverAssignments' => $caregiverAssignments // Pass the assignment count to the view
    ]);
}


    // Save caregiver change
    public function saveCaregiverChange($seniorId)
{
    $newCaregiverId = $this->request->getVar('caregiver_id');
    
    // Check how many seniors the new caregiver is already assigned to
    $caregiverAssignments = $this->seniorCaregiverModel->where('caregiver_id', $newCaregiverId)->findAll();
    $caregiverAssignmentCount = count($caregiverAssignments);

    if ($caregiverAssignmentCount >= 3) {
        // If the caregiver already has 3 assignments, show an error message
        return redirect()->back()->with('error', 'This caregiver is already assigned to 3 senior citizens.');
    }

    // Update the caregiver for the senior citizen
    $db = \Config\Database::connect();
    
    // First, remove any existing caregiver assignments for this senior
    $db->table('senior_caregiver')->where('senior_id', $seniorId)->delete();
    
    // Assign the new caregiver
    $data = [
        'senior_id' => $seniorId,
        'caregiver_id' => $newCaregiverId
    ];
    $db->table('senior_caregiver')->insert($data);

    // Flash success message and redirect
    session()->setFlashdata('success', 'Caregiver updated successfully!');
    return redirect()->to('/admin/adminDashboard');
}

    // Edit a user
    public function edit($id)
    {
        $data['user'] = $this->userModel->where('id', $id)->first();

        // If user not found, redirect to the dashboard
        if (!$data['user']) {
            return redirect()->to('/admin/adminDashboard');
        }

        return view('admin/editUser', $data);
    }

    // Update user details
    public function update()
    {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $emergency_contact = $this->request->getVar('emergency_contact');
        $role = $this->request->getVar('role');
        $age = $this->request->getVar('age'); // Get age instead of dob

        // Calculate dob based on age
        $dob = date('Y-m-d', strtotime('-' . $age . ' years')); 

        // Prepare the query to update the user
        $db = \Config\Database::connect();
        $result = $db->query("UPDATE users SET name = ?, email = ?, emergency_contact = ?, role = ?, dob = ? WHERE id = ?", [$name, $email, $emergency_contact, $role, $dob, $id]);

        if ($result) {
            return redirect()->to('/admin/adminDashboard')->with('message', 'User updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Database update failed']);
        }
    }

    // Delete a user
    public function delete($id)
    {
        // Connect to the database
        $db = \Config\Database::connect();
    
        // First, remove all caregiver assignments for this senior citizen (if any)
        $db->table('senior_caregiver')->where('senior_id', $id)->delete();
        
        // Now, delete the user
        $this->userModel->delete($id);
    
        // Redirect to the admin dashboard with a success message
        return redirect()->to('/admin/adminDashboard')->with('message', 'User deleted successfully');
    }
    

    // Health reports view
    public function healthReports()
    {
        // Load the necessary models
        $healthReportModel = new HealthReportModel();
        $userModel = new UserModel();
        
        // Fetch all health reports
        $healthReports = $healthReportModel->findAll();
        
        // Process each report to add senior citizen names
        foreach ($healthReports as &$report) {
            $seniorCitizen = $userModel->find($report['user_id']);
            $report['senior_name'] = $seniorCitizen ? $seniorCitizen['name'] : 'Unknown';
        }
        
        // Pass data to the view
        return view('admin/healthReports', [
            'healthReports' => $healthReports,
        ]);
    }

    // Health reports view
    public function medicationReports()
    {
        // Load the necessary models
        $medicationReportModel = new MedicationModel();
        $userModel = new UserModel();
        
        // Fetch all health reports
        $medicationReports = $medicationReportModel->findAll();
        
        // Process each report to add senior citizen names
        foreach ($medicationReports as &$report) {
            $seniorCitizen = $userModel->find($report['user_id']);
            $report['senior_name'] = $seniorCitizen ? $seniorCitizen['name'] : 'Unknown';
        }
        
        // Pass data to the view
        return view('admin/medicationReports', [
            'medicationReports' => $medicationReports,
        ]);
    }


    // Approve a user
    public function approveUser($id)
    {
        $this->userModel->update($id, ['is_approved' => true]);
        session()->setFlashdata('message', 'User approved successfully.');
        return redirect()->to('/admin/adminDashboard');
    }

    // Reject a user
    public function rejectUser($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('message', 'User rejected successfully.');
        return redirect()->to('/admin/adminDashboard');
    }

    public function medicationHistory()
{
    // Fetch all medication history records
    $medicationHistory = $this->medicationHistoryModel->findAll();
    $healthHistory = $this->healthHistoryModel->findAll();

    // Loop through the medication history to fetch senior and caregiver names
    foreach ($medicationHistory as &$history) {
        // Fetch senior's name
        $senior = $this->userModel->find($history['user_id']);
        $history['senior_name'] = $senior && isset($senior['name']) ? $senior['name'] : 'Unknown';

        // Fetch caregiver's name (who prescribed the medication)
        $prescribedBy = $this->userModel->find($history['prescribed_by']);
        $history['prescribed_by_name'] = $prescribedBy && isset($prescribedBy['name']) ? $prescribedBy['name'] : 'Unknown';
    }
    foreach ($healthHistory as &$health) {
        // Fetch senior's name
        $senior = $this->userModel->find($health['user_id']);
        $health['senior_name'] = $senior && isset($senior['name']) ? $senior['name'] : 'Unknown';

        // Fetch caregiver's name (who prescribed the medication)
        $recordedBy = $this->userModel->find($health['recorded_by']);
        $health['recorded_by_name'] = $recordedBy && isset($recordedBy['name']) ? $recordedBy['name'] : 'Unknown';
    }

    // Pass medication history data to the view
    $data = [
        'medicationHistory' => $medicationHistory,
        'healthHistory' => $healthHistory
    ];

    return view('admin/medicalHistory', $data);
}

public function addUser()
{
    $userModel = new UserModel();

    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password'),
        'emergency_contact' => $this->request->getPost('emergency_contact'),
        'dob' => $this->request->getPost('dob'),
        'role' => $this->request->getPost('role'),
        'is_approved' => 1, // Automatically approve new users or set to 0 for pending approval
    ];

    if ($userModel->insert($data)) {
        return redirect()->to('/admin/adminDashboard')->with('message', 'User added successfully');
    } else {
        return redirect()->back()->with('message', 'Failed to add user');
    }
}


}
