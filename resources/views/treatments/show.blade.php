<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ $treatmentPlan->name }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" x-data x-on:click="$dispatch('open-drawer', 'edit-plan-drawer-{{ $treatmentPlan->id }}')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Plan
            </x-ui.button>
            <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'add-session-drawer-{{ $treatmentPlan->id }}')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Session
            </x-ui.button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Plan Details -->
            <div class="md:col-span-2 space-y-6">
                <x-ui.card>
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Plan Overview</h3>
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wider 
                            {{ $treatmentPlan->status == 'proposed' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $treatmentPlan->status == 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $treatmentPlan->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $treatmentPlan->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $treatmentPlan->status }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Patient</span>
                            <a href="{{ route('patients.show', $treatmentPlan->patient) }}" class="text-sm font-semibold text-gray-900 hover:text-[#39D3C4] transition-colors">
                                {{ $treatmentPlan->patient->first_name }} {{ $treatmentPlan->patient->last_name }}
                            </a>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Dentist</span>
                            <span class="text-sm font-semibold text-gray-900">Dr. {{ $treatmentPlan->dentist->name }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Clinical Notes</span>
                        <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100 min-h-[100px]">
                            {{ $treatmentPlan->notes ?: 'No clinical notes provided for this plan.' }}
                        </p>
                    </div>
                </x-ui.card>

                <!-- Sessions Timeline -->
                <x-ui.card>
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Treatment Sessions</h3>
                        <span class="text-sm font-medium text-gray-500">{{ $treatmentPlan->sessions->count() }} total sessions</span>
                    </div>

                    @if($treatmentPlan->sessions->isEmpty())
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 text-gray-400 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">No sessions recorded yet</h4>
                            <p class="text-xs text-gray-500">Start the treatment by adding the first session.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($treatmentPlan->sessions->sortByDesc('session_date') as $session)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#39D3C4] mt-1.5 ring-4 ring-[#39D3C4]/20"></div>
                                        @if(!$loop->last)
                                            <div class="w-px h-full bg-gray-200 mt-2"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 pb-4">
                                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($session->session_date)->format('l, F j, Y') }}</span>
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Completed</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $session->clinical_notes ?: 'No specific notes for this session.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <!-- Financials Sidebar -->
            <div class="space-y-6">
                <x-ui.card class="bg-gray-900 text-white border-0">
                    <h3 class="text-lg font-bold mb-4 text-white">Financial Summary</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-800">
                            <span class="text-sm text-gray-400">Total Estimated Cost</span>
                            <span class="text-lg font-bold">{{ format_currency($treatmentPlan->total_estimated_cost) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pb-4 border-b border-gray-800">
                            <span class="text-sm text-gray-400">Amount Paid</span>
                            <span class="text-lg font-bold text-emerald-400">{{ format_currency($treatmentPlan->amount_paid ?? 0) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-white">Remaining Balance</span>
                            <span class="text-xl font-bold text-white">{{ format_currency($treatmentPlan->total_estimated_cost - ($treatmentPlan->amount_paid ?? 0)) }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-ui.button variant="primary" class="w-full justify-center !bg-white !text-gray-900 hover:!bg-gray-100" x-data x-on:click="$dispatch('open-drawer', 'add-payment-drawer-{{ $treatmentPlan->id }}')">
                            Record Payment
                        </x-ui.button>
                    </div>
                </x-ui.card>
            </div>
        </div>
        
        <!-- Add Drawers Here (same as index loop or included) -->
        @include('treatments.partials.drawers', ['plan' => $treatmentPlan])

    </div>
</x-app-layout>
