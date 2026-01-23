<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Page Title --}}
            {{ __('Job Categories') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">
        <!-- Job Category Table -->
        <div class="overflow-hidden rounded-xl shadow-sm border border-gray-200">
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Category Name</th>
                        <th class="px-4 sm:px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        {{-- Category Name --}}
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $category->name }}</td>
                        
                        {{-- Actions --}}
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 sm:gap-3">

                                {{-- Edit Button --}}
                                <a href="{{ route('job-categories.edit', $category->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="hidden sm:inline">Archive</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>

</x-app-layout>
