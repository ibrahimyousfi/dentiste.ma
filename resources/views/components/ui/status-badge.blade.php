@props(['status', 'type' => 'neutral', 'size' => 'sm'])

@php
    // Normalize status
    $normalizedStatus = strtolower(trim((string)$status));
    
    $statusTypes = [
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200/70',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200/70',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200/70',
        'info' => 'bg-sky-50 text-sky-700 border-sky-200/70',
        'primary' => 'bg-[#39D3C4]/10 text-[#2db3a6] border-[#39D3C4]/20',
        'neutral' => 'bg-gray-50 text-gray-600 border-gray-200/70',
    ];

    $dotTypes = [
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
        'primary' => 'bg-[#39D3C4]',
        'neutral' => 'bg-gray-400',
    ];
    
    // Auto-detect type based on common status strings if type is neutral
    if ($type === 'neutral') {
        if (in_array($normalizedStatus, ['active', 'completed', 'paid', 'success', 'done', 'received', 'accepted', 'in_stock'])) {
            $type = 'success';
        } elseif (in_array($normalizedStatus, ['pending', 'in_treatment', 'in treatment', 'waiting', 'in_progress', 'partial', 'sent', 'low_stock', 'proposed'])) {
            $type = 'warning';
        } elseif (in_array($normalizedStatus, ['cancelled', 'no_show', 'no show', 'unpaid', 'failed', 'error', 'rejected', 'out_of_stock', 'delayed'])) {
            $type = 'danger';
        } elseif (in_array($normalizedStatus, ['archived', 'draft', 'scheduled', 'confirmed'])) {
            $type = 'info';
        }
    }

    $sizes = [
        'xs' => 'text-[10px] px-2 py-0.5 font-semibold',
        'sm' => 'text-[11px] px-2.5 py-0.5 font-medium',
        'md' => 'text-xs px-3 py-1 font-medium',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['sm'];
    $classes = 'inline-flex items-center gap-1.5 rounded-full border shadow-2xs ' . ($statusTypes[$type] ?? $statusTypes['neutral']) . ' ' . $sizeClass;
    $dotClass = $dotTypes[$type] ?? $dotTypes['neutral'];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} shrink-0"></span>
    <span>{{ $slot->isEmpty() ? ucfirst(str_replace(['_', '-'], ' ', $status)) : $slot }}</span>
</span>
