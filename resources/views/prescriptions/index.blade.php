<x-app-layout>
    <x-slot name="header_search">
        <x-ui.search placeholder="Search prescriptions..." />
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-prescription-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in pb-10">
        
        <!-- Prescriptions Grid -->
        @if($prescriptions->isEmpty())
            <x-ui.card class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.5 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No prescriptions found</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">Click "Write Prescription" to generate your first medical prescription.</p>
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-prescription-drawer')">
                    Write Prescription
                </x-ui.button>
            </x-ui.card>
        @else
            <x-ui.row-list>
                @foreach($prescriptions as $prescription)
                    <x-ui.row-card>
                        <!-- Left: Patient & Rx ID -->
                        <div class="flex items-center gap-3.5 min-w-[240px]">
                            <div class="h-11 w-11 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-sm border border-indigo-200/60 shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.5 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">
                                        {{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}
                                    </h3>
                                    <x-ui.badge variant="green" size="xs" dot>Issued</x-ui.badge>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                    <span>ID: {{ $prescription->patient->national_id ?? 'N/A' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ \Carbon\Carbon::parse($prescription->date)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle 1: Doctor -->
                        <div class="flex items-center gap-2 min-w-[180px] text-xs text-gray-600">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center text-[10px] font-bold">
                                Dr
                            </div>
                            <span class="font-medium text-gray-800 truncate">Dr. {{ $prescription->dentist->name }}</span>
                        </div>

                        <!-- Middle 2: Medications count -->
                        <div class="flex items-center gap-2 min-w-[180px]">
                            <x-ui.badge variant="blue" size="sm">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                {{ $prescription->medications_count ?? '0' }} medications
                            </x-ui.badge>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200/70 hover:bg-[#39D3C4]/10 hover:text-[#2db3a6] hover:border-[#39D3C4]/30 transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                View / Print
                            </a>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('prescriptions.show', $prescription->id) }}">View Details</x-dropdown-link>
                                    <x-dropdown-link href="#">Download PDF</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <x-dropdown-link href="#" class="text-rose-600">Delete</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </x-ui.row-card>
                @endforeach
            </x-ui.row-list>
            
            @if($prescriptions->hasPages())
                <div class="mt-6">
                    {{ $prescriptions->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Prescription Drawer -->
    <x-ui.drawer id="create-prescription-drawer" title="Write Prescription">
        <form id="create-prescription-form" action="{{ route('prescriptions.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Patient & Dentist -->
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
                    
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="medications" class="block text-sm font-medium text-gray-700 mb-1">Medications & Dosage (Rx) <span class="text-red-500">*</span></label>
                        <textarea id="medications" name="medications" rows="6" required placeholder="e.g. 1. Amoxicillin 500mg, 1 tablet every 8 hours for 7 days." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="e.g. Take medications after meals." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-prescription-form').submit()">Generate</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
