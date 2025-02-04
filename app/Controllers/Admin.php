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
        $this->userModel = new UserModel();
        $this->seniorCaregiverModel = new SeniorCaregiverModel();
        $this->medicationHistoryModel = new MedicationHistoryModel();
        $this->healthHistoryModel = new HealthHistoryModel();
    }

    // Dashboard for admin
    public function dashboard()
    {
        // Ensure session is set before accessing user ID
        $user = session()->get('user');
        if (!$user || !isset($user['id']) || $user['role'] != 'admin') {
            return redirect()->to('/login');
        }

        $userId = $user['id'];
        $db = \Config\Database::connect();

        // Fetch logged-in admin details
        $loggedInUser = $db->table('users')->where('id', $userId)->get()->getRowArray();
        if (!$loggedInUser) {
            return redirect()->to('/login');
        }

        // Fetch all users
        $users = $db->table('users')->get()->getResultArray();

        // Calculate ages
        foreach ($users as &$user) {
            $user['age'] = $this->calculateAge($user['dob']);
        }

        return view('admin/adminDashboard', [
            'users' => $users,
            'totalUsers' => count($users),
            'seniorCitizensCount' => count(array_filter($users, fn($u) => $u['role'] == 'senior_citizen')),
            'caregiversCount' => count(array_filter($users, fn($u) => $u['role'] == 'caregiver')),
            'loggedInUser' => $loggedInUser,
        ]);
    }

    // Calculate age from date of birth
    private function calculateAge($dob)
    {
        $dob = new \DateTime($dob);
        $now = new \DateTime();
        return $now->diff($dob)->y;
    }

    // Assign a caregiver to a senior citizen
    public function assignCaregiver($seniorId)
    {
        $senior = $this->userModel->where('id', $seniorId)->where('role', 'senior_citizen')->first();
        if (!$senior) {
            return redirect()->to('/admin/adminDashboard')->with('error', 'Senior citizen not found.');
        }

        $caregivers = $this->userModel->where('role', 'caregiver')->findAll();

        return view('admin/assignCaregiver', [
            'senior' => $senior,
            'caregivers' => $caregivers
        ]);
    }

    // Save caregiver assignment
    public function saveCaregiverAssignment()
    {
        $seniorId = $this->request->getPost('senior_id');
        $caregiverId = $this->request->getPost('caregiver_id');

        if (empty($seniorId) || empty($caregiverId)) {
            return redirect()->back()->with('error', 'Please select both a caregiver and senior citizen.');
        }

        $existingAssignment = $this->seniorCaregiverModel->where('senior_id', $seniorId)->first();
        if ($existingAssignment) {
            return redirect()->back()->with('error', 'This senior is already assigned a caregiver.');
        }

        $caregiverCount = $this->seniorCaregiverModel->where('caregiver_id', $caregiverId)->countAllResults();
        if ($caregiverCount >= 3) {
            return redirect()->back()->with('error', 'Caregiver already assigned to 3 seniors.');
        }

        $this->seniorCaregiverModel->save(['senior_id' => $seniorId, 'caregiver_id' => $caregiverId]);
        return redirect()->to('/admin/adminDashboard')->with('success', 'Caregiver assigned successfully.');
    }

    // Change caregiver for a senior
    public function changeCaregiver($seniorId)
    {
        $senior = $this->userModel->find($seniorId);
        $currentCaregiver = $this->seniorCaregiverModel
            ->join('users', 'users.id = senior_caregiver.caregiver_id')
            ->where('senior_caregiver.senior_id', $seniorId)
            ->first();

        $caregivers = $this->userModel->where('role', 'caregiver')->findAll();

        return view('admin/changeCaregiver', [
            'senior' => $senior,
            'caregivers' => $caregivers,
            'currentCaregiver' => $currentCaregiver,
        ]);
    }

    // Health reports view
    public function healthReports()
    {
        $healthReportModel = new HealthReportModel();
        $userModel = new UserModel();

        $healthReports = $healthReportModel->findAll();

        foreach ($healthReports as &$report) {
            $seniorCitizen = $userModel->find($report['user_id']);
            $report['senior_name'] = $seniorCitizen ? $seniorCitizen['name'] : 'Unknown';
        }

        return view('admin/healthReports', [
            'healthReports' => $healthReports,
        ]);
    }

    // Medication reports view
    public function medicationReports()
    {
        $medicationReportModel = new MedicationModel();
        $userModel = new UserModel();

        $medicationReports = $medicationReportModel->findAll();

        foreach ($medicationReports as &$report) {
            $seniorCitizen = $userModel->find($report['user_id']);
            $report['senior_name'] = $seniorCitizen ? $seniorCitizen['name'] : 'Unknown';
        }

        return view('admin/medicationReports', [
            'medicationReports' => $medicationReports,
        ]);
    }

    // Approve user
    public function approveUser($id)
    {
        $this->userModel->update($id, ['is_approved' => true]);
        return redirect()->to('/admin/adminDashboard')->with('message', 'User approved.');
    }

    // Reject user
    public function rejectUser($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/adminDashboard')->with('message', 'User rejected.');
    }
}
