<x-app-layout>
    <x-slot name="header_actions">
        <form action="{{ route('appointments.index') }}" method="GET" class="flex items-center gap-3">
            <input type="hidden" name="view_mode" value="{{ request('view_mode', 'calendar') }}">
            
            <div class="relative hidden md:block w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search appointments..." class="block w-full pl-9 text-sm rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm py-2">
            </div>

            <x-ui.button variant="primary" type="button" @click="$dispatch('open-appointment-modal')">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New
            </x-ui.button>
        </form>
    </x-slot>

    <!-- FullCalendar CSS -->
    <style>
        /* Custom styling for FullCalendar to match the premium theme */
        .fc-theme-standard td, .fc-theme-standard th, .fc-theme-standard .fc-scrollgrid {
            border-color: #f3f4f6;
        }
        .fc-col-header-cell {
            background-color: #f9fafb;
            padding: 10px 0 !important;
        }
        .fc-col-header-cell-cushion {
            color: #4b5563;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .fc-daygrid-day-number {
            color: #374151;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 8px !important;
        }
        .fc-day-today {
            background-color: #f0fdfa !important;
        }
        .fc-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-weight: 600;
            font-size: 0.75rem;
            border: none !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.15s ease;
        }
        .fc-event:hover {
            transform: scale(1.02);
            cursor: pointer;
        }
        .fc-button-primary {
            background-color: white !important;
            color: #374151 !important;
            border: 1px solid #d1d5db !important;
            font-weight: 600 !important;
            text-transform: capitalize !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            border-radius: 8px !important;
            margin: 0 4px !important;
            transition: all 0.2s !important;
        }
        .fc-button-primary:hover {
            background-color: #f9fafb !important;
            border-color: #9ca3af !important;
        }
        .fc-button-primary:not(:disabled).fc-button-active,
        .fc-button-primary:not(:disabled):active {
            background-color: #39D3C4 !important;
            color: white !important;
            border-color: #39D3C4 !important;
        }
        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #111827 !important;
        }
        .fc-timegrid-slot-label-cushion {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }
        .fc-v-event {
            border-radius: 8px;
            border: none;
            padding: 4px;
        }
    </style>

    <div class="py-8" x-data="{ viewMode: '{{ request('view_mode', 'calendar') }}' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tabs Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex bg-white rounded-xl shadow-sm p-1 border border-gray-100">
                    <button @click="viewMode = 'calendar'" 
                            :class="{'bg-[#39D3C4] text-white shadow-sm': viewMode === 'calendar', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': viewMode !== 'calendar'}"
                            class="px-5 py-2 text-sm font-semibold rounded-lg transition-all flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="{'bg-[#39D3C4] text-white shadow-sm': viewMode === 'list', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': viewMode !== 'list'}"
                            class="px-5 py-2 text-sm font-semibold rounded-lg transition-all flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        List View
                    </button>
                </div>
            </div>

            <!-- Calendar Container -->
            <div x-show="viewMode === 'calendar'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div id="calendar" class="min-h-[700px]"></div>
                </div>

                <!-- Legends -->
                <div class="mt-6 flex flex-wrap gap-4 items-center justify-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-sm font-bold text-gray-700 mr-2">Status Legends:</span>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#39D3C4] mr-2"></span><span class="text-xs font-semibold text-gray-500">Scheduled</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#10B981] mr-2"></span><span class="text-xs font-semibold text-gray-500">Confirmed</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#F59E0B] mr-2"></span><span class="text-xs font-semibold text-gray-500">Waiting</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#3B82F6] mr-2"></span><span class="text-xs font-semibold text-gray-500">In Progress</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#6B7280] mr-2"></span><span class="text-xs font-semibold text-gray-500">Completed</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#EF4444] mr-2"></span><span class="text-xs font-semibold text-gray-500">Cancelled</span></div>
                    <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#8B5CF6] mr-2"></span><span class="text-xs font-semibold text-gray-500">No Show</span></div>
                </div>
            </div>

            <!-- List View Container -->
            <div x-cloak x-show="viewMode === 'list'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                
                <!-- Filters -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
                    <form action="{{ route('appointments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <input type="hidden" name="view_mode" value="list">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
                            <select name="status" class="w-full text-sm rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] py-2">
                                <option value="">All Statuses</option>
                                <option value="scheduled" @selected(request('status') == 'scheduled')>Scheduled</option>
                                <option value="confirmed" @selected(request('status') == 'confirmed')>Confirmed</option>
                                <option value="waiting" @selected(request('status') == 'waiting')>Waiting</option>
                                <option value="in_progress" @selected(request('status') == 'in_progress')>In Progress</option>
                                <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                                <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                                <option value="no_show" @selected(request('status') == 'no_show')>No Show</option>
                            </select>
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Date</label>
                            <select name="date_filter" class="w-full text-sm rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] py-2">
                                <option value="">All Time</option>
                                <option value="today" @selected(request('date_filter') == 'today')>Today</option>
                                <option value="tomorrow" @selected(request('date_filter') == 'tomorrow')>Tomorrow</option>
                                <option value="3days" @selected(request('date_filter') == '3days')>Next 3 Days</option>
                                <option value="1week" @selected(request('date_filter') == '1week')>Next 1 Week</option>
                            </select>
                        </div>

                        <div class="md:col-span-1">
                            <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl py-2 px-4 shadow-sm transition">
                                Filter Results
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dentist</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($appointmentsList as $appt)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#39D3C4]/10 flex items-center justify-center text-[#2db3a6] font-bold">
                                                    {{ substr($appt->patient->first_name, 0, 1) }}{{ substr($appt->patient->last_name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        <a href="{{ route('patients.show', $appt->patient_id) }}" class="hover:text-[#39D3C4] transition">{{ $appt->patient->first_name }} {{ $appt->patient->last_name }}</a>
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $appt->patient->phone }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appt->end_time)->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            Dr. {{ $appt->dentist->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colors = [
                                                    'scheduled' => 'bg-[#39D3C4]/10 text-[#2db3a6]',
                                                    'confirmed' => 'bg-emerald-100 text-emerald-800',
                                                    'waiting' => 'bg-amber-100 text-amber-800',
                                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-gray-100 text-gray-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'no_show' => 'bg-purple-100 text-purple-800',
                                                ];
                                                $colorClass = $colors[$appt->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $appt->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="$dispatch('open-appointment-modal', {
                                                id: {{ $appt->id }},
                                                patient_id: {{ $appt->patient_id }},
                                                dentist_id: {{ $appt->dentist_id }},
                                                appointment_date: '{{ $appt->appointment_date }}',
                                                start_time: '{{ substr($appt->start_time, 0, 5) }}',
                                                end_time: '{{ substr($appt->end_time, 0, 5) }}',
                                                status: '{{ $appt->status }}',
                                                notes: '{{ addslashes($appt->notes) }}'
                                            })" class="text-[#39D3C4] hover:text-[#2db3a6] bg-[#39D3C4]/10 hover:bg-[#39D3C4]/20 p-2 rounded-lg transition">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="text-lg font-semibold">No appointments found.</p>
                                            <p class="text-sm">Try adjusting your filters.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($appointmentsList->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            {{ $appointmentsList->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('appointments.partials.appointment-modal')

    <!-- Scripts -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Generate CSRF token for AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: '08:00:00', // Clinic opens at 8am
                slotMaxTime: '20:00:00', // Clinic closes at 8pm
                allDaySlot: false,
                slotDuration: '00:15:00', // 15 minute slots
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true, // allow "more" link when too many events
                
                // Fetch events via AJAX
                events: '{{ route("appointments.index") }}',
                
                // When user clicks on an empty slot, open modal to create
                select: function(info) {
                    let start = info.start;
                    let end = info.end;
                    
                    // Format time as HH:mm
                    let formatTime = (date) => {
                        return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
                    };
                    
                    let formatDate = (date) => {
                        let tzoffset = (new Date()).getTimezoneOffset() * 60000; // offset in milliseconds
                        let localISOTime = (new Date(date - tzoffset)).toISOString().slice(0, 10);
                        return localISOTime;
                    };

                    window.dispatchEvent(new CustomEvent('open-appointment-modal', {
                        detail: {
                            appointment_date: formatDate(start),
                            start_time: formatTime(start),
                            end_time: formatTime(end)
                        }
                    }));
                },
                
                // When user clicks an existing event, open modal to edit
                eventClick: function(info) {
                    let ev = info.event;
                    
                    let formatTime = (date) => {
                        if(!date) return '';
                        return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
                    };
                    
                    let formatDate = (date) => {
                        if(!date) return '';
                        let tzoffset = (new Date()).getTimezoneOffset() * 60000;
                        let localISOTime = (new Date(date - tzoffset)).toISOString().slice(0, 10);
                        return localISOTime;
                    };

                    window.dispatchEvent(new CustomEvent('open-appointment-modal', {
                        detail: {
                            id: ev.id,
                            patient_id: ev.extendedProps.patient_id,
                            dentist_id: ev.extendedProps.dentist_id,
                            appointment_date: formatDate(ev.start),
                            start_time: formatTime(ev.start),
                            end_time: formatTime(ev.end),
                            status: ev.extendedProps.status,
                            notes: ev.extendedProps.notes
                        }
                    }));
                },
                
                // Handle Drag & Drop to update time/date
                eventDrop: function(info) {
                    updateEventTime(info.event, info.revert);
                },
                
                // Handle Event Resize
                eventResize: function(info) {
                    updateEventTime(info.event, info.revert);
                }
            });
            
            calendar.render();

            function updateEventTime(event, revertFunc) {
                let formatDate = (date) => {
                    let tzoffset = (new Date()).getTimezoneOffset() * 60000;
                    return (new Date(date - tzoffset)).toISOString().slice(0, 10);
                };
                let formatTime = (date) => {
                    return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0') + ':00';
                };

                let data = {
                    drag_update: true,
                    appointment_date: formatDate(event.start),
                    start_time: formatTime(event.start),
                    end_time: formatTime(event.end)
                };

                fetch(`/appointments/${event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if(!res.success) {
                        alert("Error saving appointment.");
                        revertFunc();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Network error while saving appointment.");
                    revertFunc();
                });
            }
        });


    </script>
</x-app-layout>
