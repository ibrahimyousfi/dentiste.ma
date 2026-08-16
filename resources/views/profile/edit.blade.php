<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight tracking-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-8 animate-fade-in" x-data="{ tab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Settings Sidebar -->
                <div class="w-full md:w-64 shrink-0">
                    <nav class="space-y-2">
                        <button @click="tab = 'profile'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold border-[#39D3C4]': tab === 'profile', 'text-gray-600 hover:bg-gray-50 font-medium border-transparent': tab !== 'profile' }" class="w-full flex items-center px-4 py-3 text-sm rounded-xl transition-all border-l-4">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </button>
                        
                        @if(auth()->user()->hasRole('Clinic Owner') && auth()->user()->organization)
                        <button @click="tab = 'clinic'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold border-[#39D3C4]': tab === 'clinic', 'text-gray-600 hover:bg-gray-50 font-medium border-transparent': tab !== 'clinic' }" class="w-full flex items-center px-4 py-3 text-sm rounded-xl transition-all border-l-4">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Clinic Details
                        </button>
                        @endif

                        <button @click="tab = 'security'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold border-[#39D3C4]': tab === 'security', 'text-gray-600 hover:bg-gray-50 font-medium border-transparent': tab !== 'security' }" class="w-full flex items-center px-4 py-3 text-sm rounded-xl transition-all border-l-4">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Security
                        </button>

                        <button @click="tab = 'danger'" :class="{ 'bg-red-50 text-red-600 font-bold border-red-500': tab === 'danger', 'text-gray-500 hover:bg-red-50 hover:text-red-500 font-medium border-transparent': tab !== 'danger' }" class="w-full flex items-center px-4 py-3 text-sm rounded-xl transition-all border-l-4 mt-8">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Danger Zone
                        </button>
                    </nav>
                </div>

                <!-- Settings Content -->
                <div class="flex-1 bg-white rounded-3xl shadow-sm border border-gray-100 p-8 min-h-[500px]">
                    
                    <!-- Profile Tab -->
                    <div x-show="tab === 'profile'" x-transition.opacity.duration.300ms>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('Clinic Owner') && auth()->user()->organization)
                    <!-- Clinic Details Tab -->
                    <div x-show="tab === 'clinic'" style="display: none;" x-transition.opacity.duration.300ms>
                        <div class="max-w-xl">
                            @include('profile.partials.update-clinic-information-form')
                        </div>
                    </div>
                    @endif

                    <!-- Security Tab -->
                    <div x-show="tab === 'security'" style="display: none;" x-transition.opacity.duration.300ms>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Tab -->
                    <div x-show="tab === 'danger'" style="display: none;" x-transition.opacity.duration.300ms>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
