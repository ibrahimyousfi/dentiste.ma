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

        // Analytics Data: Revenue Trend (Last 6 Months)
        $revenueLabels = [];
        $revenueValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueLabels[] = $month->format('M');
            $revenueValues[] = \App\Models\Payment::where('organization_id', $organization->id)
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->sum('amount');
        }

        // Analytics Data: Appointments Breakdown (This Month)
        $appointmentStatusCounts = \App\Models\Appointment::whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $appointmentLabels = array_keys($appointmentStatusCounts);
        $appointmentValues = array_values($appointmentStatusCounts);
        if (empty($appointmentLabels)) {
             $appointmentLabels = ['No Data'];
             $appointmentValues = [0];
        }

        // Analytics Data: Patient Growth (Last 6 Months)
        $patientGrowthValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $patientGrowthValues[] = \App\Models\Patient::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return view('clinic-owner.dashboard', compact(
            'user', 
            'organization', 
            'staffCount', 
            'patientsCount', 
            'todayAppointments', 
            'totalRevenue',
            'monthlyRevenue',
            'recentPatients',
            'revenueLabels',
            'revenueValues',
            'appointmentLabels',
            'appointmentValues',
            'patientGrowthValues'
        ));
    }
}
