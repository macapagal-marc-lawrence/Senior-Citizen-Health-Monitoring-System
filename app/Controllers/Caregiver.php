<?php
namespace App\Controllers;

use App\Models\HealthRecordModel;
use App\Models\UserModel;
use App\Models\MedicationModel;
use App\Models\MedicationHistoryModel; 
use App\Models\HealthHistoryModel;
use App\Models\ReminderModel;
use App\Models\SeniorCaregiverModel; 
use CodeIgniter\Controller;

class Caregiver extends Controller
{
    // Caregiver Dashboard
    public function dashboard()
    {
        // Ensure user is logged in and has caregiver role
        $user = session()->get('user');
        if (!$user || $user['role'] != 'caregiver') {
            return redirect()->to('/login');
        }
    
        $caregiverId = $user['id'];  // Get the user ID as caregiverId
    
        // Get the list of seniors assigned to this caregiver
        $model = new UserModel();
        $seniors = $model->select('users.id, users.name, users.dob, users.emergency_contact')
                 ->join('senior_caregiver', 'senior_caregiver.senior_id = users.id')
                 ->where('senior_caregiver.caregiver_id', $caregiverId)
                 ->findAll();

                 

    
        // Instantiate the MedicationModel
        $medicationModel = new \App\Models\MedicationModel();
        
        // Get all medications for each senior under this caregiver
        $medications = [];
        foreach ($seniors as $senior) {
            // Get all medications for the senior
            $medications[$senior['id']] = $medicationModel->where('user_id', $senior['id'])->findAll();
        }
    
        // Instantiate the ReminderModel
        $reminderModel = new \App\Models\ReminderModel();
    
        // Get all reminders for each senior under this caregiver
        $reminders = [];
        foreach ($seniors as $senior) {
            // Get all reminders for the senior
            $reminders[$senior['id']] = $reminderModel->where('user_id', $senior['id'])->findAll();
        }
    
        return view('caregiver/caregiverDashboard', [
            'seniors' => $seniors,
            'medications' => $medications, // Pass medications to the view
            'reminders' => $reminders, // Pass reminders to the view
            'user' => $user,
        ]);
    }
    



    // View Health Records for a specific senior citizen
    public function viewHealthRecords($user_id)
    {
        $healthRecordModel = new HealthRecordModel();

        // Get senior citizen data (user details)
        $seniorModel = new UserModel();
        $senior = $seniorModel->find($user_id);

        // Get health records for the senior citizen
        $healthRecords = $healthRecordModel->where('user_id', $user_id)->findAll();

        // Get medications for the senior citizen
        $medicationModel = new MedicationModel();
        $medications = $medicationModel->where('user_id', $user_id)->findAll();

        return view('caregiver/viewHealthRecord', [
            'senior' => $senior,
            'healthRecords' => $healthRecords,
            'medications' => $medications
        ]);
    }

