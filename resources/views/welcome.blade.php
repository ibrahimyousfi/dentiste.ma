<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Dental Clinic SaaS') }} - Manage Your Practice</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            }
            .gradient-text {
                background: linear-gradient(135deg, #39D3C4 0%, #28a195 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .hero-bg {
                background: radial-gradient(circle at 15% 50%, rgba(57, 211, 196, 0.08), transparent 25%),
                            radial-gradient(circle at 85% 30%, rgba(57, 211, 196, 0.05), transparent 25%);
            }
            .float-anim {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#F9FAFB] selection:bg-[#39D3C4] selection:text-white">
        
        <!-- Navigation -->
        <header class="fixed w-full top-0 z-50 glass-card border-b-0 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#39D3C4] to-[#2db3a6] rounded-xl flex items-center justify-center shadow-md shadow-[#39D3C4]/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">{{ config('app.name', 'Dental Clinic') }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors hidden sm:block">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-[#39D3C4] to-[#2db3a6] hover:shadow-md hover:shadow-[#39D3C4]/20 transform transition hover:-translate-y-0.5">
                                        Start Free Trial
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-bg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#39D3C4]/10 text-[#2db3a6] text-sm font-semibold mb-6 border border-[#39D3C4]/20">
                    <span class="flex h-2 w-2 rounded-full bg-[#39D3C4] animate-pulse"></span>
                    The Next Generation Dental Software
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                    Manage your clinic <br class="hidden md:block" />
                    <span class="gradient-text">effortlessly.</span>
                </h1>
                
                <p class="mt-4 text-xl text-gray-500 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Everything you need to run a modern dental practice. From advanced odontograms and X-ray management to intelligent scheduling and billing.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border border-transparent rounded-xl shadow-lg shadow-[#39D3C4]/30 text-base font-semibold text-white bg-gradient-to-r from-[#39D3C4] to-[#2db3a6] hover:from-[#32b8ab] hover:to-[#28a195] transition-all transform hover:scale-105">
                        Get Started Today
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border border-gray-200 rounded-xl shadow-sm text-base font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                        Explore Features
                    </a>
                </div>
            </div>
            
            <!-- Hero Image/Dashboard Mockup -->
            <div class="mt-20 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative float-anim">
                <div class="rounded-2xl bg-white/50 p-2 backdrop-blur-xl border border-white shadow-2xl">
                    <div class="rounded-xl overflow-hidden bg-gray-100 border border-gray-200 aspect-[16/9] relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-100"></div>
                        <!-- Abstract Dashboard UI Representation -->
                        <div class="absolute inset-0 p-8 flex flex-col gap-6 opacity-60">
                            <!-- Fake Header -->
                            <div class="flex justify-between items-center">
                                <div class="w-1/4 h-8 bg-white rounded-lg shadow-sm"></div>
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-white rounded-full shadow-sm"></div>
                                    <div class="w-10 h-10 bg-white rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            <!-- Fake Content -->
                            <div class="flex gap-6 h-full">
                                <div class="w-1/4 bg-white rounded-xl shadow-sm p-4 flex flex-col gap-4">
                                    <div class="w-full h-8 bg-gray-100 rounded-md"></div>
                                    <div class="w-full h-8 bg-gray-100 rounded-md"></div>
                                    <div class="w-full h-8 bg-gray-100 rounded-md"></div>
                                    <div class="w-full h-8 bg-[#39D3C4]/20 rounded-md"></div>
                                </div>
                                <div class="w-3/4 flex flex-col gap-6">
                                    <div class="flex gap-6 h-32">
                                        <div class="flex-1 bg-white rounded-xl shadow-sm p-4"></div>
                                        <div class="flex-1 bg-white rounded-xl shadow-sm p-4"></div>
                                        <div class="flex-1 bg-white rounded-xl shadow-sm p-4"></div>
                                    </div>
                                    <div class="flex-1 bg-white rounded-xl shadow-sm p-4">
                                        <div class="w-full h-full border-2 border-dashed border-gray-200 rounded-lg flex items-center justify-center text-gray-400 font-medium">
                                            Interactive Dental Chart Area
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-base text-[#39D3C4] font-semibold tracking-wide uppercase">Features</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        A better way to manage your clinic
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Powerful tools designed specifically for dentists to streamline workflow, improve patient care, and grow revenue.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-[#39D3C4] mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Interactive Odontogram</h3>
                        <p class="text-gray-500 leading-relaxed">
                            A fully interactive dental chart allowing you to record conditions, plan treatments, and track progress effortlessly with precise tooth modeling.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-[#39D3C4] mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">X-Rays & Media</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Upload, organize, and view dental X-rays and clinical photos securely. Link media directly to patient records and specific teeth.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-[#39D3C4] mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Appointments</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Smart calendar management for your staff. Schedule visits, send automated reminders, and reduce patient no-shows.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gray-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#39D3C4] via-transparent to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">
                    Ready to digitize your clinic?
                </h2>
                <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    Join hundreds of dentists who trust our platform to run their daily operations efficiently.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent rounded-xl shadow-lg text-base font-semibold text-gray-900 bg-[#39D3C4] hover:bg-[#32b8ab] transition-all transform hover:scale-105">
                    Start Your Free Trial
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 pt-12 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#39D3C4] to-[#2db3a6] rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">{{ config('app.name', 'Dental Clinic') }}</span>
                    </div>
                    <div class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Dental Clinic SaaS') }}. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
