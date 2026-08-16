<x-kiosk-layout>
    <div class="bg-white rounded-3xl shadow-xl p-12 md:p-20 text-center border border-gray-100 relative overflow-hidden">
        
        <div class="mx-auto w-24 h-24 bg-[#39D3C4]/10 rounded-full flex items-center justify-center mb-8">
            <svg class="w-12 h-12 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tight">You're all set!</h2>
        <p class="text-xl text-gray-500 font-medium mb-12">Thank you for checking in. Please take a seat and the doctor will be with you shortly.</p>

        <a href="{{ route('kiosk.index') }}" class="inline-flex justify-center items-center py-4 px-10 border border-transparent rounded-2xl text-lg font-black text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-gray-900 transition-all">
            Return to Home
        </a>

        <!-- Auto-redirect back to home after 10 seconds -->
        <script>
            setTimeout(() => {
                window.location.href = "{{ route('kiosk.index') }}";
            }, 10000);
        </script>
    </div>
</x-kiosk-layout>
