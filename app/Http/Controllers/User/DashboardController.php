<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }
        public function business()
    {
        return view('user.my_business');
    }
}

