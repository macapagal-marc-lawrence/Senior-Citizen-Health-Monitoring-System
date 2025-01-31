<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicationHistoryModel extends Model
{
    protected $table = 'medication_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',                     // Reference to the senior citizen's user ID
        'medication_name', 
        'dosage', 
        'frequency', 
        'start_date', 
        'end_date', 
        'prescribed_by',               // Reference to the caregiver/doctor's user ID
        'date_prescribed', 
        'deleted_at'
    ];
    protected $useTimestamps = true;

    // Define relationships with the users table
    public function getSenior($userId)
    {
        return $this->join('users', 'users.id = medication_history.user_id')
                    ->where('medication_history.user_id', $userId)
                    ->findAll();
    }

    public function getPrescriber($prescribedById)
    {
        return $this->join('users', 'users.id = medication_history.prescribed_by')
                    ->where('medication_history.prescribed_by', $prescribedById)
                    ->findAll();
    }
}
