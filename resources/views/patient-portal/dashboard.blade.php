@extends('layouts.patient')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-[#39D3C4] to-blue-500 rounded-3xl p-8 sm:p-12 text-white shadow-lg relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-2">Hello, {{ $patient->first_name }}! 👋</h1>
            <p class="text-white/80 text-lg font-medium">Welcome back to your personal medical portal.</p>
        </div>
    </div>

    <!-- Treatment Progress -->
    @if($patient->total_sessions > 0)
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </span>
                Treatment Progress
            </h2>
            <div class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg {{ $patient->treatment_status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                {{ str_replace('_', ' ', $patient->treatment_status) }}
            </div>
        </div>

        <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
                <div>
                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-50">
                        Progress
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold text-gray-700">
                        {{ $patient->completed_sessions }} / {{ $patient->total_sessions }} Sessions
                    </span>
                </div>
            </div>
            <div class="overflow-hidden h-3 mb-4 text-xs flex rounded-full bg-gray-100">
                @php
                    $percentage = ($patient->completed_sessions / $patient->total_sessions) * 100;
                    $barColor = $patient->treatment_status === 'completed' ? 'bg-green-500' : 'bg-blue-500';
                @endphp
                <div style="width: {{ $percentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $barColor }} transition-all duration-1000 ease-in-out"></div>
            </div>
            @if($patient->treatment_status !== 'completed')
                <p class="text-sm text-gray-500 font-medium text-center">You have {{ $patient->total_sessions - $patient->completed_sessions }} sessions remaining to complete your treatment.</p>
            @else
                <p class="text-sm text-green-600 font-medium text-center">Congratulations! Your treatment plan is fully completed.</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
                Upcoming Appointments
            </h2>
        </div>

        @if($upcomingAppointments->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-bold text-gray-900">No upcoming appointments</h3>
                <p class="text-gray-500 font-medium mt-1">You're all caught up!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($upcomingAppointments as $appointment)
                    <div class="flex items-start p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col items-center justify-center w-16 h-16 bg-blue-50 text-blue-600 rounded-xl mr-5 shrink-0">
                            <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</span>
                            <span class="text-2xl font-black leading-none mt-1">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l') }}, {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</h4>
                            <p class="text-gray-500 font-medium text-sm mt-1">
                                Doctor: Dr. {{ $appointment->dentist->name ?? 'Dentist' }} <br>
                                {{ $appointment->notes ?? 'Regular Checkup' }}
                            </p>
                            
                            <div class="mt-4 flex gap-2">
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    {{ $appointment->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="{{ route('patient.chart') }}" class="group block p-8 bg-white rounded-3xl shadow-sm border border-gray-100 hover:border-[#39D3C4] transition-colors relative overflow-hidden">
            <div class="absolute right-0 bottom-0 transform translate-x-4 translate-y-4 text-gray-50 group-hover:text-[#39D3C4]/5 transition-colors">
                <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Medical Chart</h3>
                <p class="text-gray-500 font-medium">View your odontogram, diagnoses, and treatment history.</p>
            </div>
        </a>

        <a href="{{ route('patient.payments') }}" class="group block p-8 bg-white rounded-3xl shadow-sm border border-gray-100 hover:border-[#39D3C4] transition-colors relative overflow-hidden">
            <div class="absolute right-0 bottom-0 transform translate-x-4 translate-y-4 text-gray-50 group-hover:text-[#39D3C4]/5 transition-colors">
                <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Financial Records</h3>
                <p class="text-gray-500 font-medium">Review your payments, balances, and print receipts.</p>
            </div>
        </a>
    </div>

</div>
@endsection
