<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Simple Dental Color Variables */
            :root {
                --color-primary: #39D3C4; /* Bright Teal/Cyan */
                --color-primary-hover: #2db3a6;
                --color-dark: #374151; /* Dark Gray */
                --color-bg: #F9FAFB; /* Light Gray Background */
                --color-card: #FFFFFF; /* Pure White */
            }
            .text-primary { color: var(--color-primary); }
            .bg-primary { background-color: var(--color-primary); }
            .border-primary { border-color: var(--color-primary); }
            .hover\:bg-primary-hover:hover { background-color: var(--color-primary-hover); }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#F9FAFB]">
        <div class="flex h-screen overflow-hidden bg-[#F9FAFB] selection:bg-[#39D3C4] selection:text-white">
            
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Wrapper -->
            <div class="flex flex-col flex-1 w-full h-full overflow-hidden">
                
                <!-- Topbar -->
                <header class="bg-white border-b border-gray-200 sticky top-0 z-30 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <!-- Left Side (Title) -->
                    <div class="flex items-center">
                        @isset($header_title)
                            <div class="hidden md:flex items-center">
                                {{ $header_title }}
                            </div>
                        @endisset
                    </div>

                    <!-- Right Side (Contextual Search & Actions) -->
                    <div class="flex flex-1 items-center justify-between ml-4">
                        <!-- Global / Contextual Search Slot -->
                        <div class="flex-1 max-w-2xl flex items-center">
                            @isset($header_search)
                                {{ $header_search }}
                            @endisset
                        </div>

                        <!-- Context-sensitive actions -->
                        <div class="flex items-center space-x-3 ml-4">
                            @isset($header_filters)
                                <div class="hidden md:flex">
                                    {{ $header_filters }}
                                </div>
                            @endisset

                            @isset($header_actions)
                                <div class="flex items-center space-x-2">
                                    {{ $header_actions }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </header>

                <!-- Scrollable Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F9FAFB] p-4">
                    <div class="w-full max-w-full mx-auto">
                        <!-- Mobile Actions (shown only on small screens) -->
                        @isset($header_actions)
                            <div class="lg:hidden mb-6 flex flex-col sm:flex-row gap-4">
                                {{ $header_actions }}
                            </div>
                        @endisset
                        
                        {{ $slot }}
                    </div>
                </main>
            </div>
            
        </div>
        @stack('scripts')
        
        @auth
            @if(Auth::user()->organization)
                <x-ai-copilot />
            @endif
        @endauth
    </body>
</html>
