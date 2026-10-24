@props(['type' => 'info'])

@php
    $classes = [
        'success' => 'bg-emerald-50 border-emerald-400 text-emerald-800',
        'error'   => 'bg-rose-50 border-rose-400 text-rose-800',
        'warning' => 'bg-amber-50 border-amber-400 text-amber-800',
        'info'    => 'bg-blue-50 border-blue-400 text-blue-800',
    ][$type] ?? 'bg-gray-50 border-gray-400 text-gray-800';

    $icon = [
        'success' => 'fa-circle-check text-emerald-500',
        'error'   => 'fa-circle-xmark text-rose-500',
        'warning' => 'fa-triangle-exclamation text-amber-500',
        'info'    => 'fa-circle-info text-blue-500',
    ][$type] ?? 'fa-info-circle text-gray-500';
@endphp

<div {{ $attributes->merge(['class' => "flex items-center p-4 border-l-4 rounded-r-lg shadow-sm mb-4 {$classes}"]) }}>
    <i class="fa-solid {{ $icon }} text-xl mr-3"></i>
    <div class="text-sm font-medium">
        {{ $slot }}
    </div>
</div>
