<?php
namespace App\Models;

use CodeIgniter\Model;

class SeniorCaregiverModel extends Model
{
    protected $table      = 'senior_caregiver';
    protected $primaryKey = 'id';

    protected $allowedFields = ['senior_id', 'caregiver_id'];

    // Use timestamps if you want to keep track of creation and update times
    protected $useTimestamps = false;
}
