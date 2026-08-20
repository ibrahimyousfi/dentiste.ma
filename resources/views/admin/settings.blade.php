<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Platform Settings</h1>
                <p class="text-slate-400 mt-1">Configure global SaaS variables, integrations, and security.</p>
            </div>
            <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-lg hover:bg-indigo-500 transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save Changes
            </button>
        </div>
    </x-slot>

    <div class="py-6 flex flex-col lg:flex-row gap-8">
        
        <!-- Settings Sidebar -->
        <div class="w-full lg:w-64 shrink-0">
            <nav class="space-y-1">
                <a href="#" class="bg-indigo-500/10 text-indigo-400 border-l-4 border-indigo-500 flex items-center px-4 py-3 font-medium rounded-r-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    General
                </a>
                <a href="#" class="text-slate-400 hover:bg-[#1e293b] hover:text-white flex items-center px-4 py-3 font-medium rounded-lg transition border-l-4 border-transparent">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Payment Gateways
                </a>
                <a href="#" class="text-slate-400 hover:bg-[#1e293b] hover:text-white flex items-center px-4 py-3 font-medium rounded-lg transition border-l-4 border-transparent">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Email (SMTP)
                </a>
                <a href="#" class="text-slate-400 hover:bg-[#1e293b] hover:text-white flex items-center px-4 py-3 font-medium rounded-lg transition border-l-4 border-transparent">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Security
                </a>
            </nav>
        </div>

        <!-- Settings Form Area -->
        <div class="flex-1 bg-[#1e293b] rounded-2xl border border-[#334155] shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 border-b border-[#334155] flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-white">General Configuration</h2>
                        <p class="text-slate-400 text-sm mt-1">These settings affect the entire SaaS platform.</p>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-lg hover:bg-indigo-500 transition font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Save Changes
                    </button>
                </div>
                
                @if(session('success'))
                    <div class="p-4 bg-emerald-500/10 border-b border-emerald-500/20 text-emerald-400">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="p-6 space-y-8">
                    
                    <!-- Platform Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Platform Name</label>
                        <input type="text" name="platform_name" value="{{ old('platform_name', $platformName ?? 'Dental SaaS') }}" required class="w-full max-w-lg bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                        @error('platform_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Platform Logo -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Platform Logo</label>
                        
                        @if(isset($platformLogo) && $platformLogo)
                            <div class="mb-4">
                                <p class="text-xs text-slate-400 mb-2">Current Logo:</p>
                                <img src="{{ asset('storage/' . $platformLogo) }}" alt="Platform Logo" class="h-16 rounded bg-white p-2">
                            </div>
                        @endif

                        <input type="file" name="platform_logo" accept="image/*" class="w-full max-w-lg bg-[#0f172a] border border-[#334155] rounded-lg px-4 py-2.5 text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 transition">
                        <p class="text-xs text-slate-500 mt-2">Upload a clean logo (PNG/SVG) to be displayed on the homepage, login, and registration pages.</p>
                        @error('platform_logo')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                <!-- Maintenance Mode -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Maintenance Mode</label>
                    <div class="flex items-center gap-3">
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-[#334155] transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-[#0f172a]" role="switch" aria-checked="false">
                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                        <span class="text-sm text-slate-400">Offline platform for all tenants (Admin access only)</span>
                    </div>
                </div>

                <!-- Features Toggle -->
                <div class="border-t border-[#334155] pt-8">
                    <h3 class="text-md font-bold text-white mb-4">Beta Features</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 rounded-xl border border-indigo-500/30 bg-indigo-500/5">
                            <div class="mt-1">
                                <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-indigo-500 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-[#0f172a]" role="switch" aria-checked="true">
                                    <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-white">AI Dental Chart Analysis</h4>
                                <p class="text-xs text-slate-400 mt-1">Enable AI-powered diagnostic suggestions for Pro and Enterprise tenants.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-xl border border-[#334155] bg-[#0f172a]">
                            <div class="mt-1">
                                <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-[#334155] transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-[#0f172a]" role="switch" aria-checked="false">
                                    <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-white">WhatsApp Integration API</h4>
                                <p class="text-xs text-slate-400 mt-1">Allow clinics to send automated appointment reminders via WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
</x-admin-layout>
