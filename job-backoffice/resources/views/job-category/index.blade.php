<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Page Title --}}
            Job Categories {{ request()->boolean('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        {{-- Action Buttons --}}
        <div class="flex justify-end mb-4 gap-3">
            {{-- Toggle Active/Archived Button --}}
            @if(request()->boolean('archived'))
                <a href="{{ route('job-categories.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('Active Categories') }}
                </a>
            @else
                <a href="{{ route('job-categories.index', ['archived' => true]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    {{ __('Archived Categories') }}
                </a>
            @endif

            {{-- Create Job Category Button --}}
            <a href="{{ route('job-categories.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Create Category') }}
            </a>
        </div>

        {{-- Job Category Table --}}
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
                    @forelse ($categories as $category)
                    <tr class="hover:bg-blue-50 hover:shadow-sm transition-all duration-150">

                        {{-- Category Name & Description --}}
                        <td class="px-4 sm:px-6 py-4">
                            <div class="text-sm font-medium text-gray-800">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $category->description }}</div>
                            @endif
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 sm:gap-3">

                                @if(request()->boolean('archived'))
                                    {{-- Restore Button (Only in Archived view) --}}
                                    <form action="{{ route('job-categories.restore', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 hover:border-green-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            <span class="hidden sm:inline">Restore</span>
                                        </button>
                                    </form>
                                @else
                                    {{-- Edit Button --}}
                                    <a href="{{ route('job-categories.edit', $category->id) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:border-blue-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="hidden sm:inline">Edit</span>
                                    </a>

                                    {{-- Archive Button --}}
                                    <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                            <span class="hidden sm:inline">Archive</span>
                                        </button>
                                    </form>
                                @endif
                                
                            </div>
                        </td>
                    </tr>   
                    @empty

                    {{-- No Categories Found --}}
                    <tr>
                        <td colspan="2" class="px-4 sm:px-6 py-8 text-center text-sm text-gray-600 font-medium">
                            📂 {{ __('No job categories found') }}
                        </td>
                    </tr>

                    @endforelse
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
