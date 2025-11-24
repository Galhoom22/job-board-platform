@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.500ms
        class="fixed top-4 right-4 z-50 bg-green-100 border border-green-300 text-green-800
               px-5 py-3 rounded-lg shadow-lg flex items-center gap-3"
        role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>

        <span class="font-medium">
            {{ session('success') }}
        </span>
    </div>
@endif
