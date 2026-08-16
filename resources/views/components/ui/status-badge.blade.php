@props(['status', 'type' => 'neutral'])

@php
    $statusTypes = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'danger' => 'bg-rose-100 text-rose-800 border-rose-200',
        'info' => 'bg-blue-100 text-blue-800 border-blue-200',
        'neutral' => 'bg-gray-100 text-gray-800 border-gray-200',
    ];
    
    // Auto-detect type based on common status strings if type is neutral
    if ($type === 'neutral') {
        $normalizedStatus = strtolower($status);
        if (in_array($normalizedStatus, ['active', 'completed', 'paid', 'success', 'done'])) {
            $type = 'success';
        } elseif (in_array($normalizedStatus, ['pending', 'in_treatment', 'in treatment', 'waiting'])) {
            $type = 'warning';
        } elseif (in_array($normalizedStatus, ['cancelled', 'no_show', 'no show', 'unpaid', 'failed', 'error'])) {
            $type = 'danger';
        } elseif (in_array($normalizedStatus, ['archived', 'draft', 'scheduled'])) {
            $type = 'info';
        }
    }

    $classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border ' . ($statusTypes[$type] ?? $statusTypes['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot->isEmpty() ? ucfirst(str_replace('_', ' ', $status)) : $slot }}
</span>
