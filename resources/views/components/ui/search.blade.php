@props(['placeholder' => 'Search...', 'name' => 'search', 'value' => ''])

<div class="relative w-full max-w-md group">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#39D3C4] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    <input type="text" 
           name="{{ $name }}" 
           value="{{ $value }}"
           placeholder="{{ $placeholder }}" 
           {{ $attributes->merge(['class' => 'block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#39D3C4]/20 focus:border-[#39D3C4] sm:text-sm transition-all']) }}>
</div>
