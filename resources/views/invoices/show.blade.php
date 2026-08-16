<x-app-layout>
    
    <!-- Custom Print CSS injected into header -->
    @push('styles')
    <style>
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .print-container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; box-shadow: none !important; border: none !important; }
            @page { margin: 1cm; }
        }
    </style>
    @endpush

    <!-- Header (No Print) -->
    <x-slot name="header" class="no-print">
        <div class="flex justify-between items-center no-print">
            <div class="flex items-center space-x-4">
                <div class="cursor-pointer p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" onclick="window.history.back()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                        Invoice #INV-2026-0042
                    </h2>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </button>
                <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md shadow-indigo-500/30">
                    Register Payment
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Invoice Paper -->
    <div class="py-8 bg-gray-100 dark:bg-gray-900 no-print">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white text-gray-900 rounded-none sm:rounded-2xl shadow-xl border border-gray-200 p-10 sm:p-16 print-container animate-fade-in relative overflow-hidden">
                
                <!-- Watermark -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-5 pointer-events-none">
                    <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                </div>

                <div class="relative z-10">
                    <!-- Invoice Header -->
                    <div class="flex justify-between items-start border-b-2 border-gray-100 pb-8 mb-8">
                        <div>
                            <!-- Clinic Logo placeholder -->
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">Pearl Dental Care</h1>
                                    <p class="text-sm text-gray-500">Excellence in Dentistry</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>123 Medical Avenue, Suite 400</p>
                                <p>Casablanca, Morocco</p>
                                <p>+212 555-1234</p>
                                <p>contact@pearldental.ma</p>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <h2 class="text-4xl font-bold text-indigo-100 tracking-wider uppercase">INVOICE</h2>
                            <div class="mt-4 text-sm">
                                <table class="w-full text-right">
                                    <tr>
                                        <td class="text-gray-500 pr-4 pb-1">Invoice Number:</td>
                                        <td class="font-bold text-gray-900 pb-1">#INV-2026-0042</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500 pr-4 pb-1">Date of Issue:</td>
                                        <td class="font-medium text-gray-900 pb-1">Aug 08, 2026</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500 pr-4">Due Date:</td>
                                        <td class="font-medium text-gray-900">Aug 22, 2026</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Bill To -->
                    <div class="mb-10">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Bill To</h3>
                        <div class="text-gray-800 font-medium">
                            <p class="text-xl font-bold text-gray-900">John Doe</p>
                            <p class="text-sm mt-1">File #PT-00042</p>
                            <p class="text-sm text-gray-600">45 Palmer Street, Apartment 4</p>
                            <p class="text-sm text-gray-600">Casablanca, Morocco</p>
                            <p class="text-sm text-gray-600 mt-1">+212 600-000000</p>
                        </div>
                    </div>

                    <!-- Line Items -->
                    <table class="w-full mb-10 text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="py-3 px-4 rounded-l-lg font-bold">Treatment / Description</th>
                                <th class="py-3 px-4 font-bold">Tooth</th>
                                <th class="py-3 px-4 text-center font-bold">Qty</th>
                                <th class="py-3 px-4 text-right font-bold">Unit Price</th>
                                <th class="py-3 px-4 text-right rounded-r-lg font-bold">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <!-- Item 1 -->
                            <tr class="text-gray-800">
                                <td class="py-4 px-4 font-medium">Composite Resin Fillings</td>
                                <td class="py-4 px-4 text-gray-500">45</td>
                                <td class="py-4 px-4 text-center">1</td>
                                <td class="py-4 px-4 text-right">$150.00</td>
                                <td class="py-4 px-4 text-right font-semibold">$150.00</td>
                            </tr>
                            <!-- Item 2 -->
                            <tr class="text-gray-800">
                                <td class="py-4 px-4 font-medium">Dental Panoramic X-Ray</td>
                                <td class="py-4 px-4 text-gray-500">-</td>
                                <td class="py-4 px-4 text-center">1</td>
                                <td class="py-4 px-4 text-right">$50.00</td>
                                <td class="py-4 px-4 text-right font-semibold">$50.00</td>
                            </tr>
                            <!-- Item 3 -->
                            <tr class="text-gray-800">
                                <td class="py-4 px-4 font-medium">Professional Teeth Cleaning (Scaling)</td>
                                <td class="py-4 px-4 text-gray-500">All</td>
                                <td class="py-4 px-4 text-center">1</td>
                                <td class="py-4 px-4 text-right">$150.00</td>
                                <td class="py-4 px-4 text-right font-semibold">$150.00</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Totals & Notes -->
                    <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                        <div class="w-full md:w-1/2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Payment Notes</h3>
                            <p class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-lg">
                                Payment is due within 14 days. Please make checks payable to Pearl Dental Care. 
                                For bank transfers: Bank XYZ, IBAN: MA64 0000 0000 0000 0000 0000 000.
                                Thank you for your trust in our clinic!
                            </p>
                        </div>
                        
                        <div class="w-full md:w-5/12 bg-gray-50 p-6 rounded-xl">
                            <table class="w-full text-right text-sm">
                                <tr>
                                    <td class="text-gray-600 pb-3 font-medium">Subtotal</td>
                                    <td class="text-gray-900 pb-3 font-bold">$350.00</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600 pb-3 font-medium">Tax (0%)</td>
                                    <td class="text-gray-900 pb-3 font-bold">$0.00</td>
                                </tr>
                                <tr class="border-t border-gray-200">
                                    <td class="text-gray-900 pt-4 pb-2 font-bold text-lg uppercase">Total Amount</td>
                                    <td class="text-indigo-600 pt-4 pb-2 font-black text-xl">$350.00</td>
                                </tr>
                                <tr>
                                    <td class="text-green-600 pb-2 font-medium">Amount Paid</td>
                                    <td class="text-green-600 pb-2 font-bold">-$350.00</td>
                                </tr>
                                <tr class="border-t-4 border-gray-900">
                                    <td class="text-gray-900 pt-3 font-bold uppercase tracking-wider">Balance Due</td>
                                    <td class="text-gray-900 pt-3 font-black text-2xl">$0.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Paid Stamp Overlay (Visible only if paid) -->
                    <div class="absolute top-1/3 right-1/4 transform rotate-12 opacity-80 pointer-events-none">
                        <div class="border-4 border-green-500 text-green-500 px-8 py-3 rounded-xl text-5xl font-black uppercase tracking-widest shadow-sm">
                            PAID IN FULL
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
