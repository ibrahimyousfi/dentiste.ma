<x-app-layout>
    <x-slot name="header_title">
        <div class="flex items-center space-x-2">
            <a href="{{ route('staff.index') }}" class="text-gray-400 hover:text-[#39D3C4] transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Add New Staff Member') }}
            </h2>
        </div>
    </x-slot>

    <div class="animate-fade-in py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg shadow-indigo-100/20 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-8">
                
                <form method="POST" action="{{ route('staff.store') }}" class="space-y-6">
                    @csrf

                    <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                            <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-400 p-1.5 rounded-md mr-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            Staff Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Personal and account details for the staff member.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors py-2.5">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors py-2.5">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        
                        <!-- Role -->
                        <div class="md:col-span-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">System Role <span class="text-red-500">*</span></label>
                            <select id="role" name="role" required
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors py-2.5">
                                <option value="" disabled selected>Select a role...</option>
                                <option value="Clinic Owner">Doctor / Clinic Owner (Full Access)</option>
                                <option value="Secretary">Secretary / Receptionist (Front Desk Access)</option>
                                <option value="Dentist">Dentist (Clinical Access)</option>
                                <option value="Assistant">Assistant (Limited Clinical Access)</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-10 mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400 p-1.5 rounded-md mr-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            Security
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Set the initial password for this staff member.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors py-2.5">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-[#39D3C4] focus:border-[#39D3C4] shadow-sm sm:text-sm transition-colors py-2.5">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6">
                        <a class="text-sm font-medium text-gray-500 hover:text-gray-800 mr-6 transition-colors" href="{{ route('staff.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#39D3C4] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Save Staff Member') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
