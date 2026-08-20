<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F9FAFB] selection:bg-[#39D3C4] selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-[#39D3C4]/30 to-transparent blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-gradient-to-tl from-[#39D3C4]/20 to-transparent blur-[100px] pointer-events-none"></div>

            <div class="z-10 mb-8 text-center flex flex-col items-center">
                <a href="/" class="flex items-center gap-2 group">
                    @if(isset($globalPlatformLogo) && $globalPlatformLogo)
                        <img src="{{ asset('storage/' . $globalPlatformLogo) }}" alt="{{ $globalPlatformName ?? 'Platform Logo' }}" class="h-12 w-auto object-contain transform transition group-hover:scale-105">
                    @else
                        <div class="w-12 h-12 bg-gradient-to-br from-[#39D3C4] to-[#2db3a6] rounded-xl flex items-center justify-center shadow-lg shadow-[#39D3C4]/30 transform transition group-hover:scale-105">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-800 tracking-tight">{{ explode(' ', $globalPlatformName ?? 'Dental SaaS')[0] }}<span class="text-[#39D3C4]">{{ explode(' ', $globalPlatformName ?? 'Dental SaaS')[1] ?? '' }}</span></span>
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/80 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden sm:rounded-3xl z-10">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-sm text-gray-400 z-10">
                &copy; {{ date('Y') }} Dental SaaS. All rights reserved.
            </div>
        </div>
    </body>
</html>
