<?php
namespace App\Models;

use CodeIgniter\Model;

class HealthRecordModel extends Model
{
    protected $table = 'health_records';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'health_condition', 'description', 'temperature', 'blood_pressure', 'heart_rate', 'record_date', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true; // Automatically handle created_at and updated_at if not provided
}
