<div class="overflow-x-auto">
    @if($appointments->count() > 0)
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">Time</th>
                <th scope="col" class="px-6 py-4 font-black">Patient</th>
                <th scope="col" class="px-6 py-4 font-black">Doctor</th>
                <th scope="col" class="px-6 py-4 font-black">Status</th>
                <th scope="col" class="px-6 py-4 font-black text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appt)
            <tr class="bg-white border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appt->end_time)->format('h:i A') }}
                    @if(\Carbon\Carbon::parse($appt->appointment_date)->isToday())
                        <!-- Only show date if it's not today in upcoming -->
                    @else
                        <span class="block text-xs text-gray-500 font-medium mt-0.5">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900">{{ $appt->patient->first_name }} {{ $appt->patient->last_name }}</div>
                    <div class="text-xs text-gray-500">{{ $appt->patient->phone }}</div>
                </td>
                <td class="px-6 py-4 font-medium text-gray-700">
                    Dr. {{ $appt->dentist->name }}
                </td>
                <td class="px-6 py-4">
                    @php
                        $colors = [
                            'scheduled' => 'bg-[#39D3C4]/10 text-[#39D3C4]',
                            'confirmed' => 'bg-green-100 text-green-700',
                            'waiting' => 'bg-yellow-100 text-yellow-700',
                            'in_progress' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-gray-100 text-gray-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            'no_show' => 'bg-purple-100 text-purple-700',
                        ];
                        $colorClass = $colors[$appt->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClass }} capitalize">
                        {{ str_replace('_', ' ', $appt->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right flex justify-end items-center gap-2" x-data="{
                    updating: false,
                    updateStatus(newStatus) {
                        if(newStatus === 'cancelled' || newStatus === 'no_show') {
                            if(!confirm('Are you sure you want to mark this appointment as ' + (newStatus === 'no_show' ? 'No Show' : 'Cancelled') + '?')) return;
                        }
                        this.updating = true;
                        fetch('{{ url('/appointments') }}/' + {{ $appt->id }} + '/status', {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                window.location.reload();
                            } else {
                                alert(data.message || 'Error updating status');
                                this.updating = false;
                            }
                        })
                        .catch(err => {
                            alert('Network error');
                            this.updating = false;
                        });
                    }
                }">
                    <a href="tel:{{ $appt->patient->phone }}" title="Call Patient" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-700 bg-blue-100 hover:bg-blue-200 p-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </a>
                    
                    @if(!in_array($appt->status, ['completed', 'cancelled', 'no_show']))
                        <button @click="updateStatus('completed')" :disabled="updating" title="Mark as Completed" class="inline-flex items-center text-sm font-bold text-green-500 hover:text-green-700 bg-green-100 hover:bg-green-200 p-2 rounded-lg transition-colors disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button @click="updateStatus('no_show')" :disabled="updating" title="Patient No Show" class="inline-flex items-center text-sm font-bold text-red-500 hover:text-red-700 bg-red-100 hover:bg-red-200 p-2 rounded-lg transition-colors disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    @endif

                    <a href="{{ route('patients.show', $appt->patient_id) }}" class="inline-flex items-center text-sm font-bold text-[#39D3C4] hover:text-[#2db3a6] bg-[#39D3C4]/10 hover:bg-[#39D3C4]/20 px-3 py-1.5 rounded-lg transition-colors ml-2">
                        View File
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-100">
        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <h3 class="text-sm font-bold text-gray-900">{{ $emptyMessage }}</h3>
        <p class="mt-1 text-sm text-gray-500">You can use the calendar to schedule a new appointment.</p>
        <div class="mt-4">
            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                Go to Calendar
            </a>
        </div>
    </div>
    @endif
</div>
