<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicOwnerDashboardController extends Controller
{
    /**
     * Show the Clinic Owner dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // Metrics for dashboard
        $staffCount = \App\Models\User::where('organization_id', $organization->id)->count();
        $patientsCount = \App\Models\Patient::count();
        $todayAppointments = \App\Models\Appointment::with(['patient', 'dentist'])
            ->whereDate('appointment_date', today())
            ->orderBy('start_time')
            ->get();
        
        $totalRevenue = \App\Models\Payment::where('organization_id', $organization->id)->sum('amount');
        
        $monthlyRevenue = \App\Models\Payment::where('organization_id', $organization->id)
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
            
        $recentPatients = \App\Models\Patient::where('organization_id', $organization->id)->latest()->take(5)->get();

        return view('clinic-owner.dashboard', compact(
            'user', 
            'organization', 
            'staffCount', 
            'patientsCount', 
            'todayAppointments', 
            'totalRevenue',
            'monthlyRevenue',
            'recentPatients'
        ));
    }
}
