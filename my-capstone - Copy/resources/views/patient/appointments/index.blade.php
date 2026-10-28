<x-patient-layout>
    <x-slot name="title">My Appointments</x-slot>
    <x-slot name="subtitle">View and manage your clinical schedule</x-slot>

    <div class="mt-6">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 p-4 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm border border-emerald-200">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-emerald-900 text-sm font-bold tracking-tight">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-100 p-4 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm border border-red-200">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-red-900 text-sm font-bold tracking-tight">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Book New Appointment
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Calendar & Timeline -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Calendar Component Placeholder -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 tracking-tight">Appointment Calendar</h3>
                    </div>
                </div>
                <div id="patient-calendar" class="min-h-[400px]"></div>
            </div>

            @php $pendingAppts = $appointments->where('status', 'pending'); @endphp
            @if($pendingAppts->count() > 0)
                <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                    <div class="relative flex items-start gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1">Approval in Progress</h4>
                            <p class="text-xs text-gray-500 leading-relaxed mb-4">We've received your request. The clinic assistant will review and confirm your slot shortly.</p>
                            
                            <div class="flex items-center gap-4">
                                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-500 w-2/3 rounded-full"></div>
                                </div>
                                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Reviewing</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Preparation Checklist -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 tracking-tight mb-6 flex items-center gap-2">
                    <div class="w-2 h-6 bg-blue-500 rounded-full"></div>
                    Pre-Visit Checklist
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 p-4 rounded-xl border border-gray-50 bg-gray-50/30">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Medical History</p>
                            <p class="text-[10px] text-gray-500 mt-1">List your current medications and dosages</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl border border-gray-50 bg-gray-50/30">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Symptoms Note</p>
                            <p class="text-[10px] text-gray-500 mt-1">Note down when your symptoms started</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Appointment List -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 tracking-tight">Appointments</h3>
                    <div class="flex gap-1 bg-gray-100 p-1 rounded-lg">
                        <button onclick="filterAppointments('upcoming')" class="filter-btn active px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider transition-all">Upcoming</button>
                        <button onclick="filterAppointments('all')" class="filter-btn px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider transition-all">All</button>
                    </div>
                </div>

                <div class="space-y-4 max-h-[calc(100vh-350px)] overflow-y-auto pr-2 custom-scrollbar" id="appointments-container">
                    @forelse($appointments as $appointment)
                        <div class="appointment-card group bg-white rounded-xl border border-gray-100 p-4 hover:border-emerald-100 hover:shadow-md transition-all relative overflow-hidden"
                             data-status="{{ $appointment->status }}"
                             data-date="{{ $appointment->start_time->format('Y-m-d') }}">
                            
                            @php
                                $accentColor = [
                                    'pending' => 'bg-amber-500',
                                    'confirmed' => 'bg-emerald-500',
                                    'checked_in' => 'bg-blue-500',
                                    'completed' => 'bg-gray-400',
                                    'cancelled' => 'bg-red-500',
                                ][$appointment->status] ?? 'bg-gray-300';
                            @endphp
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $accentColor }} opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-900 truncate group-hover:text-emerald-700 transition-colors">Dr. {{ $appointment->doctor->name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $appointment->start_time->format('M d') }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $appointment->start_time->format('h:i A') }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-2 line-clamp-1 italic">{{ $appointment->reason }}</p>
                                </div>
                                
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'checked_in' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'completed' => 'bg-gray-50 text-gray-600 border-gray-100',
                                        'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $currentClass = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border {{ $currentClass }}">
                                    {{ $appointment->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No Appointments</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .filter-btn { color: #9ca3af; }
        .filter-btn:hover { color: #4b5563; }
        .filter-btn.active { background-color: white; color: #10b981; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    </style>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('patient-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: [
                    @foreach($appointments as $appointment)
                    {
                        title: 'Dr. {{ $appointment->doctor->name }}',
                        start: '{{ $appointment->start_time->toIso8601String() }}',
                        end: '{{ $appointment->end_time->toIso8601String() }}',
                        color: '{{ $appointment->status === "confirmed" ? "#10b981" : ($appointment->status === "pending" ? "#f59e0b" : "#94a3b8") }}'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    if (info.event.url) {
                        window.location.href = info.event.url;
                        return false;
                    }
                }
            });
            calendar.render();
        });

        function filterAppointments(filter) {
            const cards = document.querySelectorAll('.appointment-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const today = new Date().toISOString().split('T')[0];

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            cards.forEach(card => {
                const status = card.dataset.status;
                const date = card.dataset.date;
                let show = false;

                if (filter === 'all') {
                    show = true;
                } else if (filter === 'upcoming') {
                    show = date >= today && status !== 'cancelled' && status !== 'completed';
                }

                card.style.display = show ? 'block' : 'none';
            });
        }
    </script>
    @endpush
</x-patient-layout>
