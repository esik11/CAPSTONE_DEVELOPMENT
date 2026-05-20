<x-assistant-layout>
    <x-slot name="title">Patient Roster Report</x-slot>
    <x-slot name="subtitle">Complete list of registered patients</x-slot>

    <div class="mb-6 flex justify-end">
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
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">No.</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Patient Name</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID / PhilHealth</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Contact</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registered Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($patients as $index => $patient)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-400">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 uppercase">
                                    {{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }}
                                </div>
                                <div class="text-[10px] font-medium text-gray-400">
                                    {{ $patient->gender }} • {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years Old
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-700">ID: {{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</div>
                                @if($patient->philhealth_number)
                                    <div class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">PH: {{ $patient->philhealth_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-700">{{ $patient->phone_number }}</div>
                                <div class="text-[10px] font-medium text-gray-400">{{ $patient->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-700">{{ $patient->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] font-medium text-gray-400">{{ $patient->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                                No patients registered in the system.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Patients: {{ count($patients) }}</p>
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
            header, nav, button, .mb-6 { display: none !important; }
        }
    </style>
</x-assistant-layout>
