<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function register()
    {
        helper(['form']);
        echo view('register');
    }

    public function login()
    {
        helper(['form']);
        echo view('login');
    }

    public function doRegister()
{
    helper(['form', 'url']);
    
    // Define validation rules
    $rules = [
        'name'     => 'required|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'emergency_contact'  => 'required',
        'dob'      => 'required',
        'role'     => 'required|in_list[senior_citizen,caregiver,admin]',  // Validate role
    ];

    // Validate the input
    if (!$this->validate($rules)) {
        return redirect()->back()->with('error', $this->validator->getErrors())->withInput();
    }

    // Calculate age from DOB if the role is senior_citizen
    $dob = new \DateTime($this->request->getPost('dob'));
    $currentDate = new \DateTime();
    $age = $dob->diff($currentDate)->y;
    
    $role = $this->request->getPost('role');

    // Restrict registration for senior citizens only if age is 60 or above
    if ($role === 'senior_citizen' && $age < 60) {
        return redirect()->back()->with('error', 'You must be at least 60 years old to register as a senior citizen.')->withInput();
    }

    // Prepare the data to insert
    $model = new UserModel();
    $data = [
        'name'             => $this->request->getPost('name'),
        'email'            => $this->request->getPost('email'),
        'password'         => $this->request->getPost('password'),
        'emergency_contact'=> $this->request->getPost('emergency_contact'),
        'dob'              => $this->request->getPost('dob'),
        'role'             => $role,
    ];

    // Insert the user data into the database
    if ($model->insert($data)) {
        return redirect()->to('/login')->with('success', 'Registration successful! You can now log in.');
    } else {
        return redirect()->back()->with('error', 'Failed to register. Please try again.')->withInput();
    }
}


public function doLogin()
{
    helper(['form']);
    
    $email    = $this->request->getVar('email');
    $password = $this->request->getVar('password');
    
    $model = new UserModel();

    // Find the user by email
    $user = $model->where('email', $email)->first();

    if (!$user) {
        // If user doesn't exist, show invalid credentials error
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    // Direct password comparison (if you are not using hashing)
    if ($password !== $user['password']) {
        // If the password doesn't match, show invalid credentials error
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    // Check if the user is approved
    if ($user['is_approved'] == 0) {
        return redirect()->back()->with('error', 'Your account is pending approval by an admin.')->withInput();
    }

    // Set session data
    session()->set('user', $user);

    // Redirect based on the role
    if ($user['role'] == 'admin') {
        return redirect()->to('/admin/adminDashboard');  // Redirect to Admin Dashboard
    } elseif ($user['role'] == 'senior_citizen') {
        return redirect()->to('/senior/seniorDashboard');  // Redirect to Senior Citizen Dashboard
    } elseif ($user['role'] == 'caregiver') {
        return redirect()->to('/caregiver/caregiverDashboard');  // Redirect to Caregiver Dashboard
    } else {
        return redirect()->to('/login')->with('error', 'Role not recognized.');
    }
}



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
