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
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- Flatpickr Month Select Plugin CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
        <style>
            .flatpickr-calendar.arrowTop:before, .flatpickr-calendar.arrowTop:after {
                display: none;
            }
        </style>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-clinic-blue-light">
            <!-- Sidebar -->
            <div class="w-72 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex-shrink-0 shadow-2xl">
                <!-- Logo Section -->
                <div class="h-20 flex items-center justify-center border-b border-gray-700/50 bg-gradient-to-r from-teal-600/20 to-emerald-600/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-teal-400 to-emerald-400 bg-clip-text text-transparent">Salamat Doc</h1>
                            <p class="text-xs text-gray-400">Medical Portal</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="px-4 py-6 border-b border-gray-700/50">
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-800/50 to-gray-700/30 rounded-xl border border-gray-700/50">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-full flex items-center justify-center text-lg font-bold shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">Dr. {{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-3 py-6 space-y-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Main Menu</p>
                    
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 shadow-lg shadow-teal-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('patients.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 shadow-lg shadow-teal-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('patients.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="font-medium block">Patients</span>
                            <span class="text-xs text-gray-400">EMR System</span>
                        </div>
                    </a>

                    <a href="{{ route('doctor.appointments.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('doctor.appointments.*') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 shadow-lg shadow-teal-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('doctor.appointments.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <span class="font-medium">Appointments</span>
                    </a>

                    <a href="{{ route('doctor.ePrescription.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('doctor.ePrescription.*') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 shadow-lg shadow-teal-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('doctor.ePrescription.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <span class="font-medium">E-Prescription</span>
                    </a>

                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-6">Other</p>

                    <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-gray-800/50 hover:translate-x-1">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 group-hover:bg-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>
                        <span class="font-medium">Billing</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 shadow-lg shadow-teal-500/50' : 'hover:bg-gray-800/50 hover:translate-x-1' }}">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ request()->routeIs('profile.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="font-medium">Profile</span>
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
                        <!-- Breadcrumbs (if provided) -->
                        @if (isset($breadcrumbs))
                            <nav class="flex mb-3" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    {{ $breadcrumbs }}
                                </ol>
                            </nav>
                        @endif

                        <!-- Header Content -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                @if (isset($header))
                                    {{ $header }}
                                @else
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold text-gray-900">Doctor Dashboard</h2>
                                            <p class="text-sm text-gray-600 mt-0.5">Welcome back, Dr. {{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <!-- Quick Actions (if provided) -->
                                @if (isset($headerActions))
                                    {{ $headerActions }}
                                @endif

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
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    {{ $slot }}
                </main>
                <footer class="bg-white border-t border-gray-200 px-6 py-4 mt-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                        <p class="mb-2 md:mb-0">&copy; {{ date('Y') }} Salamat Doc Clinic. All rights reserved.</p>
                        <div class="flex gap-6">
                            <a href="#" class="hover:text-teal-600 transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-teal-600 transition-colors">Terms of Service</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
        <!-- Flatpickr Month Select Plugin JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#birthdate", {
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length > 0) {
                            const today = new Date();
                            const birthDate = selectedDates[0];
                            let age = today.getFullYear() - birthDate.getFullYear();
                            const m = today.getMonth() - birthDate.getMonth();
                            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                                age--;
                            }
                            document.getElementById('age').value = age;
                        }
                    }
                });
            });
        </script>
    </body>
</html>

