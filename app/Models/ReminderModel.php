<?php
namespace App\Models;

use CodeIgniter\Model;

class ReminderModel extends Model
{
    protected $table = 'reminders_alerts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'type', 'message', 'date'
    ];
}
