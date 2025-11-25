@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }} {{ request()->input('archived') === 'true' ? __('(Archived)') : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- Archived --}}
        <div class="mb-4">
            @if (request()->input('archived') === 'true')
                <a href="{{ route('companies.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    {{ __('View Active Companies') }}
                </a>
            @else
                <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                    class="text-sm text-gray-500 hover:text-gray-700 underline">
                    {{ __('View Archived Companies') }}
                </a>
            @endif
        </div>

        {{-- Add Company Button --}}
        <div class="flex justify-end items-center">
            <a href="{{ route('companies.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white
               px-5 py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg transition-all
               hover:-translate-y-0.5 duration-200">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Add Company
            </a>
        </div>

        <!-- Company Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Website</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">

                        {{-- Name --}}
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $company->name }}
                        </td>

                        {{-- Address --}}
                        <td class="px-6 py-4 text-gray-700">
                            {{ $company->address }}
                        </td>

                        {{-- Industry --}}
                        <td class="px-6 py-4 text-gray-700">
                            {{ $company->industry }}
                        </td>

                        {{-- Website --}}
                        <td class="px-6 py-4 text-blue-600 underline">
                            <a href="{{ $company->website }}" target="_blank">
                                {{ $company->website }}
                            </a>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <div class="flex space-x-4">

                                @if (request()->input('archived') === 'true')
                                    {{-- Restore --}}
                                    <form action="{{ route('companies.restore', $company->id) }}" method="POST">
                                        @csrf
                                        <button class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>
                                @else
                                    {{-- Edit --}}
                                    <a href="{{ route('companies.edit', $company->id) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        ✍️ Edit
                                    </a>

                                    {{-- Archive --}}
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No companies found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>
