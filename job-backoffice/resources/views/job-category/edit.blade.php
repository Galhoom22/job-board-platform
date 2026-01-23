<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('job-categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Category Name Field --}}
                        <div class="mb-6" x-data="{ hasError: {{ $errors->has('name') ? 'true' : 'false' }} }">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('Category Name') }}
                            </label>
                            
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                                   placeholder="Enter category name..."
                                   @input="hasError = false"
                                   :class="hasError 
                                       ? 'border-red-400 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500' 
                                       : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
                                   class="block w-full rounded-lg shadow-sm text-sm transition-all duration-200 px-4 py-2.5">
                            
                            {{-- Error Message --}}
                            <p x-show="hasError" 
                               x-transition:leave="transition ease-in duration-200"
                               x-transition:leave-start="opacity-100"
                               x-transition:leave-end="opacity-0"
                               class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('name') }}
                            </p>
                        </div>

                        {{-- Description Field --}}
                        <div class="mb-6" x-data="{ hasError: {{ $errors->has('description') ? 'true' : 'false' }} }">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('Description') }}
                                <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Enter category description..."
                                      @input="hasError = false"
                                      :class="hasError 
                                          ? 'border-red-400 bg-red-50 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-red-500' 
                                          : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
                                      class="block w-full rounded-lg shadow-sm text-sm transition-all duration-200 px-4 py-2.5 resize-none">{{ old('description', $category->description) }}</textarea>
                            
                            {{-- Error Message --}}
                            <p x-show="hasError" 
                               x-transition:leave="transition ease-in duration-200"
                               x-transition:leave-start="opacity-100"
                               x-transition:leave-end="opacity-0"
                               class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('description') }}
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 pt-4 border-t border-gray-100">
                            {{-- Cancel Button --}}
                            <a href="{{ route('job-categories.index') }}" 
                               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:border-gray-400 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                {{ __('Cancel') }}
                            </a>
                            
                            {{-- Update Button --}}
                            <button type="submit" 
                                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Update Category') }}
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>