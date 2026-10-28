<x-assistant-layout>
    <x-slot name="title">Appointments</x-slot>
    <x-slot name="subtitle">Manage today's clinical schedule</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <form method="GET" action="{{ route('assistant.appointments.index') }}" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-violet-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 transition-colors group-focus-within:text-violet-500">
                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v10.5A2.75 2.75 0 0115.25 20H4.75A2.75 2.75 0 012 17.25V6.75A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v8.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-8.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ $date }}"
                    onchange="this.form.submit()"
                    class="block w-full pl-9 pr-3 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all duration-200"
                >
            </form>

            <form method="GET" action="{{ route('assistant.appointments.index') }}" class="relative group">
                <input type="hidden" name="date" value="{{ $date }}">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-violet-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 transition-colors group-focus-within:text-violet-500">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.972.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                    </svg>
                </div>
                <select 
                    name="status" 
                    onchange="this.form.submit()"
                    class="block w-full pl-9 pr-8 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 appearance-none focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all duration-200"
                >
                    <option value="">All Statuses</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <!-- Doctor Availability Reference Panel -->
    @if($availabilities->isNotEmpty())
        <div class="mb-6 bg-emerald-50 border border-emerald-100 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-emerald-600">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-900 text-sm tracking-tight">Doctor's Clinical Availability</h3>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($date)->format('l, F d') }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($availabilities as $doctorId => $doctorAvailabilities)
                    @php $doctor = $doctorAvailabilities->first()->doctor; @endphp
                    <div class="bg-white rounded-xl border border-emerald-100/50 p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-2 mb-3 border-b border-gray-50 pb-2">
                            <div class="w-6 h-6 rounded bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shadow-sm">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-bold text-gray-900">Dr. {{ $doctor->name }}</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($doctorAvailabilities as $slot)
                                <div class="flex items-center gap-2 text-xs font-bold text-gray-600 bg-gray-50/80 hover:bg-emerald-50/50 transition-colors px-3 py-2 rounded-lg border border-gray-100">
                                    <div class="w-2 h-2 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50 animate-pulse"></div>
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mb-6 bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-6 text-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No Clinical Hours Scheduled for {{ \Carbon\Carbon::parse($date)->format('l') }}</p>
            <p class="text-[10px] text-gray-400 mt-1 font-medium">Any appointments booked today will be flagged as conflicts.</p>
        </div>
    @endif

    <!-- Requires Attention (Conflicts) -->
    @if(isset($conflicts) && $conflicts->isNotEmpty())
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4 px-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                <h3 class="font-bold text-gray-900 text-sm tracking-tight uppercase tracking-widest">Requires Attention ({{ $conflicts->count() }} Conflicts)</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                @foreach($conflicts as $appointment)
                    <div id="appointment-card-{{ $appointment->id }}" class="appointment-card-container bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-500 group">
                        <div class="p-5 flex flex-col md:flex-row items-center gap-6">
                            <!-- Status & Time -->
                            <div class="flex flex-col items-center justify-center min-w-[120px] p-3 bg-red-50 rounded-xl border border-red-100">
                                <span class="text-[9px] font-black text-red-600 uppercase tracking-widest mb-1">Out of Hours</span>
                                <span class="text-base font-black text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                                <span class="text-[9px] font-bold text-gray-400">{{ \Carbon\Carbon::parse($appointment->start_time)->format('M d, Y') }}</span>
                            </div>

                            <!-- Patient & Doctor Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                        {{ substr($appointment->patient->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-violet-600 transition-colors">{{ $appointment->patient->user->name }}</h4>
                                        <p class="text-[10px] text-gray-400 font-medium">Patient ID: #{{ str_pad($appointment->patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Assigned to:</span>
                                    <span class="text-[10px] font-black text-violet-600 bg-violet-50 px-2 py-0.5 rounded">Dr. {{ $appointment->doctor->name }}</span>
                                </div>
                            </div>

                            <!-- Conflict Reason -->
                            <div class="flex-1 max-w-sm">
                                <div class="flex items-start gap-2 p-3 bg-amber-50/50 border border-amber-100 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-[9px] font-black text-amber-700 uppercase tracking-widest mb-0.5">Availability Conflict</p>
                                        <p class="text-[10px] text-amber-800 leading-relaxed font-medium">
                                            Dr. {{ $appointment->doctor->name }} is not scheduled for clinical duties during this time block on {{ \Carbon\Carbon::parse($appointment->start_time)->format('l') }}s.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <button onclick="rescheduleConflict({{ $appointment->id }})" class="px-5 py-2.5 bg-violet-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-violet-700 transition-all shadow-md shadow-violet-600/20">
                                    Reschedule
                                </button>
                                <button onclick="cancelConflict({{ $appointment->id }})" class="px-4 py-2.5 bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-100 font-bold text-[9px] uppercase tracking-widest rounded-lg transition-all">
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Appointments Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                <h3 class="font-bold text-gray-900 tracking-tight">Schedule for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h3>
            </div>
            <span class="px-3 py-1 bg-violet-100 text-violet-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-violet-200">
                {{ $appointments->count() }} Appointments
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Time Slot</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Patient Details</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Purpose</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-lg w-fit">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}
                                    </span>
                                    <span class="text-[10px] font-medium text-gray-400 mt-1 pl-1">
                                        {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                                    </span>
                                    @if(!$appointment->isWithinDoctorAvailability())
                                        <div class="mt-2 flex items-center gap-1.5 px-2 py-1 bg-red-50 border border-red-100 rounded-lg w-fit" title="Outside Doctor's Availability">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-red-500">
                                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-[8px] font-black text-red-600 uppercase tracking-widest">Conflict</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                                        {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-violet-600 transition-colors">
                                            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-medium text-gray-400">ID: {{ str_pad($appointment->patient->id, 6, '0', STR_PAD_LEFT) }}</span>
                                            <span class="text-gray-300">•</span>
                                            <a href="{{ route('assistant.lab-results.index', ['patient_id' => $appointment->patient->id]) }}" 
                                               class="inline-flex items-center gap-1 text-[9px] font-bold text-violet-600 hover:text-violet-700 uppercase tracking-widest hover:underline">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-violet-500">
                                                    <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 01-.879 2.121l-2.377 2.377a9.845 9.845 0 015.091 1.013 8.315 8.315 0 005.713.636l.285-.071-3.954-3.955a3 3 0 01-.879-2.121v-5.02a23.614 23.614 0 00-3 0zm4.5.138a.75.75 0 00.093-1.495A24.837 24.837 0 0012 2.25a25.048 25.048 0 00-3.093.191A.75.75 0 009 3.936v4.882a1.5 1.5 0 01-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.471-4.881L15.44 9.879A1.5 1.5 0 0115 8.818V3.936z" clip-rule="evenodd" />
                                                </svg>
                                                Upload Labs
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-700 font-medium line-clamp-1 max-w-[200px]" title="{{ $appointment->reason }}">
                                    {{ $appointment->reason }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($appointment->status === 'pending')
                                        <button onclick="approveAppointment({{ $appointment->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-emerald-700 transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Approve</span>
                                        </button>
                                        <button onclick="cancelAppointment({{ $appointment->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                            <span>Decline</span>
                                        </button>
                                    @elseif($appointment->status === 'confirmed')
                                        <a href="{{ route('assistant.appointments.triage', $appointment) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-violet-700 transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                            </svg>
                                            <span>Triage & Check-in</span>
                                        </a>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 italic">No actions available</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-gray-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </div>
                                <h4 class="text-gray-900 font-bold tracking-tight">No appointments found</h4>
                                <p class="text-gray-400 text-xs mt-1 max-w-[250px] mx-auto">
                                    There are no appointments scheduled for this criteria.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reschedule Conflict Modal -->
    <div id="rescheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRescheduleModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-gray-900 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest">Reschedule Appointment</h3>
                    <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="rescheduleForm" onsubmit="submitReschedule(event)">
                    @csrf
                    <input type="hidden" id="reschedule_appointment_id">
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Select New Date</label>
                            <input type="date" id="new_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">New Start Time</label>
                                <input type="time" id="new_start" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">New End Time</label>
                                <input type="time" id="new_end" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                            </div>
                        </div>

                        <div class="bg-violet-50 p-4 rounded-2xl flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-violet-500 flex-shrink-0">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-[10px] text-violet-700 font-medium leading-relaxed">
                                Rescheduling will automatically notify the patient of the new time slot. Please ensure the new slot matches the doctor's clinical availability.
                            </p>
                        </div>
                    </div>

                    <div class="px-8 pb-8 flex gap-3">
                        <button type="button" onclick="closeRescheduleModal()" class="flex-1 py-3 bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-violet-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-violet-700 transition-all shadow-lg shadow-violet-600/20">
                            Confirm New Time
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function approveAppointment(id) {
        if (confirm('Approve this appointment?')) {
            fetch(`/assistant/appointments/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    function cancelAppointment(id) {
        if (confirm('Cancel this appointment?')) {
            fetch(`/assistant/appointments/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    function checkInAppointment(id) {
        if (confirm('Check in this patient?')) {
            fetch(`/assistant/appointments/${id}/check-in`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    // Auto-refresh when a new appointment notification comes in
    document.addEventListener('new-notification', () => {
        // We only reload if we're on the appointments page to get the latest schedule
        location.reload();
    });

    // Conflict Resolution Logic
    document.addEventListener('DOMContentLoaded', function() {
        const startInput = document.getElementById('new_start');
        const endInput = document.getElementById('new_end');
        
        if (startInput && endInput) {
            startInput.addEventListener('change', function() {
                if (this.value) {
                    const [hours, minutes] = this.value.split(':');
                    const startDate = new Date();
                    startDate.setHours(parseInt(hours), parseInt(minutes));
                    
                    // Add 1 hour
                    startDate.setHours(startDate.getHours() + 1);
                    
                    const endHours = String(startDate.getHours()).padStart(2, '0');
                    const endMinutes = String(startDate.getMinutes()).padStart(2, '0');
                    endInput.value = `${endHours}:${endMinutes}`;
                }
            });
        }
    });

    function rescheduleConflict(id) {
        document.getElementById('reschedule_appointment_id').value = id;
        document.getElementById('rescheduleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRescheduleModal() {
        document.getElementById('rescheduleModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function submitReschedule(e) {
        e.preventDefault();
        const id = document.getElementById('reschedule_appointment_id').value;
        const date = document.getElementById('new_date').value;
        const start = document.getElementById('new_start').value;
        const end = document.getElementById('new_end').value;

        if (!date || !start || !end) return;

        fetch(`/assistant/appointments/${id}/reschedule`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                start_time: `${date} ${start}`,
                end_time: `${date} ${end}`
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeRescheduleModal();
                const card = document.getElementById(`appointment-card-${id}`);
                if(card) card.remove();
                if (typeof showToast === 'function') showToast('Appointment Rescheduled Successfully');
                setTimeout(() => location.reload(), 1000);
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error rescheduling', 'error');
            }
        });
    }

    function cancelConflict(id) {
        if (confirm('Decline this appointment due to clinical conflict?')) {
            fetch(`/assistant/appointments/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById(`appointment-card-${id}`);
                    if(card) card.remove();
                    if (typeof showToast === 'function') showToast('Appointment Declined', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            });
        }
    }
    </script>
    @endpush
</x-assistant-layout>
