<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Left: Back Button + Company Name --}}
            <div class="flex items-center gap-3 flex-1">
                <a href="{{ route('companies.index') }}" 
                   class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 transition-colors"
                   title="Back to Companies">
                    <x-icon name="arrow-left" class="w-5 h-5"/>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $company->name }}
                </h2>
            </div>

            {{-- Right: Action Buttons --}}
            <div class="flex items-center gap-2">
                <x-action-btn type="edit" :href="route('companies.edit', $company)"/>
                <x-action-btn type="archive" :action="route('companies.destroy', $company)"/>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <x-toast-notification/>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y divide-gray-200">
                
                {{-- Company Details --}}
                <x-detail-row label="Company Owner" :value="$company->owner?->name"/>
                <x-detail-row label="Address" :value="$company->address"/>
                <x-detail-row label="Industry" :value="$company->industry"/>
                
                {{-- Website with clickable link --}}
                <x-detail-row label="Website">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $company->website }}
                        </a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </x-detail-row>

                {{-- Tabs Section --}}
                <div x-data="{ activeTab: 'jobs' }">
                    
                    {{-- Tabs Navigation --}}
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-5">
                            <button @click="activeTab = 'jobs'" 
                                    :class="activeTab === 'jobs' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Job Vacancies
                            </button>
                            <button @click="activeTab = 'applicants'" 
                                    :class="activeTab === 'applicants' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Applicants
                            </button>
                        </nav>
                    </div>

                    {{-- Jobs Tab --}}
                    <div x-show="activeTab === 'jobs'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="p-5">
                        
                        @if($company->jobVacancies->isEmpty())
                            <p class="text-gray-500 text-center py-8">No job vacancies yet.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($company->jobVacancies as $job)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $job->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucwords(str_replace('_', ' ', $job->type ?? '-')) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $job->location ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$job->status ?? 'active'"/>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    {{-- Applicants Tab --}}
                    <div x-show="activeTab === 'applicants'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="p-5">
                        
                        @if($company->applications->isEmpty())
                            <p class="text-gray-500 text-center py-8">No applicants yet.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied For</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AI Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($company->applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $application->user?->name ?? 'Unknown' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $application->jobVacancy?->title ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$application->status"/>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $application->aiGeneratedScore ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>