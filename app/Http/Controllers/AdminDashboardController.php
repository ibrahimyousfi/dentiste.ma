<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Show the Super Admin dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        return view('admin.dashboard', compact('user'));
    }
}
