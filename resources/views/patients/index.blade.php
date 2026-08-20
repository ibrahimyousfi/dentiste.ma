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
            Add
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in pb-10">
        @if(session('success'))
            <div class="mb-4 mx-4 sm:mx-6 lg:mx-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 mx-4 sm:mx-6 lg:mx-8 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if($patients->isEmpty())
            <div class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No patients found</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Try adjusting your filters or register a new patient to get started.</p>
            </div>
        @else
            <x-ui.row-list>
                @foreach($patients as $patient)
                    <x-ui.row-card>
                        <!-- Left: Identity & Metadata -->
                        <div class="flex items-center gap-3.5 min-w-[240px]">
                            <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-[#39D3C4]/15 to-[#39D3C4]/5 text-[#2db3a6] flex items-center justify-center font-bold text-sm border border-[#39D3C4]/20 shrink-0 shadow-2xs">
                                {{ mb_substr($patient->first_name, 0, 1) }}{{ mb_substr($patient->last_name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-sm font-bold text-gray-900 hover:text-[#39D3C4] transition-colors truncate">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </a>
                                    <x-ui.status-badge :status="$patient->treatment_status" size="xs" />
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                    <span>#{{ $patient->patient_code ?? ($patient->national_id ?? $patient->id) }}</span>
                                    @if($patient->date_of_birth)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} yrs</span>
                                    @endif
                                    @if($patient->gender)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ ucfirst($patient->gender) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Middle 1: Contact info & Quick WhatsApp/Call -->
                        <div class="flex items-center gap-2 min-w-[180px]">
                            @if($patient->phone)
                                <span class="text-xs font-medium text-gray-600 font-mono">{{ $patient->phone }}</span>
                                <div class="flex items-center gap-1 ml-1">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $patient->phone) }}" target="_blank" class="p-1 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="WhatsApp">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                    </a>
                                    <a href="tel:{{ $patient->phone }}" class="p-1 rounded-lg text-gray-400 hover:text-sky-600 hover:bg-sky-50 transition-colors" title="Call">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </a>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">No phone recorded</span>
                            @endif
                        </div>

                        <!-- Middle 2: Treatment Progress -->
                        <div class="flex items-center gap-3 min-w-[200px] flex-1 max-w-xs">
                            @if($patient->total_sessions > 0)
                                <div class="w-full">
                                    <div class="flex items-center justify-between text-[11px] font-medium text-gray-500 mb-1">
                                        <span>Sessions: <strong class="text-gray-800">{{ $patient->completed_sessions }}/{{ $patient->total_sessions }}</strong></span>
                                        <span>{{ round(($patient->completed_sessions / $patient->total_sessions) * 100) }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full {{ $patient->treatment_status === 'completed' ? 'bg-emerald-500' : 'bg-[#39D3C4]' }} rounded-full transition-all" style="width: {{ ($patient->completed_sessions / $patient->total_sessions) * 100 }}%"></div>
                                    </div>
                                </div>
                                @if($patient->completed_sessions < $patient->total_sessions)
                                    <form action="{{ route('patients.increment-session', $patient) }}" method="POST" class="shrink-0">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-lg text-gray-400 hover:text-[#39D3C4] hover:bg-[#39D3C4]/10 transition-colors" title="Mark session as completed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div x-data="{ showForm: false }" class="w-full">
                                    <button @click="showForm = true" x-show="!showForm" class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors border border-gray-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Start Plan
                                    </button>
                                    <form x-show="showForm" action="{{ route('patients.set-sessions', $patient) }}" method="POST" class="flex items-center gap-1.5" @click.away="showForm = false" style="display: none;">
                                        @csrf
                                        <input type="number" name="total_sessions" min="1" max="100" class="w-20 py-0.5 px-2 text-xs border-gray-200 rounded-lg focus:ring-[#39D3C4] focus:border-[#39D3C4]" placeholder="Sessions..." required autofocus>
                                        <button type="submit" class="p-1 text-gray-400 hover:text-[#39D3C4] transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Middle 3: Next Appointment -->
                        <div class="hidden xl:flex items-center gap-2 min-w-[150px] text-xs text-gray-500">
                            @if($patient->appointments->isNotEmpty())
                                @php $nextAppt = $patient->appointments->first(); @endphp
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M d, g:i A') }}</span>
                            @else
                                <span class="text-gray-400 text-xs">No appointment</span>
                            @endif
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-1 shrink-0">
                            <a href="{{ route('patients.show', $patient) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-[#39D3C4] hover:bg-[#39D3C4]/10 transition-colors" title="Edit Patient">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete Patient">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </x-ui.row-card>

                @endforeach
            </x-ui.row-list>
            
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
