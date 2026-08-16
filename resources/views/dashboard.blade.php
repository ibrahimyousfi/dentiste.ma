<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Clinic Command Center') }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <div class="text-sm font-semibold text-[#39D3C4] bg-[#39D3C4]/10 px-4 py-2 rounded-lg border border-[#39D3C4]/20 shadow-sm mr-4">
            {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
        </div>
    </x-slot>

    <div class="animate-fade-in space-y-8">
        
        <!-- Top Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Patients -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-[#39D3C4]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Patients</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">1,248</span>
                    <span class="ml-2 text-sm font-medium text-[#39D3C4] flex items-center mb-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        +12 this week
                    </span>
                </div>
            </div>

            <!-- Appointments -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Today's Appointments</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">24</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Across 3 doctors</span>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Monthly Revenue</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">$42,500</span>
                    <span class="ml-2 text-sm font-medium text-green-500 flex items-center mb-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        8.4%
                    </span>
                </div>
            </div>

            <!-- Lab Orders -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group border-l-4 border-l-orange-500">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Pending Lab Orders</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-orange-600">7</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Require action</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Chart Area (2/3 width) -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Revenue & Cash Flow</h3>
                    <select class="text-sm border-gray-300 rounded-lg">
                        <option>This Year</option>
                        <option>Last 6 Months</option>
                    </select>
                </div>
                
                <!-- Chart Placeholder -->
                <div class="h-72 w-full flex items-center justify-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <div class="text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <p class="text-sm font-medium">Chart.js Implementation Pending Backend Data</p>
                    </div>
                </div>
            </div>

            <!-- Low Stock & Alerts (1/3 width) -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <span class="bg-red-100 text-red-600 p-1.5 rounded-lg mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </span>
                    Inventory Alerts
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Composite Resin (A2)</p>
                            <p class="text-xs text-red-600 font-medium">Only 2 syringes left</p>
                        </div>
                        <button class="text-xs font-bold text-red-700 bg-red-200 px-2 py-1 rounded hover:bg-red-300 transition">Restock</button>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Lidocaine 2%</p>
                            <p class="text-xs text-red-600 font-medium">Out of stock!</p>
                        </div>
                        <button class="text-xs font-bold text-red-700 bg-red-200 px-2 py-1 rounded hover:bg-red-300 transition">Restock</button>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Surgical Masks</p>
                            <p class="text-xs text-yellow-600 font-medium">Running low (1 Box)</p>
                        </div>
                        <button class="text-xs font-bold text-yellow-700 bg-yellow-200 px-2 py-1 rounded hover:bg-yellow-300 transition">Restock</button>
                    </div>
                </div>
                
                <a href="#" class="block text-center mt-6 text-sm font-bold text-[#39D3C4] hover:underline">View Full Inventory</a>
            </div>
        </div>

        <!-- Recent Activity Log -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Clinic Activity Feed</h3>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-gray-100">
                    <li class="p-4 sm:px-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">Payment Received</p>
                                    <p class="text-sm text-gray-500">Receptionist recorded $350.00 for Invoice #INV-2026-0042</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">10 mins ago</div>
                        </div>
                    </li>
                    <li class="p-4 sm:px-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">New Patient Registered</p>
                                    <p class="text-sm text-gray-500">Dr. Smith registered a new patient: Sarah Adams</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">1 hour ago</div>
                        </div>
                    </li>
                    <li class="p-4 sm:px-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">CNSS Claim Generated</p>
                                    <p class="text-sm text-gray-500">Accountant exported reimbursement form for John Doe</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">3 hours ago</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</x-app-layout>
