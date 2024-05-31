<?php

namespace App\Controllers;

use App\Models\UserStatusModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userStatusModel = new UserStatusModel();
        $userStatus = $userStatusModel->where('user_id', $userId)->first();
        if (!$userStatus) {
            $userStatusModel->insert([
                'user_id' => $userId,
                'status_1' => false,
                'status_2' => false,
                'status_3' => false,
                'status_4' => false,
                'status_5' => false,
            ]);
            $userStatus = $userStatusModel->where('user_id', $userId)->first();
        }
        $data = [
            'status1' => $userStatus['status_1'],
            'status2' => $userStatus['status_2'],
            'status3' => $userStatus['status_3'],
            'status4' => $userStatus['status_4'],
            'status5' => $userStatus['status_5'],
        ];
        return view('dashboard/index', $data);
    }


    public function updateStatus()
    {
        $userId = session()->get('user_id');
        $statusIndex = $this->request->getPost('statusIndex');
        $value = $this->request->getPost('value');

        $userStatusModel = new UserStatusModel();
        $updateData = ["status_$statusIndex" => $value];

        if ($userStatusModel->where('user_id', $userId)->set($updateData)->update()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Status $statusIndex updated successfully"
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Failed to update status $statusIndex"
            ]);
        }
    }
}
