<?php

namespace App\Http\Controllers\Senior_Citizen;

use App\Http\Controllers\Controller;

class SeniorCitizenDashboardController extends Controller
{
    public function index()
    {
        return view('pages.senior_citizen.dashboard');
    }
}