<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientAuthController extends Controller
{
    /**
     * Show the login form for patients.
     */
    public function showLoginForm()
    {
        return view('patient-portal.login');
    }

    /**
     * Handle patient login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'national_id' => 'required|string',
        ]);

        // Try to find the patient
        $patient = Patient::where('phone', $request->phone)
                          ->where('national_id', $request->national_id)
                          ->first();

        if ($patient) {
            // Log the patient in using the 'patient' guard
            Auth::guard('patient')->login($patient);
            $request->session()->regenerate();

            return redirect()->intended(route('patient.dashboard'));
        }

        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ])->onlyInput('phone');
    }

    /**
     * Log the patient out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('patient.login'));
    }
}
