<x-assistant-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Welcome back, {{ Auth::user()->name }}!</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Patients -->
        <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500 rounded-l-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_patients'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600">
                        <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.125a7.125 7.125 0 014.5-6.656.75.75 0 00-.508-1.403A8.625 8.625 0 0015.75 21H17.25z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-violet-500 rounded-l-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Today's Appt.</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['today_appointments'] }}</p>
                </div>
                <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-violet-600">
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9h-16.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 rounded-l-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Pending Appr.</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pending_appointments'] }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Checked In Today -->
        <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500 rounded-l-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Checked In</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['checked_in_today'] }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Quick Actions & Lists -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('assistant.patients.create') }}" class="group bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 tracking-tight">Register Patient</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Add a new patient record</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('assistant.appointments.index') }}" class="group bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9h-16.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 tracking-tight">Manage Appointments</h3>
                            <p class="text-xs text-gray-500 mt-0.5">View today's schedule</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Today's Appointments List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 tracking-tight">Today's Appointments</h3>
                    </div>
                    <a href="{{ route('assistant.appointments.index') }}" class="text-[10px] font-bold text-violet-600 uppercase tracking-widest hover:text-violet-700 transition-colors">View All</a>
                </div>

                <div class="p-2">
                    @forelse($todayAppointments->take(5) as $appointment)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs border border-gray-200">
                                    {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-[10px] font-medium text-gray-400 truncate max-w-[150px]">{{ $appointment->reason }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'confirmed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'checked_in' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'in_progress' => 'bg-violet-50 text-violet-600 border-violet-100',
                                        'completed' => 'bg-gray-50 text-gray-600 border-gray-100',
                                        'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $currentClass = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border {{ $currentClass }}">
                                    {{ str_replace('_', ' ', $appointment->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-bold text-sm">No appointments today</p>
                            <p class="text-gray-400 text-xs mt-1">Check back later or register a patient</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

            <!-- Recent Patients (Mockup/Small List) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-900 tracking-tight mb-4">Quick Links</h3>
                <div class="space-y-2">
                    <a href="{{ route('assistant.patients.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-50 hover:bg-violet-50 hover:border-violet-100 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 group-hover:bg-violet-100 group-hover:text-violet-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-violet-700 transition-colors">Patient Directory</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-assistant-layout>
