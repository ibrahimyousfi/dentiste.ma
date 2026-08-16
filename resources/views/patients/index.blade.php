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
        @if($patients->isEmpty())
            <div class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No patients found</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Try adjusting your filters or register a new patient to get started.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($patients as $patient)
                    <div class="group relative bg-white rounded-2xl border border-gray-100 p-5 hover:border-gray-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 flex flex-col h-full">
                        <!-- Header Section -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center border border-gray-100 font-semibold text-sm">
                                    {{ mb_substr($patient->first_name, 0, 1) }}{{ mb_substr($patient->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('patients.show', $patient) }}" class="text-base font-semibold text-gray-900 hover:text-black transition-colors line-clamp-1">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </a>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[11px] font-medium text-gray-400">ID: {{ $patient->national_id ?? 'N/A' }}</span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-[11px] font-medium text-gray-400">
                                            {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' yrs' : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <x-ui.status-badge :status="$patient->treatment_status" />
                        </div>

                        <!-- Contact & Quick Actions -->
                        <div class="flex items-center gap-2 mb-6 mt-1">
                            @if($patient->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $patient->phone) }}" target="_blank" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-50 text-gray-400 hover:bg-[#25D366]/10 hover:text-[#25D366] transition-colors" title="WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            </a>
                            <a href="tel:{{ $patient->phone }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-500 transition-colors" title="Call">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                            @endif
                            
                            @if($patient->email)
                            <a href="mailto:{{ $patient->email }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 hover:text-gray-900 transition-colors" title="Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </a>
                            @endif
                        </div>

                        <!-- Treatment Progress -->
                        <div class="mb-5 flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Treatment Sessions</span>
                                <span class="text-xs font-semibold text-gray-900">{{ $patient->total_sessions > 0 ? $patient->completed_sessions . '/' . $patient->total_sessions : '0' }}</span>
                            </div>
                            @if($patient->total_sessions > 0)
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    @php
                                        $percentage = ($patient->completed_sessions / $patient->total_sessions) * 100;
                                        $barColor = $patient->treatment_status === 'completed' ? 'bg-emerald-500' : 'bg-gray-900';
                                    @endphp
                                    <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            @else
                                <div x-data="{ showForm: false }" class="relative w-full">
                                    <button @click="showForm = true" x-show="!showForm" class="w-full inline-flex justify-center items-center px-3 py-1.5 bg-gray-50 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-100 transition-colors border border-gray-100/50">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Start Treatment
                                    </button>
                                    <form x-show="showForm" action="{{ route('patients.set-sessions', $patient) }}" method="POST" class="flex items-center gap-2" @click.away="showForm = false" style="display: none;">
                                        @csrf
                                        <input type="number" name="total_sessions" min="1" max="100" class="flex-1 py-1 px-2 text-xs border-gray-200 rounded-lg focus:ring-gray-900 focus:border-gray-900 shadow-sm" placeholder="Total sessions..." required autofocus>
                                        <button type="submit" class="p-1 text-gray-400 hover:text-gray-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Footer: Next Appt & More Actions -->
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            @if($patient->appointments->isNotEmpty())
                                @php $nextAppt = $patient->appointments->first(); @endphp
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M d, g:i A') }}</span>
                                </div>
                            @else
                                <div class="text-xs text-gray-400 font-medium">No upcoming appointments</div>
                            @endif

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="p-1 rounded-md text-gray-400 hover:text-gray-900 hover:bg-gray-50 transition-colors focus:outline-none">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('patients.show', $patient) }}">View Profile</x-dropdown-link>
                                    <button x-data @click="$dispatch('open-drawer', 'edit-patient-drawer-{{ $patient->id }}')" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Edit Patient
                                    </button>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <x-dropdown-link href="#">Treatment Plan</x-dropdown-link>
                                    <x-dropdown-link href="#">Invoices & Payments</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <!-- Edit Patient Drawer -->
                    <x-ui.drawer id="edit-patient-drawer-{{ $patient->id }}" title="Edit Patient">
                        <form id="edit-patient-form-{{ $patient->id }}" action="{{ route('patients.update', $patient) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                        <input type="text" name="first_name" value="{{ $patient->first_name }}" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                        <input type="text" name="last_name" value="{{ $patient->last_name }}" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                        <input type="text" name="phone" value="{{ $patient->phone }}" required class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ $patient->email }}" class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">National ID</label>
                                    <input type="text" name="national_id" value="{{ $patient->national_id }}" class="w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                                </div>
                            </div>
                        </form>

                        <x-slot name="footer">
                            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
                            <x-ui.button variant="primary" x-on:click="document.getElementById('edit-patient-form-{{ $patient->id }}').submit()">Save Changes</x-ui.button>
                        </x-slot>
                    </x-ui.drawer>
                @endforeach
            </div>
            
            @if($patients->hasPages())
                <div class="mt-6">
                    {{ $patients->links() }}
                </div>
            @endif
        @endif
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
