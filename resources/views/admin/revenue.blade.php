<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Financial Reports</h1>
                <p class="text-slate-400 mt-1">Detailed breakdown of platform earnings, MRR, and transaction history.</p>
            </div>
            <button class="bg-[#1e293b] border border-[#334155] text-slate-300 hover:text-white px-5 py-2.5 rounded-lg shadow-lg hover:bg-[#334155] transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Report
            </button>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg">
                <p class="text-sm font-medium text-slate-400">Monthly Recurring Revenue (MRR)</p>
                <div class="flex items-end gap-3 mt-2">
                    <p class="text-3xl font-bold text-emerald-400">$12,450</p>
                    <span class="text-sm text-emerald-500 font-medium mb-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        8.4%
                    </span>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg">
                <p class="text-sm font-medium text-slate-400">Annual Run Rate (ARR)</p>
                <div class="flex items-end gap-3 mt-2">
                    <p class="text-3xl font-bold text-white">$149,400</p>
                    <span class="text-sm text-emerald-500 font-medium mb-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        12.1%
                    </span>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg">
                <p class="text-sm font-medium text-slate-400">Average Revenue Per Clinic</p>
                <div class="flex items-end gap-3 mt-2">
                    <p class="text-3xl font-bold text-white">$296</p>
                    <span class="text-sm text-rose-500 font-medium mb-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        1.2%
                    </span>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg">
                <p class="text-sm font-medium text-slate-400">Net Revenue Retention</p>
                <div class="flex items-end gap-3 mt-2">
                    <p class="text-3xl font-bold text-white">104%</p>
                    <span class="text-sm text-emerald-500 font-medium mb-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        Healthy
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg overflow-hidden">
                <div class="p-6 border-b border-[#334155] flex justify-between items-center bg-[#0f172a]/50">
                    <h3 class="text-lg font-bold text-white">Recent Payouts & Invoices</h3>
                    <select class="bg-[#1e293b] border border-[#334155] text-sm text-slate-300 rounded-lg px-3 py-1.5 outline-none focus:border-indigo-500">
                        <option>All Transactions</option>
                        <option>Successful</option>
                        <option>Failed</option>
                        <option>Refunded</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0f172a] text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-[#334155]">
                                <th class="px-6 py-4">Transaction ID</th>
                                <th class="px-6 py-4">Clinic</th>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#334155]">
                            <tr class="hover:bg-[#334155]/20">
                                <td class="px-6 py-4 text-sm font-medium text-slate-300">#TXN-8942A</td>
                                <td class="px-6 py-4 text-sm font-bold text-white">Downtown Dental</td>
                                <td class="px-6 py-4 text-sm font-bold text-emerald-400">$299.00</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-emerald-500/10 text-emerald-400 text-xs font-medium border border-emerald-500/20">
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">Today, 09:23 AM</td>
                            </tr>
                            <tr class="hover:bg-[#334155]/20">
                                <td class="px-6 py-4 text-sm font-medium text-slate-300">#TXN-8941B</td>
                                <td class="px-6 py-4 text-sm font-bold text-white">Smile Care Clinic</td>
                                <td class="px-6 py-4 text-sm font-bold text-emerald-400">$99.00</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-emerald-500/10 text-emerald-400 text-xs font-medium border border-emerald-500/20">
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">Yesterday, 14:10 PM</td>
                            </tr>
                            <tr class="hover:bg-[#334155]/20 bg-rose-500/5">
                                <td class="px-6 py-4 text-sm font-medium text-slate-300">#TXN-8940C</td>
                                <td class="px-6 py-4 text-sm font-bold text-white">Bright Smiles</td>
                                <td class="px-6 py-4 text-sm font-bold text-rose-400">$299.00</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-rose-500/10 text-rose-400 text-xs font-medium border border-rose-500/20">
                                        Failed
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">Aug 07, 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg p-6">
                <h3 class="text-lg font-bold text-white mb-6">Revenue by Plan</h3>
                
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-white">Pro Plan ($299/mo)</span>
                            <span class="text-slate-400 font-bold">$5,382 / mo</span>
                        </div>
                        <div class="w-full bg-[#0f172a] rounded-full h-2.5 border border-[#334155]">
                            <div class="bg-indigo-500 h-2.5 rounded-full" style="width: 43%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">43% of total revenue (18 Clinics)</p>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-white">Enterprise Plan ($899/mo)</span>
                            <span class="text-slate-400 font-bold">$4,495 / mo</span>
                        </div>
                        <div class="w-full bg-[#0f172a] rounded-full h-2.5 border border-[#334155]">
                            <div class="bg-purple-500 h-2.5 rounded-full" style="width: 36%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">36% of total revenue (5 Clinics)</p>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-white">Basic Plan ($99/mo)</span>
                            <span class="text-slate-400 font-bold">$2,574 / mo</span>
                        </div>
                        <div class="w-full bg-[#0f172a] rounded-full h-2.5 border border-[#334155]">
                            <div class="bg-sky-500 h-2.5 rounded-full" style="width: 21%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">21% of total revenue (26 Clinics)</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-[#334155] text-center">
                    <p class="text-sm text-slate-400">Total processed volume (YTD)</p>
                    <p class="text-2xl font-bold text-white mt-1">$96,400</p>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
