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
                            if (window.calendar) {
                                window.calendar.refetchEvents();
                            } else {
                                window.location.reload();
                            }
                            
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
                            if (window.calendar) {
                                window.calendar.refetchEvents();
                            } else {
                                window.location.reload();
                            }
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
