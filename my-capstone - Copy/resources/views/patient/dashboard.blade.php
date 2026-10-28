<x-patient-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Welcome back, {{ Auth::user()->name }}!</x-slot>

    <div class="space-y-8">
        <!-- Hero Banner -->
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-xl shadow-emerald-500/20">
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl text-center md:text-left">
                    <h2 class="text-3xl font-black tracking-tight mb-3">Need Medical Attention?</h2>
                    <p class="text-emerald-50 text-sm font-medium leading-relaxed opacity-90 mb-6">Book an appointment with our healthcare professionals in just a few clicks. Your health is our priority.</p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                        <a href="{{ route('patient.appointments.create') }}" class="px-6 py-3 bg-white text-emerald-700 text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                            Book Appointment Now
                        </a>
                        <a href="{{ route('patient.appointments.index') }}" class="px-6 py-3 bg-emerald-500/20 backdrop-blur-md border border-white/30 text-white text-sm font-bold rounded-xl hover:bg-emerald-500/30 transition-all duration-200">
                            My Schedule
                        </a>
                    </div>
                </div>
                <div class="w-48 h-48 bg-white/10 backdrop-blur-sm rounded-3xl flex items-center justify-center border border-white/20 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-32 h-32 text-white/40">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Upcoming</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">
                            {{ Auth::user()->patient?->appointments()->where('start_time', '>=', now())->where('status', '!=', 'cancelled')->count() ?? 0 }}
                        </p>
                        <p class="text-xs font-medium text-gray-400 mt-1">Scheduled Visits</p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9h-16.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Medical Records -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Records</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">
                            {{ Auth::user()->patient?->medicalRecords()->count() ?? 0 }}
                        </p>
                        <p class="text-xs font-medium text-gray-400 mt-1">Clinical Histories</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                            <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Prescriptions -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-violet-500 rounded-l-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Active</p>
                        <p class="text-3xl font-black text-gray-900 mt-1">0</p>
                        <p class="text-xs font-medium text-gray-400 mt-1">Prescriptions</p>
                    </div>
                    <div class="w-14 h-14 bg-violet-50 rounded-2xl flex items-center justify-center text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                            <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 003.814-6.883 6 6 0 00-11.314-9.62zM9.75 13.5a.75.75 0 111.5 0 .75.75 0 01-1.5 0zm0 3a.75.75 0 111.5 0 .75.75 0 01-1.5 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Quick Actions -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('patient.appointments.create') }}" class="flex flex-col items-center text-center p-4 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-emerald-50 hover:border-emerald-100 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm group-hover:bg-emerald-600 group-hover:text-white transition-all mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700">Book Appointment</span>
                        </a>

                        <a href="{{ route('patient.profile.show') }}" class="flex flex-col items-center text-center p-4 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-blue-50 hover:border-blue-100 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M18.75 12.75V12c0-1.253-.424-2.408-1.14-3.324a3 3 0 00-5.454 0 4.5 4.5 0 00-1.14 3.324v.75c0 .332.228.625.553.693l6.545 1.37a.75.75 0 00.836-.713zM6 18.75A3.375 3.375 0 012.625 15.375V6c0-.621.504-1.125 1.125-1.125h12.75c.621 0 1.125.504 1.125 1.125v1.242a4.47 4.47 0 00-1.5-.242H3.75v9.75a1.875 1.875 0 001.875 1.875h12.75A1.875 1.875 0 0020.25 18V9.25a4.47 4.47 0 00-1.5.242V18a3.375 3.375 0 01-3.375 3.375H6a3.375 3.375 0 01-3.375-3.375z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700">View Profile</span>
                        </a>

                        <a href="{{ route('patient.billing.index') }}" class="flex flex-col items-center text-center p-4 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-violet-50 hover:border-violet-100 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-violet-600 shadow-sm group-hover:bg-violet-600 group-hover:text-white transition-all mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700">View Billing</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Appointments -->
                @if(Auth::user()->patient?->appointments()->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 tracking-tight">Recent Activity</h3>
                        </div>
                        <a href="{{ route('patient.appointments.index') }}" class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest hover:text-emerald-700 transition-colors">View All</a>
                    </div>
                    <div class="p-2">
                        @foreach(Auth::user()->patient->appointments()->latest()->take(5)->get() as $appointment)
                        <div class="flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-emerald-600 transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9h-16.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">Dr. {{ $appointment->doctor->name }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $appointment->start_time->format('M d, Y') }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $appointment->start_time->format('g:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
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
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Health Tips/Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="text-sm font-bold text-gray-900 mb-4 tracking-tight">Clinic Schedule</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">Monday - Friday</span>
                            <span class="font-bold text-gray-900 uppercase">8:00 AM - 5:00 PM</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">Saturday</span>
                            <span class="font-bold text-gray-900 uppercase">8:00 AM - 12:00 PM</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">Sunday</span>
                            <span class="text-red-500 font-bold uppercase">Closed</span>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l.715 2.861a1.909 1.909 0 01-.935 2.175l-1.4 1.4a12.042 12.042 0 005.65 5.65l1.4-1.4c.64-.64 1.583-.854 2.315-.625l2.861.715c.834.21 1.42.96 1.42 1.819V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Support Line</p>
                                <p class="text-xs font-bold text-gray-900">+63 912 345 6789</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Profile Completion -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20">
                    <h4 class="font-bold text-lg mb-2">Complete Profile</h4>
                    <p class="text-xs text-blue-100 leading-relaxed mb-4 opacity-90">Ensure your medical information is up to date for better healthcare delivery.</p>
                    <a href="{{ route('patient.profile.edit') }}" class="inline-flex items-center gap-2 text-xs font-bold bg-white/20 hover:bg-white/30 backdrop-blur-md px-4 py-2 rounded-lg transition-all">
                        Update Profile
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-patient-layout>
