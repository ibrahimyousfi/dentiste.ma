<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Inventory Management') }}
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
            <input type="text" class="block w-full pl-9 pr-3 py-1.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm transition-all" placeholder="Search products...">
        </div>
        
        <a href="{{ route('inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-[#39D3C4] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Stock Item
        </a>
    </x-slot>

    <div class="animate-fade-in space-y-6">
        
        <!-- Alerts & Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Items -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Tracked Items</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">{{ $items->total() }}</span>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-l-red-500 border-t border-b border-r border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                    <span class="relative flex h-3 w-3 mr-2">
                        @if($lowStockCount > 0)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        @endif
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    Low Stock Alerts
                </p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-red-600">{{ $lowStockCount }}</span>
                    <span class="ml-2 text-sm font-medium text-gray-500 mb-1">Items below minimum</span>
                </div>
            </div>

            <!-- Inventory Value (Mock) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Est. Inventory Value</p>
                <div class="flex items-end">
                    <span class="text-3xl font-bold text-gray-900">$12,450</span>
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Product Name</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stock Level</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($items as $item)
                            @php
                                $isLow = $item->current_stock <= $item->minimum_stock;
                                $isOut = $item->current_stock == 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $isOut ? 'bg-red-50/30' : ($isLow ? 'bg-orange-50/30' : '') }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-lg {{ $isLow ? 'bg-red-100 text-red-600' : 'bg-[#39D3C4]/20 text-[#39D3C4]' }} flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->unit }} &bull; ${{ $item->cost_per_unit ?? '0.00' }}/unit</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600 font-medium">{{ $item->category ?? 'General' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-lg font-bold {{ $isOut ? 'text-red-600' : ($isLow ? 'text-orange-500' : 'text-gray-900') }}">
                                        {{ $item->current_stock }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Min: {{ $item->minimum_stock }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($isOut)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                            Out of Stock
                                        </span>
                                    @elseif($isLow)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-orange-100 text-orange-800">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-[#39D3C4] hover:text-[#2db3a6] hover:underline mr-3">Restock</button>
                                    <button class="text-gray-500 hover:text-gray-900 hover:underline">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No inventory items</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by tracking your first product or material.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($items->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
