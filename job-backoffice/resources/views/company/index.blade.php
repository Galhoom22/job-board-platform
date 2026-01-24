<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Page Title --}}
            Companies {{ request()->boolean('archived') ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        {{-- Search & Action Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            {{-- Search Form --}}
            <form action="{{ route('companies.index') }}" method="GET" class="flex-1 max-w-md" x-data x-ref="searchForm">
                @if(request()->boolean('archived'))
                    <input type="hidden" name="archived" value="true">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name, industry, or address..."
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
                <x-btn :href="route('companies.index')" color="green" icon="check-circle">
                    {{ __('Active Companies') }}
                </x-btn>
            @else
                <x-btn :href="route('companies.index', ['archived' => true])" color="gray" icon="archive">
                    {{ __('Archived Companies') }}
                </x-btn>
            @endif

            {{-- Create Company Button (Only in Active view) --}}
            @if(!request()->boolean('archived'))
                <x-btn :href="route('companies.create')" color="blue" icon="plus">
                    {{ __('Create Company') }}
                </x-btn>
            @endif
            </div>
        </div>

        {{-- Companies Table --}}
        <div class="overflow-hidden rounded-xl shadow-sm border border-gray-200">
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Company Name</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Address</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Industry</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Website</th>
                        <th class="px-4 sm:px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($companies as $company)
                    <tr class="hover:bg-blue-50 hover:shadow-sm transition-all duration-150">

                        {{-- Company Name --}}
                        <td class="px-4 sm:px-6 py-4">
                            @if($company->trashed())
                                <span class="text-sm font-medium text-gray-500">
                                    {{ $company->name }}
                                </span>
                            @else
                                <a href="{{ route('companies.show', $company) }}" 
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                    {{ $company->name }}
                                </a>
                            @endif
                        </td>

                        {{-- Address --}}
                        <td class="px-4 sm:px-6 py-4">
                            <div class="text-sm text-gray-600 line-clamp-1">{{ $company->address ?? '-' }}</div>
                        </td>

                        {{-- Industry --}}
                        <td class="px-4 sm:px-6 py-4">
                            <div class="text-sm text-gray-600">{{ $company->industry ?? '-' }}</div>
                        </td>

                        {{-- Website --}}
                        <td class="px-4 sm:px-6 py-4">
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">{{ $company->website }}</a>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 sm:gap-3">

                                @if(request()->boolean('archived'))
                                    {{-- Restore Button (Only in Archived view) --}}
                                    <x-action-btn type="restore" :action="route('companies.restore', $company->id)"/>
                                @else
                                    {{-- Edit Button --}}
                                    <x-action-btn type="edit" :href="route('companies.edit', $company)"/>

                                    {{-- Archive Button --}}
                                    <x-action-btn type="archive" :action="route('companies.destroy', $company)"/>
                                @endif
                                
                            </div>
                        </td>
                    </tr>   
                    @empty

                    {{-- No Companies Found --}}
                    <tr>
                        <td colspan="5" class="px-4 sm:px-6 py-8 text-center text-sm text-gray-600 font-medium">
                            📂 {{ __('No companies found') }}
                        </td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $companies->links() }}
        </div>
    </div>

</x-app-layout>
