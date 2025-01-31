<?php
namespace App\Models;

use CodeIgniter\Model;

class HealthReportModel extends Model
{
    protected $table = 'health_records';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'health_condition', 'description', 'temperature', 
        'blood_pressure', 'heart_rate', 'record_date'
    ];
}