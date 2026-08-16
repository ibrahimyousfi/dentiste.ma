<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\ToothFinding;
use Illuminate\Http\Request;

class DentalChartController extends Controller
{
    public function show(Patient $patient)
    {
        // Security: Ensure the user belongs to the same organization as the patient
        if ($patient->organization_id !== auth()->user()->organization_id) {
            abort(403, 'Unauthorized access to this patient.');
        }

        $findings = ToothFinding::where('patient_id', $patient->id)->get();
        $isChild = \Carbon\Carbon::parse($patient->date_of_birth)->age <= 14;

        $treatmentCatalogs = \App\Models\TreatmentCatalog::where('organization_id', auth()->user()->organization_id)->get();
        $clinicName = auth()->user()->organization->name ?? 'Dental Clinic';

        return view('patients.dental-chart', compact('patient', 'findings', 'isChild', 'treatmentCatalogs', 'clinicName'));
    }

    public function store(Request $request, Patient $patient)
    {
        if ($patient->organization_id !== auth()->user()->organization_id) {
            abort(403, 'Unauthorized access to this patient.');
        }

        $validated = $request->validate([
            'chartData' => 'required|array',
        ]);

        // We can just wipe and rewrite the baseline chart for now
        // A full clinical app might want to append to a history instead.
        ToothFinding::where('patient_id', $patient->id)
            ->whereNull('examination_id')
            ->delete();

        $inserts = [];
        $now = now();
        foreach ($validated['chartData'] as $tooth => $data) {
            // Only save if there is an actual finding (not fully healthy)
            $isHealthy = $data['status'] === 'healthy';
            $allSurfacesHealthy = true;
            if (isset($data['surfaces']) && is_array($data['surfaces'])) {
                foreach ($data['surfaces'] as $surf) {
                    if ($surf !== 'healthy') {
                        $allSurfacesHealthy = false;
                        break;
                    }
                }
            }
            
            if (!$isHealthy || !$allSurfacesHealthy || !empty($data['treatments'])) {
                
                // Calculate total price from treatments array if present
                $totalPrice = 0;
                if (!empty($data['treatments']) && is_array($data['treatments'])) {
                    foreach ($data['treatments'] as $t) {
                        $totalPrice += (float) ($t['price'] ?? 0);
                    }
                } else {
                    $totalPrice = isset($data['price']) ? (float)$data['price'] : 0.00;
                }

                $inserts[] = [
                    'patient_id' => $patient->id,
                    'tooth_number' => $tooth,
                    'status' => $data['status'] ?? 'healthy',
                    'surfaces' => isset($data['surfaces']) ? json_encode($data['surfaces']) : null,
                    'treatments' => !empty($data['treatments']) ? json_encode($data['treatments']) : null,
                    'price' => $totalPrice,
                    'received' => isset($data['received']) ? (float)$data['received'] : 0.00,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($inserts)) {
            ToothFinding::insert($inserts);
        }

        return response()->json(['success' => true]);
    }

    public function generatePlan(Request $request, Patient $patient)
    {
        if ($patient->organization_id !== auth()->user()->organization_id) {
            abort(403, 'Unauthorized access to this patient.');
        }

        // Fetch all findings with treatments
        $findings = ToothFinding::where('patient_id', $patient->id)
            ->whereNotNull('treatments')
            ->get();

        if ($findings->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No treatments found in the chart to generate a plan.']);
        }

        $totalEstimatedCost = 0;
        $notes = "Generated from Interactive Odontogram:\n\n";

        foreach ($findings as $finding) {
            $treatments = json_decode($finding->treatments, true);
            if (is_array($treatments)) {
                $notes .= "Tooth {$finding->tooth_number}:\n";
                foreach ($treatments as $treatment) {
                    $price = (float)($treatment['price'] ?? 0);
                    $totalEstimatedCost += $price;
                    $notes .= "- {$treatment['name']} (" . format_currency($price) . ")\n";
                }
                $notes .= "\n";
            }
        }

        // Create the treatment plan
        $plan = \App\Models\TreatmentPlan::create([
            'organization_id' => $patient->organization_id,
            'patient_id' => $patient->id,
            'dentist_id' => auth()->id(),
            'name' => 'Odontogram Plan - ' . now()->format(auth()->user()->organization->date_format ?? 'Y-m-d'),
            'status' => 'proposed',
            'total_estimated_cost' => $totalEstimatedCost,
            'notes' => $notes,
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('treatment-plans.show', $plan->id)
        ]);
    }
}
