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
        session()->setFlashdata('success', 'Link Created');

        return redirect()->to(route_to('user-url-screen'));
    }

    public function editDynamicUrl()
    {
        $request = service('request');
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');
        $existingLink = $dynamicLinkModel->where('user_id', $userId)->first();
        if (!$existingLink) {
            session()->setFlashdata('error', 'Dynamic link not found.');
            return redirect()->to(route_to('user-url-screen'));
        }
        $newDynamicLink = $request->getPost('new_dynamic_link');
        $dynamicLinkModel->update($existingLink['id'], ['dynamic_link' => $newDynamicLink]);
        session()->setFlashdata('success', 'Dynamic link updated successfully.');
        return redirect()->to(route_to('user-url-screen'));
    }

    public function deleteDynamicUrl()
    {
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');
        $existingLink = $dynamicLinkModel->where('user_id', $userId)->first();

        if (!$existingLink) {
            session()->setFlashdata('error', 'Dynamic link not found.');
            return redirect()->to(route_to('user-url-screen'));
        }
        $dynamicLinkModel->delete($existingLink['id']);
        session()->setFlashdata('success', 'Dynamic link deleted successfully.');
        return redirect()->to(route_to('user-url-screen'));
    }
}
