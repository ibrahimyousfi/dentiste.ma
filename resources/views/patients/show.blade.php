<x-app-layout>
    <div class="py-8 animate-fade-in" x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'overview' }" x-init="$watch('tab', value => window.history.replaceState(null, null, '#' + value))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Patient Profile Header -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-4 w-full md:w-auto">
                    <a href="{{ route('patients.index') }}" class="p-2.5 bg-gray-50 border border-gray-200 text-gray-500 hover:text-[#39D3C4] hover:border-[#39D3C4]/50 rounded-xl transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div class="flex items-center">
                        <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#39D3C4]/20 to-blue-500/20 border border-white flex items-center justify-center text-gray-700 font-bold text-2xl shadow-sm">
                            {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h2 class="font-extrabold text-2xl text-gray-900 tracking-tight">
                                {{ $patient->first_name }} {{ $patient->last_name }}
                            </h2>
                            <div class="flex flex-wrap items-center gap-3 mt-1.5">
                                <span class="bg-[#39D3C4]/10 text-[#2db3a6] border border-[#39D3C4]/20 text-xs font-bold px-2.5 py-0.5 rounded-full">PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-sm font-medium text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $patient->phone ?? 'No phone' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('patients.dental-chart', $patient) }}" class="flex-1 md:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:text-[#39D3C4] transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Dental Chart
                    </a>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6 bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex space-x-2 overflow-x-auto">
                <button @click="tab = 'overview'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'overview', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'overview' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Overview
                </button>
                <button @click="tab = 'medical'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'medical', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'medical' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Medical History
                </button>
                <button @click="tab = 'notes'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'notes', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'notes' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    Clinical Notes (AI)
                </button>
                <button @click="tab = 'media'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'media', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'media' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    X-Rays & Media
                </button>
                <button @click="tab = 'finances'" :class="{ 'bg-yellow-400/10 text-yellow-600 font-bold': tab === 'finances', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'finances' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Finances
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="space-y-6">
                <!-- Overview Tab -->
                <div x-show="tab === 'overview'" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Patient Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full hover:shadow-md transition-shadow relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gray-50 rounded-bl-full -z-10"></div>
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Patient Details</h3>
                            <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center text-xs font-bold text-[#2db3a6] bg-[#39D3C4]/10 hover:bg-[#39D3C4]/20 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </a>
                        </div>
                        <div class="space-y-5 text-sm flex-1">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Date of Birth</span>
                                <span class="font-semibold text-gray-900">{{ $patient->date_of_birth ?? 'Not specified' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Gender</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ $patient->gender ?? 'Not specified' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">National ID</span>
                                <span class="font-semibold text-gray-900">{{ $patient->national_id ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                                <span class="font-semibold text-gray-900">{{ $patient->email ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col pt-2 border-t border-gray-100">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Address</span>
                                <span class="font-semibold text-gray-900 leading-relaxed">{{ $patient->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Appointments & Quick Stats -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-gradient-to-r from-[#21c8b6] to-[#12a19b] rounded-3xl shadow-lg shadow-[#39D3C4]/20 p-8 text-white relative overflow-hidden">
                            <div class="relative z-10 flex justify-between items-center">
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-white/80 mb-2">Upcoming Appointment</h3>
                                    @php
                                        $upcoming = clone $patient->appointments;
                                        $next = $upcoming->sortBy('appointment_date')->first();
                                    @endphp
                                    @if($next)
                                        <p class="text-3xl font-extrabold mb-2">{{ \Carbon\Carbon::parse($next->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($next->start_time)->format('h:i A') }}</p>
                                        <p class="text-white/90 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Dr. {{ $next->dentist->name ?? 'Unassigned' }}
                                        </p>
                                    @else
                                        <p class="text-3xl font-extrabold mb-4">No appointments scheduled</p>
                                        <a href="{{ route('appointments.index') }}" class="inline-flex px-5 py-2.5 bg-white text-[#12a19b] hover:bg-gray-50 rounded-xl text-sm font-bold shadow-sm transition-all hover:scale-105 active:scale-95">
                                            Schedule Visit
                                        </a>
                                    @endif
                                </div>
                                <div class="hidden sm:block opacity-20">
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            <!-- Decorative background circle -->
                            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                            <div class="absolute top-0 right-10 w-32 h-32 bg-[#39D3C4]/50 rounded-full blur-3xl"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Visits</span>
                                    <div class="p-2 bg-blue-50 text-blue-500 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                </div>
                                <span class="text-3xl font-extrabold text-gray-900">{{ $patient->appointments->count() }}</span>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Outstanding Balance</span>
                                    <div class="p-2 bg-green-50 text-green-500 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                                <span class="text-3xl font-extrabold text-emerald-500">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical History Tab -->
                <div x-show="tab === 'medical'" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                            <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                                <div class="p-2 bg-rose-50 rounded-xl mr-3">
                                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                Health Profile
                            </h3>
                            <button class="text-sm px-4 py-2 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Profile
                            </button>
                        </div>
                        
                        <!-- Temporary UI for Medical History Form -->
                        @include('patients.partials.medical-history-form')
                        
                    </div>
            </div>
            
            <!-- Clinical Notes Tab -->
            <div x-show="tab === 'notes'" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                            <div class="p-2 bg-purple-50 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            Clinical Notes (AI Voice Dictation)
                        </h3>
                    </div>

                    <div x-data="voiceDictation()" class="space-y-6">
                        <!-- AI Dictation Form -->
                        <form action="{{ route('patients.notes.store', $patient) }}" method="POST" class="bg-gray-50 rounded-2xl p-6 border border-gray-100 relative shadow-inner">
                            @csrf
                            <div class="flex justify-between items-end mb-4">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">New Note</label>
                                
                                <div class="flex space-x-2">
                                    <!-- Smart Templates -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click.prevent="open = !open" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                            Templates
                                        </button>
                                        <div x-show="open" @click.away="open = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 divide-y divide-gray-100">
                                            <a href="#" @click.prevent="insertTemplate('Patient attended for routine checkup. No pain reported. Soft tissues healthy.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Standard Checkup</a>
                                            <a href="#" @click.prevent="insertTemplate('LA administered. Caries removed. Composite filling placed. Occlusion checked and adjusted. Post-op instructions given.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Composite Filling</a>
                                            <a href="#" @click.prevent="insertTemplate('Patient presented with severe pain. X-ray taken. Root canal treatment commenced. Canals cleaned and shaped. Temporary dressing placed.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Root Canal Prep</a>
                                        </div>
                                    </div>
                                    
                                    <!-- Language Selector removed (Whisper auto-detects) -->

                                    <!-- Voice Dictation Button -->
                                    <button @click.prevent="toggleRecording()" type="button" 
                                            :disabled="isProcessing"
                                            :class="isRecording ? 'bg-red-500 hover:bg-red-600 text-white border-transparent animate-pulse shadow-red-500/30 shadow-lg' : (isProcessing ? 'bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200' : 'bg-white hover:bg-gray-50 text-gray-700 border-gray-300')"
                                            class="inline-flex items-center px-4 py-1.5 border shadow-sm text-xs font-bold rounded-lg transition-all focus:outline-none">
                                        <svg x-show="!isRecording && !isProcessing" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                        <svg x-show="isRecording && !isProcessing" style="display: none;" class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        <svg x-show="isProcessing" style="display: none;" class="animate-spin mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span x-text="isRecording ? 'Stop Recording' : (isProcessing ? 'Processing AI...' : 'Start Dictation')"></span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <textarea x-ref="noteTextarea" x-model="noteContent" name="note" rows="5" :disabled="isProcessing" class="shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full sm:text-sm border-gray-200 rounded-xl bg-white p-4 font-medium text-gray-800 transition-colors disabled:opacity-50" placeholder="Start typing or click 'Start Dictation' to speak..."></textarea>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] transition-all">
                                    Save Note
                                </button>
                            </div>
                        </form>

                        <!-- Previous Notes History -->
                        <div class="mt-10">
                            <h4 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Note History
                            </h4>
                            
                            <div class="space-y-6">
                                @forelse($patient->notes as $note)
                                    <div class="bg-white border-l-4 border-[#39D3C4] p-5 rounded-r-2xl shadow-sm relative group transition-all hover:shadow-md">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-gray-200 to-gray-300 flex items-center justify-center text-xs font-bold text-gray-600 shadow-inner mr-3">
                                                    {{ substr($note->user->first_name ?? 'Dr', 0, 1) }}{{ substr($note->user->last_name ?? '', 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-900">{{ $note->user->first_name ?? 'Doctor' }} {{ $note->user->last_name ?? '' }}</span>
                                                    <span class="text-xs text-gray-500 ml-2 font-medium">{{ $note->created_at->format('d M Y - H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-gray-700 text-sm whitespace-pre-line leading-relaxed font-medium ml-11">
                                            {{ $note->note }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm text-gray-500 font-medium">No clinical notes recorded yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- X-Rays & Media Tab -->
            <div x-show="tab === 'media'" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8" x-data="xrayComparison()">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                            <div class="p-2 bg-blue-50 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            Advanced Digital Imaging
                        </h3>
                        <button @click="showUploadModal = true" class="text-sm px-4 py-2 bg-[#39D3C4] border border-transparent text-white rounded-xl font-bold hover:bg-[#2db3a6] transition-colors flex items-center shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Upload Image
                        </button>
                    </div>

                    <!-- Comparison Mode Toolbar -->
                    <div x-show="isComparing" style="display: none;" class="mb-6 bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-4 flex justify-between items-center shadow-lg text-white">
                        <div class="flex items-center space-x-3">
                            <span class="flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-[#39D3C4] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#39D3C4]"></span>
                            </span>
                            <span class="font-bold text-sm tracking-wide">Comparison Mode Active</span>
                        </div>
                        <div class="text-xs text-gray-300">
                            <span x-show="!selectedForCompare[0] || !selectedForCompare[1]">Select 2 images to compare</span>
                            <span x-show="selectedForCompare[0] && selectedForCompare[1]">Ready to compare</span>
                        </div>
                        <div class="space-x-2">
                            <button @click="openCompareView()" :disabled="!selectedForCompare[0] || !selectedForCompare[1]" :class="(selectedForCompare[0] && selectedForCompare[1]) ? 'bg-[#39D3C4] hover:bg-[#2db3a6] text-white' : 'bg-gray-700 text-gray-400 cursor-not-allowed'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                View Comparison
                            </button>
                            <button @click="toggleCompareMode()" class="px-3 py-1.5 bg-gray-700 hover:bg-gray-600 rounded-lg text-xs font-medium transition-colors">Cancel</button>
                        </div>
                    </div>

                    @if($patient->media->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">No images found</h3>
                            <p class="text-sm text-gray-500 font-medium mb-6">Upload X-Rays, Scans or intraoral photos to build the patient's gallery.</p>
                            <button @click="showUploadModal = true" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                                Upload First Image
                            </button>
                        </div>
                    @else
                        <!-- Actions & Filters -->
                        <div class="flex justify-between items-center mb-6" x-show="!isComparing">
                            <div class="flex space-x-2">
                                <select class="text-sm border-gray-200 rounded-lg text-gray-600 focus:ring-[#39D3C4] focus:border-[#39D3C4]">
                                    <option>All Types</option>
                                    <option>X-Ray</option>
                                    <option>Scan</option>
                                    <option>Intraoral Photo</option>
                                </select>
                            </div>
                            <button @click="toggleCompareMode()" class="flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                Compare Side-by-Side
                            </button>
                        </div>

                        <!-- Gallery Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($patient->media as $media)
                                <div class="group relative rounded-2xl overflow-hidden bg-gray-100 aspect-square shadow-sm hover:shadow-md transition-all border border-gray-200"
                                     :class="{ 'ring-4 ring-[#39D3C4] border-transparent': isSelected('{{ $media->id }}'), 'opacity-50': isComparing && !isSelected('{{ $media->id }}') && selectedForCompare.length >= 2 }">
                                    
                                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->category }}" class="w-full h-full object-cover">
                                    
                                    <!-- Overlay Info -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                        <div class="text-white">
                                            <span class="text-xs font-bold bg-white/20 px-2 py-0.5 rounded backdrop-blur-sm">{{ $media->category }}</span>
                                            <p class="text-sm font-medium mt-1 truncate">{{ $media->taken_at ? $media->taken_at->format('M d, Y') : '' }}</p>
                                        </div>
                                        <div class="absolute top-3 right-3 flex space-x-2" x-show="!isComparing">
                                            <form action="{{ route('media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Comparison Mode Checkbox Overlay -->
                                    <div x-show="isComparing" class="absolute inset-0 bg-gray-900/30 flex items-center justify-center cursor-pointer" @click="toggleSelection('{{ $media->id }}', '{{ asset('storage/' . $media->file_path) }}', '{{ $media->taken_at ? $media->taken_at->format('M d, Y') : '' }}')">
                                        <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-colors"
                                             :class="isSelected('{{ $media->id }}') ? 'bg-[#39D3C4] border-[#39D3C4] text-white' : 'border-white/70 bg-black/20 text-transparent'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Side-by-Side Comparison Modal -->
                    <div x-show="showCompareModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div x-show="showCompareModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-95 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <!-- Modal panel -->
                            <div x-show="showCompareModal" 
                                 x-transition:enter="ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave="ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 class="inline-block align-bottom bg-gray-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full max-w-7xl border border-gray-800">
                                
                                <div class="px-4 py-4 border-b border-gray-800 flex justify-between items-center bg-black/50">
                                    <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        Image Comparison
                                    </h3>
                                    <button @click="showCompareModal = false" type="button" class="text-gray-400 hover:text-white focus:outline-none transition-colors">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                
                                <div class="p-6">
                                    <!-- Before / After Grid -->
                                    <div class="grid grid-cols-2 gap-6 h-[70vh]">
                                        <!-- Image 1 -->
                                        <div class="flex flex-col h-full bg-black rounded-xl overflow-hidden border border-gray-800 relative group">
                                            <div class="absolute top-4 left-4 z-10 bg-black/60 backdrop-blur text-white px-3 py-1 rounded-lg text-sm font-bold border border-white/10" x-text="'Image 1 - ' + selectedForCompare[0]?.date"></div>
                                            <div class="flex-1 w-full h-full relative overflow-hidden flex items-center justify-center p-2">
                                                <img :src="selectedForCompare[0]?.url" class="max-w-full max-h-full object-contain cursor-crosshair transform transition-transform duration-200" style="filter: contrast(1.1) brightness(1.05);">
                                            </div>
                                        </div>
                                        
                                        <!-- Image 2 -->
                                        <div class="flex flex-col h-full bg-black rounded-xl overflow-hidden border border-gray-800 relative group">
                                            <div class="absolute top-4 left-4 z-10 bg-black/60 backdrop-blur text-white px-3 py-1 rounded-lg text-sm font-bold border border-white/10" x-text="'Image 2 - ' + selectedForCompare[1]?.date"></div>
                                            <div class="flex-1 w-full h-full relative overflow-hidden flex items-center justify-center p-2">
                                                <img :src="selectedForCompare[1]?.url" class="max-w-full max-h-full object-contain cursor-crosshair transform transition-transform duration-200" style="filter: contrast(1.1) brightness(1.05);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Modal -->
                    <div x-show="showUploadModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showUploadModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div x-show="showUploadModal" 
                                 x-transition:enter="ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave="ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                
                                <form action="{{ route('patients.media.store', $patient) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-6" id="modal-title">
                                                    Upload Patient Media
                                                </h3>
                                                <div class="mt-2 space-y-4">
                                                    <!-- File Upload -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Image File</label>
                                                        <input type="file" name="media_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#39D3C4]/10 file:text-[#2db3a6] hover:file:bg-[#39D3C4]/20 transition-colors">
                                                    </div>
                                                    
                                                    <!-- Category -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                                        <select name="category" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm">
                                                            <option value="X-Ray">X-Ray (Radiograph)</option>
                                                            <option value="Scan">Scan (CT/MRI)</option>
                                                            <option value="Intraoral Photo">Intraoral Photo</option>
                                                            <option value="Document">Document</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Date Taken -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Taken</label>
                                                        <input type="date" name="taken_at" value="{{ date('Y-m-d') }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm">
                                                    </div>
                                                    
                                                    <!-- Notes -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                                        <textarea name="notes" rows="2" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#39D3C4] text-base font-bold text-white hover:bg-[#2db3a6] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Upload Media
                                        </button>
                                        <button type="button" @click="showUploadModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Finances Tab -->
                <div x-show="tab === 'finances'" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Record Payment Form -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <div class="p-2 bg-yellow-50 rounded-xl mr-3">
                                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    Record Payment
                                </h3>
                                
                                <form action="{{ route('payments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Amount</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="amount" required class="focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-xl" placeholder="0.00">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">USD</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Payment Method</label>
                                            <select name="payment_method" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm rounded-xl">
                                                <option value="cash">Cash</option>
                                                <option value="credit_card">Credit Card</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="insurance">Insurance</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Notes (Optional)</label>
                                            <textarea name="notes" rows="2" class="shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full sm:text-sm border-gray-300 rounded-xl" placeholder="e.g. Deposit for implant"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] transition-colors">
                                            Save Payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Payment History -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
                                    Payment History
                                    @php
                                        $totalPaid = 0;
                                        foreach($patient->invoices as $inv) {
                                            $totalPaid += $inv->payments->sum('amount');
                                        }
                                    @endphp
                                    <span class="text-sm font-medium text-gray-500 bg-gray-50 px-3 py-1 rounded-lg">Total Paid: <strong class="text-gray-900">{{ format_currency($totalPaid) }}</strong></span>
                                </h3>
                                
                                @if($patient->invoices->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($patient->invoices as $invoice)
                                            @foreach($invoice->payments as $payment)
                                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex justify-between items-center hover:border-gray-200 transition-colors">
                                                <div class="flex items-center">
                                                    <div class="p-2 {{ $payment->payment_method === 'cash' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }} rounded-lg mr-4">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900">{{ format_currency($payment->amount) }} <span class="text-xs font-normal text-gray-500 uppercase ml-2 bg-gray-200 px-2 py-0.5 rounded-full">{{ str_replace('_', ' ', $payment->payment_method) }}</span></p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }} &bull; {{ $payment->notes ?? 'No notes' }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-xs font-bold text-gray-400">Invoice</span>
                                                    <p class="text-sm font-bold text-gray-700">{{ $invoice->invoice_number }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <h3 class="text-sm font-bold text-gray-900">No payments yet</h3>
                                        <p class="text-sm text-gray-500 mt-1">Record a payment to see it here.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('xrayComparison', () => ({
                showUploadModal: false,
                isComparing: false,
                showCompareModal: false,
                selectedForCompare: [], // Array of objects {id, url, date}

                toggleCompareMode() {
                    this.isComparing = !this.isComparing;
                    if (!this.isComparing) {
                        this.selectedForCompare = [];
                    }
                },

                isSelected(id) {
                    return this.selectedForCompare.some(item => item.id === id);
                },

                toggleSelection(id, url, date) {
                    if (this.isSelected(id)) {
                        this.selectedForCompare = this.selectedForCompare.filter(item => item.id !== id);
                    } else if (this.selectedForCompare.length < 2) {
                        this.selectedForCompare.push({ id, url, date });
                    }
                },

                openCompareView() {
                    if (this.selectedForCompare.length === 2) {
                        this.showCompareModal = true;
                    }
                }
            }));
            
            Alpine.data('voiceDictation', () => ({
                noteContent: '',
                isRecording: false,
                isProcessing: false,
                mediaRecorder: null,
                audioChunks: [],
                
                async toggleRecording() {
                    if (this.isRecording) {
                        this.isRecording = false;
                        if (this.mediaRecorder) {
                            this.mediaRecorder.stop();
                        }
                    } else {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            this.mediaRecorder = new MediaRecorder(stream);
                            this.audioChunks = [];
                            
                            this.mediaRecorder.ondataavailable = e => {
                                if (e.data.size > 0) this.audioChunks.push(e.data);
                            };
                            
                            this.mediaRecorder.onstop = async () => {
                                this.isProcessing = true;
                                const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                                
                                const formData = new FormData();
                                formData.append('audio', audioBlob, 'recording.webm');
                                
                                try {
                                    const res = await fetch('{{ route("patients.notes.voice", $patient) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    });
                                    const data = await res.json();
                                    
                                    if (data.success) {
                                        let currentVal = this.$refs.noteTextarea ? this.$refs.noteTextarea.value : this.noteContent;
                                        let newVal = currentVal + (currentVal ? '\n\n' : '') + data.formatted_text;
                                        this.noteContent = newVal;
                                        if (this.$refs.noteTextarea) {
                                            this.$refs.noteTextarea.value = newVal;
                                            this.$refs.noteTextarea.dispatchEvent(new Event('input', { bubbles: true }));
                                        }
                                    } else {
                                        alert(data.message || 'Error processing audio.');
                                    }
                                } catch (err) {
                                    alert('Error uploading audio.');
                                    console.error(err);
                                }
                                
                                this.isProcessing = false;
                                
                                // Stop all tracks to release microphone
                                stream.getTracks().forEach(track => track.stop());
                            };
                            
                            this.mediaRecorder.start();
                            this.isRecording = true;
                        } catch (err) {
                            alert('Microphone access denied or not available.');
                            console.error(err);
                        }
                    }
                },
                
                insertTemplate(text) {
                    let currentVal = this.$refs.noteTextarea ? this.$refs.noteTextarea.value : this.noteContent;
                    let newVal = currentVal + (currentVal ? '\n\n' : '') + text;
                    this.noteContent = newVal;
                    if (this.$refs.noteTextarea) {
                        this.$refs.noteTextarea.value = newVal;
                        this.$refs.noteTextarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
