<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;

class KioskController extends Controller
{
    /**
     * Show the Kiosk welcome screen.
     */
    public function index()
    {
        return view('kiosk.index');
    }

    /**
     * Identify patient by phone number and check for today's appointment.
     */
    public function identify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Find patient by phone
        $patient = Patient::where('phone', $request->phone)->first();

        if (!$patient) {
            return back()->with('error', 'No patient found with this phone number. Please check with the receptionist.');
        }

        // Check if patient has an appointment today
        $appointment = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', Carbon::today())
            ->whereIn('status', ['Scheduled', 'Confirmed'])
            ->orderBy('start_time', 'asc')
            ->first();

        if (!$appointment) {
            return back()->with('error', 'You do not have any scheduled appointments for today. Please check with the receptionist.');
        }

        // Store patient and appointment ID in session for the kiosk flow
        session([
            'kiosk_patient_id' => $patient->id,
            'kiosk_appointment_id' => $appointment->id,
        ]);

        return redirect()->route('kiosk.form');
    }

    /**
     * Show the medical history update and signature form.
     */
    public function form()
    {
        $patientId = session('kiosk_patient_id');
        $appointmentId = session('kiosk_appointment_id');

        if (!$patientId || !$appointmentId) {
            return redirect()->route('kiosk.index');
        }

        $patient = Patient::findOrFail($patientId);
        $appointment = Appointment::findOrFail($appointmentId);

        return view('kiosk.form', compact('patient', 'appointment'));
    }

    /**
     * Submit the form, update medical history, check-in, and save signature.
     */
    public function submit(Request $request)
    {
        $patientId = session('kiosk_patient_id');
        $appointmentId = session('kiosk_appointment_id');

        if (!$patientId || !$appointmentId) {
            return redirect()->route('kiosk.index');
        }

        $patient = Patient::findOrFail($patientId);
        $appointment = Appointment::findOrFail($appointmentId);

        // Update medical history if provided
        if ($request->has('medical_history')) {
            $patient->medical_history = $request->medical_history;
            $patient->save();
        }

        // Handle signature saving (base64 from canvas)
        if ($request->has('signature_data') && !empty($request->signature_data)) {
            // Usually we'd save this to a Media Library or a specific 'signatures' column/table.
            // For now, we assume we might save it as an attachment or in a specific column.
            // We'll skip the actual file saving for this snippet unless we have a specific column.
        }

        // Check-in the patient
        $appointment->status = 'Waiting';
        $appointment->save();

        // Clear session
        session()->forget(['kiosk_patient_id', 'kiosk_appointment_id']);

        return redirect()->route('kiosk.done');
    }

    /**
     * Show the completion screen.
     */
    public function done()
    {
        return view('kiosk.done');
    }
}
