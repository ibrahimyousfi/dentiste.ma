<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Treatment Plans') }}
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
            <input type="text" class="block w-full pl-9 pr-3 py-1.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm transition-all" placeholder="Search treatments...">
        </div>
        
        <a href="{{ route('treatment-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-[#39D3C4] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Propose Plan
        </a>
    </x-slot>

    <div class="animate-fade-in space-y-6">
        
        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Proposed Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Proposed</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $proposedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Awaiting patient approval</span>
                </div>
            </div>

            <!-- Accepted/Active Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-l-blue-500 border-t border-b border-r border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                    <span class="relative flex h-3 w-3 mr-2">
                        @if($acceptedCount > 0)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        @endif
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    Active & Accepted
                </p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-blue-600">{{ $acceptedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">In progress</span>
                </div>
            </div>

            <!-- Completed Plans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Completed</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $completedCount }}</span>
                    <span class="ml-2 text-sm font-medium text-green-500 flex items-center mb-1">
                        Successfully finished
                    </span>
                </div>
            </div>
        </div>

        <!-- Treatment Plans Table -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Patient / Dentist</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Treatment Plan</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $plan->patient->first_name }} {{ $plan->patient->last_name }}</div>
                                    <div class="text-xs text-gray-500">Dr. {{ $plan->dentist->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0 rounded bg-gray-100 flex items-center justify-center text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-gray-900 font-medium">{{ $plan->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $plan->sessions_count }} Sessions Scheduled</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">${{ number_format($plan->total_estimated_cost, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($plan->status == 'proposed')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-800">
                                            Proposed
                                        </span>
                                    @elseif($plan->status == 'accepted')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                            Accepted
                                        </span>
                                    @elseif($plan->status == 'completed')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-[#39D3C4] hover:text-[#2db3a6] hover:underline mr-3">Sessions</button>
                                    <button class="text-gray-500 hover:text-gray-900 hover:underline">View</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No treatment plans found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Click "Propose Plan" to start drafting a treatment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($plans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $plans->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
