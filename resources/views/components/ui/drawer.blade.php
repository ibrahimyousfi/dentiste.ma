@props(['id', 'title' => null, 'maxWidth' => 'md'])

@php
$id = $id ?? md5($attributes->wire('model'));
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div x-data="{ show: false }"
     x-on:open-drawer.window="if ($event.detail === '{{ $id }}') { show = true }"
     x-on:close-drawer.window="if ($event.detail === '{{ $id }}') { show = false }"
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     class="fixed inset-0 overflow-hidden z-50"
     style="display: none;">
     
    <div class="absolute inset-0 overflow-hidden">
        <!-- Backdrop -->
        <div x-show="show" 
             class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
             x-on:click="show = false" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <!-- Drawer Content -->
            <div x-show="show"
                 class="w-screen {{ $maxWidth }} bg-white shadow-2xl flex flex-col"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                 
                @if($title)
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white shadow-sm z-10">
                    <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
                    <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#39D3C4] rounded-lg p-2 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @endif

                <div class="p-6 flex-1 overflow-y-auto">
                    {{ $slot }}
                </div>
                
                @isset($footer)
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 z-10">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
