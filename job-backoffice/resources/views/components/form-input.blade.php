@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'optional' => false,
    'rows' => null,
])

@php
$isTextarea = !is_null($rows);
$fieldValue = old($name, $value);
$hasError = $errors->has($name);
@endphp

<div class="mb-6" x-data="{ hasError: {{ $hasError ? 'true' : 'false' }} }">
    {{-- Label --}}
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ __($label) }}
        @if($optional)
            <span class="text-gray-400 font-normal">(Optional)</span>
        @endif
    </label>
    
    {{-- Input/Textarea --}}
    @if($isTextarea)
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            @input="hasError = false"
            :class="hasError 
                ? 'border-red-400 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500' 
                : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
            {{ $attributes->merge(['class' => 'block w-full rounded-lg shadow-sm text-sm transition-all duration-200 px-4 py-2.5 resize-none']) }}
        >{{ $fieldValue }}</textarea>
    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ $fieldValue }}"
            placeholder="{{ $placeholder }}"
            @input="hasError = false"
            :class="hasError 
                ? 'border-red-400 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500' 
                : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
            {{ $attributes->merge(['class' => 'block w-full rounded-lg shadow-sm text-sm transition-all duration-200 px-4 py-2.5']) }}
        >
    @endif
    
    {{-- Error Message --}}
    <p x-show="hasError" 
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="mt-2 text-sm text-red-600 flex items-center gap-1">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        {{ $errors->first($name) }}
    </p>
</div>
