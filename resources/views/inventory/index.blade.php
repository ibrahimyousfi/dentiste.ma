<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
            {{ __('Inventory Management') }}
        </h2>
    </x-slot>

    <x-slot name="header_search">
        <x-ui.search placeholder="Search products..." />
    </x-slot>

    <x-slot name="header_actions">
        <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-inventory-drawer')">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Stock Item
        </x-ui.button>
    </x-slot>

    <div class="animate-fade-in space-y-6 pb-10">
        
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

        <!-- Inventory Grid -->
        @if($items->isEmpty())
            <x-ui.card class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No inventory items</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">Get started by tracking your first product or material.</p>
                <x-ui.button variant="primary" x-data x-on:click="$dispatch('open-drawer', 'create-inventory-drawer')">
                    Add Stock Item
                </x-ui.button>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($items as $item)
                    @php
                        $isLow = $item->current_stock <= $item->minimum_stock;
                        $isOut = $item->current_stock == 0;
                    @endphp
                    <x-ui.card class="group hover:shadow-md transition-all relative h-full flex flex-col p-5 {{ $isOut ? 'border-red-200 shadow-sm shadow-red-100' : ($isLow ? 'border-orange-200 shadow-sm shadow-orange-100' : '') }}">
                        <!-- Dropdown Menu for Actions -->
                        <div class="absolute top-4 right-4 z-10">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none" title="More Actions">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="#" class="text-[#39D3C4] font-medium">Receive Stock (+)</x-dropdown-link>
                                    <x-dropdown-link href="#" class="text-orange-600 font-medium">Use Stock (-)</x-dropdown-link>
                                    <x-dropdown-link href="{{ route('inventory.edit', $item->id) }}">Edit Details</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('inventory.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out" onclick="return confirm('Are you sure you want to delete this item?');">
                                            Delete Item
                                        </button>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Header & Status -->
                        <div class="mb-4 pr-8">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider 
                                    {{ $isOut ? 'bg-red-100 text-red-800' : ($isLow ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $isOut ? 'Out of Stock' : ($isLow ? 'Low Stock' : 'In Stock') }}
                                </span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="h-10 w-10 flex-shrink-0 rounded-lg {{ $isLow ? 'bg-red-100 text-red-600' : 'bg-[#39D3C4]/20 text-[#39D3C4]' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#39D3C4] transition-colors line-clamp-1" title="{{ $item->name }}">
                                        {{ $item->name }}
                                    </h3>
                                    <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $item->category ?? 'General' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Level Details -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100 text-center flex-1">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Current Stock Level</div>
                            <div class="text-3xl font-black {{ $isOut ? 'text-red-600' : ($isLow ? 'text-orange-500' : 'text-gray-900') }}">
                                {{ $item->current_stock }}
                                <span class="text-sm font-bold text-gray-400 ml-1">{{ $item->unit }}</span>
                            </div>
                            <div class="text-xs font-semibold text-gray-500 mt-2">
                                Minimum threshold: <span class="text-gray-900">{{ $item->minimum_stock }}</span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-auto pt-3 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <div class="font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Last Restock</div>
                                    <div class="font-medium text-gray-900">
                                        {{ $item->updated_at ? $item->updated_at->format('M d, Y') : 'Unknown' }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Unit Cost</div>
                                    <div class="font-bold text-gray-900">
                                        ${{ $item->cost_per_unit ?? '0.00' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
            
            @if($items->hasPages())
                <div class="mt-6">
                    {{ $items->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Inventory Drawer -->
    <x-ui.drawer id="create-inventory-drawer" title="Add Stock Item">
        <form id="create-inventory-form" action="{{ route('inventory.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Item Details -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Lidocaine 2% with Epinephrine" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="e.g. Anesthetics, Composites, PPE..." list="category-suggestions" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                        <datalist id="category-suggestions">
                            <option value="Anesthetics">
                            <option value="Composites">
                            <option value="PPE (Gloves, Masks)">
                            <option value="Endodontics">
                            <option value="Implants & Accessories">
                            <option value="Ortho Supplies">
                            <option value="Disposables">
                        </datalist>
                    </div>
                </div>

                <!-- Stock Levels -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="current_stock" class="block text-sm font-medium text-gray-700 mb-1">Current Stock <span class="text-red-500">*</span></label>
                        <input type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', 0) }}" required min="0" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                    
                    <div>
                        <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">Minimum Alert Level <span class="text-red-500">*</span></label>
                        <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 10) }}" required min="0" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>

                <!-- Units & Costs -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Unit of Measure <span class="text-red-500">*</span></label>
                        <select id="unit" name="unit" required class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                            <option value="Boxes" @selected(old('unit') == 'Boxes')>Boxes</option>
                            <option value="Pieces" @selected(old('unit') == 'Pieces')>Pieces</option>
                            <option value="Packs" @selected(old('unit') == 'Packs')>Packs</option>
                            <option value="Bottles" @selected(old('unit') == 'Bottles')>Bottles</option>
                            <option value="Syringes" @selected(old('unit') == 'Syringes')>Syringes</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="cost_per_unit" class="block text-sm font-medium text-gray-700 mb-1">Cost Per Unit ($)</label>
                        <input type="number" name="cost_per_unit" id="cost_per_unit" value="{{ old('cost_per_unit') }}" step="0.01" min="0" placeholder="0.00" class="block w-full rounded-xl border-gray-200 focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm">
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-ui.button variant="secondary" x-on:click="show = false">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="document.getElementById('create-inventory-form').submit()">Add Item</x-ui.button>
        </x-slot>
    </x-ui.drawer>
</x-app-layout>
