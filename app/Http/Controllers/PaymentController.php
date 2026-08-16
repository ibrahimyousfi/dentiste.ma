<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Patient;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * One-step payment recording logic.
     * Automatically creates a paid invoice and attaches the payment to it.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,insurance',
            'notes' => 'nullable|string',
            'treatment_plan_id' => 'nullable|exists:treatment_plans,id',
        ]);

        $patient = Patient::findOrFail($request->patient_id);
        $organizationId = $patient->organization_id;

        // 1. Create the Invoice (One-Step Logic)
        $invoice = Invoice::create([
            'organization_id' => $organizationId,
            'patient_id' => $patient->id,
            'treatment_plan_id' => $request->treatment_plan_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'total_amount' => $request->amount,
            'paid_amount' => $request->amount,
            'status' => 'paid',
            'due_date' => Carbon::today(),
        ]);

        // 2. Create the Payment linked to the Invoice
        Payment::create([
            'organization_id' => $organizationId,
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => Carbon::today(),
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully! Invoice generated.');
    }
}
