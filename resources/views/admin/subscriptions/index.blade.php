<x-admin-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Subscriptions Management</h1>
            <p class="text-slate-400 mt-1">Manage subscription plans and active clinic tenants.</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="space-y-6">
            
            <!-- Session Messages -->
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl mb-6 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Subscription Plans Overview -->
            <div class="bg-[#1e293b] border border-[#334155] overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-6">Subscription Plans</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($plans as $plan)
                        <div class="border rounded-xl p-6 {{ $plan->slug === 'pro' ? 'border-indigo-500/50 bg-indigo-500/10' : 'border-[#334155] bg-[#0f172a]' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-lg text-white">{{ $plan->name }}</h4>
                                    <p class="text-2xl font-black mt-2 text-white">${{ $plan->price_monthly }}<span class="text-sm font-normal text-slate-400">/mo</span></p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $plan->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            
                            <ul class="space-y-2 text-sm text-slate-300">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $plan->limit_users ? $plan->limit_users . ' Users Limit' : 'Unlimited Users' }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $plan->limit_patients ? $plan->limit_patients . ' Patients Limit' : 'Unlimited Patients' }}
                                </li>
                                @foreach($plan->features ?? [] as $feature => $enabled)
                                    @if($enabled)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ ucwords(str_replace('_', ' ', $feature)) }}
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pending Upgrade Requests -->
            @if(isset($pendingRequests) && count($pendingRequests) > 0)
            <div class="bg-[#1e293b] border border-amber-500/30 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-amber-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pending Upgrade Requests
                        </h3>
                        <span class="px-2.5 py-0.5 bg-amber-500/20 text-amber-400 rounded-full text-xs font-bold">{{ count($pendingRequests) }} Pending</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="bg-[#0f172a] text-slate-400 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="py-3 px-4 rounded-l-lg border-b border-[#334155]">Clinic</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Requested Plan</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Payment Method</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Requested At</th>
                                    <th class="py-3 px-4 rounded-r-lg text-right border-b border-[#334155]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#334155]">
                                @foreach($pendingRequests as $req)
                                <tr class="hover:bg-[#334155]/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-white">{{ $req->organization->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-slate-400">{{ $req->organization->email ?? '' }}</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-500/20 text-indigo-400">
                                            {{ $req->plan->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-xs font-medium uppercase">
                                        {{ str_replace('_', ' ', $req->payment_method) }}
                                    </td>
                                    <td class="py-4 px-4">
                                        {{ $req->created_at->diffForHumans() }}
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.subscriptions.requests.approve', $req) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg transition" onclick="return confirm('Approve this upgrade?');">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.subscriptions.requests.reject', $req) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-[#0f172a] border border-[#334155] hover:bg-rose-500/20 hover:text-rose-400 hover:border-rose-500/50 text-slate-300 text-xs font-bold rounded-lg transition" onclick="return confirm('Reject this upgrade request?');">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Active Subscriptions -->
            <div class="bg-[#1e293b] border border-[#334155] overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-6">Active Subscriptions</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="bg-[#0f172a] text-slate-400 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="py-3 px-4 rounded-l-lg border-b border-[#334155]">Clinic</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Plan</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Status</th>
                                    <th class="py-3 px-4 border-b border-[#334155]">Ends At</th>
                                    <th class="py-3 px-4 rounded-r-lg text-right border-b border-[#334155]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#334155]">
                                @foreach($subscriptions as $sub)
                                <tr class="hover:bg-[#334155]/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-white">{{ $sub->organization->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-slate-400">{{ $sub->organization->email ?? '' }}</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-500/20 text-indigo-400">
                                            {{ $sub->plan->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if($sub->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400">Active</span>
                                        @elseif($sub->status === 'suspended')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-500/20 text-rose-400">Suspended</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-500/20 text-slate-300">{{ ucfirst($sub->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        {{ $sub->ends_at ? $sub->ends_at->format('M d, Y') : 'Lifetime' }}
                                        @if($sub->ends_at && $sub->ends_at->isPast())
                                            <span class="text-rose-400 text-xs ml-1">(Expired)</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Update Plan (Direct buttons for simplicity in dark theme) -->
                                            <div class="flex flex-col gap-1 items-end">
                                                @foreach($plans as $plan)
                                                    @if($plan->id !== $sub->subscription_plan_id)
                                                    <form method="POST" action="{{ route('admin.subscriptions.update-plan', $sub) }}">
                                                        @csrf
                                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                        <button type="submit" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">To {{ $plan->name }}</button>
                                                    </form>
                                                    @endif
                                                @endforeach
                                            </div>
                                            
                                            <!-- Extend -->
                                            <form method="POST" action="{{ route('admin.subscriptions.extend', $sub) }}" class="ml-2 pl-2 border-l border-[#334155]">
                                                @csrf
                                                <input type="hidden" name="days" value="30">
                                                <button type="submit" class="text-xs text-emerald-400 hover:text-emerald-300 font-medium">+30 Days</button>
                                            </form>

                                            <!-- Suspend -->
                                            <form method="POST" action="{{ route('admin.subscriptions.suspend', $sub) }}" class="ml-2 pl-2 border-l border-[#334155]">
                                                @csrf
                                                <button type="submit" class="text-xs {{ $sub->status === 'suspended' ? 'text-emerald-400 hover:text-emerald-300' : 'text-rose-400 hover:text-rose-300' }} font-medium">
                                                    {{ $sub->status === 'suspended' ? 'Re-activate' : 'Suspend' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $subscriptions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
