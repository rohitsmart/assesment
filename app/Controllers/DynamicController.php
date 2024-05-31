<?php

namespace App\Controllers;

use App\Models\DynamicLinkModel;

class DynamicController extends BaseController
{
    public function showDynamic($dynamicLink)
    {
        $userId = session()->get('user_id');

        $dynamicLinkModel = new DynamicLinkModel();
        $dynamicLinkData = $dynamicLinkModel->where('user_id', $userId)
                                            ->where('dynamic_link', $dynamicLink)
                                            ->first();
        if ($dynamicLinkData) {
            return view('dashboard/dynamic', ['dynamicLinkData' => $dynamicLinkData]);
        } else {
            session()->setFlashdata('error', 'Invalid or unauthorized access to the dynamic link.');
            return redirect()->to(route_to('user-url-screen'));
        }
    }


    
}
