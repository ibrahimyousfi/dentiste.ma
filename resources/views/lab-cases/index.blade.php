<x-app-layout>
    <x-slot name="header_search">
        <x-ui.search placeholder="Search lab cases..." />
    </x-slot>
    
    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-labcase-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">

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
            <x-ui.row-list>
                @foreach($cases as $case)
                    @php
                        $isDelayed = $case->status == 'delayed';
                        $isReceived = $case->status == 'received';
                        $variant = $isDelayed ? 'danger' : ($isReceived ? 'success' : 'default');
                    @endphp
                    <x-ui.row-card :variant="$variant">
                        <!-- Left: Patient & Doctor -->
                        <div class="flex items-center gap-3.5 min-w-[220px]">
                            <div class="h-11 w-11 rounded-2xl {{ $isDelayed ? 'bg-rose-50 text-rose-600 border-rose-200/60' : ($isReceived ? 'bg-emerald-50 text-emerald-600 border-emerald-200/60' : 'bg-indigo-50 text-indigo-600 border-indigo-200/60') }} flex items-center justify-center font-bold text-sm border shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">
                                        {{ $case->patient->first_name }} {{ $case->patient->last_name }}
                                    </h3>
                                    <x-ui.badge :variant="$isDelayed ? 'red' : ($isReceived ? 'green' : 'yellow')" dot size="xs">
                                        {{ $isDelayed ? 'Delayed' : ($isReceived ? 'Received' : 'Pending') }}
                                    </x-ui.badge>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                    <span>Dr. {{ $case->dentist->name }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>Sent: {{ \Carbon\Carbon::parse($case->sent_date)->format('M d') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle 1: Lab Partner & Work Type -->
                        <div class="flex items-center gap-2.5 min-w-[200px]">
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-800">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="truncate">{{ $case->labPartner->name }}</span>
                                </div>
                                <div class="mt-0.5">
                                    <x-ui.badge variant="gray" size="xs">{{ $case->type_of_work ?? 'General Work' }}</x-ui.badge>
                                </div>
                            </div>
                        </div>

                        <!-- Middle 2: Due Date -->
                        <div class="flex items-center gap-2 min-w-[140px] text-xs">
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Due Date</span>
                                <span class="font-bold {{ $isDelayed ? 'text-rose-600' : 'text-gray-800' }}">
                                    {{ $case->due_date ? \Carbon\Carbon::parse($case->due_date)->format('M d, Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('lab-cases.show', $case->id) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-colors" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>

                            <a href="{{ route('lab-cases.edit', $case->id) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-sky-600 hover:bg-sky-50 transition-colors" title="Edit Case">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    @if($case->status != 'received')
                                        <x-dropdown-link href="#" class="text-[#39D3C4] font-medium">Mark as Received</x-dropdown-link>
                                    @endif
                                    <x-dropdown-link href="#">Contact Lab</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('lab-cases.destroy', $case->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-rose-600 hover:bg-rose-50 focus:outline-none transition duration-150 ease-in-out" onclick="return confirm('Are you sure you want to delete this case?');">
                                            Delete Case
                                        </button>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </x-ui.row-card>
                @endforeach
            </x-ui.row-list>
            
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
