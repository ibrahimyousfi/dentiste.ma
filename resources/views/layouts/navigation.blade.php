<!-- Sidebar Navigation -->
<aside 
    class="bg-white border-r border-gray-200 text-gray-700 flex flex-col transition-all duration-300 ease-in-out z-40 relative shadow-sm"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
>
    <!-- Logo Area -->
    <div class="h-16 flex items-center justify-center border-b border-black/5 shrink-0">
        @php
            $hasLogo = auth()->check() && auth()->user()->organization && auth()->user()->organization->logo;
            $logoUrl = $hasLogo ? Storage::url(auth()->user()->organization->logo) : null;
            $clinicName = auth()->check() && auth()->user()->organization ? auth()->user()->organization->name : 'Simple Dental';
        @endphp

        <!-- Expanded Logo -->
        <div x-show="sidebarOpen" class="flex items-center justify-center w-full px-4 h-full py-2">
            @if($hasLogo)
                <img src="{{ $logoUrl }}" alt="{{ $clinicName }}" class="h-full w-full object-contain">
            @else
                <div class="w-12 h-12 rounded-lg bg-[#39D3C4] flex items-center justify-center text-white font-bold text-2xl">
                    {{ substr($clinicName, 0, 1) }}
                </div>
            @endif
        </div>
        
        <!-- Collapsed Logo -->
        <div x-show="!sidebarOpen" class="flex items-center justify-center w-full h-full py-2">
            @if($hasLogo)
                <img src="{{ $logoUrl }}" alt="Logo" class="h-full w-full object-contain">
            @else
                <div class="w-10 h-10 rounded-lg bg-[#39D3C4] flex items-center justify-center text-white font-bold text-xl">
                    {{ substr($clinicName, 0, 1) }}
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 overflow-x-hidden">
        <nav class="space-y-1 px-2">
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('clinic.dashboard') || request()->routeIs('secretary.dashboard') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
               title="Dashboard">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Dashboard</span>
            </a>

            @if(auth()->user()->hasRole('Super Admin'))
                <!-- Super Admin Links -->
                <div x-show="sidebarOpen" class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">System</div>
                <a href="{{ route('admin.organizations.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.organizations.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Clinics">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Clinics</span>
                </a>
            @else
            
                <div x-show="sidebarOpen" class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Clinical</div>

            <!-- Patients -->
            <a href="{{ route('patients.index') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('patients.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
               title="Patients Database">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Patients</span>
            </a>

            @hasrole('Clinic Owner')
                <!-- Treatments & Plans -->
                <a href="{{ route('treatment-plans.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('treatment-plans.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Treatments & Plans">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Treatments & Plans</span>
                </a>

                <!-- Prescriptions -->
                <a href="{{ route('prescriptions.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('prescriptions.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Prescriptions">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.5 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14z"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Prescriptions</span>
                </a>
                
                <div x-show="sidebarOpen" class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Administration</div>

                <!-- Staff Management -->
                <a href="{{ route('staff.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('staff.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Clinic Staff">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Staff Management</span>
                </a>
            @endhasrole

            <div x-show="sidebarOpen" class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Operations</div>

            <!-- Appointments -->
            <a href="{{ route('appointments.index') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('appointments.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
               title="Appointments Calendar">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Appointments</span>
            </a>

            @hasrole('Clinic Owner')
                <!-- Laboratory -->
                <a href="{{ route('lab-cases.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('lab-cases.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Laboratory Orders">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Laboratory</span>
                </a>

                <!-- Inventory -->
                <a href="{{ route('inventory.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('inventory.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
                   title="Inventory & Stock">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Inventory</span>
                </a>
            @endhasrole
            
            <div x-show="sidebarOpen" class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Finance</div>

            <!-- Invoices & Billing -->
            <a href="{{ route('invoices.index') }}" 
               class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('invoices.*') ? 'bg-[#39D3C4]/10 text-[#39D3C4]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#39D3C4]' }}"
               title="Invoices & Billing">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Invoices</span>
            </a>

            @endif
        </nav>
    </div>

    <!-- Bottom Profile Dropdown -->
    <div class="p-4 border-t border-gray-200 bg-gray-50 shrink-0 relative" x-data="{ profileMenuOpen: false }" @click.away="profileMenuOpen = false">
        
        <!-- Dropdown Menu (Appears above the profile button) -->
        <div x-show="profileMenuOpen" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
             class="absolute bottom-full left-0 w-full mb-2 px-2 z-50"
             style="display: none;">
             
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 py-2 w-full overflow-hidden">
                <!-- User Info Header in Dropdown -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] transition-colors">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile & Settings
                </a>

                @hasrole('Clinic Owner')
                <a href="{{ route('clinic.subscription') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] transition-colors">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Subscription & Billing
                </a>
                @endhasrole
                
                <div class="border-t border-gray-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                        <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Trigger Button -->
        <button @click="profileMenuOpen = !profileMenuOpen" class="w-full flex items-center justify-between hover:bg-gray-100 p-2 rounded-xl transition-colors text-left" :class="!sidebarOpen ? 'justify-center' : ''">
            <div class="flex items-center space-x-3 w-full" :class="!sidebarOpen ? 'justify-center' : ''">
                <div class="h-10 w-10 rounded-full bg-[#39D3C4]/20 text-[#39D3C4] flex items-center justify-center font-bold text-lg shrink-0" title="{{ Auth::user()->name }}">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div x-show="sidebarOpen" class="flex-1 min-w-0 overflow-hidden">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}</p>
                </div>
            </div>
            
            <svg x-show="sidebarOpen" class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{ 'transform rotate-180': profileMenuOpen }">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </div>
</aside>
