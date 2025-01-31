<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'email', 'password', 'emergency_contact', 'dob', 'role', 'is_approved'];

    protected $validationRules = [
        'name'     => 'required|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'emergency_contact' => 'required',
        'dob'      => 'required',
        'role'     => 'required|in_list[senior_citizen,caregiver,admin]',  // Validate role
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered.',
        ],
    ];
    public function register($data)
    {
        // Store the password directly without hashing
        return $this->save($data);
    }
    
    public function login($email, $password)
    {
        $user = $this->where('email', $email)->first();
        // Directly compare passwords as plain text
        if ($user && $user['password'] === $password) {
            return $user;
        }
        return false;
    }
    
}
