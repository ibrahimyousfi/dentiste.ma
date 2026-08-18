@props([
    'href' => null,
    'variant' => 'default', // default, danger, warning, success
    'active' => false,
])

@php
    $variantClasses = [
        'default' => 'border-gray-100/90 hover:border-gray-300 hover:shadow-[0_4px_20px_rgba(0,0,0,0.03)]',
        'warning' => 'border-amber-200/80 bg-amber-50/20 hover:border-amber-300 hover:shadow-[0_4px_20px_rgba(245,158,11,0.05)]',
        'danger' => 'border-rose-200/80 bg-rose-50/20 hover:border-rose-300 hover:shadow-[0_4px_20px_rgba(244,63,94,0.05)]',
        'success' => 'border-emerald-200/80 bg-emerald-50/20 hover:border-emerald-300 hover:shadow-[0_4px_20px_rgba(16,185,129,0.05)]',
    ];

    $borderHover = $variantClasses[$variant] ?? $variantClasses['default'];
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} 
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge([
        'class' => "group relative bg-white rounded-2xl border p-4 sm:px-5 sm:py-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 transition-all duration-200 $borderHover " . ($href ? 'cursor-pointer hover:-translate-y-0.5' : '')
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
