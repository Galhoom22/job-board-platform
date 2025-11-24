<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- Add Job Category Button --}}
        <div class="flex justify-end items-center">
            <a href="{{ route('job-categories.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white
               px-5 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg transition-all
               hover:-translate-y-0.5 duration-200">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Add Job Category
            </a>
        </div>

        <!-- Job Category Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                {{-- Edit Button --}}
                                <a href="{{ route('job-categories.edit', $category->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    ✍️ Edit
                                </a>


                                {{-- Delete Button --}}
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">🗃️
                                        Archive</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
