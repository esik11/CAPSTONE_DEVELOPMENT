<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />
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

        <style>
            @keyframes pulse-slow {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.8;
                }
            }
            .animate-pulse-slow {
                animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-50" x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))">
            <!-- Sidebar -->
            <div class="flex-shrink-0 shadow-xl transition-all duration-300 ease-in-out relative flex flex-col"
                 :class="sidebarCollapsed ? 'w-[72px]' : 'w-64'"
                 style="background: linear-gradient(180deg, #0f1729 0%, #152036 50%, #0f1729 100%);">

                <!-- Toggle Button -->
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                        class="absolute -right-3 top-[4.5rem] z-50 w-6 h-6 bg-teal-600 hover:bg-teal-500 rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                         class="w-3.5 h-3.5 text-white transition-transform duration-300"
                         :class="sidebarCollapsed ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <!-- Logo Section -->
                <div class="h-16 flex items-center border-b border-white/[0.06] px-4 overflow-hidden">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-teal-400 to-teal-600 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                <path d="M11.644 1.59a.75.75 0 01.712 0l9.75 5.25a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.712 0l-9.75-5.25a.75.75 0 010-1.32l9.75-5.25z" />
                                <path d="M3.265 10.602l7.668 4.129a2.25 2.25 0 002.134 0l7.668-4.13 1.37.739a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.71 0l-9.75-5.25a.75.75 0 010-1.32l1.37-.738z" />
                                <path d="M3.265 15.602l7.668 4.129a2.25 2.25 0 002.134 0l7.668-4.13 1.37.739a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.71 0l-9.75-5.25a.75.75 0 010-1.32l1.37-.738z" />
                            </svg>
                        </div>
                        <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="whitespace-nowrap">
                            <h1 class="text-base font-bold text-white tracking-tight">Salamat Doc</h1>
                            <p class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">Medical Portal</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="px-3 py-4 border-b border-white/[0.06]">
                    <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-white/[0.04] border border-white/[0.06]"
                         :class="sidebarCollapsed ? 'justify-center' : ''">
                        <div class="w-9 h-9 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full flex items-center justify-center text-sm font-semibold text-white flex-shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">Dr. {{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-3 py-4 space-y-0.5 flex-1 overflow-y-auto">
                    <p x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Main Menu</p>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('dashboard')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium">Dashboard</span>
                        <!-- Tooltip for collapsed state -->
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Dashboard
                        </div>
                    </a>

                    <!-- Patients -->
                    <a href="{{ route('patients.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('patients.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" />
                            <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                        </svg>
                        <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex-1">
                            <span class="text-sm font-medium block">Patients</span>
                            <span class="text-[10px] text-slate-500">EMR System</span>
                        </div>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Patients · EMR
                        </div>
                    </a>

                    <!-- My Schedule -->
                    <a href="{{ route('doctor.appointments.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('doctor.appointments.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ 
                           tip: false,
                           pendingCount: {{ App\Models\Appointment::where('doctor_id', Auth::id())->where('status', 'pending')->count() }}
                       }" 
                       @mouseenter="tip = sidebarCollapsed" 
                       @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium flex-1">My Schedule</span>
                        <template x-if="pendingCount > 0">
                            <span class="flex-shrink-0 px-1.5 py-0.5 bg-amber-500 text-white text-[9px] font-bold rounded-full" x-text="pendingCount" x-show="!sidebarCollapsed"></span>
                        </template>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            My Schedule
                        </div>
                    </a>

                    <!-- My Availability -->
                    <a href="{{ route('doctor.availability.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('doctor.availability.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium">My Availability</span>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Availability
                        </div>
                    </a>

                    <p x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2 mt-5">Other</p>
                    <div x-show="sidebarCollapsed" class="my-3 mx-3 border-t border-white/[0.06]"></div>

                    <!-- Audit Logs -->
                    <a href="{{ route('doctor.audit-logs.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('doctor.audit-logs.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="flex-1">
                            <span class="text-sm font-medium block">Audit Logs</span>
                            <span class="text-[10px] text-slate-500">HIPAA Compliance</span>
                        </div>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Audit Logs · HIPAA
                        </div>
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('doctor.reports.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('doctor.reports.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium">Reports</span>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Reports
                        </div>
                    </a>

                    <!-- Billing -->
                    <a href="{{ route('doctor.billing.index') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('doctor.billing.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 17.625V4.875zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium">Billing</span>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Billing
                        </div>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                       class="group flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition-all duration-200
                              {{ request()->routeIs('profile.*')
                                  ? 'bg-teal-500/10 text-teal-400 border-l-[3px] border-teal-400 ml-0 pl-[9px]'
                                  : 'text-slate-400 hover:text-white hover:bg-white/[0.04]' }}"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       x-data="{ tip: false }" @mouseenter="tip = sidebarCollapsed" @mouseleave="tip = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-sm font-medium">Profile</span>
                        <div x-show="tip" x-transition class="absolute left-full ml-3 px-2.5 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-md shadow-lg whitespace-nowrap z-50 border border-slate-700">
                            Profile
                        </div>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
                    <div class="px-6 py-3.5">
                        <!-- Breadcrumbs (if provided) -->
                        @if (isset($breadcrumbs))
                            <nav class="flex mb-2" aria-label="Breadcrumb">
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
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-900">Doctor Dashboard</h2>
                                            <p class="text-sm text-gray-500 mt-0.5">Welcome back, Dr. {{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 flex-shrink-0">
                                <!-- Global Patient Search -->
                                <div x-data="patientSearch()" class="relative">
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            x-model="query"
                                            @input.debounce.300ms="search()"
                                            @focus="focused = true"
                                            @keydown.escape="clear()"
                                            placeholder="Quick search patients..."
                                            class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                                        />
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                        <button 
                                            x-show="query.length > 0"
                                            @click="clear()"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Search Results Dropdown -->
                                    <div 
                                        x-show="focused && results.length > 0"
                                        @click.away="focused = false"
                                        x-transition
                                        class="absolute top-full mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                                    >
                                        <div class="p-2 bg-gray-50 border-b border-gray-100">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Search Results</p>
                                        </div>
                                        <div class="max-h-80 overflow-y-auto">
                                            <template x-for="patient in results" :key="patient.id">
                                                <a 
                                                    :href="`/patients/${patient.id}`"
                                                    class="block p-3 hover:bg-teal-50 transition-colors border-b border-gray-50 last:border-0"
                                                    @click="clear()"
                                                >
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                                            <span x-text="patient.name.charAt(0)"></span>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-gray-900" x-text="patient.name"></p>
                                                            <div class="flex items-center gap-2 mt-0.5">
                                                                <span class="text-xs text-gray-500" x-text="`ID: ${patient.patient_id}`"></span>
                                                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                                <span class="text-xs text-gray-500" x-text="`${patient.age} yrs`"></span>
                                                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                                <span class="text-xs text-gray-500 capitalize" x-text="patient.gender"></span>
                                                            </div>
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            </template>
                                        </div>
                                        <div class="p-2 bg-gray-50 border-t border-gray-100 text-center">
                                            <a href="{{ route('patients.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 uppercase tracking-wide">
                                                View All Patients →
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- No Results -->
                                    <div 
                                        x-show="focused && query.length > 0 && results.length === 0 && !loading"
                                        @click.away="focused = false"
                                        x-transition
                                        class="absolute top-full mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-100 p-6 text-center z-50"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-gray-300 mb-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                        </svg>
                                        <p class="text-sm text-gray-500 font-medium">No patients found</p>
                                        <p class="text-xs text-gray-400 mt-1">Try searching by name, ID, or phone number</p>
                                    </div>
                                </div>

                                <!-- Quick Actions (if provided) -->
                                @if (isset($headerActions))
                                    {{ $headerActions }}
                                @endif

                                <!-- Notifications -->
                                <x-notification-bell />

                                <!-- User Dropdown -->
                                <x-doctor-user-dropdown />
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
                <footer class="bg-white border-t border-gray-100 px-6 py-3 mt-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
                        <p class="mb-1 md:mb-0">&copy; {{ date('Y') }} Salamat Doc Clinic. All rights reserved.</p>
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

        @stack('scripts')
        @livewireScripts

        <!-- Global Toast Notification System -->
        <div id="toast-container" class="fixed top-6 right-6 z-[100] space-y-3"></div>

        <script>
            function patientSearch() {
                return {
                    query: '',
                    results: [],
                    focused: false,
                    loading: false,
                    
                    search() {
                        if (this.query.length < 2) {
                            this.results = [];
                            return;
                        }
                        
                        this.loading = true;
                        
                        fetch(`/doctor/patients/quick-search?q=${encodeURIComponent(this.query)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.results = data.patients || [];
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            this.results = [];
                            this.loading = false;
                        });
                    },
                    
                    clear() {
                        this.query = '';
                        this.results = [];
                        this.focused = false;
                    }
                }
            }
            
            function showToast(message, type = 'success') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                const colors = type === 'success' ? 'bg-teal-600' : 'bg-red-600';
                
                toast.className = `${colors} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in slide-in-from-right-full duration-300 transform transition-all`;
                toast.innerHTML = `
                    <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-xs font-black uppercase tracking-widest">${message}</p>
                `;
                
                container.appendChild(toast);
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
            }
        </script>
    </body>
</html>
