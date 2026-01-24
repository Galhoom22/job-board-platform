@props(['label', 'value' => null])

<div class="p-5">
    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">
        {{ $label }}
    </label>
    <p class="mt-1 text-gray-900">
        {{ $value ?? $slot ?? '-' }}
    </p>
</div>
