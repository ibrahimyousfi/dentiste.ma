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

        <!-- Invoices Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            <!-- Mock Card 1 (Paid) -->
            <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col p-5">
                <!-- Dropdown Menu for Actions -->
                <div class="absolute top-4 right-4 z-10">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('dashboard') }}">View / Print</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Header & Status -->
                <div class="mb-4 pr-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-800">
                            Paid
                        </span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xs">
                            JD
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                John Doe
                            </h3>
                            <p class="text-xs text-[#39D3C4] font-bold mt-0.5">#INV-2026-0042</p>
                        </div>
                    </div>
                </div>

                <!-- Amount Details -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100 text-center flex-1">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Amount</div>
                    <div class="text-3xl font-black text-gray-900">
                        $350.00
                    </div>
                    <div class="text-xs font-semibold text-green-600 mt-2">
                        Balance: $0.00
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-auto pt-3 border-t border-gray-100 text-center">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Invoice Date</div>
                    <div class="text-sm font-medium text-gray-900">Aug 08, 2026</div>
                </div>
            </x-ui.card>

            <!-- Mock Card 2 (Partial) -->
            <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col p-5 border-orange-200 shadow-sm shadow-orange-100">
                <!-- Dropdown Menu for Actions -->
                <div class="absolute top-4 right-4 z-10">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#" class="text-[#39D3C4] font-medium">Record Payment</x-dropdown-link>
                            <x-dropdown-link href="#">View / Print</x-dropdown-link>
                            <x-dropdown-link href="#">Send Reminder</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Header & Status -->
                <div class="mb-4 pr-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-800">
                            Partial
                        </span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 text-purple-700 flex items-center justify-center font-bold text-xs">
                            SA
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                Sarah Adams
                            </h3>
                            <p class="text-xs text-[#39D3C4] font-bold mt-0.5">#INV-2026-0043</p>
                        </div>
                    </div>
                </div>

                <!-- Amount Details -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100 text-center flex-1">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Amount</div>
                    <div class="text-3xl font-black text-gray-900">
                        $1,200.00
                    </div>
                    <div class="text-xs font-semibold text-orange-600 mt-2">
                        Balance Due: $600.00
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-auto pt-3 border-t border-gray-100 text-center">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Invoice Date</div>
                    <div class="text-sm font-medium text-gray-900">Aug 07, 2026</div>
                </div>
            </x-ui.card>

            <!-- Mock Card 3 (Unpaid) -->
            <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col p-5 border-red-200 shadow-sm shadow-red-100">
                <!-- Dropdown Menu for Actions -->
                <div class="absolute top-4 right-4 z-10">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#" class="text-[#39D3C4] font-medium">Record Payment</x-dropdown-link>
                            <x-dropdown-link href="#">View / Print</x-dropdown-link>
                            <x-dropdown-link href="#" class="text-red-600">Send Urgent Reminder</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Header & Status -->
                <div class="mb-4 pr-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-800">
                            Unpaid
                        </span>
                        <span class="text-[10px] font-bold text-red-600">Overdue (2 Days)</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center font-bold text-xs">
                            MR
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                Mike Ross
                            </h3>
                            <p class="text-xs text-[#39D3C4] font-bold mt-0.5">#INV-2026-0044</p>
                        </div>
                    </div>
                </div>

                <!-- Amount Details -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100 text-center flex-1">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Amount</div>
                    <div class="text-3xl font-black text-gray-900">
                        $450.00
                    </div>
                    <div class="text-xs font-black text-red-600 mt-2">
                        Balance Due: $450.00
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-auto pt-3 border-t border-gray-100 text-center">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Invoice Date</div>
                    <div class="text-sm font-medium text-gray-900">Aug 05, 2026</div>
                </div>
            </x-ui.card>
        </div>
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
