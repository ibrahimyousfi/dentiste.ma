<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource (or JSON for calendar).
     */
    public function index(Request $request)
    {
        // If the request wants JSON or has 'start' parameter from FullCalendar, return events
        if ($request->wantsJson() || $request->has('start')) {
            $start = $request->query('start');
            $end = $request->query('end');

            $query = Appointment::with(['patient', 'dentist']);

            if ($start && $end) {
                $query->whereBetween('appointment_date', [
                    Carbon::parse($start)->format('Y-m-d'),
                    Carbon::parse($end)->format('Y-m-d')
                ]);
            }

            $appointments = $query->get();

            $events = $appointments->map(function ($appt) {
                // Determine color based on status
                $color = match($appt->status) {
                    'confirmed' => '#10B981', // Emerald
                    'waiting' => '#F59E0B',   // Amber
                    'in_progress' => '#3B82F6', // Blue
                    'completed' => '#6B7280', // Gray
                    'cancelled' => '#EF4444', // Red
                    'no_show' => '#8B5CF6',   // Purple
                    default => '#39D3C4',     // Primary Teal (scheduled)
                };

                return [
                    'id' => $appt->id,
                    'title' => $appt->patient->first_name . ' ' . $appt->patient->last_name . ' - ' . $appt->dentist->name,
                    'start' => $appt->appointment_date . 'T' . $appt->start_time,
                    'end' => $appt->appointment_date . 'T' . $appt->end_time,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'extendedProps' => [
                        'status' => $appt->status,
                        'patient_id' => $appt->patient_id,
                        'dentist_id' => $appt->dentist_id,
                        'notes' => $appt->notes
                    ]
                ];
            });

            return response()->json($events);
        }

        // Otherwise, return the View with needed data for modals
        $patients = Patient::orderBy('first_name')->get();
        
        // Dentists are users with 'Clinic Owner' role (or we can just fetch all users for now if it's a small clinic)
        // Ideally we fetch users who have permission to be dentists.
        // For SaaS, usually we'll just get all users in the organization who aren't patients or secretaries.
        $dentists = User::where('organization_id', auth()->user()->organization_id ?? 1)
            ->whereHas('roles', function($q) {
                $q->where('name', 'Clinic Owner'); // Or 'Dentist' if added later
            })->get();

        return view('appointments.index', compact('patients', 'dentists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dentist_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $maxMinutesPerDay = 480; // 8 hours of clinical time
        $offDays = [0]; // Sunday (0 = Sunday, 1 = Monday, etc.)
        $requestedDate = Carbon::parse($request->appointment_date);
        $newApptDuration = Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time));

        // Smart Logic Check
        $isOffDay = in_array($requestedDate->dayOfWeek, $offDays);
        
        $existingAppointments = Appointment::where('appointment_date', $requestedDate->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->get();
            
        $totalBookedMinutes = 0;
        foreach ($existingAppointments as $appt) {
            $totalBookedMinutes += Carbon::parse($appt->start_time)->diffInMinutes(Carbon::parse($appt->end_time));
        }

        $isFull = ($totalBookedMinutes + $newApptDuration) > $maxMinutesPerDay;

        // Skip the check if 'force' is passed (optional feature, but for now we strictly enforce)
        if ($isOffDay || $isFull) {
            $nextDate = $requestedDate->copy()->addDay();
            while (true) {
                if (in_array($nextDate->dayOfWeek, $offDays)) {
                    $nextDate->addDay();
                    continue;
                }
                
                $nextDayAppointments = Appointment::where('appointment_date', $nextDate->format('Y-m-d'))
                    ->whereNotIn('status', ['cancelled', 'no_show'])
                    ->get();
                    
                $nextDayBookedMinutes = 0;
                foreach ($nextDayAppointments as $appt) {
                    $nextDayBookedMinutes += Carbon::parse($appt->start_time)->diffInMinutes(Carbon::parse($appt->end_time));
                }

                if (($nextDayBookedMinutes + $newApptDuration) <= $maxMinutesPerDay) {
                    break;
                }
                $nextDate->addDay();
            }

            $reason = $isOffDay 
                ? "The selected day is a Holiday (Sunday)." 
                : "The clinic has reached its maximum working capacity (8 hours) for this day.";
            
            return response()->json([
                'success' => false, 
                'message' => $reason,
                'suggest_next' => true,
                'next_available_date' => $nextDate->format('Y-m-d'),
                'next_available_formatted' => $nextDate->format('l, M j, Y')
            ]);
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'dentist_id' => $request->dentist_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status ?? 'scheduled',
            'notes' => $request->notes
        ]);

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Check if this is a drag-and-drop resize/move update from FullCalendar
        if ($request->has('drag_update')) {
            $request->validate([
                'appointment_date' => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s',
            ]);

            $appointment->update([
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return response()->json(['success' => true]);
        }

        // Otherwise full update from form
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dentist_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $oldStatus = $appointment->status;
        $appointment->update($validated);

        // Smart Cancellation Alert
        $waitlistMatches = false;
        if ($request->status === 'Cancelled' && $oldStatus !== 'Cancelled') {
            // Check if there's anyone on the waitlist for this organization
            $waitlistCount = \App\Models\Waitlist::where('organization_id', $appointment->organization_id)
                ->where('status', 'waiting')
                ->count();
            
            if ($waitlistCount > 0) {
                $waitlistMatches = true;
            }
        }

        return response()->json([
            'success' => true, 
            'appointment' => $appointment,
            'waitlist_matches' => $waitlistMatches,
            'message' => $waitlistMatches ? 'Appointment cancelled. There are patients on the Waitlist who can fill this slot!' : 'Appointment updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Quickly update appointment status from dashboard
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string|in:scheduled,confirmed,waiting,in_progress,completed,cancelled,no_show'
        ]);

        $appointment->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}
