<x-patient-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 14.526a7.5 7.5 0 0110.364 0l4.432 4.432a.75.75 0 01-1.06 1.06l-4.432-4.432a6 6 0 00-8.284 0l-4.432 4.432a.75.75 0 01-1.06-1.06l4.432-4.432z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">
                        My Health Record
                    </h2>
                    <p class="text-sm text-gray-500">Your consolidated clinical history and wellness tracking</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        <!-- Vitals Highlights Grid -->
        @if($latestVitals)
        <div class="mb-2">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Latest Vitals Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Weight -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Weight</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->weight ?? '--' }} <span class="text-sm text-gray-500 font-normal">kg</span></p>
                    </div>
                </div>

                <!-- Blood Pressure -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-red-50 rounded-xl text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 14.526a7.5 7.5 0 0110.364 0M12 21a9.003 9.003 0 008.354-5.646.75.75 0 011.239-.23A9.002 9.002 0 0112 21z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Blood Pressure</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->systolic ?? '--' }}/{{ $latestVitals->diastolic ?? '--' }} <span class="text-sm text-gray-500 font-normal">mmHg</span></p>
                    </div>
                </div>

                <!-- Heart Rate -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-pink-50 rounded-xl text-pink-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 14.526a7.5 7.5 0 0110.364 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 14.526l4.432 4.432a6 6 0 008.284 0l-4.432-4.432z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Heart Rate</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->heart_rate ?? '--' }} <span class="text-sm text-gray-500 font-normal">bpm</span></p>
                    </div>
                </div>

                <!-- Temperature -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Temperature</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->temperature ?? '--' }} <span class="text-sm text-gray-500 font-normal">°C</span></p>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2 text-right">Last recorded: {{ $latestVitals->recorded_at->format('M d, Y h:i A') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Medical History -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Allergies Profile -->
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="bg-red-50/50 p-4 border-b border-red-100">
                        <h3 class="font-bold text-red-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Known Allergies
                        </h3>
                    </div>
                    <div class="p-4">
                        @if($allergies->count() > 0)
                            <ul class="space-y-3">
                                @foreach($allergies as $allergy)
                                <li class="flex items-start justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $allergy->allergen ?? $allergy->allergen_name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($allergy->type) ?? 'Unknown' }}</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                        {{ strtolower($allergy->severity) === 'severe' ? 'bg-red-100 text-red-700' : 
                                           (strtolower($allergy->severity) === 'moderate' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ $allergy->severity }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 italic py-2 text-center">No known allergies recorded.</p>
                        @endif
                    </div>
                </div>

                <!-- Active Medical Conditions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 p-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Active Conditions
                        </h3>
                    </div>
                    <div class="p-4">
                        @if($activeConditions->count() > 0)
                            <ul class="space-y-4">
                                @foreach($activeConditions as $condition)
                                <li class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold text-gray-900">{{ $condition->name }}</p>
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-medium rounded">Active</span>
                                    </div>
                                    @if($condition->pivot->notes)
                                        <p class="text-xs text-gray-600 line-clamp-2">{{ $condition->pivot->notes }}</p>
                                    @endif
                                    @if($condition->pivot->diagnosed_date)
                                        <p class="text-[10px] text-gray-400">Diagnosed: {{ \Carbon\Carbon::parse($condition->pivot->diagnosed_date)->format('M Y') }}</p>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 italic py-2 text-center">No active conditions recorded.</p>
                        @endif
                    </div>
                </div>

                <!-- Surgical & Hospital History -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 p-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Surgical & Hospital History
                        </h3>
                    </div>
                    <div class="p-4">
                        @if($surgicalHistories->count() > 0 || $hospitalizations->count() > 0)
                            <div class="space-y-4">
                                @if($surgicalHistories->count() > 0)
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Surgeries</h4>
                                        <ul class="space-y-2">
                                            @foreach($surgicalHistories as $surgery)
                                                <li class="text-sm">
                                                    <p class="font-medium text-gray-900">{{ $surgery->procedure }}</p>
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($surgery->date)->format('M Y') }} • {{ $surgery->hospital }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                @if($hospitalizations->count() > 0)
                                    @if($surgicalHistories->count() > 0)
                                        <div class="border-t border-gray-100 my-2"></div>
                                    @endif
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Hospitalizations</h4>
                                        <ul class="space-y-2">
                                            @foreach($hospitalizations as $hosp)
                                                <li class="text-sm">
                                                    <p class="font-medium text-gray-900">{{ $hosp->reason }}</p>
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($hosp->admission_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($hosp->discharge_date)->format('M d, Y') }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic py-2 text-center">No surgical or hospital history recorded.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Middle and Right Columns: Medications and Timeline -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Active Medications -->
                <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl shadow-sm border border-orange-200 overflow-hidden">
                    <div class="p-4 border-b border-orange-200 bg-white/50 backdrop-blur-sm">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Current Medications
                        </h3>
                    </div>
                    <div class="p-4">
                        @if($activeMedications->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($activeMedications as $med)
                                <div class="bg-white rounded-xl p-3 border border-orange-100 shadow-sm flex flex-col">
                                    <p class="font-semibold text-gray-900">{{ $med->medicine_name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $med->dosage }} • {{ $med->frequency }}</p>
                                    @if($med->instructions)
                                        <p class="text-xs text-orange-700 mt-2 bg-orange-50 p-2 rounded">{{ $med->instructions }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic py-2 text-center">No active medications recorded.</p>
                        @endif
                    </div>
                </div>

                <!-- Family & Lifestyle History -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 p-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Family & Lifestyle History
                        </h3>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Family History -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Family History</h4>
                            @if($familyHistories && $familyHistories->count() > 0)
                                <ul class="space-y-2">
                                    @foreach($familyHistories as $hx)
                                    <li class="flex items-start gap-2 text-sm">
                                        <span class="font-medium text-gray-900 w-24 flex-shrink-0">{{ $hx->relative }}:</span>
                                        <span class="text-gray-600">{{ $hx->condition }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500 italic">No family history recorded.</p>
                            @endif
                        </div>

                        <!-- Lifestyle -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Lifestyle</h4>
                            @if($socialHistory)
                                <ul class="space-y-2 text-sm">
                                    <li class="flex justify-between border-b border-gray-50 pb-1">
                                        <span class="text-gray-500">Smoking:</span>
                                        <span class="font-medium text-gray-900">{{ $socialHistory->smoking ?? 'Not recorded' }}</span>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-50 pb-1">
                                        <span class="text-gray-500">Alcohol:</span>
                                        <span class="font-medium text-gray-900">{{ $socialHistory->alcohol ?? 'Not recorded' }}</span>
                                    </li>
                                    <li class="flex justify-between border-b border-gray-50 pb-1">
                                        <span class="text-gray-500">Drug Use:</span>
                                        <span class="font-medium text-gray-900">{{ $socialHistory->drug_use ?? 'Not recorded' }}</span>
                                    </li>
                                </ul>
                            @else
                                <p class="text-sm text-gray-500 italic">No lifestyle information recorded.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Consultation Timeline -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Clinical Visit History
                    </h3>

                    @if($consultations->count() > 0)
                        <div class="relative border-l-2 border-blue-100 ml-3 space-y-8 pb-4">
                            @foreach($consultations as $consult)
                            <div class="relative pl-8">
                                <!-- Timeline Dot -->
                                <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px] top-1.5 ring-4 ring-white shadow-sm"></div>
                                
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 hover:border-blue-200 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $consult->visit_type ?? 'General Consultation' }}</h4>
                                            <p class="text-sm font-medium text-blue-600">Dr. {{ $consult->doctor->name }}</p>
                                        </div>
                                        <div class="text-right flex flex-col items-end gap-2">
                                            <div>
                                                <span class="block text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($consult->consultation_date)->format('M d, Y') }}</span>
                                                <span class="block text-xs text-gray-500">{{ \Carbon\Carbon::parse($consult->consultation_time)->format('h:i A') }}</span>
                                            </div>
                                            <a href="{{ route('patient.consultations.pdf', $consult) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white hover:bg-blue-50 border border-gray-200 hover:border-blue-200 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                Download PDF
                                            </a>
                                        </div>
                                    </div>
                                    
                                    @if($consult->diagnoses && count($consult->diagnoses) > 0)
                                    <div class="mt-4 bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Diagnoses</p>
                                        <ul class="list-disc list-inside text-sm text-gray-800 space-y-1">
                                            @foreach($consult->diagnoses as $diagnosis)
                                                <li>
                                                    {{ $diagnosis['description'] ?? $diagnosis['name'] ?? 'Unknown Diagnosis' }} 
                                                    @if(isset($diagnosis['code']) || isset($diagnosis['type'])) 
                                                        <span class="text-xs text-gray-400">({{ $diagnosis['code'] ?? $diagnosis['type'] }})</span> 
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if($consult->treatment_plan)
                                    <div class="mt-3 bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Treatment Plan</p>
                                        <p class="text-sm text-gray-800 leading-relaxed">{!! nl2br(e($consult->treatment_plan)) !!}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No past consultation history found.</p>
                            <p class="text-sm text-gray-400 mt-1">Your completed visits will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</x-patient-layout>
