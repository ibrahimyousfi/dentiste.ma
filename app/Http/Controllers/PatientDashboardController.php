<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\ToothFinding;

class PatientDashboardController extends Controller
{
    /**
     * Show the patient dashboard.
     */
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $upcomingAppointments = Appointment::with('dentist')
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('patient-portal.dashboard', compact('patient', 'upcomingAppointments'));
    }

    /**
     * Show the patient's dental chart / medical record.
     */
    public function chart()
    {
        $patient = Auth::guard('patient')->user();
        
        $findings = ToothFinding::where('patient_id', $patient->id)->get();
        
        $isChild = \Carbon\Carbon::parse($patient->date_of_birth)->age <= 12;
        $treatmentCatalogs = [];
        
        return view('patient-portal.chart', compact('patient', 'findings', 'isChild', 'treatmentCatalogs'));
    }

    /**
     * Show the patient's payment history.
     */
    public function payments()
    {
        $patient = Auth::guard('patient')->user();
        
        $payments = Payment::whereHas('invoice', function($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->orderBy('payment_date', 'desc')->get();
            
        return view('patient-portal.payments', compact('patient', 'payments'));
    }
}
