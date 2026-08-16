<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Treatment Plans') }}
        </h2>
    </x-slot>

    <x-slot name="header_search">
        <x-ui.search placeholder="Search treatments..." />
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-treatment-plan-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Propose Plan
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">
        
        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Proposed Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Proposed</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $proposedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Awaiting approval</span>
                </div>
            </div>

            <!-- Accepted/Active Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-l-blue-500 border-t border-b border-r border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                    <span class="relative flex h-3 w-3 mr-2">
                        @if($acceptedCount > 0)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        @endif
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    Active & Accepted
                </p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-blue-600">{{ $acceptedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">In progress</span>
                </div>
            </div>

            <!-- Completed Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Completed</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $completedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-green-500 flex items-center mb-1">
                        Successfully finished
                    </span>
                </div>
            </div>
        </div>

        <!-- Treatment Plans Grid -->
        @if($plans->isEmpty())
            <x-ui.card class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No treatment plans found</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">Click "Propose Plan" to start drafting a treatment.</p>
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-treatment-plan-drawer')">
                    Propose Plan
                </x-ui.button>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col">


                        <!-- Card Header: Treatment Name & Status -->
                        <div class="mb-4 pr-8">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider 
                                    {{ $plan->status == 'proposed' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $plan->status == 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $plan->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $plan->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $plan->status }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium">{{ $plan->created_at ? $plan->created_at->format('M d, Y') : '' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                {{ $plan->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">Tooth: {{ $plan->tooth ?? 'General' }}</p>
                        </div>

                        <!-- Patient & Doctor Info -->
                        <div class="bg-gray-50 rounded-xl p-3 mb-4 border border-gray-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#39D3C4]/10 text-[#39D3C4] flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($plan->patient->first_name, 0, 1) }}{{ substr($plan->patient->last_name, 0, 1) }}
                                    </div>
                                    <a href="{{ route('patients.show', $plan->patient) }}" class="text-sm font-semibold text-gray-700 hover:text-[#39D3C4] transition-colors">
                                        {{ $plan->patient->first_name }} {{ $plan->patient->last_name }}
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Dr. {{ $plan->dentist->name }}
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Progress</span>
                                <span class="text-xs font-bold text-gray-900">{{ $plan->completed_sessions ?? 0 }}/{{ $plan->sessions_count ?? 0 }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                @php
                                    $progress = $plan->sessions_count > 0 ? (($plan->completed_sessions ?? 0) / $plan->sessions_count) * 100 : 0;
                                @endphp
                                <div class="h-full bg-[#39D3C4] rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <!-- Financials -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Estimated</div>
                                    <div class="text-sm font-bold text-gray-900">${{ number_format($plan->total_estimated_cost, 2) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Paid / Remaining</div>
                                    <div class="text-sm font-medium text-gray-500">
                                        <span class="text-emerald-600 font-bold">${{ number_format($plan->amount_paid ?? 0, 2) }}</span> / 
                                        <span class="text-rose-500 font-bold">${{ number_format($plan->total_estimated_cost - ($plan->amount_paid ?? 0), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-1.5 w-full justify-center">
                                <a href="{{ route('treatment-plans.show', $plan) }}" class="group relative p-1.5 rounded-md text-gray-400 hover:text-[#39D3C4] hover:bg-gray-50 transition-colors" title="View Plan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                
                                <button x-data x-on:click="$dispatch('open-drawer', 'edit-plan-drawer-{{ $plan->id }}')" class="group relative p-1.5 rounded-md text-gray-400 hover:text-blue-500 hover:bg-gray-50 transition-colors" title="Edit Plan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                
                                <form action="{{ route('treatment-plans.update-status', $plan) }}" method="POST" class="inline" title="Continue Treatment (Accept Plan)">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="group relative p-1.5 rounded-md text-gray-400 hover:text-indigo-500 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                </form>
                                
                                <button x-data x-on:click="$dispatch('open-drawer', 'add-session-drawer-{{ $plan->id }}')" class="group relative p-1.5 rounded-md text-gray-400 hover:text-emerald-500 hover:bg-gray-50 transition-colors" title="Add Session">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                                
                                <button x-data x-on:click="$dispatch('open-drawer', 'add-payment-drawer-{{ $plan->id }}')" class="group relative p-1.5 rounded-md text-gray-400 hover:text-orange-500 hover:bg-gray-50 transition-colors" title="Payment">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </button>
                                
                                <a href="#" class="group relative p-1.5 rounded-md text-gray-400 hover:text-purple-500 hover:bg-gray-50 transition-colors" title="Documents">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </a>
                                
                                <form action="{{ route('treatment-plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this treatment plan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="group relative p-1.5 rounded-md text-gray-400 hover:text-red-500 hover:bg-gray-50 transition-colors" title="Delete Plan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </x-ui.card>
                    
                    <!-- Include Drawers for this plan -->
                    @include('treatments.partials.drawers', ['plan' => $plan])
                    
                @endforeach
            </div>
            
            @if($plans->hasPages())
                <div class="mt-6">
                    {{ $plans->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Treatment Plan Drawer -->
    <x-ui.drawer id="create-treatment-plan-drawer" title="Propose Treatment Plan">
        <form id="create-treatment-plan-form" action="{{ route('treatment-plans.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Participants -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient <span class="text-red-500">*</span></label>
                        <select id="patient_id" name="patient_id" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="dentist_id" class="block text-sm font-medium text-gray-700 mb-1">Dentist <span class="text-red-500">*</span></label>
                        <select id="dentist_id" name="dentist_id" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="">Select Dentist</option>
                            @foreach($dentists as $dentist)
                                <option value="{{ $dentist->id }}" @selected(old('dentist_id', auth()->id()) == $dentist->id)>Dr. {{ $dentist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Plan Details & Cost -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Treatment Plan Title <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Full Mouth Rehabilitation - Phase 1" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>

                    <div>
                        <label for="total_estimated_cost" class="block text-sm font-medium text-gray-700 mb-1">Total Estimated Cost ($) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="total_estimated_cost" id="total_estimated_cost" value="{{ old('total_estimated_cost') }}" required placeholder="0.00" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Clinical Notes & Summary</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Brief overview of the planned procedures..." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-treatment-plan-form').submit()">Save Proposed Plan</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
