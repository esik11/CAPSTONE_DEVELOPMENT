<x-assistant-layout>
    <x-slot name="title">Daily Schedule Report</x-slot>
    <x-slot name="subtitle">Appointments scheduled for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('assistant.reports.schedule') }}" class="flex items-center gap-2">
            <input type="date" name="date" value="{{ $date }}" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 outline-none transition-all">
            <button type="submit" class="px-4 py-2 bg-violet-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-violet-700 transition-all shadow-sm">Filter</button>
        </form>

        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-violet-600 hover:text-white hover:border-violet-600 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm1 8H6v4h8v-4z" clip-rule="evenodd" />
            </svg>
            <span>Print Report</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden print:shadow-none print:border-none">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Patient</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Purpose / Reason</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-lg inline-block">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 uppercase">
                                    {{ $appointment->patient->last_name }}, {{ $appointment->patient->first_name }}
                                </div>
                                <div class="text-[10px] font-medium text-gray-400">
                                    {{ $appointment->patient->phone_number }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-700 font-medium line-clamp-2 max-w-md">
                                    {{ $appointment->reason ?? 'Routine Check-up' }}
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                                No appointments scheduled for this date.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Appointments: {{ count($appointments) }}</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Generated on {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            .print\:shadow-none { box-shadow: none !important; }
            .print\:border-none { border: none !important; }
            .bg-white { background-color: white !important; }
            main, main * { visibility: visible; }
            main { position: absolute; left: 0; top: 0; width: 100%; }
            header, nav, button, form, .mb-6 { display: none !important; }
        }
    </style>
</x-assistant-layout>