    // Add Health Record for a specific senior citizen
    public function addHealthRecord($user_id)
    {
        // Get the form data using getPost()
        $health_condition = $this->request->getPost('health_condition') ?: NULL; // Set to NULL if not provided
        $description = $this->request->getPost('description') ?: NULL; // Set to NULL if not provided
        $blood_pressure = $this->request->getPost('blood_pressure');
        $heart_rate = $this->request->getPost('heart_rate');
        $temperature = $this->request->getPost('temperature');

        // Prepare the data for insertion
        $data = [
            'user_id' => $user_id, 
            'health_condition' => $health_condition,
            'description' => $description,
            'temperature' => $temperature,
            'blood_pressure' => $blood_pressure,
            'heart_rate' => $heart_rate,
            'record_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Use HealthRecordModel to insert data
        $healthRecordModel = new HealthRecordModel();

        // Save the record
        if ($healthRecordModel->save($data)) {
            session()->setFlashdata('message', 'Health record added successfully');
        } else {
            session()->setFlashdata('message', 'Failed to add health record');
            log_message('error', 'Database Error: ' . implode(', ', $healthRecordModel->errors()));
        }

        // Redirect back to the caregiver dashboard
        return redirect()->to('/caregiver/caregiverDashboard');
    }

    // Add Medication for a specific senior citizen
    public function addMedication($user_id)
    {
        // Get the form data using getPost()
        $medication_name = $this->request->getPost('medication_name');
        $dosage = $this->request->getPost('dosage');
        $frequency = $this->request->getPost('frequency');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date') ?: NULL;  // Set to NULL if not provided

        // Prepare data for insertion
        $data = [
            'user_id' => $user_id,  // Reference to the senior citizen's user_id
            'medication_name' => $medication_name,
            'dosage' => $dosage,
            'frequency' => $frequency,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Use MedicationModel to insert data
        $medicationModel = new MedicationModel();

        // Save the medication record
        if ($medicationModel->save($data)) {
            session()->setFlashdata('message', 'Medication record added successfully');
        } else {
            log_message('error', 'Failed to insert medication record: ' . print_r($data, true));
            session()->setFlashdata('message', 'Failed to add medication record');
        }

        // Redirect back to the caregiver dashboard
        return redirect()->to('/caregiver/caregiverDashboard');
    }

    // Add Reminder for a specific senior citizen
    public function addReminder($user_id)
    {
        // Get the form data using getPost()
        $type = $this->request->getPost('type');
        $message = $this->request->getPost('message');
        $date = $this->request->getPost('date');    

        // Prepare data for insertion
        $data = [
            'user_id' => $user_id,  // Reference to the senior citizen's user_id
            'type' => $type,
            'message' => $message,
            'date' => $date,
            
        ];

        // Use MedicationModel to insert data
        $reminderModel = new ReminderModel();

        // Save the medication record
        if ($reminderModel->save($data)) {
            session()->setFlashdata('message', 'Reminder added successfully');
        } else {
            log_message('error', 'Failed to insert medication record: ' . print_r($data, true));
            session()->setFlashdata('message', 'Failed to add medication record');
        }

        // Redirect back to the caregiver dashboard
        return redirect()->to('/caregiver/caregiverDashboard');
    }

    public function updateHealthRecord()
    {
        $id = $this->request->getVar('id');
        $health_condition = $this->request->getVar('health_condition');
        $description = $this->request->getVar('description');
        $temperature = $this->request->getVar('temperature');
        $blood_pressure = $this->request->getVar('blood_pressure');
        $heart_rate = $this->request->getVar('heart_rate');
    

        
        $healthRecordModel = new HealthRecordModel();

        // Prepare the query to update the user
        $query = "UPDATE health_records SET health_condition = ?, description = ?, temperature = ?, blood_pressure = ?, heart_rate = ? WHERE id = ?";
        $db = \Config\Database::connect();
        $result = $db->query($query, [$health_condition, $description, $temperature, $blood_pressure, $heart_rate, $id]);

        // Check if the query was successful
        if ($result) {
            return redirect()->to('/caregiver/caregiverDashboard')->with('message', 'Health record updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Database update failed']);
        }
    }

    public function deleteHealthRecord($id)
    {
       // Get the current user from the session
    $user = session()->get('user');
    
    // Create instances of MedicationModel, MedicationHistoryModel, SeniorCaregiverModel, and UserModel
    $healthRecordModel = new HealthRecordModel();
    $healthHistoryModel = new HealthHistoryModel();
    $seniorCaregiverModel = new SeniorCaregiverModel(); // To fetch caregiver info
    $userModel = new UserModel(); // UserModel to fetch user details
    
    // Retrieve the medication record from the medications table
    $health = $healthRecordModel->find($id);
    
    if ($health) {
        // Find the caregiver assigned to the senior citizen based on the user_id in medications table
        $caregiverAssignment = $seniorCaregiverModel->where('senior_id', $health['user_id'])->first();
        
        if ($caregiverAssignment) {
            // Get the caregiver's user_id (prescribed_by)
            $recordedByUserId = $caregiverAssignment['caregiver_id'];  // caregiver_id is the caregiver's user_id
        } else {
            // If no caregiver is found, set prescribed_by to null or a default value
            $recordedByUserId = null;
        }

        // Now, get the details of the caregiver (prescriber)
        $recorder = $userModel->find($recordedByUserId);

        // Prepare data for the medication_history table
        $healthHistoryData = [
            'user_id' => $health['user_id'],                    // Senior's user ID (foreign key to users table)
            'health_condition' => $health['health_condition'],
            'description' => $health['description'],
            'temperature' => $health['temperature'],
            'blood_pressure' => $health['blood_pressure'],
            'heart_rate' => $health['heart_rate'],
            'recorded_by ' => $recorder ? $recorder['id'] : null,  // Prescribed by caregiver (foreign key to users table)
            'record_date' => $health['created_at'], // Use start_date as the date prescribed
            'deleted_at' => (new \DateTime())->format('Y-m-d H:i:s') // Better handling of the timestamp
        ];

        // Insert into the medication_history table
        $healthHistoryModel->insert($healthHistoryData);

        // Delete the record from medications table
        $healthRecordModel->delete($id);
        // Redirect to the dashboard after deletion
        return redirect()->to('/caregiver/caregiverDashboard')->with('message', 'Health record deleted successfully');
    }
    }

    public function updateMedRecord()
    {
        $id = $this->request->getVar('id');
        $medication_name = $this->request->getVar('medication_name');
        $dosage = $this->request->getVar('dosage');
        $frequency = $this->request->getVar('frequency');
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
    

        
        $medicationModel = new MedicationModel();

        // Prepare the query to update the user
        $query = "UPDATE medications SET medication_name = ?, dosage = ?, frequency = ?, start_date = ?, end_date = ? WHERE id = ?";
        $db = \Config\Database::connect();
        $result = $db->query($query, [$medication_name, $dosage, $frequency, $start_date, $end_date, $id]);

        // Check if the query was successful
        if ($result) {
            return redirect()->to('/caregiver/caregiverDashboard')->with('message', 'Medication record updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Database update failed']);
        }
    }

