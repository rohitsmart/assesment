<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }


public function processLogin()
{
    helper(['form']);
    
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $validation = \Config\Services::validation();
    $validation->setRules([
        'email' => 'required|valid_email',
        'password' => 'required|min_length[8]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        session()->setFlashdata('errors', $validation->getErrors());
        return redirect()->back()->withInput();
    }

    $userModel = new \App\Models\User();
    $user = $userModel->authenticate($email, $password);

    if (!$user) {
        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->back()->withInput();
    }

    $userData = [
        'user_id' => $user['id'],
    ];
    session()->set($userData);
    session()->setFlashdata('success', 'Login successful.');
    return redirect()->to('/dashboard');
}




    public function register()
    {
        return view('auth/register');
    }


    public function processRegister()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('errors', $validation->getErrors());
             return redirect()->back()->withInput();
        }
        
        $userModel = new \App\Models\User();
        $userData = [
            'email' => $email,
            'password' => $password
        ];


        if (!$userModel->insert($userData)) {
            log_message('error', 'Failed to create user: ' . json_encode($userModel->errors()));
            session()->setFlashdata('errors', $userModel->errors());
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'User created successfully! Please log in.');
        return redirect()->route('login-user-view');
        
       
    }

}
