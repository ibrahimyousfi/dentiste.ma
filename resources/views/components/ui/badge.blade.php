@props([
    'variant' => 'gray', // teal, green, blue, yellow, red, purple, gray
    'size' => 'md', // sm, md, lg
    'dot' => false,
])

@php
    $variants = [
        'teal' => 'bg-[#39D3C4]/10 text-[#2db3a6] border-[#39D3C4]/20',
        'primary' => 'bg-[#39D3C4]/10 text-[#2db3a6] border-[#39D3C4]/20',
        'green' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
        'blue' => 'bg-sky-50 text-sky-700 border-sky-200/60',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
        'yellow' => 'bg-amber-50 text-amber-700 border-amber-200/60',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200/60',
        'red' => 'bg-rose-50 text-rose-700 border-rose-200/60',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-200/60',
        'purple' => 'bg-purple-50 text-purple-700 border-purple-200/60',
        'gray' => 'bg-gray-50 text-gray-600 border-gray-200/60',
    ];

    $dotColors = [
        'teal' => 'bg-[#39D3C4]',
        'primary' => 'bg-[#39D3C4]',
        'green' => 'bg-emerald-500',
        'emerald' => 'bg-emerald-500',
        'blue' => 'bg-sky-500',
        'indigo' => 'bg-indigo-500',
        'yellow' => 'bg-amber-500',
        'amber' => 'bg-amber-500',
        'red' => 'bg-rose-500',
        'rose' => 'bg-rose-500',
        'purple' => 'bg-purple-500',
        'gray' => 'bg-gray-400',
    ];

    $sizes = [
        'xs' => 'text-[10px] px-2 py-0.5 font-semibold',
        'sm' => 'text-[11px] px-2.5 py-0.5 font-medium',
        'md' => 'text-xs px-3 py-1 font-medium',
        'lg' => 'text-sm px-3.5 py-1.5 font-medium',
    ];

    $colorClass = $variants[$variant] ?? $variants['gray'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $dotClass = $dotColors[$variant] ?? $dotColors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border shadow-sm $colorClass $sizeClass transition-colors"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} shrink-0"></span>
    @endif
    {{ $slot }}
</span>
