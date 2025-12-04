<div class="space-y-4 sticky top-24">
    @if($activeView === 'executive')
        <!-- EXECUTIVE SUMMARY VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
        <!-- Patient Demographics -->
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Patient Information</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">MRN:</span>
                <span class="font-medium text-gray-900">{{ $patient->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Age:</span>
                <span class="font-medium text-gray-900">{{ $patient->age }} years</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Gender:</span>
                <span class="font-medium text-gray-900">{{ ucfirst($patient->gender) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Contact:</span>
                <span class="font-medium text-gray-900">{{ $patient->phone_number }}</span>
            </div>
        </div>
    </div>

    <!-- Latest Vitals -->
    @if($latestVitals)
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Latest Vitals</h3>
            <div class="grid grid-cols-2 gap-3 text-sm">
                @if($latestVitals->blood_pressure_systolic && $latestVitals->blood_pressure_diastolic)
                    <div>
                        <span class="text-gray-500 block">BP</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->blood_pressure_systolic }}/{{ $latestVitals->blood_pressure_diastolic }}</span>
                    </div>
                @endif
                @if($latestVitals->heart_rate)
                    <div>
                        <span class="text-gray-500 block">HR</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->heart_rate }} bpm</span>
                    </div>
                @endif
                @if($latestVitals->temperature)
                    <div>
                        <span class="text-gray-500 block">Temp</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->temperature }}°C</span>
                    </div>
                @endif
                @if($latestVitals->respiratory_rate)
                    <div>
                        <span class="text-gray-500 block">RR</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->respiratory_rate }}/min</span>
                    </div>
                @endif
                @if($latestVitals->weight)
                    <div>
                        <span class="text-gray-500 block">Weight</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->weight }} kg</span>
                    </div>
                @endif
                @if($latestVitals->height)
                    <div>
                        <span class="text-gray-500 block">Height</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->height }} cm</span>
                    </div>
                @endif
            </div>
            <p class="text-xs text-gray-400 mt-2">
                Recorded {{ $latestVitals->created_at->diffForHumans() }}
            </p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Latest Vitals</h3>
            <p class="text-sm text-gray-500">No vitals recorded</p>
        </div>
    @endif

    <!-- Allergies (Critical) -->
    <div class="bg-red-50 border-2 border-red-200 rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-semibold text-red-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Allergies
            </h3>
            <button wire:click="openAllergyModal" 
                    class="text-xs text-red-600 hover:text-red-700 font-medium">
                + Add
            </button>
        </div>
        @if($allergies && $allergies->count() > 0)
            <div class="space-y-2">
                @foreach($allergies as $allergy)
                    <div class="bg-white rounded px-3 py-2 border border-red-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $allergy->allergen_name }}</p>
                                <p class="text-xs text-gray-600">{{ ucfirst($allergy->type) }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded
                                {{ $allergy->severity === 'severe' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $allergy->severity === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $allergy->severity === 'mild' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($allergy->severity) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-600">No known allergies</p>
        @endif
    </div>

    <!-- Active Conditions -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-600 fill-current" viewBox="0 0 24 24">
                    <path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z" />
                </svg>
                Pinned Conditions
            </h3>
            <button wire:click="openConditionModal" 
                    class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                + Add
            </button>
        </div>
        @php
            $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $patient->id)->latest()->first();
            $pinnedConditions = collect();
            if ($medicalRecord) {
                $pinnedConditions = \App\Models\MedicalCondition::whereHas('medicalRecords', function ($query) use ($medicalRecord) {
                    $query->where('medical_record_id', $medicalRecord->id)
                          ->where('status', 'active')
                          ->where('is_pinned', 1);
                })
                ->with(['medicalRecords' => function ($query) use ($medicalRecord) {
                    $query->where('medical_record_id', $medicalRecord->id);
                }])
                ->get()
                ->map(function ($condition) use ($medicalRecord) {
                    $pivot = \DB::table('patient_conditions')
                        ->where('medical_record_id', $medicalRecord->id)
                        ->where('condition_id', $condition->id)
                        ->first();
                    if ($pivot) {
                        $condition->pivot = $pivot;
                    }
                    return $condition;
                });
            }
        @endphp
        @if($pinnedConditions->count() > 0)
            <div class="space-y-2">
                @foreach($pinnedConditions as $condition)
                    <div class="text-sm p-2 bg-yellow-50 rounded border border-yellow-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $condition->condition_name }}</p>
                                @if($condition->pivot && $condition->pivot->notes)
                                    <p class="text-gray-600 text-xs mt-1">{{ $condition->pivot->notes }}</p>
                                @endif
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">No pinned conditions</p>
        @endif
    </div>

    <!-- Active Medications -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-semibold text-gray-900">Active Medications</h3>
            <button wire:click="openMedicationModal" 
                    class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                + Add
            </button>
        </div>
        @php
            $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $patient->id)->latest()->first();
            $medications = $medicalRecord ? $medicalRecord->medications : collect();
        @endphp
        @if($medications->count() > 0)
            <div class="space-y-2">
                @foreach($medications->take(5) as $med)
                    <div class="text-sm">
                        <p class="font-medium text-gray-900">{{ $med->medicine_name }}</p>
                        <p class="text-gray-600 text-xs">{{ $med->dosage }} - {{ $med->frequency }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">No active medications</p>
        @endif
    </div>

    <!-- Recent Consultations -->
    @if($recentConsultations && $recentConsultations->count() > 0)
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Recent Visits</h3>
            <div class="space-y-2">
                @foreach($recentConsultations as $consultation)
                    <div class="text-sm border-l-2 border-blue-500 pl-3 py-1">
                        <p class="text-gray-900 font-medium">
                            {{ $consultation->consultation_date->format('M d, Y') }}
                        </p>
                        @if($consultation->selected_complaints)
                            <p class="text-xs text-gray-500">
                                {{ implode(', ', array_slice($consultation->selected_complaints, 0, 2)) }}
                                @if(count($consultation->selected_complaints) > 2)
                                    +{{ count($consultation->selected_complaints) - 2 }} more
                                @endif
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    </div>

    @elseif($activeView === 'consultation')
        <!-- CONSULTATION NOTES VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
        
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Consultation Summary</h3>
            
            <!-- Symptoms Section -->
            @if($consultation && $consultation->selected_complaints && count($consultation->selected_complaints) > 0)
                <div class="mb-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-left mb-2">
                        <h4 class="text-sm font-semibold text-gray-900">Symptoms</h4>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="space-y-2">
                        <!-- Visit Type -->
                        @if($consultation->visit_type)
                            <div class="text-xs">
                                <span class="font-medium text-gray-700">Visit Type:</span>
                                <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $consultation->visit_type)) }}</span>
                            </div>
                        @endif

                        <!-- Chief Complaints -->
                        <div>
                            <p class="text-xs font-medium text-gray-700 mb-1">Chief Complaints:</p>
                            <div class="space-y-1">
                                @foreach($consultation->selected_complaints as $complaint)
                                    <div class="text-xs text-gray-900 pl-2 border-l-2 border-blue-400">
                                        {{ $complaint }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Template Responses -->
                        @if($consultation->template_responses && count($consultation->template_responses) > 0)
                            <div class="mt-2 space-y-1">
                                @foreach($consultation->template_responses as $complaint => $responses)
                                    @if(is_array($responses) && count($responses) > 0)
                                        <div class="text-xs">
                                            <p class="font-medium text-gray-700">{{ $complaint }}:</p>
                                            <ul class="pl-3 space-y-0.5 text-gray-600">
                                                @foreach($responses as $question => $answer)
                                                    @if($answer)
                                                        <li class="text-xs">• {{ $question }}: <span class="text-gray-900">{{ is_array($answer) ? implode(', ', $answer) : $answer }}</span></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Duration & Onset -->
                        @if($consultation->symptom_duration || $consultation->symptom_onset)
                            <div class="text-xs space-y-1 mt-2">
                                @if($consultation->symptom_duration)
                                    <div>
                                        <span class="font-medium text-gray-700">Duration:</span>
                                        <span class="text-gray-900">{{ $consultation->symptom_duration }} {{ $consultation->symptom_duration_unit ?? 'days' }}</span>
                                    </div>
                                @endif
                                @if($consultation->symptom_onset)
                                    <div>
                                        <span class="font-medium text-gray-700">Onset:</span>
                                        <span class="text-gray-900">{{ ucfirst($consultation->symptom_onset) }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Symptom Notes -->
                        @if($consultation->symptom_notes_final)
                            <div class="mt-2 p-2 bg-gray-50 rounded text-xs">
                                <p class="font-medium text-gray-700 mb-1">Clinical Notes:</p>
                                <div class="text-gray-900 prose prose-sm max-w-none">
                                    {!! $consultation->symptom_notes_final !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-xs text-gray-500 italic mb-4">
                    No symptoms documented yet
                </div>
            @endif

            <!-- Examination Section -->
            @if($consultation && ($consultation->temperature || $consultation->general_appearance))
                <div class="mb-4 pt-3 border-t" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-left mb-2">
                        <h4 class="text-sm font-semibold text-gray-900">Examination</h4>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="space-y-2">
                        <!-- Vital Signs -->
                        @if($consultation->temperature || $consultation->pulse_rate || $consultation->blood_pressure)
                            <div class="text-xs">
                                <p class="font-medium text-gray-700 mb-1">Vital Signs:</p>
                                <div class="grid grid-cols-2 gap-1 text-gray-600">
                                    @if($consultation->temperature)
                                        <div>Temp: <span class="text-gray-900">{{ $consultation->temperature }}°C</span></div>
                                    @endif
                                    @if($consultation->pulse_rate)
                                        <div>HR: <span class="text-gray-900">{{ $consultation->pulse_rate }} bpm</span></div>
                                    @endif
                                    @if($consultation->blood_pressure)
                                        <div>BP: <span class="text-gray-900">{{ $consultation->blood_pressure }}</span></div>
                                    @endif
                                    @if($consultation->respiratory_rate)
                                        <div>RR: <span class="text-gray-900">{{ $consultation->respiratory_rate }}/min</span></div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- General Appearance -->
                        @if($consultation->general_appearance)
                            <div class="text-xs">
                                <p class="font-medium text-gray-700">General:</p>
                                <div class="text-gray-900 prose prose-sm max-w-none">
                                    {!! $consultation->general_appearance !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Session Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-blue-900 mb-3">Session Info</h3>
            <div class="space-y-2 text-sm">
                @if($consultation)
                    <div class="flex justify-between">
                        <span class="text-blue-700">Date:</span>
                        <span class="font-medium text-blue-900">{{ $consultation->consultation_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Section:</span>
                        <span class="font-medium text-blue-900">{{ ucfirst($consultation->current_section ?? 'symptoms') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Status:</span>
                        <span class="px-2 py-1 text-xs font-medium 
                            {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </div>
                @else
                    <p class="text-xs text-blue-700">No active consultation</p>
                @endif
            </div>
        </div>
        </div>

    @elseif($activeView === 'alerts')
        <!-- ALERTS & WARNINGS VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold text-red-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Critical Alerts
            </h3>
            
            <!-- Allergies Alert -->
            @if($allergies && $allergies->count() > 0)
                <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4 mb-4">
                    <h4 class="text-sm font-bold text-red-900 mb-2">⚠️ ALLERGIES</h4>
                    <div class="space-y-2">
                        @foreach($allergies as $allergy)
                            <div class="bg-white rounded px-3 py-2 border-l-4 border-red-500">
                                <p class="text-sm font-bold text-red-900">{{ $allergy->allergen_name }}</p>
                                <p class="text-xs text-red-700">{{ ucfirst($allergy->type) }} - {{ ucfirst($allergy->severity) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-green-800">✓ No known allergies</p>
                </div>
            @endif

            <!-- Drug Interactions Warning -->
            @if($activeMedications && $activeMedications->count() > 1)
                <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4">
                    <h4 class="text-sm font-bold text-yellow-900 mb-2">⚠️ Multiple Medications</h4>
                    <p class="text-xs text-yellow-800">Patient is on {{ $activeMedications->count() }} medications. Check for interactions.</p>
                </div>
            @endif
        </div>
        </div>

    @elseif($activeView === 'vitals')
        <!-- VITALS VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vital Signs</h3>
            
            @if($latestVitals)
                <div class="space-y-4">
                    <!-- Blood Pressure -->
                    @if($latestVitals->blood_pressure_systolic && $latestVitals->blood_pressure_diastolic)
                        <div class="border-l-4 border-blue-500 pl-3">
                            <p class="text-xs text-gray-500">Blood Pressure</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $latestVitals->blood_pressure_systolic }}/{{ $latestVitals->blood_pressure_diastolic }}
                            </p>
                            <p class="text-xs text-gray-500">mmHg</p>
                        </div>
                    @endif

                    <!-- Heart Rate -->
                    @if($latestVitals->heart_rate)
                        <div class="border-l-4 border-red-500 pl-3">
                            <p class="text-xs text-gray-500">Heart Rate</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->heart_rate }}</p>
                            <p class="text-xs text-gray-500">bpm</p>
                        </div>
                    @endif

                    <!-- Temperature -->
                    @if($latestVitals->temperature)
                        <div class="border-l-4 border-orange-500 pl-3">
                            <p class="text-xs text-gray-500">Temperature</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->temperature }}</p>
                            <p class="text-xs text-gray-500">°C</p>
                        </div>
                    @endif

                    <!-- Respiratory Rate -->
                    @if($latestVitals->respiratory_rate)
                        <div class="border-l-4 border-green-500 pl-3">
                            <p class="text-xs text-gray-500">Respiratory Rate</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $latestVitals->respiratory_rate }}</p>
                            <p class="text-xs text-gray-500">/min</p>
                        </div>
                    @endif

                    <!-- Weight & Height -->
                    <div class="grid grid-cols-2 gap-3">
                        @if($latestVitals->weight)
                            <div class="border-l-4 border-purple-500 pl-3">
                                <p class="text-xs text-gray-500">Weight</p>
                                <p class="text-xl font-bold text-gray-900">{{ $latestVitals->weight }}</p>
                                <p class="text-xs text-gray-500">kg</p>
                            </div>
                        @endif
                        @if($latestVitals->height)
                            <div class="border-l-4 border-indigo-500 pl-3">
                                <p class="text-xs text-gray-500">Height</p>
                                <p class="text-xl font-bold text-gray-900">{{ $latestVitals->height }}</p>
                                <p class="text-xs text-gray-500">cm</p>
                            </div>
                        @endif
                    </div>

                    <p class="text-xs text-gray-400 text-center pt-2 border-t">
                        Recorded {{ $latestVitals->created_at->diffForHumans() }}
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-8">No vitals recorded</p>
            @endif
        </div>
        </div>
    @endif
</div>
