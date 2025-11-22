<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/fullcalendar.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
        {{-- <link rel="stylesheet" href="{{ asset('css/fullcalendar_custom.css') }}"> --}}

        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    </head>
    <body class="font-inter antialiased">
        <div class="flex h-screen bg-gray-50">
            <!-- Sidebar -->
            <div class="w-72 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex-shrink-0 shadow-2xl">
                <!-- Logo Section -->
                <div class="h-20 flex items-center justify-center border-b border-gray-700/50 bg-gradient-to-r from-blue-600/20 to-indigo-600/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">Salamat Doc</h1>
                            <p class="text-xs text-gray-400">Patient Portal</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="px-4 py-6 border-b border-gray-700/50">
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-800/50 to-gray-700/30 rounded-xl border border-gray-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-lg font-bold shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <nav class="px-3 py-6 space-y-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Main Menu</p>
                    
                    <a href="{{ route('patient.dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patient.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patient.dashboard') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('patient.profile.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patient.profile.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patient.profile.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <span class="font-medium block">My Profile</span>
                                <span class="text-xs text-gray-400">Personal info</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition class="mt-1 space-y-1 pl-4">
                            <a href="{{ route('patient.profile.show') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('patient.profile.show') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-gray-800/30 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm font-medium">View Profile</span>
                            </a>
                            <a href="{{ route('patient.profile.edit') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('patient.profile.edit') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-gray-800/30 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125l-4.5-4.5" />
                                </svg>
                                <span class="text-sm font-medium">Edit Profile</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('patient.appointments.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patient.appointments.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patient.appointments.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <span class="font-medium">Appointments</span>
                    </a>

                    <a href="{{ route('patient.prescriptions.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patient.prescriptions.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patient.prescriptions.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <span class="font-medium">Prescriptions</span>
                    </a>

                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-6">Other</p>

                    <a href="{{ route('patient.billing.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patient.billing.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patient.billing.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>
                        <span class="font-medium">Billing</span>
                    </a>
                </nav>

                <!-- Logout Button at Bottom -->
                <div class="px-3 pb-6 mt-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 bg-red-600/10 hover:bg-red-600 border border-red-600/30 hover:border-red-600">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-600/20 group-hover:bg-white/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-400 group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                            </div>
                            <span class="font-medium text-red-400 group-hover:text-white">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
                    <div class="px-6 py-4">
                        <!-- Header Content -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                @if (isset($header))
                                    {{ $header }}
                                @else
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold text-gray-900">Patient Dashboard</h2>
                                            <p class="text-sm text-gray-600 mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
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
                                <x-patient-user-dropdown />
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    {{ $slot }}
                </main>
                <footer class="bg-white border-t border-gray-200 px-6 py-4 mt-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                        <p class="mb-2 md:mb-0">&copy; {{ date('Y') }} Salamat Doc Clinic. All rights reserved.</p>
                        <div class="flex gap-6">
                            <a href="#" class="hover:text-blue-600 transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-blue-600 transition-colors">Terms of Service</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
