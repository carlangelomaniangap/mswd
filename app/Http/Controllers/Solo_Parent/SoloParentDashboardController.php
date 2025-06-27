<?php

namespace App\Http\Controllers\Solo_Parent;

use App\Http\Controllers\Controller;

class SoloParentDashboardController extends Controller
{
    public function index()
    {
        return view('pages.solo_parent.dashboard');
    }
}