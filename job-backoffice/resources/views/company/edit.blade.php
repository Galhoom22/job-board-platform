<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') . ' - ' . $company->name }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('companies.update', $company->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="redirect_to" value="{{ request('from') }}">

                    {{-- Company Details Section --}}
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Company Details</h3>
                        <p class="text-sm text-gray-500 mb-6">Edit the company details</p>

                        <x-form-input 
                            name="name" 
                            label="Company Name" 
                            placeholder="Enter company name..."
                            :value="$company->name"
                        />

                        <x-form-input 
                            name="address" 
                            label="Address" 
                            placeholder="Enter company address..."
                            :value="$company->address"
                        />

                        <x-form-select 
                            name="industry" 
                            label="Industry" 
                            :options="$industries"
                            :selected="$company->industry"
                            placeholder="Select industry..."
                        />

                        <x-form-input 
                            name="website" 
                            label="Website" 
                            type="url"
                            placeholder="https://example.com"
                            :value="$company->website"
                            :optional="true"
                        />
                    </div>

                    {{-- Company Owner Section --}}
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Company Owner</h3>
                        <p class="text-sm text-gray-500 mb-6">Edit the company owner details</p>

                        <x-form-input 
                            name="owner_name" 
                            label="Owner Name" 
                            placeholder="Enter owner name..."
                            :value="$company->owner?->name"
                        />

                        {{-- Email (Read-only) --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Owner Email
                            </label>
                            <input 
                                type="email"
                                value="{{ $company->owner?->email }}"
                                readonly
                                class="block w-full rounded-lg shadow-sm text-sm px-4 py-2.5 bg-gray-100 border-gray-300 text-gray-500 cursor-not-allowed"
                            >
                        </div>

                        {{-- Password (Optional) --}}
                        <div class="mb-6" x-data="{ showPassword: false }">
                            <label for="owner_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Change Owner Password
                                <span class="text-gray-400 font-normal">(Leave blank to keep the same)</span>
                            </label>
                            <div class="relative">
                                <input 
                                    :type="showPassword ? 'text' : 'password'"
                                    name="owner_password" 
                                    id="owner_password" 
                                    placeholder="Enter new password..."
                                    class="block w-full rounded-lg shadow-sm text-sm transition-all duration-200 px-4 py-2.5 pr-10 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                >
                                <button 
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <x-icon x-show="!showPassword" name="eye-off" class="w-5 h-5"/>
                                    <x-icon x-show="showPassword" name="eye" class="w-5 h-5"/>
                                </button>
                            </div>
                            @error('owner_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="p-6 flex items-center justify-end gap-3 bg-gray-50">
                        <x-btn :href="route('companies.index')" color="white">
                            {{ __('Cancel') }}
                        </x-btn>
                        
                        <x-btn type="submit" color="blue">
                            {{ __('Update Company') }}
                        </x-btn>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>