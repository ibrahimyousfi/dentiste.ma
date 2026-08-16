<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Appointments Calendar') }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" type="button" @click="$dispatch('open-appointment-modal')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Appointment
        </x-ui.button>
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Calendar Container -->
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
    </div>

    <!-- Appointment Modal (Alpine.js) -->
    <div 
        x-data="appointmentModal()"
        @open-appointment-modal.window="openModal($event.detail)"
        x-show="isOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div 
                x-show="isOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity" 
                @click="closeModal()"
            >
                <div class="absolute inset-0 bg-gray-900 opacity-50 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal Panel -->
            <div 
                x-show="isOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100"
            >
                <form @submit.prevent="saveAppointment()">
                    
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-900" x-text="isEditing ? 'Edit Appointment' : 'New Appointment'"></h3>
                        <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-600 bg-white rounded-full p-2 hover:bg-gray-200 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="bg-white px-6 py-6 space-y-5">
                        
                        <!-- Patient Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Patient <span class="text-red-500">*</span></label>
                            <select x-model="form.patient_id" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700" required>
                                <option value="">Select a patient...</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->phone }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dentist Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Doctor / Dentist <span class="text-red-500">*</span></label>
                            <select x-model="form.dentist_id" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700" required>
                                <option value="">Select doctor...</option>
                                @foreach($dentists as $dentist)
                                    <option value="{{ $dentist->id }}">Dr. {{ $dentist->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Date -->
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                                <input type="date" x-model="form.appointment_date" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700" required>
                            </div>
                            <!-- Status -->
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                                <select x-model="form.status" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="waiting">Waiting in Clinic</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="no_show">No Show</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start Time -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Start Time <span class="text-red-500">*</span></label>
                                <input type="time" x-model="form.start_time" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700" required>
                            </div>
                            <!-- End Time -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">End Time <span class="text-red-500">*</span></label>
                                <input type="time" x-model="form.end_time" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700" required>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Internal Notes</label>
                            <textarea x-model="form.notes" rows="2" class="w-full rounded-xl border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] shadow-sm font-medium text-gray-700 placeholder-gray-400" placeholder="E.g. Patient requested a cleaning..."></textarea>
                        </div>
                        
                        <!-- Error Message -->
                        <div x-show="errorMessage" class="bg-red-50 text-red-600 p-3 rounded-lg text-sm font-medium flex items-start" style="display:none;">
                            <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span x-text="errorMessage"></span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-100 rounded-b-3xl">
                        <div>
                            <button x-show="isEditing" type="button" @click="deleteAppointment()" class="text-red-500 font-bold text-sm hover:text-red-700 px-3 py-2 rounded-lg hover:bg-red-50 transition">
                                Delete
                            </button>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" @click="closeModal()" class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 shadow-sm transition">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-[#39D3C4] border border-transparent rounded-xl text-sm font-bold text-white hover:bg-[#2db3a6] focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 shadow-lg hover:-translate-y-0.5 transition transform disabled:opacity-50" :disabled="isSaving">
                                <svg x-show="isSaving" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isEditing ? 'Update Appointment' : 'Save Appointment'"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        // Alpine Component for Modal
        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentModal', () => ({
                isOpen: false,
                isEditing: false,
                isSaving: false,
                errorMessage: '',
                form: {
                    id: null,
                    patient_id: '',
                    dentist_id: '',
                    appointment_date: '',
                    start_time: '',
                    end_time: '',
                    status: 'scheduled',
                    notes: ''
                },
                
                openModal(data = null) {
                    this.errorMessage = '';
                    if (data && data.id) {
                        this.isEditing = true;
                        this.form = { ...data };
                    } else if (data) {
                        this.isEditing = false;
                        this.resetForm();
                        this.form.appointment_date = data.appointment_date;
                        this.form.start_time = data.start_time;
                        this.form.end_time = data.end_time;
                    } else {
                        this.isEditing = false;
                        this.resetForm();
                    }
                    this.isOpen = true;
                },
                
                closeModal() {
                    this.isOpen = false;
                },
                
                resetForm() {
                    this.form = {
                        id: null,
                        patient_id: '',
                        dentist_id: '',
                        appointment_date: new Date().toISOString().slice(0, 10),
                        start_time: '09:00',
                        end_time: '09:30',
                        status: 'scheduled',
                        notes: ''
                    };
                },
                
                saveAppointment() {
                    this.isSaving = true;
                    this.errorMessage = '';
                    
                    let url = this.isEditing ? `/appointments/${this.form.id}` : '/appointments';
                    let method = this.isEditing ? 'PUT' : 'POST';
                    
                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isSaving = false;
                        if(data.errors) {
                            this.errorMessage = Object.values(data.errors).map(v => v.join(', ')).join(' | ');
                        } else if(data.message && !data.success) {
                            // SMART SCHEDULING ALERT
                            if (data.suggest_next) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Day Unavailable',
                                        text: data.message + ' The next available slot is ' + data.next_available_formatted + '. Would you like to schedule it then?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, move to ' + data.next_available_formatted,
                                        cancelButtonText: 'No, cancel',
                                        confirmButtonColor: '#39D3C4'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            this.form.appointment_date = data.next_available_date;
                                            this.saveAppointment();
                                        } else {
                                            this.errorMessage = data.message;
                                        }
                                    });
                                } else {
                                    if (confirm(data.message + '\n\nThe next available slot is ' + data.next_available_formatted + '. Would you like to schedule it then?')) {
                                        this.form.appointment_date = data.next_available_date;
                                        this.saveAppointment();
                                    } else {
                                        this.errorMessage = data.message;
                                    }
                                }
                            } else {
                                this.errorMessage = data.message;
                            }
                        } else {
                            // Success!
                            this.closeModal();
                            window.calendar.refetchEvents();
                            
                            // Smart Cancellation Alert
                            if (data.waitlist_matches) {
                                // SweetAlert or standard alert
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Waitlist Match!',
                                        text: data.message,
                                        icon: 'info',
                                        showCancelButton: true,
                                        confirmButtonText: 'View Waitlist',
                                        cancelButtonText: 'Dismiss',
                                        confirmButtonColor: '#39D3C4'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '/dashboard'; // Go to secretary dashboard waitlist
                                        }
                                    });
                                } else {
                                    alert(data.message);
                                }
                            }
                        }
                    })
                    .catch(err => {
                        this.isSaving = false;
                        this.errorMessage = 'A network error occurred. Please try again.';
                        console.error(err);
                    });
                },
                
                deleteAppointment() {
                    if(!confirm("Are you sure you want to delete this appointment?")) return;
                    
                    this.isSaving = true;
                    fetch(`/appointments/${this.form.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isSaving = false;
                        if(data.success) {
                            this.closeModal();
                            window.calendar.refetchEvents();
                        } else {
                            this.errorMessage = 'Failed to delete appointment.';
                        }
                    })
                    .catch(err => {
                        this.isSaving = false;
                        this.errorMessage = 'Network error during deletion.';
                    });
                }
            }));
        });
    </script>
</x-app-layout>
