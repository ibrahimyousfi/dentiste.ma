<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Register New Clinic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1E293B] overflow-hidden shadow-lg sm:rounded-lg p-6 max-w-3xl mx-auto border-t-4 border-indigo-500">
                
                <form method="POST" action="{{ route('admin.organizations.store') }}">
                    @csrf

                    <h3 class="text-lg font-bold text-white mb-4 border-b border-[#334155] pb-2">1. Clinic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Clinic Name -->
                        <div>
                            <label for="clinic_name" class="block font-medium text-sm text-gray-300">Clinic Name</label>
                            <input id="clinic_name" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="clinic_name" value="{{ old('clinic_name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('clinic_name')" class="mt-2" />
                        </div>
                        
                        <!-- Clinic Email -->
                        <div>
                            <label for="clinic_email" class="block font-medium text-sm text-gray-300">Clinic Email (Optional)</label>
                            <input id="clinic_email" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="clinic_email" value="{{ old('clinic_email') }}" />
                            <x-input-error :messages="$errors->get('clinic_email')" class="mt-2" />
                        </div>

                        <!-- Clinic Phone -->
                        <div>
                            <label for="clinic_phone" class="block font-medium text-sm text-gray-300">Clinic Phone (Optional)</label>
                            <input id="clinic_phone" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="clinic_phone" value="{{ old('clinic_phone') }}" />
                            <x-input-error :messages="$errors->get('clinic_phone')" class="mt-2" />
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-white mb-4 border-b border-[#334155] pb-2 mt-8">2. Owner Account</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Owner Name -->
                        <div>
                            <label for="owner_name" class="block font-medium text-sm text-gray-300">Owner Full Name</label>
                            <input id="owner_name" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="owner_name" value="{{ old('owner_name') }}" required />
                            <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                        </div>

                        <!-- Owner Email -->
                        <div>
                            <label for="owner_email" class="block font-medium text-sm text-gray-300">Owner Login Email</label>
                            <input id="owner_email" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="owner_email" value="{{ old('owner_email') }}" required />
                            <x-input-error :messages="$errors->get('owner_email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block font-medium text-sm text-gray-300">Temporary Password</label>
                            <input id="password" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirm Password</label>
                            <input id="password_confirmation" class="block mt-1 w-full bg-[#0F172A] border-[#334155] text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <a class="underline text-sm text-gray-400 hover:text-white mr-4" href="{{ route('admin.organizations.index') }}">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Create Clinic & Owner Account') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>
