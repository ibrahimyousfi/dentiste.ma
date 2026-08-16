<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="cursor-pointer p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" onclick="window.history.back()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                    {{ __('Register Payment') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Record a new payment for Invoice #INV-2026-0043 (Sarah Adams)</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg shadow-indigo-100/20 dark:shadow-none sm:rounded-3xl border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row">
                
                <!-- Left Panel: Invoice Summary -->
                <div class="w-full md:w-5/12 bg-gray-50 dark:bg-gray-900/50 p-8 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-6">Payment Summary</h3>
                    
                    <div class="space-y-6">
                        <!-- Invoice Info -->
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Invoice</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">#INV-2026-0043</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Patient Name</p>
                            <div class="flex items-center">
                                <div class="h-6 w-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xs mr-2">SA</div>
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">Sarah Adams</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                        <!-- Financials -->
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600 dark:text-gray-400 font-medium">Invoice Total</p>
                            <p class="text-gray-900 dark:text-gray-100 font-bold">$1,200.00</p>
                        </div>
                        <div class="flex justify-between items-center text-green-600">
                            <p class="font-medium">Previously Paid</p>
                            <p class="font-bold">-$600.00</p>
                        </div>
                        
                        <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800 rounded-xl p-4 mt-6">
                            <p class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-1">Remaining Balance Due</p>
                            <p class="text-3xl font-black text-orange-600 dark:text-orange-400">$600.00</p>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Payment Form -->
                <div class="w-full md:w-7/12 p-8 lg:p-12" x-data="{ amount: 600.00 }">
                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" name="invoice_id" value="43">

                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Enter Payment Details</h3>

                        <div class="space-y-6">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Payment Amount</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-lg font-bold">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="amount" id="amount" x-model="amount" required
                                        class="block w-full pl-8 pr-4 py-3 sm:text-lg font-bold rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors">
                                </div>
                                <div class="mt-2 flex space-x-2">
                                    <button type="button" @click="amount = 600.00" class="text-xs px-3 py-1 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-lg hover:bg-indigo-100 font-medium transition-colors">Pay Full Balance</button>
                                    <button type="button" @click="amount = 300.00" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 font-medium transition-colors">Pay Half</button>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Payment Method</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3" x-data="{ method: 'card' }">
                                    
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="payment_method" value="cash" x-model="method" class="peer sr-only">
                                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition-all">
                                            <svg class="w-6 h-6 mx-auto mb-1 text-gray-400 peer-checked:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Cash</span>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="payment_method" value="card" x-model="method" class="peer sr-only">
                                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition-all">
                                            <svg class="w-6 h-6 mx-auto mb-1 text-gray-400 peer-checked:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Card</span>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="payment_method" value="transfer" x-model="method" class="peer sr-only">
                                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition-all">
                                            <svg class="w-6 h-6 mx-auto mb-1 text-gray-400 peer-checked:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                            <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Transfer</span>
                                        </div>
                                    </label>
                                    
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="payment_method" value="insurance" x-model="method" class="peer sr-only">
                                        <div class="p-3 text-center rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition-all">
                                            <svg class="w-6 h-6 mx-auto mb-1 text-gray-400 peer-checked:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Insurance</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Date & Notes -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="payment_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Date</label>
                                    <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}"
                                        class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors py-2.5">
                                </div>
                                <div>
                                    <label for="reference" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Receipt / Ref #</label>
                                    <input type="text" name="reference" id="reference" placeholder="Optional"
                                        class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors py-2.5">
                                </div>
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Payment Notes</label>
                                <textarea id="notes" name="notes" rows="2"
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors"></textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all shadow-lg shadow-indigo-500/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
