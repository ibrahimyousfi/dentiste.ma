<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3 cursor-pointer group" onclick="window.location='{{ route('prescriptions.index') }}'">
            <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                    {{ __('Write Prescription') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Generate a new medical prescription for a patient.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg shadow-purple-100/20 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form action="{{ route('prescriptions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                Patient & Dentist
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Patient -->
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Patient <span class="text-red-500">*</span></label>
                                <select id="patient_id" name="patient_id" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-purple-500 focus:border-purple-500 shadow-sm sm:text-sm transition-colors py-2.5">
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
                                <select id="dentist_id" name="dentist_id" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-purple-500 focus:border-purple-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                    <option value="">Select Dentist</option>
                                    @foreach($dentists as $dentist)
                                        <option value="{{ $dentist->id }}" @selected(old('dentist_id', auth()->id()) == $dentist->id)>Dr. {{ $dentist->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dentist_id')" class="mt-2" />
                            </div>
                            
                            <!-- Date -->
                            <div class="md:col-span-2">
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-purple-500 focus:border-purple-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </span>
                                Prescription Details
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <div class="md:col-span-2">
                                <label for="medications" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Medications & Dosage (Rx) <span class="text-red-500">*</span></label>
                                <textarea id="medications" name="medications" rows="6" required placeholder="e.g.&#10;1. Amoxicillin 500mg, 1 tablet every 8 hours for 7 days.&#10;2. Ibuprofen 400mg, 1 tablet every 6 hours as needed for pain."
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-purple-500 focus:border-purple-500 shadow-sm sm:text-sm transition-colors">{{ old('medications') }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">List all medications, dosages, and instructions clearly.</p>
                                <x-input-error :messages="$errors->get('medications')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Additional Notes</label>
                                <textarea id="notes" name="notes" rows="2" placeholder="e.g. Take medications after meals."
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-purple-500 focus:border-purple-500 shadow-sm sm:text-sm transition-colors">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('prescriptions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-purple-500/30 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all">
                                Generate & Print Prescription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
