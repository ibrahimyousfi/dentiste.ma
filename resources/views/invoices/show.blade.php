@if(request()->has('print'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - {{ $invoice->patient->first_name }} {{ $invoice->patient->last_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-family: 'Inter', sans-serif; }
        @page { margin: 10mm; }
        .no-print { display: none !important; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased" onload="setTimeout(() => window.print(), 800)">
    <div class="max-w-4xl mx-auto p-8">
        @include('invoices.partials.invoice-content')
    </div>
</body>
</html>
@else
<x-app-layout>
    
    <!-- Header (No Print) -->
    <x-slot name="header" class="no-print">
        <div class="flex justify-between items-center no-print">
            <div class="flex items-center space-x-4">
                <a href="{{ route('invoices.index') }}" class="cursor-pointer p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight flex items-center gap-2">
                        Invoice {{ $invoice->invoice_number }}
                        <x-ui.status-badge :status="$invoice->status" size="sm" />
                    </h2>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('invoices.show', $invoice) }}?print=true" target="_blank" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </a>
                @if($invoice->status !== 'paid')
                <button x-data x-on:click="$dispatch('open-drawer', 'record-payment-drawer')" class="inline-flex items-center px-4 py-2 bg-[#39D3C4] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2db3a6] shadow-md shadow-[#39D3C4]/30">
                    Record Payment
                </button>
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Invoice Paper -->
    <div class="py-8 bg-gray-100 dark:bg-gray-900 no-print">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white text-gray-900 rounded-none sm:rounded-2xl shadow-xl border border-gray-200 p-10 sm:p-16 animate-fade-in relative overflow-hidden">
                @include('invoices.partials.invoice-content')
            </div>
        </div>
    </div>

    <!-- Record Payment Drawer -->
    <x-ui.drawer id="record-payment-drawer" title="Record Payment">
        <form id="record-payment-form" action="{{ route('invoices.pay', $invoice) }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Balance Info -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Balance Due</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }} {{ auth()->user()->organization->currency ?? 'MAD' }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount ($) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0.01" max="{{ $invoice->total_amount - $invoice->paid_amount }}" name="amount" id="amount" value="{{ $invoice->total_amount - $invoice->paid_amount }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method <span class="text-red-500">*</span></label>
                        <select id="payment_method" name="payment_method" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="insurance">Insurance</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" onclick="document.getElementById('record-payment-form').submit();">Record Payment</x-ui.button>
        </x-slot>
    </x-ui.drawer>

</x-app-layout>
@endif
