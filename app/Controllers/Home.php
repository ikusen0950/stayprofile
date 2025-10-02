<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function dashboard(): string
    {
        // This method will require authentication
        $data = [
            'user' => user(),
            'title' => 'Dashboard'
        ];
        
        return view('dashboard', $data);
    }
}
