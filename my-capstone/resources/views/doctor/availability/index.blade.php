<x-doctor-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-violet-600">
                                <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        Clinical Schedule Painter
                    </h1>
                    <p class="text-gray-500 mt-2 text-sm max-w-2xl">
                        Design your weekly template by <span class="text-violet-600 font-bold">painting</span> clinical blocks on the grid. 
                        Click and drag to create slots, resize to adjust, or drag to move. 
                        Click an existing block to remove it.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em] mb-1">Current Schedule</p>
                        <p class="text-xs font-black text-gray-900 bg-white border border-gray-100 px-3 py-1.5 rounded-lg shadow-sm">
                            {{ now()->startOfWeek()->format('M d') }} - {{ now()->endOfWeek()->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

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

            <!-- Calendar Container -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden mb-8">
                <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-violet-500 rounded-sm"></div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Clinical Hours</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-gray-100 border border-gray-200 rounded-sm"></div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Unavailable</span>
                        </div>
                    </div>
                    <div class="text-[10px] font-bold text-violet-600 bg-violet-50 px-3 py-1 rounded-full uppercase tracking-tighter">
                        Interactive Grid Active
                    </div>
                </div>
                
                <div class="p-6">
                    <div id="availability-calendar" class="clinical-painter-calendar"></div>
                </div>
            </div>

            <!-- Form & Action Footer -->
            <form action="{{ route('doctor.availability.update') }}" method="POST">
                @csrf
                <!-- Hidden inputs will be injected here by JS -->
                <div id="slots-data-container" class="hidden"></div>

                <div class="bg-gray-900 rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl shadow-gray-900/20">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-violet-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold tracking-tight">Ready to publish?</h4>
                            <p class="text-gray-400 text-xs">Saving will update your clinical schedule for all Patients and Assistants.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <button type="button" onclick="location.reload()" class="flex-1 md:flex-none px-6 py-3 text-gray-400 hover:text-white font-bold text-xs uppercase tracking-widest transition-colors">
                            Discard Changes
                        </button>
                        <button type="submit" class="flex-1 md:flex-none px-10 py-4 bg-violet-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-violet-500 transition-all shadow-lg shadow-violet-600/30 active:scale-95">
                            Save Schedule
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Inject initial data for JS -->
    <script>
        @php
            $flattened = [];
            foreach($availabilities as $dayId => $slots) {
                foreach($slots as $slot) {
                    $flattened[] = [
                        'day_of_week' => $dayId,
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                    ];
                }
            }
        @endphp
        window.initialAvailabilities = @json($flattened);
    </script>

    <style>
        /* Professional Calendar Styling for Clinical Painter */
        .clinical-painter-calendar .fc-timegrid-slot {
            height: 40px !important;
        }
        .clinical-painter-calendar .fc-col-header-cell {
            padding: 15px 0 !important;
            background: #f8fafc;
        }
        .clinical-painter-calendar .fc-col-header-cell-cushion {
            text-decoration: none !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            color: #64748b !important;
        }
        .clinical-painter-calendar .fc-timegrid-event {
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .clinical-painter-calendar .fc-timegrid-event:hover {
            transform: scale(1.02);
            z-index: 10 !important;
        }
        .fc-v-event .fc-event-main {
            padding: 4px 8px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fc-v-event .fc-event-main::after {
            content: 'Clinical Block';
            font-size: 8px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.8;
        }
    </style>
</x-doctor-layout>
