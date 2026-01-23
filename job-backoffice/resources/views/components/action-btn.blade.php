@props([
    'type' => 'edit',
    'href' => null,
    'action' => null,
    'method' => 'POST',
])

@php
$types = [
    'edit' => [
        'color' => 'blue',
        'icon' => 'edit',
        'label' => 'Edit',
    ],
    'archive' => [
        'color' => 'red',
        'icon' => 'archive',
        'label' => 'Archive',
        'method' => 'DELETE',
    ],
    'restore' => [
        'color' => 'green',
        'icon' => 'restore',
        'label' => 'Restore',
    ],
];

$config = $types[$type] ?? $types['edit'];
$color = $config['color'];

$colors = [
    'blue' => 'text-blue-700 bg-blue-50 border-blue-200 hover:bg-blue-100 hover:border-blue-300 focus:ring-blue-500',
    'red' => 'text-red-700 bg-red-50 border-red-200 hover:bg-red-100 hover:border-red-300 focus:ring-red-500',
    'green' => 'text-green-700 bg-green-50 border-green-200 hover:bg-green-100 hover:border-green-300 focus:ring-green-500',
];

$baseClasses = 'inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium border rounded-md hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 transition-all duration-150';
$colorClasses = $colors[$color] ?? $colors['blue'];
$classes = "$baseClasses $colorClasses";
@endphp

@if($href)
    {{-- Link Button --}}
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <x-icon :name="$config['icon']" class="w-3.5 h-3.5"/>
        <span class="hidden sm:inline">{{ $config['label'] }}</span>
    </a>
@elseif($action)
    {{-- Form Button --}}
    <form action="{{ $action }}" method="POST" class="inline">
        @csrf
        @if(($config['method'] ?? $method) === 'DELETE')
            @method('DELETE')
        @endif
        <button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
            <x-icon :name="$config['icon']" class="w-3.5 h-3.5"/>
            <span class="hidden sm:inline">{{ $config['label'] }}</span>
        </button>
    </form>
@endif