    public function deleteMedRecord($id)
{
    // Get the current user from the session
    $user = session()->get('user');
    
    // Create instances of MedicationModel, MedicationHistoryModel, SeniorCaregiverModel, and UserModel
    $medicationModel = new MedicationModel();
    $medicationHistoryModel = new MedicationHistoryModel();
    $seniorCaregiverModel = new SeniorCaregiverModel(); // To fetch caregiver info
    $userModel = new UserModel(); // UserModel to fetch user details
    
    // Retrieve the medication record from the medications table
    $medication = $medicationModel->find($id);
    
    if ($medication) {
        // Find the caregiver assigned to the senior citizen based on the user_id in medications table
        $caregiverAssignment = $seniorCaregiverModel->where('senior_id', $medication['user_id'])->first();
        
        if ($caregiverAssignment) {
            // Get the caregiver's user_id (prescribed_by)
            $prescribedByUserId = $caregiverAssignment['caregiver_id'];  // caregiver_id is the caregiver's user_id
        } else {
            // If no caregiver is found, set prescribed_by to null or a default value
            $prescribedByUserId = null;
        }

        // Now, get the details of the caregiver (prescriber)
        $prescriber = $userModel->find($prescribedByUserId);

        // Prepare data for the medication_history table
        $historyData = [
            'user_id' => $medication['user_id'],                    // Senior's user ID (foreign key to users table)
            'medication_name' => $medication['medication_name'],
            'dosage' => $medication['dosage'],
            'frequency' => $medication['frequency'],
            'start_date' => $medication['start_date'],
            'end_date' => $medication['end_date'],
            'prescribed_by' => $prescriber ? $prescriber['id'] : null,  // Prescribed by caregiver (foreign key to users table)
            'date_prescribed' => $medication['start_date'], // Use start_date as the date prescribed
            'deleted_at' => (new \DateTime())->format('Y-m-d H:i:s') // Better handling of the timestamp
        ];

        // Insert into the medication_history table
        $medicationHistoryModel->insert($historyData);

        // Delete the record from medications table
        $medicationModel->delete($id);

        // Redirect based on the user role
        if ($user && $user['role'] == 'caregiver') {
            return redirect()->to('/caregiver/caregiverDashboard')->with('message', 'Medication record deleted successfully');
        } elseif ($user && $user['role'] == 'senior_citizen') {
            return redirect()->to('/senior/seniorDashboard')->with('message', 'Medication deleted successfully');
        } else {
            return redirect()->to('/login')->with('error', 'Session expired. Please log in again.');
        }
    } else {
        return redirect()->to('/caregiver/caregiverDashboard')->with('error', 'Medication record not found');
    }
}




    public function deleteReminder($id)
    {
        $reminderModel = new ReminderModel();
        $reminderModel->delete($id);
    
        // Redirect to the dashboard after deletion
        return redirect()->to('/senior/seniorDashboard')->with('message', 'Reminder done successfully');
    }

    
}

