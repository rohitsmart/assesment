<?php

namespace App\Models;

use CodeIgniter\Model;

class DynamicLinkModel extends Model
{
    protected $table            = 'dynamic_links';
    protected $useTimestamps = false;

    protected $allowedFields = ['user_id', 'dynamic_link'];

}
