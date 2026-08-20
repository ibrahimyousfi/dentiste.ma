<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organizationId = auth()->user()->organization_id ?? 1;
        
        $query = Invoice::with('patient')
            ->where('organization_id', $organizationId);

        // Search by Invoice # or Patient Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($pq) use ($search) {
                      $pq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'All Statuses') {
            $status = strtolower($request->status);
            $query->where('status', $status);
        }

        $invoices = $query->latest()->paginate(15);
        $patients = Patient::where('organization_id', $organizationId)->orderBy('first_name')->get();

        return view('invoices.index', compact('invoices', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $organizationId = auth()->user()->organization_id ?? 1;

        Invoice::create([
            'organization_id' => $organizationId,
            'patient_id' => $request->patient_id,
            'invoice_number' => 'INV-' . date('Y') . '-' . strtoupper(substr(uniqid(), -4)),
            'total_amount' => $request->amount,
            'paid_amount' => 0,
            'status' => $request->amount > 0 ? 'unpaid' : 'paid',
            'due_date' => $request->invoice_date,
            // You might want to save description if the Invoice model has it, or use notes
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        if ($invoice->organization_id !== (auth()->user()->organization_id ?? 1)) {
            abort(403);
        }

        $invoice->load(['patient', 'payments']);
        
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Record a payment for this invoice.
     */
    public function pay(Request $request, Invoice $invoice)
    {
        if ($invoice->organization_id !== (auth()->user()->organization_id ?? 1)) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,insurance',
            'notes' => 'nullable|string',
        ]);

        // Validate amount does not exceed balance
        $balance = $invoice->total_amount - $invoice->paid_amount;
        if ($request->amount > $balance) {
            return back()->withErrors(['amount' => 'Payment amount cannot exceed the balance due.']);
        }

        // Create Payment
        Payment::create([
            'organization_id' => $invoice->organization_id,
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => Carbon::today(),
            'notes' => $request->notes,
        ]);

        // Update Invoice status
        $invoice->paid_amount += $request->amount;
        if ($invoice->paid_amount >= $invoice->total_amount) {
            $invoice->status = 'paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->status = 'partial';
        }
        $invoice->save();

        return back()->with('success', 'Payment recorded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->organization_id !== (auth()->user()->organization_id ?? 1)) {
            abort(403);
        }
        
        // Optionally prevent deleting if it has payments
        if ($invoice->payments()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete invoice with existing payments.']);
        }

        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
