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
                        <!-- Dropdown Menu for Actions -->
                        <div class="absolute top-4 right-4 z-10">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#">View Plan</x-dropdown-link>
                                    <x-dropdown-link href="#">Edit</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <x-dropdown-link href="#">Continue Treatment</x-dropdown-link>
                                    <x-dropdown-link href="#">Add Session</x-dropdown-link>
                                    <x-dropdown-link href="#">Payment</x-dropdown-link>
                                    <x-dropdown-link href="#">Documents</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

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
                    </x-ui.card>
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
