<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request()->query('filter', 'active');

        $query = Patient::with(['appointments' => function($q) {
            $q->where('appointment_date', '>=', now()->format('Y-m-d'))
              ->orderBy('appointment_date', 'asc')
              ->orderBy('start_time', 'asc');
        }]);

        if ($filter === 'active') {
            $query->where(function($q) {
                $q->where('treatment_status', '!=', 'completed')
                  ->orWhereNull('treatment_status');
            });
        } elseif ($filter === 'upcoming') {
            $query->whereHas('appointments', function($q) {
                $q->where('appointment_date', '>=', now()->format('Y-m-d'));
            });
        } elseif ($filter === 'today') {
            $query->whereHas('appointments', function($q) {
                $q->where('appointment_date', now()->format('Y-m-d'));
            });
        } elseif ($filter === 'in_clinic') {
            $query->whereHas('appointments', function($q) {
                $q->where('appointment_date', now()->format('Y-m-d'))
                  ->whereIn('status', ['waiting', 'in_progress']);
            });
        } elseif ($filter === 'in_treatment') {
            $query->where('treatment_status', 'in_treatment');
        } elseif ($filter === 'completed') {
            $query->where('treatment_status', 'completed');
        }

        $counts = [
            'active' => Patient::where(function($q) {
                $q->where('treatment_status', '!=', 'completed')
                  ->orWhereNull('treatment_status');
            })->count(),
            'in_treatment' => Patient::where('treatment_status', 'in_treatment')->count(),
            'completed' => Patient::where('treatment_status', 'completed')->count(),
            'all' => Patient::count(),
        ];

        $patients = $query->latest()->paginate(10);
        return view('patients.index', compact('patients', 'filter', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'national_id' => 'required|string|max:50',
            'address' => 'nullable|string',
            'total_sessions' => 'nullable|integer|min:0',
        ]);

        // In a real app, this will be the authenticated user's organization_id
        $validated['organization_id'] = auth()->user()->organization_id ?? 1;

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['notes.user', 'invoices.payments']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'national_id' => 'required|string|max:50',
            'address' => 'nullable|string',
            'total_sessions' => 'nullable|integer|min:0',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function storeNote(Request $request, Patient $patient)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $patient->notes()->create([
            'user_id' => auth()->id(),
            'note' => $request->note,
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Clinical note added successfully.');
    }

    public function incrementSession(Patient $patient)
    {
        if ($patient->completed_sessions < $patient->total_sessions) {
            $patient->completed_sessions++;
            
            if ($patient->completed_sessions >= $patient->total_sessions) {
                $patient->treatment_status = 'completed';
            }
            
            $patient->save();
            return back()->with('success', 'Session completed successfully.');
        }
        
        return back()->with('error', 'All sessions are already completed.');
    }

    public function setSessions(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'total_sessions' => 'required|integer|min:1|max:100',
        ]);

        $patient->total_sessions = $validated['total_sessions'];
        $patient->completed_sessions = 0;
        $patient->treatment_status = 'in_treatment';
        $patient->save();

        return back()->with('success', 'Treatment plan started successfully.');
    }
}
