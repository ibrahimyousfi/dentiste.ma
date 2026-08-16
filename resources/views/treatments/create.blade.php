<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3 cursor-pointer group" onclick="window.location='{{ route('treatment-plans.index') }}'">
            <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                    {{ __('Propose Treatment Plan') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Draft a comprehensive clinical plan and estimated cost for a patient.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg shadow-teal-100/20 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form action="{{ route('treatment-plans.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                Participants
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Select the patient and the responsible dentist for this plan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Patient -->
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Patient <span class="text-red-500">*</span></label>
                                <select id="patient_id" name="patient_id" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                            </div>

                            <!-- Dentist -->
                            <div>
                                <label for="dentist_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dentist <span class="text-red-500">*</span></label>
                                <select id="dentist_id" name="dentist_id" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                    <option value="">Select Dentist</option>
                                    @foreach($dentists as $dentist)
                                        <option value="{{ $dentist->id }}" @selected(old('dentist_id', auth()->id()) == $dentist->id)>Dr. {{ $dentist->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dentist_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </span>
                                Plan Details & Cost
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Plan Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Treatment Plan Title <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Full Mouth Rehabilitation - Phase 1"
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Cost -->
                            <div>
                                <label for="total_estimated_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Estimated Cost ($) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" min="0" name="total_estimated_cost" id="total_estimated_cost" value="{{ old('total_estimated_cost') }}" required placeholder="0.00"
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('total_estimated_cost')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Clinical Notes & Summary</label>
                                <textarea id="notes" name="notes" rows="4" placeholder="Brief overview of the planned procedures..."
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500 shadow-sm sm:text-sm transition-colors">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('treatment-plans.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-teal-500/30 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all">
                                Save Proposed Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
