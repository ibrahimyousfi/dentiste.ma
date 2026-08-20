<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Clinics Management</h1>
                <p class="text-slate-400 mt-1">Monitor and manage all tenant clinics on the platform.</p>
            </div>
            <a href="{{ route('admin.organizations.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-lg hover:bg-indigo-500 transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Register New Clinic
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        
        @if(isset($pendingRequests) && $pendingRequests->count() > 0)
            <div class="mb-6 bg-amber-500/10 border border-amber-500/20 rounded-xl overflow-hidden shadow-sm">
                <div class="px-4 py-3 border-b border-amber-500/20 bg-amber-500/5 flex items-center justify-between">
                    <div class="flex items-center text-amber-400 font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pending Subscription Upgrades ({{ $pendingRequests->count() }})
                    </div>
                    <a href="{{ route('admin.subscriptions.index') }}" class="text-sm text-amber-400 hover:text-amber-300 font-medium underline">Manage All</a>
                </div>
                <div class="divide-y divide-amber-500/10">
                    @foreach($pendingRequests as $req)
                        <div class="px-4 py-3 flex items-center justify-between">
                            <div>
                                <span class="text-white font-semibold">{{ $req->organization->name }}</span>
                                <span class="text-slate-400 text-sm ml-2">requested upgrade to</span>
                                <span class="text-amber-400 font-bold ml-1">{{ $req->plan->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('admin.subscriptions.approve', $req->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 text-xs font-bold rounded-lg border border-emerald-500/30 transition">
                                        Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-xl overflow-hidden">
            <!-- Table Controls -->
            <div class="p-6 border-b border-[#334155] flex justify-between items-center bg-[#0f172a]/50">
                <div class="relative w-64">
                    <input type="text" placeholder="Search clinics..." class="w-full bg-[#1e293b] border border-[#334155] rounded-lg pl-10 pr-4 py-2 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-[#1e293b] border border-[#334155] text-slate-300 rounded-lg text-sm font-medium hover:bg-[#334155] transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    <button class="px-4 py-2 bg-[#1e293b] border border-[#334155] text-slate-300 rounded-lg text-sm font-medium hover:bg-[#334155] transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0f172a] text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-[#334155]">
                            <th class="px-6 py-4">Clinic Details</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">SaaS Metrics</th>
                            <th class="px-6 py-4">Financials</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#334155]">
                        @forelse($organizations as $org)
                            <tr class="hover:bg-[#334155]/20 transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                            {{ substr($org->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-base">{{ $org->name }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-2">
                                                <span>Registered {{ $org->created_at->format('M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($org->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Suspended
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center gap-2 text-sm text-slate-300">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <span class="font-medium text-white">{{ $org->users_count }}</span> Staff
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-slate-300">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span class="font-medium text-white">{{ $org->patients_count ?? 0 }}</span> Patients
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-emerald-400">{{ format_currency($org->payments_sum_amount ?? 0) }}</div>
                                    <div class="text-xs text-slate-500">Gross Revenue</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View Clinic -->
                                        <a href="{{ route('admin.organizations.show', $org) }}" class="p-2 bg-[#0f172a] hover:bg-indigo-500/20 text-slate-400 hover:text-indigo-400 rounded-lg transition border border-[#334155]" title="View Clinic Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>

                                        <!-- Edit Clinic -->
                                        <a href="{{ route('admin.organizations.edit', $org) }}" class="p-2 bg-[#0f172a] hover:bg-emerald-500/20 text-slate-400 hover:text-emerald-400 rounded-lg transition border border-[#334155]" title="Edit Clinic">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        <div class="h-6 w-px bg-[#334155] mx-1"></div>

                                        <!-- WhatsApp -->
                                        @if($org->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $org->phone) }}" target="_blank" class="p-2 bg-[#0f172a] hover:bg-[#25D366]/20 text-slate-400 hover:text-[#25D366] rounded-lg transition border border-[#334155]" title="Message on WhatsApp">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.12.545 4.184 1.583 6L.511 23.49l5.603-1.468C7.886 22.955 9.932 23.5 12.03 23.5c6.647 0 12.03-5.385 12.03-12.03C24.06 4.823 18.678 0 12.031 0zm0 21.523c-1.785 0-3.535-.482-5.074-1.393l-.364-.216-3.774.989.998-3.68-.238-.377A9.553 9.553 0 012.477 12.03c0-5.263 4.283-9.546 9.554-9.546 5.27 0 9.545 4.283 9.545 9.546 0 5.263-4.275 9.545-9.545 9.545zm5.244-7.15c-.287-.144-1.703-.842-1.966-.938-.263-.096-.454-.144-.645.144-.191.288-.74 1.054-.908 1.27-.168.216-.336.24-.623.096-.287-.144-1.215-.448-2.316-1.428-.857-.763-1.436-1.706-1.604-1.994-.168-.288-.018-.444.126-.588.13-.13.287-.336.43-.504.144-.168.191-.288.287-.48.096-.192.048-.36-.024-.504-.072-.144-.645-1.556-.883-2.128-.232-.556-.47-.48-.645-.489-.168-.009-.36-.012-.552-.012-.191 0-.503.072-.767.36-.264.288-1.006.983-1.006 2.397 0 1.414 1.03 2.78 1.174 2.972.144.192 2.025 3.092 4.908 4.338 2.882 1.246 2.882.83 3.408.782.527-.048 1.703-.695 1.942-1.366.24-.67.24-1.246.168-1.366-.072-.12-.264-.192-.552-.336z"/></svg>
                                        </a>
                                        @endif

                                        <!-- Email -->
                                        @if($org->email)
                                        <a href="mailto:{{ $org->email }}" class="p-2 bg-[#0f172a] hover:bg-sky-500/20 text-slate-400 hover:text-sky-400 rounded-lg transition border border-[#334155]" title="Send Email">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </a>
                                        @endif

                                        <div class="h-6 w-px bg-[#334155] mx-1"></div>



                                        <!-- Suspend -->
                                        <form method="POST" action="{{ route('admin.organizations.suspend', $org) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 bg-[#0f172a] {{ $org->status === 'active' ? 'hover:bg-rose-500/20 hover:text-rose-400 text-slate-400' : 'bg-emerald-500/20 text-emerald-400 border-emerald-500' }} rounded-lg transition border border-[#334155]" title="{{ $org->status === 'active' ? 'Suspend Clinic' : 'Activate Clinic' }}">
                                                @if($org->status === 'active')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#0f172a] border border-[#334155] text-slate-500 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-white">No clinics found</h3>
                                    <p class="text-slate-400 mt-1 max-w-sm mx-auto">You haven't registered any clinics on the platform yet. Click the 'Register New Clinic' button to get started.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Placeholder -->
            <div class="p-4 border-t border-[#334155] bg-[#0f172a]/50 text-slate-400 text-sm flex justify-between items-center">
                <span>Showing {{ count($organizations) }} clinics</span>
                <div class="flex gap-1">
                    <button class="px-3 py-1 bg-[#1e293b] border border-[#334155] rounded hover:bg-[#334155] transition text-white">&laquo;</button>
                    <button class="px-3 py-1 bg-indigo-600 border border-indigo-600 rounded text-white font-bold">1</button>
                    <button class="px-3 py-1 bg-[#1e293b] border border-[#334155] rounded hover:bg-[#334155] transition text-white">&raquo;</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
