<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data x-init="Alpine.store('sidebar', { open: true })">
    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <div 
            class="flex-1 min-h-screen bg-gray-100 transition-all duration-300"
            :class="$store.sidebar.open ? '' : 'rounded-l-2xl shadow-lg'"
        >
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow w-full">
                    <div class="w-full py-4 px-4 flex items-center gap-4">
                        {{-- Toggle Sidebar Button (shows when sidebar is closed) --}}
                        <button 
                            x-show="!$store.sidebar.open"
                            x-transition
                            @click="$store.sidebar.open = true" 
                            class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors"
                            title="Open Sidebar"
                        >
                            <x-icon name="menu" class="w-5 h-5"/>
                        </button>
                        <div class="flex-1">{{ $header }}</div>
                    </div>
                </header>
            @endisset


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>