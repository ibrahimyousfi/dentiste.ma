<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Laboratory Orders') }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <!-- Global Search -->
        <div class="relative w-full sm:w-64 md:w-80 mr-4">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="block w-full pl-9 pr-3 py-1.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm transition-all" placeholder="Search lab cases...">
        </div>
        
        <a href="{{ route('lab-cases.create') }}" class="inline-flex items-center px-4 py-2 bg-[#39D3C4] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Send New Case
        </a>
    </x-slot>

    <div class="animate-fade-in space-y-6">
        
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

        <!-- Lab Cases Table -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Patient / Dentist</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lab Partner</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Timeline</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($cases as $case)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $case->patient->first_name }} {{ $case->patient->last_name }}</div>
                                    <div class="text-xs text-gray-500">Dr. {{ $case->dentist->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0 rounded bg-gray-100 flex items-center justify-center text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <span class="ml-3 text-sm text-gray-900 font-medium">{{ $case->labPartner->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500 mb-1">Sent: <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($case->sent_date)->format('M d, Y') }}</span></div>
                                    <div class="text-xs text-gray-500">Due: <span class="font-bold {{ $case->status == 'delayed' ? 'text-red-500' : 'text-gray-900' }}">{{ $case->due_date ? \Carbon\Carbon::parse($case->due_date)->format('M d, Y') : 'N/A' }}</span></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($case->status == 'delayed')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                            Delayed
                                        </span>
                                    @elseif($case->status == 'received')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                            Received
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                            Sent (Pending)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-[#39D3C4] hover:text-[#2db3a6] hover:underline mr-3">Mark Received</button>
                                    <button class="text-gray-500 hover:text-gray-900 hover:underline">View</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No active lab cases</h3>
                                    <p class="mt-1 text-sm text-gray-500">Click "Send New Case" to create your first lab order.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($cases->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $cases->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
