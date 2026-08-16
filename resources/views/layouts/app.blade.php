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
                    <!-- Left Side (Toggle + Title) -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#39D3C4] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] rounded-lg p-2 transition-colors mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        @isset($header_title)
                            <div class="hidden md:flex items-center">
                                {{ $header_title }}
                            </div>
                        @endisset
                    </div>

                    <!-- Right Side (Actions + Profile) -->
                    <div class="flex items-center space-x-4">
                        @isset($header_actions)
                            <div class="hidden lg:flex items-center">
                                {{ $header_actions }}
                            </div>
                        @endisset

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 border-l border-gray-200 pl-4 ml-2">
                                    <div class="h-8 w-8 rounded-full bg-[#39D3C4]/10 text-[#39D3C4] flex items-center justify-center font-bold mr-2">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden sm:block">{{ Auth::user()->name }}</div>
                                    <div class="ml-1 hidden sm:block">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Scrollable Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F9FAFB] p-6">
                    <div class="w-full max-w-7xl mx-auto">
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
    </body>
</html>
