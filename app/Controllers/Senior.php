<?php
namespace App\Controllers;

use App\Models\HealthRecordModel;
use App\Models\UserModel;
use App\Models\MedicationModel;
use App\Models\ReminderModel;
use App\Models\SeniorCaregiverModel;  // New model for senior_caregiver table
use CodeIgniter\Controller;

class Senior extends Controller
{
    public function dashboard()
    {
        // Ensure user is logged in
        $user = session()->get('user');
        $reminders = session()->get('reminders');
        if (!$user || $user['role'] != 'senior_citizen') {
            return redirect()->to('/login');
        }

        // Get the senior's health records and medications
        $healthRecordModel = new HealthRecordModel();
        $medicationModel = new MedicationModel();
        $userModel = new UserModel();
        $seniorCaregiverModel = new SeniorCaregiverModel();
        $reminderModel = new ReminderModel();


        // Fetch health records for the logged-in senior
        $healthRecords = $healthRecordModel->where('user_id', $user['id'])->findAll();
        $reminders = $reminderModel->where('user_id', $user['id'])->findAll();

        // Fetch medications for the logged-in senior
        $medications = $medicationModel->where('user_id', $user['id'])->findAll();

        // Fetch the caregiver assigned to the senior
        $caregiverAssignment = $seniorCaregiverModel->where('senior_id', $user['id'])->first();
        $caregiver = null;
        if ($caregiverAssignment) {
            $caregiver = $userModel->find($caregiverAssignment['caregiver_id']);
        }

        // Calculate the senior's age from their date of birth (dob)
        $dob = $user['dob']; // Assuming 'dob' is stored as 'YYYY-MM-DD'
        $age = $this->calculateAge($dob);

        // Pass the data to the view
        return view('senior/seniorDashboard', [
            'healthRecords' => $healthRecords,
            'medications' => $medications,
            'reminders' =>$reminders,
            'user' => $user,
            'age' => $age,
            'caregiver' => $caregiver  // Pass caregiver details to the view
        ]);
    }

    // Function to calculate age based on date of birth
    private function calculateAge($dob)
    {
        $dobDate = new \DateTime($dob);
        $today = new \DateTime();
        $age = $today->diff($dobDate)->y;
        return $age;
    }
}
