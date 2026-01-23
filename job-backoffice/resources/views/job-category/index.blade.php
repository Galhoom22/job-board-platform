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

        {{-- Search & Action Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            {{-- Search Form --}}
            <form action="{{ route('job-categories.index') }}" method="GET" class="flex-1 max-w-md" x-data x-ref="searchForm">
                @if(request()->boolean('archived'))
                    <input type="hidden" name="archived" value="true">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search categories by name or description..."
                           @input.debounce.750ms="$refs.searchForm.submit()"
                           x-init="@if(request('search')) $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length) @endif"
                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 transition-all duration-150">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-icon name="search" class="w-4 h-4 text-gray-400"/>
                    </div>
                </div>
            </form>

            {{-- Action Buttons --}}
            <div class="flex gap-3">
            {{-- Toggle Active/Archived Button --}}
            @if(request()->boolean('archived'))
                <x-btn :href="route('job-categories.index')" color="green" icon="check-circle">
                    {{ __('Active Categories') }}
                </x-btn>
            @else
                <x-btn :href="route('job-categories.index', ['archived' => true])" color="gray" icon="archive">
                    {{ __('Archived Categories') }}
                </x-btn>
            @endif

            {{-- Create Job Category Button (Only in Active view) --}}
            @if(!request()->boolean('archived'))
                <x-btn :href="route('job-categories.create')" color="blue" icon="plus">
                    {{ __('Create Category') }}
                </x-btn>
            @endif
            </div>
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
                                    <x-action-btn type="restore" :action="route('job-categories.restore', $category->id)"/>
                                @else
                                    {{-- Edit Button --}}
                                    <x-action-btn type="edit" :href="route('job-categories.edit', $category->id)"/>

                                    {{-- Archive Button --}}
                                    <x-action-btn type="archive" :action="route('job-categories.destroy', $category->id)"/>
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
