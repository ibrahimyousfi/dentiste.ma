@props([
    'spacing' => 'space-y-3',
])

<div {{ $attributes->merge(['class' => "w-full $spacing"]) }}>
    {{ $slot }}
</div>
