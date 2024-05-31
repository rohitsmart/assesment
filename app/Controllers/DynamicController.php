<?php

namespace App\Controllers;

use App\Models\DynamicLinkModel;
use App\Models\UserStatusModel;

class DynamicController extends BaseController
{
    public function showDynamic($dynamicLink)
    {
        $userId = session()->get('user_id');

        $dynamicLinkModel = new DynamicLinkModel();
        $dynamicLinkData = $dynamicLinkModel->where('user_id', $userId)
                                            ->where('dynamic_link', $dynamicLink)
                                            ->first();
        $userStatusModel = new UserStatusModel();
        $userStatus = $userStatusModel->where('user_id', $userId)->first();
        $data = [
            'status1' => $userStatus['status_1'],
            'status2' => $userStatus['status_2'],
            'status3' => $userStatus['status_3'],
            'status4' => $userStatus['status_4'],
            'status5' => $userStatus['status_5'],
        ];
        if ($dynamicLinkData) {
            return view('dashboard/dynamic', ['dynamicLinkData' => $dynamicLinkData, 'statuses' => $data]);
        } else {
            session()->setFlashdata('error', 'Invalid or unauthorized access to the dynamic link.');
            return redirect()->to(route_to('user-url-screen'));
        }
    }


    
}
