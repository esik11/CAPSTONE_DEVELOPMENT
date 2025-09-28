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
            <div class="w-64 bg-clinic-blue-dark text-white flex-shrink-0">
                <div class="h-16 flex items-center justify-center text-2xl font-bold">
                    Salamat Doc
                </div>
                <nav class="mt-10">
                    <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('patients.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 00.255-.35L20.923 9.255A3.001 3.001 0 0018.71 5.093l-1.566 1.566m-4.63-.653a2.25 2.25 0 00-3.375 1.733v1.11a2.25 2.25 0 002.25 2.25H15M8.25 12H12m4.875 0H21m-1.5 2.25h-.75m-4.5-1.5H11.25m-6.75 0H5.25" />
                        </svg>
                        Patients (EMR)
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H12a1.125 1.125 0 01-1.125-1.125V1.5m6.75 10.5l3.125-3.125M12 18V5.25M15.75 18H5.25" />
                        </svg>
                        E-Prescription
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12v-.008zM12 18h.008v.008H12v-.008z" />
                        </svg>
                        Appointments
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9H19.5m-16.5 5.25h6m-6 2.25h3m-3 6l3-3m-3 3v-3m0-6h.008v.008H2.25V17.25zM12.75 9h7.5A.75.75 0 0121 9.75v3.75a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V9.75c0-.414.336-.75.75-.75z" />
                        </svg>
                        Billing
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-clinic-blue-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Profile
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="flex justify-between items-center bg-white p-4 shadow">
                    <div class="text-xl font-semibold">Doctor Dashboard</div>
                    <div>
                        <!-- User Dropdown (from existing navigation.blade.php) -->
                        @include('layouts.navigation')
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-clinic-blue-light p-4">
                    {{ $slot }}
                </main>
                <footer class="bg-clinic-blue-dark p-4 shadow mt-auto text-white text-center text-sm">
                    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
                        <p class="mb-2 md:mb-0">&copy; {{ date('Y') }} Salamat Doc Clinic. All rights reserved.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-gray-300">Privacy Policy</a>
                            <a href="#" class="hover:text-gray-300">Terms of Service</a>
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

