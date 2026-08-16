@props(['id', 'title' => null, 'maxWidth' => '2xl'])

@php
$id = $id ?? md5($attributes->wire('model'));
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
][$maxWidth];
@endphp

<div x-data="{ show: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $id }}') { show = true }"
     x-on:close-modal.window="if ($event.detail === '{{ $id }}') { show = false }"
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex items-center justify-center"
     style="display: none;">
     
    <!-- Backdrop -->
    <div x-show="show" 
         class="fixed inset-0 transform transition-all" 
         x-on:click="show = false" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
    </div>

    <!-- Modal Content -->
    <div x-show="show"
         class="mb-6 bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
         
         @if($title)
         <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
             <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
             <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] rounded-lg p-1 transition-colors">
                 <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
         </div>
         @endif

        <div class="p-6">
            {{ $slot }}
        </div>
        
        @isset($footer)
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
