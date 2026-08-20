<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Get Started</h2>
        <p class="text-gray-500 text-sm mt-1">Submit a request to register your clinic</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Clinic Name -->
        <div>
            <label for="clinic_name" class="block font-medium text-sm text-gray-700 mb-1">Clinic Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <input id="clinic_name" type="text" name="clinic_name" value="{{ old('clinic_name') }}" required autofocus autocomplete="organization"
                    class="block w-full pl-10 rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4]/20 transition-all text-sm py-2.5" placeholder="Dental Care Clinic">
            </div>
            <x-input-error :messages="$errors->get('clinic_name')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Owner Name -->
        <div>
            <label for="owner_name" class="block font-medium text-sm text-gray-700 mb-1">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input id="owner_name" type="text" name="owner_name" value="{{ old('owner_name') }}" required autocomplete="name"
                    class="block w-full pl-10 rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4]/20 transition-all text-sm py-2.5" placeholder="Dr. John Doe">
            </div>
            <x-input-error :messages="$errors->get('owner_name')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Work Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="block w-full pl-10 rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4]/20 transition-all text-sm py-2.5" placeholder="contact@clinic.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone" class="block font-medium text-sm text-gray-700 mb-1">Phone Number</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                    class="block w-full pl-10 rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4]/20 transition-all text-sm py-2.5" placeholder="+1 (555) 000-0000">
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-500" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm shadow-[#39D3C4]/20 text-sm font-semibold text-white bg-gradient-to-r from-[#39D3C4] to-[#2db3a6] hover:from-[#32b8ab] hover:to-[#28a195] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] transition-all transform hover:scale-[1.02] active:scale-100">
                Submit Request
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            Already registered? 
            <a href="{{ route('login') }}" class="font-semibold text-[#39D3C4] hover:text-[#2db3a6] transition-colors">Sign in</a>
        </div>
    </form>
</x-guest-layout>
