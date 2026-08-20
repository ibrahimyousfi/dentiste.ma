@php $org = auth()->user()->organization; @endphp

<div class="relative z-10">
    <!-- Invoice Header -->
    <div class="flex flex-col md:flex-row justify-between items-start border-b-2 border-gray-100 pb-8 mb-8">
        <div class="mb-6 md:mb-0">
            <!-- Clinic Logo & Info (Stacked) -->
            <div class="flex flex-col items-start mb-4">
                @if($org && $org->logo)
                    <img src="{{ Storage::url($org->logo) }}" alt="{{ $org->name }}" class="h-16 w-auto object-contain mb-3 rounded-lg">
                @else
                    <div class="h-16 w-16 bg-indigo-600 rounded-lg flex items-center justify-center text-white mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $org->name ?? 'Dental Clinic' }}</h1>
                    <p class="text-sm text-gray-500">Excellence in Dentistry</p>
                </div>
            </div>
            <div class="text-sm text-gray-600 space-y-1">
                @if($org && $org->address)
                    <p>{!! nl2br(e($org->address)) !!}</p>
                @else
                    <p>Clinic Address Not Set</p>
                @endif
                <p>{{ $org->phone ?? '' }}</p>
                <p>{{ $org->email ?? '' }}</p>
            </div>
        </div>
        
        <div class="text-left md:text-right w-full md:w-auto">
            <h2 class="text-4xl font-bold text-gray-200 tracking-wider uppercase">INVOICE</h2>
            <div class="mt-4 text-sm inline-block">
                <table class="w-full text-left md:text-right">
                    <tr>
                        <td class="text-gray-500 pr-4 pb-2">Invoice Number:</td>
                        <td class="font-bold text-gray-900 pb-2">{{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-2">Date of Issue:</td>
                        <td class="font-medium text-gray-900 pb-2">{{ $invoice->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4">Due Date:</td>
                        <td class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Bill To -->
    <div class="mb-10">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Bill To</h3>
        <div class="text-gray-800 font-medium">
            <p class="text-xl font-bold text-gray-900">{{ $invoice->patient->first_name }} {{ $invoice->patient->last_name }}</p>
            <p class="text-sm mt-1 text-gray-500">File #{{ $invoice->patient->id }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ $invoice->patient->phone ?? '' }}</p>
            <p class="text-sm text-gray-600">{{ $invoice->patient->email ?? '' }}</p>
        </div>
    </div>

    <!-- Line Items (simplified) -->
    <table class="w-full mb-10 text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                <th class="py-3 px-4 rounded-l-lg font-bold">Description</th>
                <th class="py-3 px-4 text-right rounded-r-lg font-bold">Amount</th>
            </tr>
        </thead>
        <tbody class="text-sm divide-y divide-gray-100">
            <tr class="text-gray-800">
                <td class="py-4 px-4 font-medium">{{ $invoice->description ?? 'Dental Services' }}</td>
                <td class="py-4 px-4 text-right font-semibold">{{ number_format($invoice->total_amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals & Notes -->
    <div class="flex flex-col md:flex-row justify-between items-start gap-8">
        <div class="w-full md:w-1/2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Payment Notes</h3>
            <p class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-lg">
                Payment is due within 14 days. Please make checks payable to {{ $org->name ?? 'our clinic' }}. 
                For bank transfers: Bank XYZ, IBAN: MA64 0000 0000 0000 0000 0000 000.
                Thank you for your trust in our clinic!
            </p>
        </div>
        
        <div class="w-full md:w-5/12 bg-gray-50 p-6 rounded-xl">
            <table class="w-full text-right text-sm">
                <tr>
                    <td class="text-gray-600 pb-3 font-medium">Subtotal</td>
                    <td class="text-gray-900 pb-3 font-bold">{{ number_format($invoice->total_amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
                </tr>
                <tr>
                    <td class="text-gray-600 pb-3 font-medium">Tax (0%)</td>
                    <td class="text-gray-900 pb-3 font-bold">0.00 {{ $org->currency ?? 'MAD' }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="text-gray-900 pt-4 pb-2 font-bold text-lg uppercase">Total Amount</td>
                    <td class="text-indigo-600 pt-4 pb-2 font-black text-xl">{{ number_format($invoice->total_amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
                </tr>
                <tr>
                    <td class="text-green-600 pb-2 font-medium">Amount Paid</td>
                    <td class="text-green-600 pb-2 font-bold">-{{ number_format($invoice->paid_amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
                </tr>
                <tr class="border-t-4 border-gray-900">
                    <td class="text-gray-900 pt-3 font-bold uppercase tracking-wider">Balance Due</td>
                    <td class="text-gray-900 pt-3 font-black text-2xl">{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Payment History (If any) -->
    @if($invoice->payments->count() > 0)
    <div class="mt-12 pt-8 border-t border-gray-100 no-print" id="payment-history-section">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Payment History</h3>
        <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 font-bold">Date</th>
                        <th class="py-3 px-4 font-bold">Method</th>
                        <th class="py-3 px-4 font-bold">Notes</th>
                        <th class="py-3 px-4 text-right font-bold">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($invoice->payments as $payment)
                    <tr>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                        <td class="py-3 px-4 uppercase">{{ str_replace('_', ' ', $payment->payment_method) }}</td>
                        <td class="py-3 px-4 text-gray-500">{{ $payment->notes ?? '-' }}</td>
                        <td class="py-3 px-4 text-right font-bold text-green-600">{{ number_format($payment->amount, 2) }} {{ $org->currency ?? 'MAD' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <style>
        /* Hide payment history block during print if desired, although it is nice to have. 
           Wait, removing the `no-print` from the container might be better. Let's keep it visible in print as it shows the trail. */
        @media print {
            #payment-history-section { display: block !important; }
        }
    </style>
    @endif

</div>
