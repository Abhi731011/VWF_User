<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        return view('master.dashboard');
    }

    public function profile()
    {
        return view('master.profile');
    }
}
