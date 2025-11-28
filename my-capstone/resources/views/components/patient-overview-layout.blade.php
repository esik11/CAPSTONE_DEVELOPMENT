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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-50">
            <!-- Main Content (No main sidebar) -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
                    <div class="px-6 py-4">
                        <!-- Header Content -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                @if (isset($header))
                                    {{ $header }}
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <!-- Notifications -->
                                <button class="relative p-2.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                                </button>
                                
                                <!-- User Dropdown -->
                                <x-doctor-user-dropdown />
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 overflow-hidden">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        @livewireScripts
    </body>
</html>
