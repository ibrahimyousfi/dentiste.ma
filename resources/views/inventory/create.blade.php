<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3 cursor-pointer group" onclick="window.location='{{ route('inventory.index') }}'">
            <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                    {{ __('Add New Item') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Register a new product, material, or instrument to the inventory.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg shadow-indigo-100/20 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form action="{{ route('inventory.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </span>
                                Item Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Provide the basic identification for this item.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Item Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Lidocaine 2% with Epinephrine"
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                <select id="category" name="category" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                    <option value="">Select Category</option>
                                    <option value="Consumables" @selected(old('category') == 'Consumables')>Consumables</option>
                                    <option value="Anesthesia" @selected(old('category') == 'Anesthesia')>Anesthesia</option>
                                    <option value="Instruments" @selected(old('category') == 'Instruments')>Instruments</option>
                                    <option value="Composites" @selected(old('category') == 'Composites')>Composites</option>
                                    <option value="Endodontics" @selected(old('category') == 'Endodontics')>Endodontics</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Measurement Unit <span class="text-red-500">*</span></label>
                                <select id="unit" name="unit" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                    <option value="">Select Unit</option>
                                    <option value="boxes" @selected(old('unit') == 'boxes')>Boxes</option>
                                    <option value="pcs" @selected(old('unit') == 'pcs')>Pieces (pcs)</option>
                                    <option value="ml" @selected(old('unit') == 'ml')>Milliliters (ml)</option>
                                    <option value="packs" @selected(old('unit') == 'packs')>Packs</option>
                                </select>
                                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400 p-1.5 rounded-md mr-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </span>
                                Stock Tracking
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Set up thresholds to receive low-stock alerts automatically.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
                            <!-- Current Stock -->
                            <div>
                                <label for="current_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Stock <span class="text-red-500">*</span></label>
                                <input type="number" min="0" name="current_stock" id="current_stock" value="{{ old('current_stock', 0) }}" required
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('current_stock')" class="mt-2" />
                            </div>

                            <!-- Minimum Stock -->
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minimum Alert Level <span class="text-red-500">*</span></label>
                                <input type="number" min="0" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 5) }}" required
                                    class="block w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500 rounded-xl dark:border-orange-800 bg-orange-50 dark:bg-orange-900/20 text-gray-900 dark:text-gray-100 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
                            </div>
                            
                            <!-- Cost -->
                            <div>
                                <label for="cost_per_unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cost Per Unit ($)</label>
                                <input type="number" step="0.01" min="0" name="cost_per_unit" id="cost_per_unit" value="{{ old('cost_per_unit') }}" placeholder="0.00"
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm transition-colors py-2.5">
                                <x-input-error :messages="$errors->get('cost_per_unit')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('inventory.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                                Save Product to Inventory
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
