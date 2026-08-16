<x-admin-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">System Overview</h1>
            <p class="text-slate-400 mt-1">Monitor your SaaS platform's performance, revenue, and growth.</p>
        </div>
    </x-slot>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- MRR -->
        <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500 rounded-full opacity-10 blur-xl group-hover:opacity-20 transition"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Monthly Revenue</h3>
                <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-end gap-3">
                <span class="text-3xl font-bold text-white">$12,450</span>
                <span class="text-sm font-bold text-emerald-400 flex items-center mb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +14.5%
                </span>
            </div>
        </div>

        <!-- Active Clinics -->
        <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500 rounded-full opacity-10 blur-xl group-hover:opacity-20 transition"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Active Clinics</h3>
                <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="flex items-end gap-3">
                <span class="text-3xl font-bold text-white">48</span>
                <span class="text-sm font-bold text-emerald-400 flex items-center mb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +3 this week
                </span>
            </div>
        </div>

        <!-- Total Subscriptions -->
        <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-sky-500 rounded-full opacity-10 blur-xl group-hover:opacity-20 transition"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Active Users</h3>
                <div class="p-2 bg-sky-500/10 rounded-lg text-sky-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-end gap-3">
                <span class="text-3xl font-bold text-white">312</span>
                <span class="text-sm font-bold text-slate-500 flex items-center mb-1">
                    Doctors & Staff
                </span>
            </div>
        </div>

        <!-- Churn Rate -->
        <div class="bg-[#1e293b] rounded-2xl p-6 border border-[#334155] shadow-lg relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500 rounded-full opacity-10 blur-xl group-hover:opacity-20 transition"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Churn Rate</h3>
                <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
            <div class="flex items-end gap-3">
                <span class="text-3xl font-bold text-white">1.2%</span>
                <span class="text-sm font-bold text-emerald-400 flex items-center mb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    -0.4%
                </span>
            </div>
        </div>
    </div>

    <!-- Charts & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Revenue Chart Placeholder -->
        <div class="lg:col-span-2 bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg flex flex-col">
            <div class="p-6 border-b border-[#334155] flex justify-between items-center">
                <h2 class="text-lg font-bold text-white">Revenue Growth</h2>
                <select class="bg-[#0f172a] border border-[#334155] text-sm text-slate-300 rounded-lg px-3 py-1.5 outline-none focus:border-indigo-500">
                    <option>Last 6 Months</option>
                    <option>This Year</option>
                    <option>All Time</option>
                </select>
            </div>
            <div class="p-6 flex-1 flex items-center justify-center min-h-[300px]">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-500/10 text-indigo-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="text-slate-400 font-medium">Chart.js Implementation Pending</p>
                    <p class="text-slate-500 text-sm mt-1">Connect backend data to visualize MRR growth</p>
                </div>
            </div>
        </div>

        <!-- Recent Tenants / Activity -->
        <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg flex flex-col">
            <div class="p-6 border-b border-[#334155]">
                <h2 class="text-lg font-bold text-white">Recent Signups</h2>
            </div>
            <div class="p-0 overflow-y-auto max-h-[350px]">
                <ul class="divide-y divide-[#334155]">
                    <li class="p-4 hover:bg-[#334155]/30 transition flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold shrink-0">
                            SD
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Smile Dentistry</p>
                            <p class="text-xs text-slate-400 mt-0.5">Subscribed to Pro Plan ($299/mo)</p>
                            <p class="text-xs text-slate-500 mt-1">2 hours ago</p>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-[#334155]/30 transition flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold shrink-0">
                            PD
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Premium Dental Care</p>
                            <p class="text-xs text-slate-400 mt-0.5">Started 14-day Free Trial</p>
                            <p class="text-xs text-slate-500 mt-1">Yesterday</p>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-[#334155]/30 transition flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold shrink-0">
                            DC
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Downtown Clinic</p>
                            <p class="text-xs text-slate-400 mt-0.5">Upgraded to Enterprise Plan</p>
                            <p class="text-xs text-slate-500 mt-1">2 days ago</p>
                        </div>
                    </li>
                    <li class="p-4 hover:bg-[#334155]/30 transition flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-slate-700 text-slate-300 flex items-center justify-center font-bold shrink-0">
                            FC
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Family Care Dental</p>
                            <p class="text-xs text-slate-400 mt-0.5">Subscribed to Basic Plan ($99/mo)</p>
                            <p class="text-xs text-slate-500 mt-1">3 days ago</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="p-4 border-t border-[#334155] text-center">
                <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300 font-medium">View All Tenants &rarr;</a>
            </div>
        </div>

    </div>

</x-admin-layout>
