<x-app-layout>
    <x-slot name="header_search">
        <form method="GET" action="{{ route('invoices.index') }}" class="flex">
            <x-ui.search name="search" value="{{ request('search') }}" placeholder="Search by Invoice # or Patient Name..." />
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </x-slot>

    <x-slot name="header_actions">
        <form method="GET" action="{{ route('invoices.index') }}" class="flex items-center">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <select name="status" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-2 border-gray-200 focus:outline-none focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm rounded-lg bg-white shadow-sm font-medium mr-4">
                <option value="All Statuses" {{ request('status') == 'All Statuses' ? 'selected' : '' }}>All Statuses</option>
                <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
            </select>

            <x-ui.button type="button" variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-invoice-drawer')">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New
            </x-ui.button>
        </form>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">

        <!-- Invoices List -->
        <x-ui.row-list>
            @forelse($invoices as $invoice)
                @php
                    $variant = 'default';
                    $badgeVariant = 'green';
                    $badgeText = 'Fully Settled';
                    $initials = substr($invoice->patient->first_name, 0, 1) . substr($invoice->patient->last_name, 0, 1);
                    $iconBg = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                    $balanceDue = $invoice->total_amount - $invoice->paid_amount;
                    $balanceColor = 'text-emerald-600';

                    if ($invoice->status === 'partial') {
                        $variant = 'warning';
                        $badgeVariant = 'amber';
                        $percent = $invoice->total_amount > 0 ? round(($invoice->paid_amount / $invoice->total_amount) * 100) : 0;
                        $badgeText = $percent . '% Paid';
                        $iconBg = 'bg-amber-50 text-amber-700 border-amber-200/60';
                        $balanceColor = 'text-amber-600';
                    } elseif ($invoice->status === 'unpaid') {
                        $variant = 'danger';
                        $badgeVariant = 'red';
                        $badgeText = 'Action Needed';
                        $iconBg = 'bg-rose-50 text-rose-700 border-rose-200/60';
                        $balanceColor = 'text-rose-600';
                    }
                @endphp
                <x-ui.row-card :variant="$variant">
                    <!-- Left: Patient & Invoice ID -->
                    <div class="flex items-center gap-3.5 min-w-[240px]">
                        <div class="h-11 w-11 rounded-2xl {{ $iconBg }} flex items-center justify-center font-bold text-sm border shrink-0 shadow-2xs">
                            {{ strtoupper($initials) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-gray-900 truncate"><a href="{{ route('patients.show', $invoice->patient_id) }}" class="hover:text-[#39D3C4]">{{ $invoice->patient->first_name }} {{ $invoice->patient->last_name }}</a></h3>
                                <x-ui.status-badge :status="$invoice->status" size="xs" />
                                @if($invoice->status !== 'paid' && \Carbon\Carbon::parse($invoice->due_date)->isPast())
                                    <x-ui.badge variant="red" size="xs">Overdue</x-ui.badge>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                <span class="text-[#39D3C4] font-semibold">{{ $invoice->invoice_number }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Middle 1: Amount & Balance -->
                    <div class="flex items-center gap-6 min-w-[200px]">
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase font-semibold">Total</span>
                            <span class="font-black text-gray-900 text-base">${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase font-semibold">Balance Due</span>
                            <span class="font-bold {{ $balanceColor }} text-sm">${{ number_format($balanceDue, 2) }}</span>
                        </div>
                    </div>

                    <!-- Middle 2: Payment Status Tag -->
                    <div class="hidden sm:flex items-center gap-2 min-w-[140px]">
                        <x-ui.badge :variant="$badgeVariant" dot size="sm">{{ $badgeText }}</x-ui.badge>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        @if($invoice->status !== 'paid')
                            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-xl shadow-sm text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                                Record Payment
                            </a>
                        @else
                            <a href="{{ route('invoices.show', $invoice) }}?print=true" target="_blank" class="inline-flex items-center justify-center py-1.5 px-3 text-xs font-bold rounded-xl shadow-sm text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Print
                            </a>
                        @endif

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('invoices.show', $invoice) }}">View Details</x-dropdown-link>
                                <x-dropdown-link href="{{ route('invoices.show', $invoice) }}?print=true" target="_blank">Print Invoice</x-dropdown-link>
                                @if($invoice->status !== 'paid')
                                <form method="POST" action="{{ route('invoices.destroy', $invoice) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-dropdown-link href="#" onclick="event.preventDefault(); if(confirm('Delete this invoice?')) this.closest('form').submit();" class="text-rose-600">Delete Invoice</x-dropdown-link>
                                </form>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                </x-ui.row-card>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-500 font-medium">No invoices found.</p>
                </div>
            @endforelse
        </x-ui.row-list>

        @if($invoices->hasPages())
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

    <x-ui.drawer id="create-invoice-drawer" title="Create New Invoice">
        <form id="create-invoice-form" action="{{ route('invoices.store') }}" method="POST">
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
            <x-ui.button variant="primary" onclick="document.getElementById('create-invoice-form').submit();">Create Invoice</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
