<?php

namespace App\Http\Controllers;

use App\Models\TreatmentPlan;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class TreatmentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org_id = auth()->user()->organization_id ?? 1;
        
        $plans = TreatmentPlan::with(['patient', 'dentist'])
                    ->withCount('sessions')
                    ->where('organization_id', $org_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                    
        $proposedCount = TreatmentPlan::where('organization_id', $org_id)
                            ->where('status', 'proposed')
                            ->count();
                            
        $acceptedCount = TreatmentPlan::where('organization_id', $org_id)
                            ->where('status', 'accepted')
                            ->count();
                            
        $completedCount = TreatmentPlan::where('organization_id', $org_id)
                            ->where('status', 'completed')
                            ->count();
                            
        return view('treatments.index', compact('plans', 'proposedCount', 'acceptedCount', 'completedCount'));
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
        
        return view('treatments.create', compact('patients', 'dentists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dentist_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'total_estimated_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['organization_id'] = auth()->user()->organization_id ?? 1;
        $validated['status'] = 'proposed';

        TreatmentPlan::create($validated);

        return redirect()->route('treatment-plans.index')->with('success', 'Treatment plan proposed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
