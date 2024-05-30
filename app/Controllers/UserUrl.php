<?php

namespace App\Controllers;

use App\Models\DynamicLinkModel;

class UserUrl extends BaseController
{
    public function index()
    {
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');
        $dynamicLink = $dynamicLinkModel->where('user_id', $userId)->first();
        $data = ['dynamicLink' => $dynamicLink];
        return view('dashboard/url', $data);   
    }

    public function createDynamicUrl()
    {

        $request = service('request');
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');
        $data = [
            'user_id' => $userId,
            'dynamic_link' => $request->getPost('dynamic_link')
        ];
        $dynamicLinkModel->insert($data);
        return redirect()->to(route_to('user-url-screen'));
    }
}
