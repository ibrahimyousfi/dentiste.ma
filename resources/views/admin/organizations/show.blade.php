<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.organizations.index') }}" class="p-2 bg-[#1e293b] border border-[#334155] text-slate-400 hover:text-white rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">{{ $organization->name }}</h1>
                    <p class="text-slate-400 mt-1">Detailed clinic overview and performance metrics.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.organizations.edit', $organization) }}" class="bg-[#1e293b] border border-[#334155] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#334155] transition font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Clinic
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        
        <!-- Status & Contact Card -->
        <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg p-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                    {{ substr($organization->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $organization->name }}</h2>
                    <div class="flex items-center gap-4 mt-2 text-sm text-slate-400">
                        @if($organization->email)
                        <a href="mailto:{{ $organization->email }}" class="flex items-center gap-1 hover:text-indigo-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $organization->email }}
                        </a>
                        @endif
                        @if($organization->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $organization->phone) }}" target="_blank" class="flex items-center gap-1 hover:text-[#25D366] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $organization->phone }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4 items-center bg-[#0f172a] p-4 rounded-xl border border-[#334155]">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Platform Status</p>
                    @if($organization->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Active Tenant
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span> Suspended
                        </span>
                    @endif
                </div>
                <div class="w-px h-10 bg-[#334155]"></div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Subscription Plan</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 capitalize">
                        {{ $organization->subscription_plan }} Plan
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Key Metrics -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Clinic Metrics</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-[#334155]">
                            <span class="text-slate-400">Total Registered Staff</span>
                            <span class="text-xl font-bold text-white">{{ $organization->users->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-[#334155]">
                            <span class="text-slate-400">Total Patients</span>
                            <span class="text-xl font-bold text-white">{{ $organization->patients->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-[#334155]">
                            <span class="text-slate-400">Gross Processed Volume</span>
                            <span class="text-xl font-bold text-emerald-400">${{ number_format($organization->payments->sum('amount'), 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Member Since</span>
                            <span class="text-sm font-medium text-white">{{ $organization->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg p-6">
                    <h3 class="text-lg font-bold text-white mb-4">SaaS Actions</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.organizations.reset', $organization) }}">
                            @csrf
                            <button class="w-full py-2.5 bg-[#0f172a] border border-[#334155] hover:border-amber-500/50 text-slate-300 hover:text-amber-400 rounded-lg transition font-medium flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Reset Trial (14 Days)
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.organizations.suspend', $organization) }}">
                            @csrf
                            <button class="w-full py-2.5 {{ $organization->status === 'active' ? 'bg-rose-500/10 border-rose-500/20 text-rose-500 hover:bg-rose-500/20' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-500 hover:bg-emerald-500/20' }} border rounded-lg transition font-medium flex items-center justify-center gap-2">
                                @if($organization->status === 'active')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    Suspend Clinic Access
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Re-activate Clinic
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Staff List -->
            <div class="lg:col-span-2 bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg overflow-hidden">
                <div class="p-6 border-b border-[#334155] bg-[#0f172a]/50">
                    <h3 class="text-lg font-bold text-white">Registered Staff</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0f172a] text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-[#334155]">
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#334155]">
                            @forelse($organization->users as $user)
                                <tr class="hover:bg-[#334155]/20">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-slate-800 text-slate-300 text-xs font-medium rounded-md border border-[#334155]">
                                            {{ $user->roles->first()?->name ?? 'Staff' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-400">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-400">No staff members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
