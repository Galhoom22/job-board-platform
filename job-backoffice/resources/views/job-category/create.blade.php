<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Job Category') }}
            </h2>
            <a href="{{ route('job-categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 flex justify-center">
        <form action="{{ route('job-categories.store') }}" method="POST"
            class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-xl border border-gray-100 relative overflow-hidden">
            @csrf

            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <div class="space-y-6">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">{{ __('Category Details') }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Define the classification for job listings.') }}</p>
                </div>

                {{-- Name Field --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Category Name') }} <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200' }} focus:ring-4 focus:ring-opacity-50 transition-all shadow-sm"
                            placeholder="{{ __('e.g. Backend Engineering') }}" required autofocus>
                    </div>

                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description Field --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Description') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span>
                    </label>

                    <textarea id="description" name="description" rows="5"
                        class="w-full px-4 py-3 rounded-lg border {{ $errors->has('description') ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200' }} focus:ring-4 focus:ring-opacity-50 transition-all shadow-sm resize-none"
                        placeholder="{{ __('Briefly describe the responsibilities or scope...') }}">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-2 text-right">
                        {{ __('Maximum 500 characters') }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('job-categories.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg border border-gray-300
           text-gray-700 font-medium bg-white shadow-sm
           hover:bg-gray-100 hover:border-gray-400 hover:text-gray-900
           transition-all duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                        {{ __('Cancel') }}
                    </a>



                    <button type="submit"
                        class="px-8 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200 focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                        {{ __('Save Category') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
