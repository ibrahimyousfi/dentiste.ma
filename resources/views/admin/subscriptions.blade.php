<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Subscriptions Management</h1>
                <p class="text-slate-400 mt-1">Manage platform subscription plans, trials, and billing cycles.</p>
            </div>
            <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-lg hover:bg-indigo-500 transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Create New Plan
            </button>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] flex items-center justify-between shadow-lg">
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Active Subscriptions</p>
                    <p class="text-2xl font-bold text-white mt-1">42</p>
                </div>
                <div class="w-12 h-12 bg-indigo-500/10 rounded-full flex items-center justify-center text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] flex items-center justify-between shadow-lg">
                <div>
                    <p class="text-sm font-medium text-slate-400">Clinics on Free Trial</p>
                    <p class="text-2xl font-bold text-white mt-1">6</p>
                </div>
                <div class="w-12 h-12 bg-amber-500/10 rounded-full flex items-center justify-center text-amber-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] flex items-center justify-between shadow-lg">
                <div>
                    <p class="text-sm font-medium text-slate-400">Canceled this Month</p>
                    <p class="text-2xl font-bold text-white mt-1">1</p>
                </div>
                <div class="w-12 h-12 bg-rose-500/10 rounded-full flex items-center justify-center text-rose-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
        </div>

        <!-- Plans Distribution & Table -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg overflow-hidden">
                <div class="p-6 border-b border-[#334155]">
                    <h3 class="text-lg font-bold text-white">Recent Subscription Activity</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#0f172a] text-xs font-semibold text-slate-400 uppercase">
                            <tr>
                                <th class="px-6 py-4">Clinic</th>
                                <th class="px-6 py-4">Plan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Next Billing</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#334155]">
                            <tr class="hover:bg-[#334155]/20">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white text-sm">Downtown Dental</div>
                                    <div class="text-xs text-slate-400">contact@downtown.com</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-white">Pro Plan <span class="text-slate-400 font-normal">($299/mo)</span></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md border border-emerald-500/20">Active</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-300">Sep 1, 2026</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">Manage</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#334155]/20">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white text-sm">Smile Care</div>
                                    <div class="text-xs text-slate-400">admin@smilecare.net</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-white">Basic Plan <span class="text-slate-400 font-normal">($99/mo)</span></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-amber-500/10 text-amber-400 text-xs font-medium rounded-md border border-amber-500/20">Trial (3 days left)</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-300">-</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">Manage</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Available Plans -->
            <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg p-6">
                <h3 class="text-lg font-bold text-white mb-4">SaaS Plans Pricing</h3>
                
                <div class="space-y-4">
                    <div class="p-4 border border-[#334155] rounded-xl bg-[#0f172a]/50">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-white">Basic</h4>
                            <span class="px-2 py-0.5 bg-slate-800 text-slate-300 text-xs font-medium rounded-md">21 Clinics</span>
                        </div>
                        <p class="text-2xl font-bold text-indigo-400">$99<span class="text-sm font-normal text-slate-500">/mo</span></p>
                        <p class="text-xs text-slate-400 mt-2">Up to 3 staff members, basic charting.</p>
                    </div>

                    <div class="p-4 border border-indigo-500/50 rounded-xl bg-indigo-500/10 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-500 rounded-full opacity-20 blur-xl"></div>
                        <div class="flex justify-between items-start mb-2 relative z-10">
                            <h4 class="font-bold text-white flex items-center gap-2">Pro <span class="bg-indigo-500 text-white text-[10px] px-1.5 py-0.5 rounded uppercase">Popular</span></h4>
                            <span class="px-2 py-0.5 bg-indigo-900 text-indigo-300 text-xs font-medium rounded-md">18 Clinics</span>
                        </div>
                        <p class="text-2xl font-bold text-indigo-400 relative z-10">$299<span class="text-sm font-normal text-slate-400">/mo</span></p>
                        <p class="text-xs text-slate-300 mt-2 relative z-10">Unlimited staff, advanced analytics, custom domain.</p>
                    </div>

                    <div class="p-4 border border-[#334155] rounded-xl bg-[#0f172a]/50">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-white">Enterprise</h4>
                            <span class="px-2 py-0.5 bg-slate-800 text-slate-300 text-xs font-medium rounded-md">3 Clinics</span>
                        </div>
                        <p class="text-2xl font-bold text-indigo-400">$899<span class="text-sm font-normal text-slate-500">/mo</span></p>
                        <p class="text-xs text-slate-400 mt-2">Multiple branches, dedicated support manager.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
