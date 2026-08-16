<?php

namespace App\Http\Controllers;

use App\Models\LabCase;
use App\Models\LabPartner;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class LabCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org_id = auth()->user()->organization_id ?? 1;
        
        $cases = LabCase::with(['patient', 'dentist', 'labPartner'])
                    ->where('organization_id', $org_id)
                    ->orderBy('sent_date', 'desc')
                    ->paginate(15);
                    
        $activeCount = LabCase::where('organization_id', $org_id)
                            ->where('status', 'sent')
                            ->count();
                            
        $delayedCount = LabCase::where('organization_id', $org_id)
                            ->where('status', 'delayed')
                            ->count();
                            
        $receivedMonthCount = LabCase::where('organization_id', $org_id)
                            ->where('status', 'received')
                            ->whereMonth('updated_at', now()->month)
                            ->count();
                            
        // For the Create Drawer
        $patients = Patient::where('organization_id', $org_id)->orderBy('first_name')->get();
        $partners = LabPartner::where('organization_id', $org_id)->orderBy('name')->get();
        $dentists = User::where('organization_id', $org_id)->orderBy('name')->get();

        return view('lab-cases.index', compact('cases', 'activeCount', 'delayedCount', 'receivedMonthCount', 'patients', 'partners', 'dentists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $org_id = auth()->user()->organization_id ?? 1;
        $patients = Patient::where('organization_id', $org_id)->orderBy('first_name')->get();
        $partners = LabPartner::where('organization_id', $org_id)->orderBy('name')->get();
        // Assume dentists are users with organization_id
        $dentists = User::where('organization_id', $org_id)->orderBy('name')->get();
        
        return view('lab-cases.create', compact('patients', 'partners', 'dentists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'dentist_id' => 'required|exists:users,id',
            'lab_partner_id' => 'required|exists:lab_partners,id',
            'sent_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:sent_date',
            'instructions' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $validated['organization_id'] = auth()->user()->organization_id ?? 1;
        $validated['status'] = 'sent';

        LabCase::create($validated);

        return redirect()->route('lab-cases.index')->with('success', 'Lab case created and sent successfully.');
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
