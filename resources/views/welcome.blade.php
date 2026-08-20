<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Dental Clinic SaaS') }} - The Future of Dental Practice</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #39D3C4;
            --primary-dark: #28a195;
            --bg-dark: #030712;
            --bg-card: rgba(17, 24, 39, 0.7);
        }

        body {
            background-color: var(--bg-dark);
            color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-card {
            background: linear-gradient(145deg, rgba(31, 41, 55, 0.4) 0%, rgba(17, 24, 39, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Gradients */
        .text-gradient {
            background: linear-gradient(to right, #ffffff, #9ca3af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, #39D3C4, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Glowing Orbs */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.5;
        }

        .glow-orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(57, 211, 196, 0.2);
            top: -100px;
            left: -100px;
        }

        .glow-orb-2 {
            width: 500px;
            height: 500px;
            background: rgba(59, 130, 246, 0.15);
            top: 20%;
            right: -200px;
        }

        /* Infinite Marquee */
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: 100%;
            padding: 2rem 0;
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .marquee-content {
            display: inline-flex;
            animation: scroll 30s linear infinite;
            gap: 4rem;
            align-items: center;
        }
        
        .marquee-content:hover {
            animation-play-state: paused;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Grid Background */
        .bg-grid {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%);
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(57, 211, 196, 0.15);
            border-color: rgba(57, 211, 196, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(57, 211, 196, 0.3);
        }
        .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(57, 211, 196, 0.5);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="antialiased selection:bg-[#39D3C4] selection:text-white relative">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] bg-grid"></div>
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass border-b-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#39D3C4] to-blue-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-[#39D3C4]/20">
                        D
                    </div>
                    <span class="font-bold text-xl tracking-tight text-white">Dental<span class="text-[#39D3C4]">SaaS</span></span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-300 hover:text-white transition">Features</a>
                    <a href="#pricing" class="text-sm font-medium text-gray-300 hover:text-white transition">Pricing</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-300 hover:text-white transition">Trusted By</a>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white hover:text-[#39D3C4] transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-bold btn-primary px-5 py-2.5 rounded-full">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass border border-[#39D3C4]/30 text-[#39D3C4] text-xs font-semibold uppercase tracking-wider mb-8 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-[#39D3C4] animate-pulse"></span>
                Antigravity 2.0 Engine Enabled
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
                The Operating System for <br class="hidden md:block">
                <span class="text-gradient-primary">Modern Dental Clinics</span>
            </h1>
            
            <p class="mt-4 max-w-2xl text-lg md:text-xl text-gray-400 mx-auto mb-10 animate-fade-in-up" style="animation-delay: 0.2s">
                Elevate your practice with AI-driven charting, automated billing, and a world-class patient experience. Everything you need, unified in one elegant platform.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-full text-lg font-bold flex items-center justify-center gap-2">
                    Start Your Free Trial
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="#features" class="glass px-8 py-4 rounded-full text-lg font-bold text-white hover:bg-white/5 transition flex items-center justify-center gap-2">
                    Explore Features
                </a>
            </div>

            <!-- Hero Image/Dashboard Mockup -->
            <div class="mt-20 relative mx-auto max-w-5xl animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="absolute inset-0 bg-gradient-to-t from-bg-dark to-transparent z-10 top-1/2"></div>
                <div class="glass-card rounded-2xl p-2 border border-gray-700/50 shadow-2xl overflow-hidden relative group">
                    <!-- Fake Window Controls -->
                    <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-800 bg-[#111827]">
                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    </div>
                    <!-- Mockup Content -->
                    <div class="bg-[#0f172a] h-[400px] w-full rounded-b-xl relative overflow-hidden flex flex-col p-8">
                        <div class="w-full flex gap-6">
                            <div class="w-1/4 space-y-4">
                                <div class="h-8 bg-gray-800 rounded-lg w-full"></div>
                                <div class="h-8 bg-gray-800 rounded-lg w-3/4"></div>
                                <div class="h-8 bg-gray-800 rounded-lg w-5/6"></div>
                            </div>
                            <div class="w-3/4 space-y-6">
                                <div class="flex gap-4">
                                    <div class="h-32 bg-[#39D3C4]/10 border border-[#39D3C4]/20 rounded-2xl w-1/3"></div>
                                    <div class="h-32 bg-blue-500/10 border border-blue-500/20 rounded-2xl w-1/3"></div>
                                    <div class="h-32 bg-purple-500/10 border border-purple-500/20 rounded-2xl w-1/3"></div>
                                </div>
                                <div class="h-48 bg-gray-800 rounded-2xl w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted Dentals Marquee -->
    <div id="testimonials" class="py-12 border-y border-white/5 bg-black/20">
        <div class="max-w-7xl mx-auto px-4 mb-6 text-center">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest">Trusted by industry-leading clinics</p>
        </div>
        
        <div class="marquee-container">
            <div class="marquee-content">
                @if(isset($clinics) && $clinics->count() > 0)
                    <!-- Duplicate for infinite scroll effect -->
                    @foreach($clinics as $clinic)
                        <div class="flex items-center gap-3 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 cursor-pointer">
                            @if($clinic->logo)
                                <img src="{{ Storage::url($clinic->logo) }}" alt="{{ $clinic->name }}" class="h-10 object-contain">
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr($clinic->name, 0, 1) }}
                                    </div>
                                    <span class="text-xl font-bold text-white tracking-tight">{{ $clinic->name }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <!-- Repeat exactly same elements -->
                    @foreach($clinics as $clinic)
                        <div class="flex items-center gap-3 grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 cursor-pointer">
                            @if($clinic->logo)
                                <img src="{{ Storage::url($clinic->logo) }}" alt="{{ $clinic->name }}" class="h-10 object-contain">
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr($clinic->name, 0, 1) }}
                                    </div>
                                    <span class="text-xl font-bold text-white tracking-tight">{{ $clinic->name }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-gray-500 font-medium">Join the growing network of modern dental practices today.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Features Bento Grid -->
    <div id="features" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-[#39D3C4] font-bold tracking-wide uppercase text-sm mb-2">Powerful Features</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-white">Everything you need to scale.</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Large Feature Card -->
                <div class="md:col-span-2 glass-card rounded-3xl p-8 hover-lift relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#39D3C4]/10 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-[#39D3C4]/20 transition-all"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-[#39D3C4]/20 text-[#39D3C4] flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-white mb-3">AI-Powered Dental Charting</h4>
                        <p class="text-gray-400 max-w-md">Instantly log findings, generate treatment plans, and automatically update patient records using our intuitive visual charting tools and AI Copilot.</p>
                    </div>
                </div>

                <!-- Small Feature Card -->
                <div class="glass-card rounded-3xl p-8 hover-lift relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-2">Automated Billing</h4>
                        <p class="text-gray-400 text-sm">Generate beautiful invoices, track payments, and manage expenses seamlessly.</p>
                    </div>
                </div>

                <!-- Small Feature Card -->
                <div class="glass-card rounded-3xl p-8 hover-lift relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-all"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-2">WhatsApp Reminders</h4>
                        <p class="text-gray-400 text-sm">Reduce no-shows by up to 40% with automated, personalized WhatsApp and Email notifications.</p>
                    </div>
                </div>

                <!-- Large Feature Card -->
                <div class="md:col-span-2 glass-card rounded-3xl p-8 hover-lift relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl -ml-20 -mt-20 group-hover:bg-amber-500/20 transition-all"></div>
                    <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
                        <div class="flex-1">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h4 class="text-2xl font-bold text-white mb-3">Multi-Role Management</h4>
                            <p class="text-gray-400">Dedicated dashboards for Doctors, Secretaries, and Assistants. Control permissions and track performance analytics per staff member.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="py-24 relative bg-black/30 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Transparent Pricing</h2>
                <p class="text-xl text-gray-400">Choose the plan that fits your clinic's scale.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center max-w-6xl mx-auto">
                @if(isset($plans) && $plans->count() > 0)
                    @foreach($plans as $plan)
                        <div class="glass-card rounded-3xl p-8 hover-lift relative {{ $plan->slug === 'pro' ? 'border-[#39D3C4]/50 shadow-2xl shadow-[#39D3C4]/10 md:scale-105 z-10' : 'border-gray-800' }}">
                            @if($plan->slug === 'pro')
                                <div class="absolute top-0 inset-x-0 flex justify-center -mt-4">
                                    <span class="bg-gradient-to-r from-[#39D3C4] to-[#2BA99B] text-white text-xs font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-lg">
                                        Most Popular
                                    </span>
                                </div>
                            @endif
                            
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                            <div class="flex items-baseline mb-6">
                                <span class="text-5xl font-extrabold text-white">${{ $plan->price_monthly }}</span>
                                <span class="text-gray-500 ml-2 font-medium">/month</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-center text-gray-300">
                                    <svg class="w-5 h-5 text-[#39D3C4] mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $plan->limit_patients ? $plan->limit_patients . ' Patients' : 'Unlimited Patients' }}
                                </li>
                                <li class="flex items-center text-gray-300">
                                    <svg class="w-5 h-5 text-[#39D3C4] mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $plan->limit_users ? $plan->limit_users . ' Staff Members' : 'Unlimited Staff' }}
                                </li>
                                @foreach($plan->features ?? [] as $feature => $enabled)
                                    @if($enabled)
                                        <li class="flex items-center text-gray-300">
                                            <svg class="w-5 h-5 text-[#39D3C4] mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            {{ ucwords(str_replace('_', ' ', $feature)) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            
                            <a href="{{ route('register') }}" class="w-full block text-center {{ $plan->slug === 'pro' ? 'btn-primary' : 'glass hover:bg-white/10 text-white' }} py-3 rounded-xl font-bold transition-all">
                                Get Started
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center text-gray-400 py-10">
                        Pricing plans are currently being updated. Check back soon!
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-black py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#39D3C4] to-blue-500 flex items-center justify-center text-white font-bold shadow-lg">
                    D
                </div>
                <span class="font-bold tracking-tight text-white">Dental<span class="text-[#39D3C4]">SaaS</span></span>
            </div>
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'DentalSaaS') }}. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-gray-400 hover:text-white transition">Privacy</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Terms</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
