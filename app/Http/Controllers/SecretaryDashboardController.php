<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Waitlist;
use App\Models\Patient;
use Carbon\Carbon;

class SecretaryDashboardController extends Controller
{
    /**
     * Show the Secretary dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // Fetch active waitlist for the organization
        $waitlist = Waitlist::with('patient')
            ->where('organization_id', $organization->id)
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch patients for recall (no appointments in the last 6 months, and no upcoming appointments)
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        
        $recalls = Patient::where('organization_id', $organization->id)
            ->whereDoesntHave('appointments', function($q) use ($sixMonthsAgo) {
                $q->where('appointment_date', '>', $sixMonthsAgo);
            })
            ->take(10)
            ->get();

        // Fetch appointments for Today, Tomorrow, and Next 3 Days
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $next3Days = Carbon::today()->addDays(4);

        $appointments = \App\Models\Appointment::with(['patient', 'dentist'])
            ->where('organization_id', $organization->id)
            ->whereBetween('appointment_date', [$today->format('Y-m-d'), $next3Days->format('Y-m-d')])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $todayAppointments = $appointments->where('appointment_date', $today->format('Y-m-d'));
        $tomorrowAppointments = $appointments->where('appointment_date', $tomorrow->format('Y-m-d'));
        $upcomingAppointments = $appointments->filter(function($appt) use ($tomorrow) {
            return Carbon::parse($appt->appointment_date)->gt($tomorrow);
        });

        // Revenue Tracking
        $todaysRevenue = \App\Models\Payment::where('organization_id', $organization->id)
            ->whereDate('payment_date', $today)
            ->sum('amount');

        $todaysPaymentsCount = \App\Models\Payment::where('organization_id', $organization->id)
            ->whereDate('payment_date', $today)
            ->count();

        return view('secretary.dashboard', compact(
            'user', 'organization', 'waitlist', 'recalls', 
            'todayAppointments', 'tomorrowAppointments', 'upcomingAppointments',
            'todaysRevenue', 'todaysPaymentsCount'
        ));
    }
}
