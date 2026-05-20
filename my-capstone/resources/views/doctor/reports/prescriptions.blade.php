<x-doctor-layout>
    <div class="py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Issued Prescriptions</h1>
                    <p class="text-gray-600 mt-2">Complete list of all prescriptions with medication details</p>
                </div>
                <a href="{{ route('doctor.reports.index') }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    ← Back to Reports
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('doctor.reports.prescriptions') }}" class="flex flex-wrap gap-4 items-end">
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
                    <a href="{{ route('doctor.reports.prescriptions') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Reset
                    </a>
                    <a href="{{ route('doctor.reports.prescriptions', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            @forelse($consultations as $consultation)
                @if($consultation->prescriptions && count($consultation->prescriptions) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <!-- Consultation Header -->
                        <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $consultation->patient->age }} yrs, {{ ucfirst($consultation->patient->sex) }} • 
                                    Consultation Date: {{ $consultation->consultation_date->format('M d, Y') }}
                                </p>
                                @if($consultation->diagnosis)
                                    <p class="text-sm text-gray-700 mt-2"><span class="font-medium">Diagnosis:</span> {{ $consultation->diagnosis }}</p>
                                @endif
                            </div>
                            <a href="{{ route('consultations.show', $consultation) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Consultation
                            </a>
                        </div>

                        <!-- Prescriptions List -->
                        <div class="space-y-3">
                            @foreach($consultation->prescriptions as $index => $prescription)
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-purple-700 font-semibold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $prescription['medicine_name'] }} {{ $prescription['strength'] }}</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2 text-sm">
                                            <div>
                                                <span class="text-gray-600">Dosage:</span>
                                                <span class="text-gray-900 font-medium ml-1">{{ $prescription['dosage'] }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Duration:</span>
                                                <span class="text-gray-900 font-medium ml-1">{{ $prescription['duration'] }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Quantity:</span>
                                                <span class="text-gray-900 font-medium ml-1">{{ $prescription['quantity'] }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Instructions:</span>
                                                <span class="text-gray-900 font-medium ml-1">{{ $prescription['instructions'] }}</span>
                                            </div>
                                        </div>
                                        @if(!empty($prescription['additional_instructions']))
                                            <p class="text-sm text-gray-600 mt-2 italic">{{ $prescription['additional_instructions'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-gray-500 text-lg">No prescriptions found</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($consultations->hasPages())
            <div class="mt-6">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>
</x-doctor-layout>
