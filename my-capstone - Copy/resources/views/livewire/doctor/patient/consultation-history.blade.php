<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Consultation History
            </h3>
            <span class="text-sm text-gray-500">{{ $consultations->count() }} completed</span>
        </div>
        <button onclick="document.getElementById('consultation-history-section').classList.add('hidden')" 
                class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @if($consultations->isEmpty())
        <div class="text-center py-8">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-500 text-sm">No completed consultations yet</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($consultations as $consultation)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-teal-300 hover:bg-teal-50 transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $consultation->consultation_date->format('M d, Y') }}
                                </span>
                                @if($consultation->consultation_time)
                                    <span class="text-xs text-gray-500">
                                        {{ $consultation->consultation_time->format('h:i A') }}
                                    </span>
                                @endif
                                <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium">
                                    Completed
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Dr. {{ $consultation->doctor->name }}</span>
                            </div>

                            @if($consultation->diagnoses && count($consultation->diagnoses) > 0)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Diagnoses:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($consultation->diagnoses as $diagnosis)
                                            <span class="inline-block px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs">
                                                {{ $diagnosis['description'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($consultation->selected_complaints && count($consultation->selected_complaints) > 0)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Chief Complaints:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($consultation->selected_complaints as $complaint)
                                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                                {{ $complaint }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2 ml-4">
                            <a href="{{ route('consultations.summary', $consultation) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </a>
                            <a href="{{ route('consultations.pdf', $consultation) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
