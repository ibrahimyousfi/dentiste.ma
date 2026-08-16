<x-kiosk-layout>
    <div class="bg-white rounded-3xl shadow-xl p-10 md:p-16 w-full text-center border border-gray-100 relative overflow-hidden">
        
        <!-- Decoration -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#39D3C4] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>

        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tight">Welcome to the Clinic</h2>
            <p class="text-lg md:text-xl text-gray-500 font-medium mb-12">Please check in for your appointment by entering your registered phone number.</p>

            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-8 font-bold flex items-center justify-center gap-2 animate-bounce">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('kiosk.identify') }}" method="POST" class="max-w-md mx-auto" x-data="{ phone: '' }">
                @csrf
                <div class="mb-8 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <input type="tel" name="phone" id="phone" x-model="phone" class="block w-full pl-16 pr-6 py-6 text-2xl font-bold border-gray-200 rounded-2xl shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] text-center bg-gray-50 placeholder-gray-400" placeholder="e.g. +212 600 000 000" required autocomplete="off">
                </div>

                <button type="submit" :disabled="phone.length < 8" :class="phone.length < 8 ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 hover:shadow-xl hover:shadow-[#39D3C4]/20'" class="w-full flex justify-center items-center py-5 px-8 border border-transparent rounded-2xl text-xl font-black text-white bg-[#39D3C4] focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-[#39D3C4] transition-all duration-300 transform">
                    Check In Now
                    <svg class="ml-3 -mr-1 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</x-kiosk-layout>
