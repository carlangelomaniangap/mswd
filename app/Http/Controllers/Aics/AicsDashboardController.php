<?php

namespace App\Http\Controllers\Aics;

use App\Http\Controllers\Controller;

class AicsDashboardController extends Controller
{
    public function index()
    {
        return view('pages.aics.dashboard');
    }
}