<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Job Category') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('job-categories.store') }}" method="POST">
                        @csrf
                        
                        {{-- Category Name Field --}}
                        <x-form-input 
                            name="name" 
                            label="Category Name" 
                            placeholder="Enter category name..."
                        />

                        {{-- Description Field --}}
                        <x-form-input 
                            name="description" 
                            label="Description" 
                            placeholder="Enter category description..."
                            :rows="3"
                            :optional="true"
                        />

                        {{-- Action Buttons --}}
                        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 pt-4 border-t border-gray-100">
                            {{-- Cancel Button --}}
                            <x-btn :href="route('job-categories.index')" color="white" icon="arrow-left">
                                {{ __('Cancel') }}
                            </x-btn>
                            
                            {{-- Create Button --}}
                            <x-btn type="submit" color="blue" icon="plus">
                                {{ __('Create Category') }}
                            </x-btn>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>