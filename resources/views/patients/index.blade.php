<x-app-layout>
    <x-slot name="header_search">
        <x-ui.search placeholder="Search patients by name or ID..." />
    </x-slot>
    
    <x-slot name="header_filters">
        <!-- Tab Filters -->
        <div class="flex items-center space-x-1 bg-gray-100/50 p-1 rounded-xl">
            <a href="{{ route('patients.index', ['filter' => 'active']) }}" 
               class="flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'active' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                Active <span class="ml-2 px-1.5 py-0.5 rounded-full text-xs {{ $filter === 'active' ? 'bg-gray-100 text-gray-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['active'] ?? 0 }}</span>
            </a>
            <a href="{{ route('patients.index', ['filter' => 'in_treatment']) }}" 
               class="flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'in_treatment' ? 'bg-white text-[#39D3C4] shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                In Treatment <span class="ml-2 px-1.5 py-0.5 rounded-full text-xs {{ $filter === 'in_treatment' ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'bg-gray-200 text-gray-500' }}">{{ $counts['in_treatment'] ?? 0 }}</span>
            </a>
            <a href="{{ route('patients.index', ['filter' => 'completed']) }}" 
               class="flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'completed' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                Completed <span class="ml-2 px-1.5 py-0.5 rounded-full text-xs {{ $filter === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['completed'] ?? 0 }}</span>
            </a>
            <div class="w-px h-4 bg-gray-300 mx-1"></div>
            <a href="{{ route('patients.index', ['filter' => 'all']) }}" 
               class="flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                All <span class="ml-2 px-1.5 py-0.5 rounded-full text-xs {{ $filter === 'all' ? 'bg-gray-100 text-gray-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['all'] ?? 0 }}</span>
            </a>
        </div>
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-patient-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Patient
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in pb-10">
        <x-ui.card>
            @if($patients->isEmpty())
                <div class="p-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No patients found</h3>
                    <p class="text-gray-500 max-w-sm mx-auto">Try adjusting your filters or register a new patient to get started.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($patients as $patient)
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
                                        <x-dropdown-link href="{{ route('patients.show', $patient) }}">View Profile</x-dropdown-link>
                                        <x-dropdown-link href="{{ route('patients.edit', $patient) }}">Edit Patient</x-dropdown-link>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <x-dropdown-link href="#">New Appointment</x-dropdown-link>
                                        <x-dropdown-link href="#">Treatment Plan</x-dropdown-link>
                                        <x-dropdown-link href="#">Documents</x-dropdown-link>
                                        <x-dropdown-link href="#">Invoices & Payments</x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>

                            <div class="flex-1">
                                <!-- Avatar and Basic Info -->
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="flex-shrink-0 h-14 w-14 rounded-full bg-[#39D3C4]/10 flex items-center justify-center text-[#39D3C4] font-bold text-xl">
                                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 pr-8">
                                        <a href="{{ route('patients.show', $patient) }}" class="text-base font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </a>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            {{ $patient->national_id ?? 'No ID' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="space-y-2 mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    @if($patient->phone)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $patient->phone }}
                                    </div>
                                    @endif
                                    @if($patient->date_of_birth)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 .454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h10z"></path></svg>
                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} yrs old
                                    </div>
                                    @endif
                                </div>

                                <!-- Progress & Status -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Treatment Progress</span>
                                        <span class="text-xs font-bold text-gray-900">{{ $patient->total_sessions > 0 ? $patient->completed_sessions . '/' . $patient->total_sessions : '0/0' }}</span>
                                    </div>
                                    @if($patient->total_sessions > 0)
                                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                            @php
                                                $percentage = ($patient->completed_sessions / $patient->total_sessions) * 100;
                                                $barColor = $patient->treatment_status === 'completed' ? 'bg-emerald-500' : 'bg-[#39D3C4]';
                                            @endphp
                                            <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    @else
                                        <div x-data="{ showForm: false }" class="relative w-full">
                                            <button @click="showForm = true" x-show="!showForm" class="w-full inline-flex justify-center items-center px-3 py-1 bg-white border border-dashed border-gray-300 rounded-lg shadow-sm text-xs font-medium text-gray-500 hover:bg-gray-50 hover:text-[#39D3C4] hover:border-[#39D3C4] transition-all">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                Start Plan
                                            </button>
                                            
                                            <form x-show="showForm" action="{{ route('patients.set-sessions', $patient) }}" method="POST" class="flex items-center space-x-2 w-full" @click.away="showForm = false" style="display: none;">
                                                @csrf
                                                <input type="number" name="total_sessions" min="1" max="100" class="flex-1 block w-full py-1 px-2 text-xs border-gray-200 rounded-lg focus:ring-[#39D3C4] focus:border-[#39D3C4]" placeholder="Sessions" required autofocus>
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 bg-[#39D3C4]/10 text-[#39D3C4] rounded-lg hover:bg-[#39D3C4]/20 transition-colors shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <x-ui.status-badge :status="$patient->treatment_status" />
                                
                                @if($patient->appointments->isNotEmpty())
                                    @php $nextAppt = $patient->appointments->first(); @endphp
                                    <div class="text-right">
                                        <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Next Appt</div>
                                        <div class="text-xs font-bold text-gray-900 mt-0.5">
                                            {{ \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M d') }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-right">
                                        <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Next Appt</div>
                                        <div class="text-xs font-medium text-gray-400 mt-0.5">None</div>
                                    </div>
                                @endif
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
                
                @if($patients->hasPages())
                    <div class="mt-6">
                        {{ $patients->links() }}
                    </div>
                @endif
            @endif
        </x-ui.card>
    </div>

    <!-- Create Patient Drawer -->
    <x-ui.drawer id="create-patient-drawer" title="Add New Patient">
        <form id="create-patient-form" action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                        <input type="text" name="first_name" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                        <input type="text" name="last_name" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="text" name="phone" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">National ID</label>
                    <input type="text" name="national_id" class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-patient-form').submit()">Save Patient</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
