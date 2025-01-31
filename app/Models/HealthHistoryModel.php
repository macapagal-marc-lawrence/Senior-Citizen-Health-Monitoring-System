<?php

namespace App\Models;

use CodeIgniter\Model;

class HealthHistoryModel extends Model
{
    protected $table = 'health_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',                     // Reference to the senior citizen's user ID
        'health_condition', 
        'description', 
        'temperature', 
        'blood_pressure', 
        'heart_rate', 
        'recorded_by ',               // Reference to the caregiver/doctor's user ID
        'record_date', 
        'created_at',
        'deleted_at'
    ];
    protected $useTimestamps = true;

    // Define relationships with the users table
    public function getSenior($userId)
    {
        return $this->join('users', 'users.id = health_history.user_id')
                    ->where('health_history.user_id', $userId)
                    ->findAll();
    }

    public function getRecorder($prescribedById)
    {
        return $this->join('users', 'users.id = health_history.recorded_by')
                    ->where('health_history.recorded_by', $recordedById)
                    ->findAll();
    }
}
