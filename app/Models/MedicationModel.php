<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicationModel extends Model
{
    protected $table = 'medications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', // Use this to reference the senior citizen's user ID
        'medication_name', 'dosage', 'frequency', 
        'start_date', 'end_date', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
