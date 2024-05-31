<?php

namespace App\Controllers;

use App\Models\UserStatusModel;
use WebSocket\Client;

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
            'statuses' => [
                'status1' => $userStatus['status_1'],
                'status2' => $userStatus['status_2'],
                'status3' => $userStatus['status_3'],
                'status4' => $userStatus['status_4'],
                'status5' => $userStatus['status_5'],
            ],
        ];

        return view('dashboard/index', $data);
    }

    public function updateStatus()
    {
        $userId = session()->get('user_id');
        $statusIndex = $this->request->getPost('statusIndex');
        $value = $this->request->getPost('value');

        // Debug logging for received data
        log_message('debug', 'Received request: statusIndex=' . print_r($statusIndex, true) . ', value=' . print_r($value, true) . ', userId=' . $userId);

        // Validate that statusIndex and value are not arrays
        if (is_array($statusIndex) || is_array($value)) {
            log_message('error', 'Invalid data: statusIndex or value is an array.');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid data: statusIndex or value is an array.'
            ]);
        }

        // Ensure statusIndex is a valid status field
        if (!in_array($statusIndex, [1, 2, 3, 4, 5])) {
            log_message('error', 'Invalid status index: ' . $statusIndex);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid status index.'
            ]);
        }

        // Prepare the data for updating
        $updateData = ['status_' . $statusIndex => $value];

        try {
            $userStatusModel = new UserStatusModel();
            $result = $userStatusModel->where('user_id', $userId)->set($updateData)->update();
            if ($result) {
                $this->broadcastStatusUpdate($userId);
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
        } catch (\Exception $e) {
            log_message('error', 'An error occurred: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => "An error occurred: " . $e->getMessage()
            ]);
        }
    }

    private function broadcastStatusUpdate($userId)
    {
        $userStatusModel = new UserStatusModel();
        $userStatus = $userStatusModel->where('user_id', $userId)->first();

        $statuses = [
            'status1' => (bool) $userStatus['status_1'],
            'status2' => (bool) $userStatus['status_2'],
            'status3' => (bool) $userStatus['status_3'],
            'status4' => (bool) $userStatus['status_4'],
            'status5' => (bool) $userStatus['status_5'],
        ];

        $msg = json_encode($statuses);
        try {
            $ws = new Client('ws://localhost:8090');
            $ws->send($msg);
            $this->logger->info("WebSocket message sent: $msg");
            $ws->close();
        } catch (\Exception $e) {
            $this->logger->error("WebSocket error: " . $e->getMessage());
        }
    }
}
