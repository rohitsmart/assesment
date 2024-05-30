<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'status1' => true,
            'status2' => false,
            'status3' => true,
            'status4' => false,
            'status5' => true,
        ];
        
        return view('dashboard/index', $data);
    }
}
