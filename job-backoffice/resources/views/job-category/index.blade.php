@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Categories') }} {{ request()->input('archived') === 'true' ? __('(Archived)') : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- Archived --}}
        <div class="mb-4">
            @if (request()->input('archived') === 'true')
                <a href="{{ route('job-categories.index') }}" class="text-sm text-gray-500 underline hover:text-gray-700">
                    {{ __('View Active Categories') }}
                </a>
            @else
                <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
                    class="text-sm text-gray-500 underline hover:text-gray-700">
                    {{ __('View Archived Categories') }}
                </a>
            @endif
        </div>

        {{-- Add Job Category Button --}}
        <div class="flex items-center justify-end">
            <a href="{{ route('job-categories.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 font-medium text-white shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Add Job Category
            </a>
        </div>

        <!-- Job Category Table -->
        <table class="mt-4 min-w-full divide-y divide-gray-200 rounded-lg bg-white shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="w-40 px-6 py-3 text-right text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            <div class="font-semibold text-gray-900">
                                {{ $category->name }}
                            </div>

                            @if ($category->description)
                                <div class="mt-1 text-xs text-gray-500">
                                    {{ Str::limit($category->description, 80) }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-4">

                                {{-- Edit Button --}}
                                <a href="{{ route('job-categories.edit', $category->id) }}"
                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>

                                    Edit
                                </a>

                                {{-- Archive Button --}}
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST"
                                    class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('DELETE')

                                    <button class="inline-flex items-center gap-1 text-red-600 hover:text-red-800">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7h16M9 7V4h6v3m-8 0v12a2 2 0 002 2h6a2 2 0 002-2V7" />
                                        </svg>

                                        Archive
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                            No job categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
