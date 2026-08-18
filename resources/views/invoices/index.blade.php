<x-app-layout>
    <x-slot name="header_search">
        <x-ui.search placeholder="Search by Invoice # or Patient Name..." />
    </x-slot>

    <x-slot name="header_actions">
        <select class="block w-full pl-3 pr-10 py-2 border-gray-200 focus:outline-none focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm rounded-lg bg-white shadow-sm font-medium mr-4">
            <option>All Statuses</option>
            <option>Paid</option>
            <option>Partial</option>
            <option>Unpaid</option>
        </select>

        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-invoice-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">

        <!-- Invoices List -->
        <x-ui.row-list>
            
            <!-- Invoice 1 (Paid) -->
            <x-ui.row-card>
                <!-- Left: Patient & Invoice ID -->
                <div class="flex items-center gap-3.5 min-w-[240px]">
                    <div class="h-11 w-11 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm border border-emerald-200/60 shrink-0 shadow-2xs">
                        JD
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-gray-900 truncate">John Doe</h3>
                            <x-ui.status-badge status="paid" size="xs" />
                        </div>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                            <span class="text-[#39D3C4] font-semibold">#INV-2026-0042</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>Aug 08, 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Middle 1: Amount & Balance -->
                <div class="flex items-center gap-6 min-w-[200px]">
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Total</span>
                        <span class="font-black text-gray-900 text-base">$350.00</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Balance Due</span>
                        <span class="font-bold text-emerald-600 text-sm">$0.00</span>
                    </div>
                </div>

                <!-- Middle 2: Payment Status Tag -->
                <div class="hidden sm:flex items-center gap-2 min-w-[140px]">
                    <x-ui.badge variant="green" dot size="sm">Fully Settled</x-ui.badge>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <x-ui.button variant="secondary" class="!py-1.5 !px-3 !text-xs">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print
                    </x-ui.button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('dashboard') }}">View Details</x-dropdown-link>
                            <x-dropdown-link href="#">Download PDF</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </x-ui.row-card>

            <!-- Invoice 2 (Partial) -->
            <x-ui.row-card variant="warning">
                <!-- Left: Patient & Invoice ID -->
                <div class="flex items-center gap-3.5 min-w-[240px]">
                    <div class="h-11 w-11 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-sm border border-amber-200/60 shrink-0 shadow-2xs">
                        SA
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-gray-900 truncate">Sarah Adams</h3>
                            <x-ui.status-badge status="partial" size="xs" />
                        </div>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                            <span class="text-[#39D3C4] font-semibold">#INV-2026-0043</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>Aug 07, 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Middle 1: Amount & Balance -->
                <div class="flex items-center gap-6 min-w-[200px]">
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Total</span>
                        <span class="font-black text-gray-900 text-base">$1,200.00</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Balance Due</span>
                        <span class="font-bold text-amber-600 text-sm">$600.00</span>
                    </div>
                </div>

                <!-- Middle 2: Tag -->
                <div class="hidden sm:flex items-center gap-2 min-w-[140px]">
                    <x-ui.badge variant="amber" dot size="sm">50% Paid</x-ui.badge>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <x-ui.button variant="primary" class="!py-1.5 !px-3 !text-xs">
                        Record Payment
                    </x-ui.button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#">View Details</x-dropdown-link>
                            <x-dropdown-link href="#">Send Reminder</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </x-ui.row-card>

            <!-- Invoice 3 (Unpaid) -->
            <x-ui.row-card variant="danger">
                <!-- Left: Patient & Invoice ID -->
                <div class="flex items-center gap-3.5 min-w-[240px]">
                    <div class="h-11 w-11 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold text-sm border border-rose-200/60 shrink-0 shadow-2xs">
                        MR
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-gray-900 truncate">Mike Ross</h3>
                            <x-ui.status-badge status="unpaid" size="xs" />
                            <x-ui.badge variant="red" size="xs">Overdue 2d</x-ui.badge>
                        </div>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                            <span class="text-[#39D3C4] font-semibold">#INV-2026-0044</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>Aug 05, 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Middle 1: Amount & Balance -->
                <div class="flex items-center gap-6 min-w-[200px]">
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Total</span>
                        <span class="font-black text-gray-900 text-base">$450.00</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-[10px] uppercase font-semibold">Balance Due</span>
                        <span class="font-bold text-rose-600 text-sm">$450.00</span>
                    </div>
                </div>

                <!-- Middle 2: Tag -->
                <div class="hidden sm:flex items-center gap-2 min-w-[140px]">
                    <x-ui.badge variant="red" dot size="sm">Action Needed</x-ui.badge>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <x-ui.button variant="primary" class="!py-1.5 !px-3 !text-xs">
                        Record Payment
                    </x-ui.button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#" class="text-rose-600">Send Urgent Reminder</x-dropdown-link>
                            <x-dropdown-link href="#">View Details</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </x-ui.row-card>
        </x-ui.row-list>
    </div>

    <!-- Create Invoice Drawer -->
    <x-ui.drawer id="create-invoice-drawer" title="Create New Invoice">
        <form id="create-invoice-form" action="#" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Patient & Date -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient <span class="text-red-500">*</span></label>
                        <select id="patient_id" name="patient_id" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-1">Invoice Date <span class="text-red-500">*</span></label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ date('Y-m-d') }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Total Amount ($) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="amount" id="amount" required placeholder="0.00" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description / Notes</label>
                        <textarea id="description" name="description" rows="3" placeholder="e.g. Dental consultation and cleaning..." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="alert('This feature will be connected to the backend soon!'); show = false;">Create Invoice</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
