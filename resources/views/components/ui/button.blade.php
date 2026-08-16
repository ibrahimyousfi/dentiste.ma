@props(['variant' => 'primary', 'type' => 'button', 'href' => null, 'size' => 'md', 'icon' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'icon' => 'p-2',
    ];
    
    $variantClasses = [
        'primary' => 'bg-[#39D3C4] hover:bg-[#2db3a6] text-white shadow-sm focus:ring-[#39D3C4]',
        'secondary' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 shadow-sm focus:ring-[#39D3C4]',
        'danger' => 'bg-rose-500 hover:bg-rose-600 text-white shadow-sm focus:ring-rose-500',
        'ghost' => 'hover:bg-gray-100 text-gray-600 focus:ring-gray-500',
        'success' => 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm focus:ring-emerald-500',
    ];

    $classes = $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="mr-2 -ml-1">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="mr-2 -ml-1">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </button>
@endif
