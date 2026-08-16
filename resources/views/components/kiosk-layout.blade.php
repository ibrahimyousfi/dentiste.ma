<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Smile Clinic') }} - Kiosk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,700,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Disable pull-to-refresh on tablets and selecting text */
            body {
                overscroll-behavior-y: contain;
                user-select: none;
                -webkit-user-select: none;
            }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col justify-center items-center">
        
        <!-- Header / Logo -->
        <div class="absolute top-8 left-8 flex items-center gap-3">
            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-[#39D3C4] to-teal-600 flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ config('app.name', 'Smile Clinic') }}</h1>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Self-Service</p>
            </div>
        </div>

        <!-- Main Content Slot -->
        <main class="w-full max-w-2xl px-6">
            {{ $slot }}
        </main>

        @stack('scripts')
    </body>
</html>
