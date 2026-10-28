<x-doctor-layout>
    <div class="py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Daily Consultation Logs</h1>
                    <p class="text-gray-600 mt-2">Detailed records of all completed consultations</p>
                </div>
                <a href="{{ route('doctor.reports.index') }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    ← Back to Reports
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('doctor.reports.consultations') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Filter
                    </button>
                    <a href="{{ route('doctor.reports.consultations') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Reset
                    </a>
                    <a href="{{ route('doctor.reports.consultations', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Chief Complaint</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diagnosis</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($consultations as $consultation)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $consultation->consultation_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium text-gray-900">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</div>
                                    <div class="text-gray-500">{{ $consultation->patient->age }} yrs, {{ ucfirst($consultation->patient->sex) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $consultation->appointment?->type === 'telemedicine' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $consultation->appointment?->type === 'telemedicine' ? 'Telemedicine' : 'Walk-in' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ Str::limit($consultation->chief_complaint, 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ Str::limit($consultation->diagnosis, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('consultations.show', $consultation) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p>No consultations found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($consultations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-doctor-layout>
