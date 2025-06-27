<?php

namespace App\Http\Controllers\Pwd;

use App\Http\Controllers\Controller;

class PwdDashboardController extends Controller
{
    public function index()
    {
        return view('pages.pwd.dashboard');
    }
}