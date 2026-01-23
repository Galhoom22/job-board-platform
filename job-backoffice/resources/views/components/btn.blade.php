@props([
    'href' => null,
    'color' => 'blue',
    'icon' => null,
    'type' => 'button',
])

@php
$colors = [
    'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
    'green' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
    'gray' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
    'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
];

$baseClasses = 'inline-flex items-center gap-2 px-4 py-2 border border-transparent rounded-lg font-medium text-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150';
$colorClasses = $colors[$color] ?? $colors['blue'];
$classes = "$baseClasses $colorClasses";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" />
        @endif
        {{ $slot }}
    </button>
@endif
