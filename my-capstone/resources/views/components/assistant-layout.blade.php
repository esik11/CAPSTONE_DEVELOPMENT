<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Assistant Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Inter', sans-serif; }
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
            .sidebar-scrollbar::-webkit-scrollbar { width: 3px; }
            .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 overflow-hidden">
        <div class="flex h-screen bg-gray-50" x-data="{ sidebarCollapsed: localStorage.getItem('assistantSidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('assistantSidebarCollapsed', val))">
            <!-- Sidebar -->
            <div class="flex-shrink-0 shadow-xl transition-all duration-300 ease-in-out relative flex flex-col"
                 :class="sidebarCollapsed ? 'w-[72px]' : 'w-64'"
                 style="background: linear-gradient(180deg, #0f1729 0%, #152036 50%, #0f1729 100%);">
                
                <!-- Logo Section -->
                <div class="h-16 flex items-center px-4 overflow-hidden border-b border-white/5 flex-shrink-0">
                    <div class="flex items-center gap-3 min-w-max">
                        <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-violet-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                <path d="M11.644 1.59a.75.75 0 01.712 0l9.75 5.25a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.712 0l-9.75-5.25a.75.75 0 010-1.32l9.75-5.25z" />
                                <path d="M3.265 10.602l7.635 4.11a.75.75 0 00.712 0l7.635-4.11 2.484 1.338a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.712 0l-9.75-5.25a.75.75 0 010-1.32l2.484-1.338z" />
                                <path d="M3.265 14.535l7.635 4.11a.75.75 0 00.712 0l7.635-4.11 2.484 1.338a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.712 0l-9.75-5.25a.75.75 0 010-1.32l2.484-1.338z" />
                            </svg>
                        </div>
                        <span class="text-white font-bold text-lg tracking-tight transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0' : 'opacity-100'">
                            Salamat Doc
                        </span>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1 sidebar-scrollbar">
                    <p class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-4 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0' : 'opacity-100'">Main Menu</p>
                    
                    <!-- Dashboard -->
                    <a href="{{ route('assistant.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.dashboard') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.dashboard'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.dashboard') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Dashboard
                        </span>
                    </a>

                    <!-- Patients -->
                    <a href="{{ route('assistant.patients.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.patients.*') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.patients.*'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.patients.*') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.125a7.125 7.125 0 014.5-6.656.75.75 0 00-.508-1.403A8.625 8.625 0 0015.75 21H17.25z" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.patients.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Patients
                        </span>
                    </a>

                    <!-- Appointments -->
                    <a href="{{ route('assistant.appointments.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.appointments.*') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.appointments.*'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.appointments.*') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9h-16.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.appointments.*') && !request()->routeIs('assistant.appointments.conflicts') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Appointments
                        </span>
                    </a>

                    <!-- Lab Results -->
                    <a href="{{ route('assistant.lab-results.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.lab-results.*') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.lab-results.*'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.lab-results.*') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 01-.879 2.121l-2.377 2.377a9.845 9.845 0 015.091 1.013 8.315 8.315 0 005.713.636l.285-.071-3.954-3.955a3 3 0 01-.879-2.121v-5.02a23.614 23.614 0 00-3 0zm4.5.138a.75.75 0 00.093-1.495A24.837 24.837 0 0012 2.25a25.048 25.048 0 00-3.093.191A.75.75 0 009 3.936v4.882a1.5 1.5 0 01-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.471-4.881L15.44 9.879A1.5 1.5 0 0115 8.818V3.936z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.lab-results.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Lab Results
                        </span>
                    </a>

                    <!-- Billing & Payments -->
                    <a href="{{ route('assistant.billing.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.billing.*') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.billing.*'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.billing.*') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM21 9.75H3V18h18V9.75zM3 8.25h18V4.875a.375.375 0 00-.375-.375H3.375a.375.375 0 00-.375.375V8.25z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.billing.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Billing & Payments
                        </span>
                    </a>

                    <div class="pt-4 pb-2 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0' : 'opacity-100'">
                        <p class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">Reports</p>
                    </div>

                    <!-- Patient Roster -->
                    <a href="{{ route('assistant.reports.patients') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.reports.patients') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.reports.patients'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.reports.patients') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.reports.patients') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Patient Roster
                        </span>
                    </a>

                    <!-- Daily Schedule -->
                    <a href="{{ route('assistant.reports.schedule') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group relative"
                       :class="sidebarCollapsed ? 'justify-center' : ''"
                       {{ request()->routeIs('assistant.reports.schedule') ? '' : 'hover:bg-white/5' }}>
                        @if(request()->routeIs('assistant.reports.schedule'))
                            <div class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-violet-500 rounded-r-full"></div>
                            <div class="absolute inset-0 bg-violet-500/10 rounded-lg"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('assistant.reports.schedule') ? 'text-violet-400' : 'text-gray-400 group-hover:text-gray-200' }}">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('assistant.reports.schedule') ? 'text-white' : 'text-gray-400 group-hover:text-gray-200' }}" :class="sidebarCollapsed ? 'hidden' : 'block'">
                            Daily Schedule
                        </span>
                    </a>
                </div>

                <!-- User Profile & Sidebar Toggle -->
                <div class="mt-auto border-t border-white/5 p-4 bg-black/10 flex-shrink-0">
                    <div class="flex items-center justify-between gap-3 mb-4 transition-all duration-300" :class="sidebarCollapsed ? 'flex-col' : ''">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-8 h-8 rounded-lg bg-violet-500/20 border border-violet-500/30 flex items-center justify-center flex-shrink-0 text-violet-400 font-bold text-xs">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 transition-opacity duration-300" :class="sidebarCollapsed ? 'hidden' : 'block'">
                                <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500 truncate">Assistant</p>
                            </div>
                        </div>
                        <button @click="sidebarCollapsed = !sidebarCollapsed" 
                                class="p-1.5 rounded-lg hover:bg-white/5 text-gray-500 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''">
                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-red-500/10 text-gray-500 hover:text-red-400 transition-all duration-200 group"
                                :class="sidebarCollapsed ? 'justify-center' : ''">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 flex-shrink-0 text-gray-500 group-hover:text-red-400 transition-colors">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-medium" :class="sidebarCollapsed ? 'hidden' : 'block'">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="bg-white border-b border-gray-200 h-16 flex items-center px-6 flex-shrink-0">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col">
                                <h2 class="text-lg font-bold text-gray-900 leading-tight">{{ $title ?? 'Assistant Dashboard' }}</h2>
                                <p class="text-xs text-gray-500 font-medium">{{ $subtitle ?? 'Manage patients and appointments' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-end">
                                <span class="text-xs font-bold text-gray-900">{{ now()->format('l, M j, Y') }}</span>
                                <span class="text-[10px] font-medium text-gray-500 uppercase tracking-wider">{{ now()->format('g:i A') }}</span>
                            </div>
                            
                            <div class="h-8 w-[1px] bg-gray-200"></div>
                            
                            <!-- Global Live Notifications -->
                            <x-notification-bell />

                            <div class="h-8 w-[1px] bg-gray-200"></div>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 hover:bg-gray-50 p-1 rounded-lg transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center text-violet-600 font-bold text-xs border border-violet-200 shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                    <p class="px-4 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Account</p>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium transition-colors">Profile Settings</a>
                                    <div class="my-1 border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 p-6 custom-scrollbar">
                    @if (session('success'))
                        <div class="mb-6 bg-white border border-emerald-100 p-4 rounded-xl shadow-sm flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-gray-900 text-sm font-semibold">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-white border border-red-100 p-4 rounded-xl shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-900 text-sm font-bold mb-1">Please check the following:</p>
                                    <ul class="list-disc list-inside text-red-600 text-xs font-medium space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
        
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        @stack('scripts')

        <!-- Global Toast Notification System -->
        <div id="toast-container" class="fixed top-6 right-6 z-[100] space-y-3"></div>

        <script>
            function showToast(message, type = 'success') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                const colors = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
                
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
