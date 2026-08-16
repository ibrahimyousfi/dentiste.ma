<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>
    
    <x-slot name="header_actions">
        <a href="{{ route('patients.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-sm transition-all">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Patient
        </a>
    </x-slot>

    <div class="animate-fade-in max-w-7xl mx-auto pb-10">
        <!-- Google-style Search Bar & Filters -->
        <div class="mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-11 pr-4 py-3 border-none rounded-full shadow-sm bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all text-base" placeholder="Search patients by name or National ID...">
            </div>

            <!-- Microsoft/Google style Tab Filters -->
            <div class="flex items-center space-x-1 bg-gray-100/50 p-1 rounded-xl">
                <a href="{{ route('patients.index', ['filter' => 'active']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors
                          {{ $filter === 'active' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    Active <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $filter === 'active' ? 'bg-gray-100 text-gray-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['active'] ?? 0 }}</span>
                </a>
                <a href="{{ route('patients.index', ['filter' => 'in_treatment']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors
                          {{ $filter === 'in_treatment' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    In Treatment <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $filter === 'in_treatment' ? 'bg-blue-50 text-blue-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['in_treatment'] ?? 0 }}</span>
                </a>
                <a href="{{ route('patients.index', ['filter' => 'completed']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors
                          {{ $filter === 'completed' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    Completed <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $filter === 'completed' ? 'bg-green-50 text-green-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['completed'] ?? 0 }}</span>
                </a>
                <div class="w-px h-5 bg-gray-300 mx-2"></div>
                <a href="{{ route('patients.index', ['filter' => 'all']) }}" 
                   class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors
                          {{ $filter === 'all' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    All <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $filter === 'all' ? 'bg-purple-50 text-purple-600' : 'bg-gray-200 text-gray-500' }}">{{ $counts['all'] ?? 0 }}</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($patients->isEmpty())
                <div class="p-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4 text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No patients found</h3>
                    <p class="text-gray-500 max-w-sm mx-auto">Try adjusting your filters or register a new patient to get started.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Patient</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Contact</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Treatment Progress</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Next Appt</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($patients as $patient)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('patients.show', $patient) }}" class="flex items-center group cursor-pointer">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium text-sm">
                                                {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                                    {{ $patient->national_id ?? 'No ID' }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $patient->phone ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $patient->email ?? 'No email' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($patient->total_sessions > 0)
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-1 w-24">
                                                    <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                                        @php
                                                            $percentage = ($patient->completed_sessions / $patient->total_sessions) * 100;
                                                            $barColor = $patient->treatment_status === 'completed' ? 'bg-green-500' : 'bg-blue-500';
                                                        @endphp
                                                        <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                                <span class="text-xs font-medium text-gray-600">
                                                    {{ $patient->completed_sessions }}/{{ $patient->total_sessions }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] uppercase font-semibold mt-1 tracking-wider {{ $patient->treatment_status === 'completed' ? 'text-green-600' : 'text-blue-600' }}">
                                                {{ str_replace('_', ' ', $patient->treatment_status) }}
                                            </div>
                                        @else
                                            <div x-data="{ showForm: false }" class="relative">
                                                <button @click="showForm = true" x-show="!showForm" class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-full shadow-sm text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                    Start Plan
                                                </button>
                                                
                                                <form x-show="showForm" action="{{ route('patients.set-sessions', $patient) }}" method="POST" class="flex items-center space-x-2" @click.away="showForm = false" style="display: none;">
                                                    @csrf
                                                    <input type="number" name="total_sessions" min="1" max="100" class="block w-16 py-1 px-2 text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Qty" required autofocus>
                                                    <button type="submit" class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors shadow-sm">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($patient->appointments->isNotEmpty())
                                            @php $nextAppt = $patient->appointments->first(); @endphp
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M d') }}, {{ \Carbon\Carbon::parse($nextAppt->start_time)->format('h:i A') }}
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">None</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if($patient->total_sessions > 0 && $patient->treatment_status !== 'completed')
                                                <form action="{{ route('patients.increment-session', $patient) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-gray-200 text-gray-400 bg-white hover:bg-green-50 hover:text-green-500 hover:border-green-200 focus:outline-none transition-all shadow-sm" title="Mark Session Completed">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                                <div class="w-px h-4 bg-gray-200 mx-1"></div>
                                            @endif
                                            
                                            @if($patient->phone)
                                                <a href="#" class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full hover:bg-green-200 hover:text-green-700 hover:scale-110 transition-all shadow-sm" title="Message on WhatsApp">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                                </a>
                                            @endif
                                            @if($patient->email)
                                                <a href="#" class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 hover:text-blue-700 hover:scale-110 transition-all shadow-sm" title="Send Email">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                </a>
                                            @endif
                                            
                                            <div class="w-px h-6 bg-gray-200 mx-1"></div>
                                            
                                            <a href="{{ route('patients.show', $patient) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-500 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition-colors" title="View Profile">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($patients->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $patients->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
