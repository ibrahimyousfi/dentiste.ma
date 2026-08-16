<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight tracking-tight">
            {{ $organization->name ?? 'Clinic Overview' }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <div class="flex gap-3">
            <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-[#39D3C4] hover:bg-[#2db3a6] border border-transparent rounded-xl font-bold text-sm text-white shadow-sm transition-all shadow-[#39D3C4]/30 hover:shadow-[#39D3C4]/50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Patient
            </a>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:text-[#39D3C4] transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Settings
            </a>
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Patients -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Patients</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900">{{ number_format($patientsCount) }}</h3>
                    <p class="text-sm font-medium text-blue-600 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Total Registered
                    </p>
                </div>

                <!-- Today's Appointments -->
                <div class="bg-gradient-to-br from-[#39D3C4] to-[#12a19b] rounded-3xl p-6 shadow-lg shadow-[#39D3C4]/30 text-white relative overflow-hidden group hover:shadow-[#39D3C4]/40 transition-all">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-white/80 uppercase tracking-wider">Today</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-white relative z-10">{{ number_format($todayAppointments->count()) }}</h3>
                    <p class="text-sm font-medium text-white/90 mt-2 flex items-center relative z-10">
                        Appointments Today
                    </p>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-50 to-transparent rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 text-green-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Monthly Revenue</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900">${{ number_format($monthlyRevenue, 2) }}</h3>
                    <p class="text-sm font-medium text-green-500 mt-2 flex items-center justify-between">
                        <span>This Month</span>
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-lg">Total: ${{ number_format($totalRevenue, 2) }}</span>
                    </p>
                </div>

                <!-- Staff Count -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-transparent rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 text-purple-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Staff</span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900">{{ number_format($staffCount) }}</h3>
                    <a href="{{ route('staff.index') }}" class="text-sm font-bold text-purple-600 mt-2 flex items-center hover:text-purple-800 transition-colors">
                        Manage Team
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Today's Schedule -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Today's Schedule</h3>
                        <a href="{{ route('appointments.index') }}" class="text-sm font-bold text-[#39D3C4] hover:text-[#2db3a6]">View Calendar</a>
                    </div>
                    <div class="p-6">
                        @if($todayAppointments->isEmpty())
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No appointments today</h3>
                                <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Enjoy a relaxed day or use this time to review clinic operations.</p>
                                <a href="{{ route('appointments.index') }}" class="inline-flex px-5 py-2.5 bg-[#39D3C4]/10 text-[#2db3a6] hover:bg-[#39D3C4]/20 rounded-xl text-sm font-bold transition-all">
                                    Schedule an Appointment
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($todayAppointments as $appt)
                                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors cursor-pointer" onclick="window.location='{{ route('patients.show', $appt->patient_id) }}'">
                                        <div class="w-16 text-center border-r border-gray-200 pr-4 mr-4">
                                            <div class="text-sm font-extrabold text-gray-900">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i') }}</div>
                                            <div class="text-xs font-bold text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('A') }}</div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-bold text-gray-900">{{ $appt->patient->first_name }} {{ $appt->patient->last_name }}</h4>
                                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Dr. {{ $appt->dentist->name ?? 'Unassigned' }}
                                            </p>
                                        </div>
                                        <div>
                                            @php
                                                $statusColor = match($appt->status) {
                                                    'confirmed' => 'bg-emerald-100 text-emerald-800',
                                                    'waiting' => 'bg-amber-100 text-amber-800',
                                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-gray-100 text-gray-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'no_show' => 'bg-purple-100 text-purple-800',
                                                    default => 'bg-[#39D3C4]/10 text-[#39D3C4]',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wider {{ $statusColor }}">
                                                {{ $appt->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Patients -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Recent Patients</h3>
                        <a href="{{ route('patients.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900">View All</a>
                    </div>
                    <div class="p-6">
                        @if($recentPatients->isEmpty())
                            <p class="text-gray-500 text-sm text-center py-4">No patients registered yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($recentPatients as $patient)
                                    <div class="flex items-center group cursor-pointer" onclick="window.location='{{ route('patients.show', $patient->id) }}'">
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm group-hover:from-[#39D3C4]/20 group-hover:to-blue-500/20 group-hover:text-[#39D3C4] transition-all">
                                            {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors">
                                                {{ $patient->first_name }} {{ $patient->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500 font-medium">
                                                PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                        <div class="text-gray-400 group-hover:text-[#39D3C4] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
