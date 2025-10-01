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
        <div class="flex min-h-screen bg-clinic-blue-light dark:bg-gray-900">
            <!-- Sidebar -->
            <div class="w-64 bg-clinic-blue-dark text-white flex-shrink-0 shadow-lg md:w-20 md:hover:w-64 transition-all duration-300 ease-in-out group">
                <div class="h-16 flex items-center justify-center text-xl font-bold text-clinic-green-medium overflow-hidden">
                    <span class="md:hidden md:group-hover:block transition-opacity duration-300 ease-in-out">Salamat Doc Patient</span>
                    <x-heroicon-s-heart class="md:group-hover:hidden h-8 w-8 text-clinic-green-medium" />
                </div>
                <nav class="mt-5 space-y-1">
                    <a href="{{ route('patient.dashboard') }}" class="group flex items-center py-2.5 px-4 rounded-md transition duration-200 hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.dashboard') ? 'bg-clinic-green-dark text-white' : 'text-gray-300' }}">
                        <x-heroicon-o-home class="mr-3 h-5 w-5 group-hover:text-white {{ request()->routeIs('patient.dashboard') ? 'text-white' : 'text-gray-400' }}" />
                        <span class="md:hidden md:group-hover:block">Dashboard</span>
                    </a>
                    <div x-data="{ open: {{ request()->routeIs('patient.profile.*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = ! open" class="group flex items-center py-2.5 px-4 rounded-md transition duration-200 hover:bg-clinic-green-medium hover:text-white w-full text-left {{ request()->routeIs('patient.profile.*') ? 'bg-clinic-green-dark text-white' : 'text-gray-300' }}">
                            <x-heroicon-o-user-circle class="mr-3 h-5 w-5 group-hover:text-white {{ request()->routeIs('patient.profile.*') ? 'text-white' : 'text-gray-400' }}" />
                            <span class="md:hidden md:group-hover:block">Profile</span>
                            <svg class="ms-auto w-4 h-4 transition-transform md:hidden md:group-hover:block" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" @click.outside="open = false" class="bg-clinic-blue-medium text-white rounded-md shadow-lg mt-1 w-full z-10" x-cloak>
                            <a href="{{ route('patient.profile.show') }}" class="block py-2 px-4 text-sm hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.profile.show') ? 'bg-clinic-green-dark text-white' : 'text-gray-200' }} pl-6">
                                <x-heroicon-o-eye class="mr-3 h-4 w-4 inline-block" />
                                View Profile
                            </a>
                            <a href="{{ route('patient.profile.edit') }}" class="block py-2 px-4 text-sm hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.profile.edit') ? 'bg-clinic-green-dark text-white' : 'text-gray-200' }} pl-6">
                                <x-heroicon-o-pencil class="mr-3 h-4 w-4 inline-block" />
                                Edit Profile
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('patient.appointments.index') }}" class="group flex items-center py-2.5 px-4 rounded-md transition duration-200 hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.appointments.index') ? 'bg-clinic-green-dark text-white' : 'text-gray-300' }}">
                        <x-heroicon-o-calendar class="mr-3 h-5 w-5 group-hover:text-white {{ request()->routeIs('patient.appointments.index') ? 'text-white' : 'text-gray-400' }}" />
                        <span class="md:hidden md:group-hover:block">Appointments</span>
                    </a>
                    <a href="{{ route('patient.billing.index') }}" class="group flex items-center py-2.5 px-4 rounded-md transition duration-200 hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.billing.index') ? 'bg-clinic-green-dark text-white' : 'text-gray-300' }}">
                        <x-heroicon-o-currency-dollar class="mr-3 h-5 w-5 group-hover:text-white {{ request()->routeIs('patient.billing.index') ? 'text-white' : 'text-gray-400' }}" />
                        <span class="md:hidden md:group-hover:block">Billing</span>
                    </a>
                    <a href="{{ route('patient.prescriptions.index') }}" class="group flex items-center py-2.5 px-4 rounded-md transition duration-200 hover:bg-clinic-green-medium hover:text-white {{ request()->routeIs('patient.prescriptions.index') ? 'bg-clinic-green-dark text-white' : 'text-gray-300' }}">
                        <x-heroicon-c-clipboard-document-list class="mr-3 h-5 w-5 group-hover:text-white {{ request()->routeIs('patient.prescriptions.index') ? 'text-white' : 'text-gray-400' }}" />
                        <span class="md:hidden md:group-hover:block">Prescriptions</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <header class="flex justify-between items-center bg-white p-4 shadow-md">
                    <div class="text-xl font-semibold text-gray-800">
                        @isset($header)
                            {{ $header }}
                        @else
                            {{ Route::currentRouteName() ? __(ucwords(str_replace(['patient.', '.'], ['', ' '], Route::currentRouteName()))) : 'Dashboard' }}
                        @endisset
                    </div>
                    <div>
                        <div class="flex items-center space-x-4">
                            <!-- Notification Bell -->
                            <button class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-clinic-green-dark focus:outline-none focus:ring focus:ring-clinic-green-dark rounded-full transition duration-150 ease-in-out">
                                <x-heroicon-o-bell class="h-6 w-6" />
                                <span class="absolute -top-1 -right-1 block h-3 w-3 rounded-full ring-2 ring-white bg-red-500 text-xs text-white flex items-center justify-center" style="font-size: 0.6rem;">3</span>
                            </button>

                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = ! open" class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-clinic-green-dark hover:border-clinic-green-dark focus:outline-none focus:text-clinic-green-dark focus:border-clinic-green-dark transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover mr-2" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ Auth::user()->name }}">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>

                                <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-20" x-cloak>
                                    <a href="{{ route('patient.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clinic-green-light hover:text-clinic-green-dark flex items-center">
                                        <x-heroicon-o-cog class="w-4 h-4 mr-2" />
                                        Settings
                                    </a>
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clinic-green-light hover:text-clinic-green-dark flex items-center">
                                            <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4 mr-2" />
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 bg-gray-100 dark:bg-gray-100 p-4">
                    {{ $slot }}
                </main>
                <footer class="bg-clinic-blue-dark p-4 mt-auto text-white text-center text-sm border-t border-clinic-blue-light">
                    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
                        <p class="mb-2 md:mb-0 text-gray-400">&copy; {{ date('Y') }} Salamat Doc Clinic. All rights reserved.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-clinic-green-medium text-gray-400">Privacy Policy</a>
                            <a href="#" class="hover:text-clinic-green-medium text-gray-400">Terms of Service</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
