<?php

namespace App\Models;

use CodeIgniter\Model;

class UserStatusModel extends Model
{
    protected $table  = 'user_statuses';  
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'status_1', 'status_2', 'status_3', 'status_4', 'status_5'];
}
