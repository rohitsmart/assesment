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

    public function editDynamicUrl($dynamicLink)
    {
        $request = service('request');
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');

        $existingLink = $dynamicLinkModel->where('user_id', $userId)
                                        ->where('dynamic_link', $dynamicLink)
                                        ->first();

        if (!$existingLink) {
            session()->setFlashdata('error', 'Dynamic link not found.');
            return redirect()->to(route_to('user-url-screen'));
        }

        $existingLink->dynamic_link = $request->getPost('new_dynamic_link');
        $dynamicLinkModel->save($existingLink);

        session()->setFlashdata('success', 'Dynamic link updated successfully.');

        return redirect()->to(route_to('user-url-screen'));
    }

    public function deleteDynamicUrl($dynamicLink)
    {
        $dynamicLinkModel = new DynamicLinkModel();
        $userId = session()->get('user_id');

        $deleted = $dynamicLinkModel->where('user_id', $userId)
                                    ->where('dynamic_link', $dynamicLink)
                                    ->delete();
        if ($deleted) {
            session()->setFlashdata('success', 'Dynamic link deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Unable to delete dynamic link.');
        }

        return redirect()->to(route_to('user-url-screen'));
    }


}
