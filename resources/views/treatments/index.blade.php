<x-app-layout>
    <x-slot name="header_search">
        <x-ui.search placeholder="Search treatments..." />
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-treatment-plan-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">
        


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
            <x-ui.row-list>
                @foreach($plans as $plan)
                    <x-ui.row-card>
                        <!-- Left: Treatment Info & Tooth -->
                        <div class="flex items-center gap-3.5 min-w-[220px]">
                            <div class="h-11 w-11 rounded-2xl bg-[#39D3C4]/10 text-[#2db3a6] flex items-center justify-center font-bold text-sm border border-[#39D3C4]/20 shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('treatment-plans.show', $plan) }}" class="text-sm font-bold text-gray-900 hover:text-[#39D3C4] transition-colors truncate">
                                        {{ $plan->name }}
                                    </a>
                                    <x-ui.status-badge :status="$plan->status" size="xs" />
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                    <span>Tooth: <strong class="text-gray-600 font-medium">{{ $plan->tooth ?? 'General' }}</strong></span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ $plan->created_at ? $plan->created_at->format('M d, Y') : '' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle 1: Patient & Dentist -->
                        <div class="flex items-center gap-2.5 min-w-[180px]">
                            <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center text-xs font-bold shrink-0">
                                {{ substr($plan->patient->first_name, 0, 1) }}{{ substr($plan->patient->last_name, 0, 1) }}
                            </div>
                            <div class="min-w-0 text-xs">
                                <a href="{{ route('patients.show', $plan->patient) }}" class="font-semibold text-gray-900 hover:text-[#39D3C4] transition-colors block truncate">
                                    {{ $plan->patient->first_name }} {{ $plan->patient->last_name }}
                                </a>
                                <span class="text-gray-400 truncate block">Dr. {{ $plan->dentist->name }}</span>
                            </div>
                        </div>

                        <!-- Middle 2: Progress -->
                        <div class="flex items-center gap-3 min-w-[180px] flex-1 max-w-xs">
                            <div class="w-full">
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-500 mb-1">
                                    <span>Sessions: <strong class="text-gray-800">{{ $plan->completed_sessions ?? 0 }}/{{ $plan->sessions_count ?? 0 }}</strong></span>
                                    @php
                                        $progress = $plan->sessions_count > 0 ? (($plan->completed_sessions ?? 0) / $plan->sessions_count) * 100 : 0;
                                    @endphp
                                    <span>{{ round($progress) }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#39D3C4] rounded-full transition-all" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Middle 3: Financials -->
                        <div class="flex items-center gap-4 min-w-[170px] text-xs">
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Cost</span>
                                <span class="font-bold text-gray-900">{{ format_currency($plan->total_estimated_cost) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Remaining</span>
                                <span class="font-bold text-rose-500">{{ format_currency($plan->total_estimated_cost - ($plan->amount_paid ?? 0)) }}</span>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-1 shrink-0">
                            <a href="{{ route('treatment-plans.show', $plan) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-colors" title="View Plan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            
                            <button x-data x-on:click="$dispatch('open-drawer', 'edit-plan-drawer-{{ $plan->id }}')" class="p-1.5 rounded-lg text-gray-400 hover:text-sky-600 hover:bg-sky-50 transition-colors" title="Edit Plan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <button x-data x-on:click="$dispatch('open-drawer', 'add-session-drawer-{{ $plan->id }}')" class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Add Session">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>

                            <button x-data x-on:click="$dispatch('open-drawer', 'add-payment-drawer-{{ $plan->id }}')" class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Add Payment">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </button>
                            
                            <form action="{{ route('treatment-plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this treatment plan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete Plan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </x-ui.row-card>
                    
                    <!-- Include Drawers for this plan -->
                    @include('treatments.partials.drawers', ['plan' => $plan])
                    
                @endforeach
            </x-ui.row-list>
            
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
