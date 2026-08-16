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
                    ->withSum('invoices as amount_paid', 'paid_amount')
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
                            
        // For Create Drawer
        $patients = Patient::where('organization_id', $org_id)->orderBy('first_name')->get();
        $dentists = User::where('organization_id', $org_id)->orderBy('name')->get();

        return view('treatments.index', compact('plans', 'proposedCount', 'acceptedCount', 'completedCount', 'patients', 'dentists'));
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
    public function show(TreatmentPlan $treatmentPlan)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        if ($treatmentPlan->organization_id !== $org_id) {
            abort(403);
        }
        
        $treatmentPlan->load(['patient', 'dentist', 'sessions']);
        
        // Calculate amount paid by summing up payments associated with this treatment plan
        // Assuming we have a way to track payments per plan, or we pass it
        // Since we are mocking/building the financial side, we'll pass the plan directly
        return view('treatments.show', compact('treatmentPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatmentPlan $treatmentPlan)
    {
        // Handled via drawer in index, but if accessed directly:
        return redirect()->route('treatment-plans.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TreatmentPlan $treatmentPlan)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        if ($treatmentPlan->organization_id !== $org_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_estimated_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $treatmentPlan->update($validated);

        return redirect()->back()->with('success', 'Treatment plan updated successfully.');
    }

    /**
     * Update the status of the treatment plan.
     */
    public function updateStatus(Request $request, TreatmentPlan $treatmentPlan)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        if ($treatmentPlan->organization_id !== $org_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:proposed,accepted,completed,rejected',
        ]);

        $treatmentPlan->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Treatment plan status updated to ' . $validated['status'] . '.');
    }

    /**
     * Store a new session for the treatment plan.
     */
    public function storeSession(Request $request, TreatmentPlan $treatmentPlan)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        if ($treatmentPlan->organization_id !== $org_id) {
            abort(403);
        }

        $validated = $request->validate([
            'session_date' => 'required|date',
            'clinical_notes' => 'nullable|string',
        ]);

        $treatmentPlan->sessions()->create([
            'organization_id' => $org_id,
            'patient_id' => $treatmentPlan->patient_id,
            'dentist_id' => $treatmentPlan->dentist_id,
            'session_date' => $validated['session_date'],
            'clinical_notes' => $validated['clinical_notes'],
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Treatment session added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentPlan $treatmentPlan)
    {
        $org_id = auth()->user()->organization_id ?? 1;
        if ($treatmentPlan->organization_id !== $org_id) {
            abort(403);
        }

        $treatmentPlan->delete();

        return redirect()->route('treatment-plans.index')->with('success', 'Treatment plan deleted successfully.');
    }
}
