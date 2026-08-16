<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org_id = auth()->user()->organization_id ?? 1;
        
        $prescriptions = Prescription::with(['patient', 'dentist'])
                    ->where('organization_id', $org_id)
                    ->orderBy('date', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                            
        // For Create Drawer
        $patients = Patient::where('organization_id', $org_id)->orderBy('first_name')->get();
        $dentists = User::where('organization_id', $org_id)->orderBy('name')->get();

        return view('prescriptions.index', compact('prescriptions', 'patients', 'dentists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $org_id = auth()->user()->organization_id ?? 1;
        $patients = Patient::where('organization_id', $org_id)->orderBy('first_name')->get();
        // Assume dentists are users with organization_id
        $dentists = User::where('organization_id', $org_id)->orderBy('name')->get();
        
        return view('prescriptions.create', compact('patients', 'dentists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dentist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'medications' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['organization_id'] = auth()->user()->organization_id ?? 1;

        $prescription = Prescription::create($validated);

        return redirect()->route('prescriptions.show', $prescription->id)->with('success', 'Prescription created successfully.');
    }

    /**
     * Display the specified resource (used for printing).
     */
    public function show(string $id)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        $prescription = Prescription::with(['patient', 'dentist'])
                            ->where('organization_id', $org_id)
                            ->findOrFail($id);
                            
        return view('prescriptions.print', compact('prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
