<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal - {{ config('app.name', 'Dental Clinic') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover, .nav-link.active { color: #39D3C4; background-color: rgba(57, 211, 196, 0.1); }
    </style>
</head>
<body class="text-gray-800 antialiased">
    
    <!-- Top Navbar -->
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center text-[#39D3C4] mr-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900 hidden sm:block">Patient Portal</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-2">
                    <a href="{{ route('patient.dashboard') }}" class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : 'text-gray-600' }} px-4 py-2 rounded-xl font-semibold text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('patient.chart') }}" class="nav-link {{ request()->routeIs('patient.chart') ? 'active' : 'text-gray-600' }} px-4 py-2 rounded-xl font-semibold text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Medical Chart
                    </a>
                    <a href="{{ route('patient.payments') }}" class="nav-link {{ request()->routeIs('patient.payments') ? 'active' : 'text-gray-600' }} px-4 py-2 rounded-xl font-semibold text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Payments
                    </a>
                </div>

                <!-- User Dropdown & Logout (Desktop) -->
                <div class="hidden sm:flex items-center">
                    <span class="text-sm font-bold text-gray-700 mr-4">{{ Auth::guard('patient')->user()->first_name }}</span>
                    <form method="POST" action="{{ route('patient.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-100 pb-4 shadow-inner">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('patient.dashboard') }}" class="block px-4 py-3 rounded-xl font-bold text-base {{ request()->routeIs('patient.dashboard') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50' }}">
                    Dashboard
                </a>
                <a href="{{ route('patient.chart') }}" class="block px-4 py-3 rounded-xl font-bold text-base {{ request()->routeIs('patient.chart') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50' }}">
                    Medical Chart
                </a>
                <a href="{{ route('patient.payments') }}" class="block px-4 py-3 rounded-xl font-bold text-base {{ request()->routeIs('patient.payments') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50' }}">
                    Payments
                </a>
            </div>

            <div class="pt-4 pb-1 border-t border-gray-100">
                <div class="px-8">
                    <div class="font-bold text-base text-gray-800">{{ Auth::guard('patient')->user()->first_name }} {{ Auth::guard('patient')->user()->last_name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::guard('patient')->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1 px-4">
                    <form method="POST" action="{{ route('patient.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 font-bold text-red-500 rounded-xl hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm font-medium">
                &copy; {{ date('Y') }} {{ Auth::guard('patient')->user()->organization->name ?? 'Dental Clinic' }}. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
