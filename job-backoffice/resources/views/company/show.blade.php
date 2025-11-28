@php
    $tab = request('tab') ?? 'jobs';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- Back Button --}}
        <a href="{{ route('companies.index') }}"
            class="mb-4 inline-flex items-center gap-2 rounded-lg bg-gray-600 px-5 py-2.5 font-medium text-white shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-700 hover:shadow-lg">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>

            Back
        </a>

        {{-- Wrapper --}}
        <div class="rounded-lg bg-white p-6 shadow">
            {{-- Company Details --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="col-span-2">
                    <h3 class="mb-4 text-lg font-semibold">Company Details</h3>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">Name:</p>
                    <p class="text-gray-700">{{ $company->name }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">Address:</p>
                    <p class="text-gray-700">{{ $company->address }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">Industry:</p>
                    <p class="text-gray-700">{{ $company->industry }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">Website:</p>
                    <p class="text-gray-700"><a class="text-blue-600 underline hover:text-blue-700"
                            href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
                </div>
            </div>

            {{-- Edit and Archive Button --}}
            <div class="mt-6 flex items-center justify-end space-x-4">

                {{-- Edit Button --}}
                <a href="{{ route('companies.edit', $company->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 font-medium text-white shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>

                    Edit
                </a>


                {{-- Archive Button --}}
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-5 py-2.5 font-medium text-white shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:bg-red-600 hover:shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7h16M9 7V4h6v3m-8 0v12a2 2 0 002 2h6a2 2 0 002-2V7" />
                        </svg>

                        Archive
                    </button>
                </form>

            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('companies.show', $company->id) }}?tab=jobs"
                            class="{{ $tab === 'jobs' ? 'border-b-2 border-blue-500' : '' }} px-4 py-2 font-semibold text-gray-800">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show', $company->id) }}?tab=applications"
                            class="{{ $tab === 'applications' ? 'border-b-2 border-blue-500' : '' }} px-4 py-2 font-semibold text-gray-800">Applications</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>
                <!-- Jobs Tab -->
                <div id="jobs" class="{{ $tab === 'jobs' ? 'block' : 'hidden' }}">
                    <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr class="text-left text-sm font-semibold text-gray-700">
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Location</th>
                                <th class="w-32 px-4 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($jobs as $job)
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800">{{ $job->title }}</td>
                                    <td class="px-4 py-3 capitalize text-gray-600">{{ $job->type }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $job->location }}</td>

                                    <td class="px-4 py-3">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}"
                                            class="rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow transition hover:bg-blue-700">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $jobs->links() }}
                    </div>
                </div>

                <!-- Applications Tab -->
                <div id="applications" class="{{ $tab === 'applications' ? 'block' : 'hidden' }}">
                    <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr class="text-left text-sm font-semibold text-gray-700">
                                <th class="px-4 py-3">Applicant Name</th>
                                <th class="px-4 py-3">Job Title</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="w-32 px-4 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($applications as $application)
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800">{{ $application->user->name }}</td>
                                    <td class="px-4 py-3 capitalize text-gray-600">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $application->status }}</td>

                                    <td class="px-4 py-3">
                                        <a href="{{ route('job-applications.show', $application->id) }}"
                                            class="rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow transition hover:bg-blue-700">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
