@props(['status'])

@php
    $colors = match($status) {
        'accepted' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'active' => 'bg-green-100 text-green-800',
        'closed' => 'bg-gray-100 text-gray-800',
        default => 'bg-yellow-100 text-yellow-800',
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2 inline-flex text-xs leading-5 font-semibold rounded-full {$colors}"]) }}>
    {{ ucfirst($status ?? 'pending') }}
</span>
