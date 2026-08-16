<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Laboratory Orders') }}
        </h2>
    </x-slot>

    <x-slot name="header_search">
        <x-ui.search placeholder="Search lab cases..." />
    </x-slot>
    
    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-labcase-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Send New Case
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">
        
        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Active Cases -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Active Cases (Sent)</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $activeCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Awaiting delivery</span>
                </div>
            </div>

            <!-- Delayed Cases -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-l-red-500 border-t border-b border-r border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                    <span class="relative flex h-3 w-3 mr-2">
                        @if($delayedCount > 0)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        @endif
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    Delayed
                </p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-red-600">{{ $delayedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Past due date</span>
                </div>
            </div>

            <!-- Received this Month -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Received This Month</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $receivedMonthCount }}</span>
                    <span class="ml-2 text-sm font-medium text-green-500 flex items-center mb-1">
                        Ready for patients
                    </span>
                </div>
            </div>
        </div>

        <!-- Lab Cases Grid -->
        @if($cases->isEmpty())
            <x-ui.card class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No active lab cases</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">Click "Send New Case" to create your first lab order.</p>
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-labcase-drawer')">
                    Send New Case
                </x-ui.button>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($cases as $case)
                    <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col p-5 {{ $case->status == 'delayed' ? 'border-red-200 shadow-sm shadow-red-100' : '' }}">
                        <!-- Dropdown Menu for Actions -->
                        <div class="absolute top-4 right-4 z-10">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('lab-cases.show', $case->id) }}">View Details</x-dropdown-link>
                                    @if($case->status != 'received')
                                        <x-dropdown-link href="#" class="text-[#39D3C4]">Mark as Received</x-dropdown-link>
                                    @endif
                                    <x-dropdown-link href="{{ route('lab-cases.edit', $case->id) }}">Edit</x-dropdown-link>
                                    <x-dropdown-link href="#">Contact Lab</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('lab-cases.destroy', $case->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out" onclick="return confirm('Are you sure you want to delete this case?');">
                                            Delete
                                        </button>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Header & Status -->
                        <div class="mb-4 pr-8">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider 
                                    {{ $case->status == 'delayed' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $case->status == 'received' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ !in_array($case->status, ['delayed', 'received']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ $case->status == 'delayed' ? 'Delayed' : ($case->status == 'received' ? 'Received' : 'Sent (Pending)') }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1">
                                {{ $case->patient->first_name }} {{ $case->patient->last_name }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Dr. {{ $case->dentist->name }}
                            </div>
                        </div>

                        <!-- Lab & Work Details -->
                        <div class="bg-gray-50 rounded-xl p-3 mb-4 border border-gray-100 space-y-2 text-sm flex-1">
                            <div class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="truncate">{{ $case->labPartner->name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-500 text-xs">
                                <span class="font-semibold px-2 py-0.5 bg-white border border-gray-200 rounded">
                                    {{ $case->type_of_work ?? 'General Work' }}
                                </span>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <div class="font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Sent</div>
                                    <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($case->sent_date)->format('M d, Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Due Date</div>
                                    <div class="font-bold {{ $case->status == 'delayed' ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $case->due_date ? \Carbon\Carbon::parse($case->due_date)->format('M d, Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
            
            @if($cases->hasPages())
                <div class="mt-6">
                    {{ $cases->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Lab Case Drawer -->
    <x-ui.drawer id="create-labcase-drawer" title="Send Lab Case">
        <form id="create-labcase-form" action="{{ route('lab-cases.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div class="mb-2">
                    <p class="text-sm text-gray-500">Create a new work order for an external dental laboratory.</p>
                </div>

                <!-- Patient & Dentist -->
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
                        <label for="dentist_id" class="block text-sm font-medium text-gray-700 mb-1">Dentist <span class="text-red-500">*</span></label>
                        <select id="dentist_id" name="dentist_id" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="">Select Dentist</option>
                            @foreach($dentists as $dentist)
                                <option value="{{ $dentist->id }}" @selected(old('dentist_id', auth()->id()) == $dentist->id)>Dr. {{ $dentist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Lab Partner & Timeline -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="lab_partner_id" class="block text-sm font-medium text-gray-700 mb-1">Laboratory Partner <span class="text-red-500">*</span></label>
                        <select id="lab_partner_id" name="lab_partner_id" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="">Select Lab</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sent_date" class="block text-sm font-medium text-gray-700 mb-1">Sent Date <span class="text-red-500">*</span></label>
                        <input type="date" name="sent_date" id="sent_date" value="{{ old('sent_date', date('Y-m-d')) }}" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Expected Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <!-- Instructions & Cost -->
                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions / Prescription</label>
                    <textarea id="instructions" name="instructions" rows="3" placeholder="e.g. Zirconia crown on tooth 46, shade A2..." class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm"></textarea>
                </div>
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost ($)</label>
                    <input type="number" step="0.01" min="0" name="cost" id="cost" placeholder="0.00" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-labcase-form').submit()">Send Order</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
