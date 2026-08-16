<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reception Dashboard') }} - {{ $organization->name ?? 'Clinic' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Appointments Widget -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border-t-4 border-[#39D3C4] flex items-center justify-between">
                    <div>
                        <h4 class="text-md font-bold text-gray-800">Manage Appointments</h4>
                        <p class="text-sm text-gray-500 mt-1">Book new patients or adjust schedule.</p>
                    </div>
                    <a href="{{ route('appointments.index') }}" class="bg-[#39D3C4] text-white font-bold px-5 py-2.5 rounded-xl shadow-lg hover:-translate-y-0.5 hover:bg-[#2db3a6] transition transform">
                        Calendar
                    </a>
                </div>
                
                <!-- Daily Revenue Widget -->
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 overflow-hidden shadow-sm sm:rounded-2xl p-6 border-t-4 border-yellow-300 flex items-center justify-between text-white relative">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-32 h-32 -mt-4 -mr-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.11-1.36-3.11-2.92v-.46h2.59c.07.65.76 1.15 2.1 1.15 1.55 0 2.11-.47 2.11-1.12 0-.61-.55-.79-2.22-1.16-2.02-.45-3.35-1.1-3.35-2.73 0-1.39 1.14-2.31 2.89-2.71V6h2.67v1.92c1.38.23 2.5 1.01 2.7 2.45h-2.5c-.15-.65-.77-1.17-1.92-1.17-1.32 0-1.89.54-1.89 1.09 0 .61.76.84 2.5 1.25 2.07.49 3.07 1.25 3.07 2.76 0 1.54-1.19 2.52-2.97 2.79z"></path></svg>
                    </div>
                    <div class="z-10">
                        <h4 class="text-sm font-bold text-yellow-100 uppercase tracking-wider">Today's Revenue</h4>
                        <p class="text-4xl font-extrabold mt-1">${{ number_format($todaysRevenue, 2) }}</p>
                        <p class="text-sm text-yellow-100 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $todaysPaymentsCount }} payments collected
                        </p>
                    </div>
                </div>
            </div>

            <!-- Smart Daily Overview Table -->
            <div x-data="{ tab: 'today' }" class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-gray-50/50 gap-4">
                    <h3 class="text-xl font-black text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Schedule Overview
                    </h3>
                    <div class="flex bg-white rounded-xl shadow-sm p-1 border border-gray-100 w-full md:w-auto">
                        <button @click="tab = 'today'" :class="{ 'bg-[#39D3C4] text-white': tab === 'today', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': tab !== 'today' }" class="flex-1 md:flex-none px-4 py-2 rounded-lg text-sm font-bold transition-all">
                            Today <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="tab === 'today' ? 'bg-white/20' : 'bg-gray-100'">{{ $todayAppointments->count() }}</span>
                        </button>
                        <button @click="tab = 'tomorrow'" :class="{ 'bg-[#39D3C4] text-white': tab === 'tomorrow', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': tab !== 'tomorrow' }" class="flex-1 md:flex-none px-4 py-2 rounded-lg text-sm font-bold transition-all">
                            Tomorrow <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="tab === 'tomorrow' ? 'bg-white/20' : 'bg-gray-100'">{{ $tomorrowAppointments->count() }}</span>
                        </button>
                        <button @click="tab = 'upcoming'" :class="{ 'bg-[#39D3C4] text-white': tab === 'upcoming', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': tab !== 'upcoming' }" class="flex-1 md:flex-none px-4 py-2 rounded-lg text-sm font-bold transition-all">
                            Next 3 Days <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="tab === 'upcoming' ? 'bg-white/20' : 'bg-gray-100'">{{ $upcomingAppointments->count() }}</span>
                        </button>
                    </div>
                </div>

                <div class="p-0">
                    <!-- Today Tab -->
                    <div x-show="tab === 'today'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        @include('secretary.partials.appointments-table', ['appointments' => $todayAppointments, 'emptyMessage' => 'No appointments scheduled for today.'])
                    </div>
                    
                    <!-- Tomorrow Tab -->
                    <div x-show="tab === 'tomorrow'" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        @include('secretary.partials.appointments-table', ['appointments' => $tomorrowAppointments, 'emptyMessage' => 'No appointments scheduled for tomorrow.'])
                    </div>

                    <!-- Upcoming Tab -->
                    <div x-show="tab === 'upcoming'" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        @include('secretary.partials.appointments-table', ['appointments' => $upcomingAppointments, 'emptyMessage' => 'No appointments scheduled in the next 3 days.'])
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Waitlist Widget -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                    <div class="px-6 py-4 flex justify-between items-center border-b border-gray-50">
                        <h4 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Waitlist
                        </h4>
                        <span class="bg-[#39D3C4]/10 text-[#39D3C4] text-xs font-bold px-3 py-1 rounded-full">{{ $waitlist->count() }}</span>
                    </div>
                    
                    <div class="p-6">
                        @if($waitlist->count() > 0)
                            <div class="space-y-3">
                                @foreach($waitlist as $item)
                                <div class="bg-gray-50 rounded-xl p-3 flex justify-between items-center border border-gray-100 hover:border-[#39D3C4]/50 transition-colors">
                                    <div>
                                        <p class="font-bold text-sm text-gray-900">{{ $item->patient->first_name }} {{ $item->patient->last_name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $item->patient->phone }} • {{ $item->preferred_days ?? 'Any day' }}</p>
                                    </div>
                                    <button class="text-[#39D3C4] hover:text-[#2db3a6] text-sm font-bold bg-[#39D3C4]/10 hover:bg-[#39D3C4]/20 px-3 py-1.5 rounded-lg transition-colors">Notify</button>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-sm text-gray-500 font-medium">No patients currently on the waitlist.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Recalls Widget -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                    <div class="px-6 py-4 flex justify-between items-center border-b border-gray-50">
                        <h4 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            6-Month Recalls
                        </h4>
                        <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">{{ $recalls->count() }} Due</span>
                    </div>

                    <div class="p-6">
                        @if($recalls->count() > 0)
                            <div class="space-y-3">
                                @foreach($recalls as $patient)
                                <div class="bg-gray-50 rounded-xl p-3 flex justify-between items-center border border-gray-100 hover:border-purple-500/50 transition-colors">
                                    <div>
                                        <p class="font-bold text-sm text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Last visited: {{ $patient->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <button class="text-purple-600 hover:text-purple-800 text-sm font-bold bg-purple-100 hover:bg-purple-200 px-3 py-1.5 rounded-lg transition-colors">Recall</button>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-sm text-gray-500 font-medium">All patients are up to date on checkups!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
