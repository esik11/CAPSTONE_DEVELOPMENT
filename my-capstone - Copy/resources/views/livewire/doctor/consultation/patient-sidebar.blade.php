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
    @if($consultation->blood_pressure || $consultation->pulse_rate || $consultation->temperature || $consultation->weight)
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Today's Vitals</h3>
            <div class="grid grid-cols-2 gap-3 text-sm">
                @if($consultation->blood_pressure)
                    <div>
                        <span class="text-gray-500 block">BP</span>
                        <span class="font-medium text-gray-900">{{ $consultation->blood_pressure }} mmHg</span>
                    </div>
                @endif
                @if($consultation->pulse_rate)
                    <div>
                        <span class="text-gray-500 block">HR</span>
                        <span class="font-medium text-gray-900">{{ $consultation->pulse_rate }} bpm</span>
                    </div>
                @endif
                @if($consultation->temperature)
                    <div>
                        <span class="text-gray-500 block">Temp</span>
                        <span class="font-medium text-gray-900">{{ $consultation->temperature }}°C</span>
                    </div>
                @endif
                @if($consultation->respiratory_rate)
                    <div>
                        <span class="text-gray-500 block">RR</span>
                        <span class="font-medium text-gray-900">{{ $consultation->respiratory_rate }}/min</span>
                    </div>
                @endif
                @if($consultation->weight)
                    <div>
                        <span class="text-gray-500 block">Weight</span>
                        <span class="font-medium text-gray-900">{{ $consultation->weight }} kg</span>
                    </div>
                @endif
                @if($consultation->height)
                    <div>
                        <span class="text-gray-500 block">Height</span>
                        <span class="font-medium text-gray-900">{{ $consultation->height }} cm</span>
                    </div>
                @endif
            </div>
            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-widest">
                Taken during triage
            </p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Today's Vitals</h3>
            <p class="text-sm text-gray-500">No vitals recorded yet</p>
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
                @foreach($recentConsultations as $consultationItem)
                    <button wire:click="viewPastConsultation({{ $consultationItem->id }})" 
                            class="w-full text-left text-sm border-l-2 border-blue-500 pl-3 py-2 hover:bg-blue-50 transition-colors group">
                        <p class="text-gray-900 font-bold group-hover:text-blue-700">
                            {{ $consultationItem->consultation_date->format('M d, Y') }}
                        </p>
                        @if($consultationItem->selected_complaints)
                            <p class="text-[10px] text-gray-500 line-clamp-1">
                                {{ implode(', ', array_slice($consultationItem->selected_complaints, 0, 2)) }}
                            </p>
                        @endif
                    </button>
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
                    @if($consultation->followup_date)
                        <div class="flex justify-between">
                            <span class="text-blue-700">Follow-up:</span>
                            <span class="font-medium text-blue-900">{{ $consultation->followup_date->format('M d, Y') }}</span>
                        </div>
                    @endif
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Vital Signs</h3>
                <span class="px-2 py-1 bg-violet-100 text-violet-700 text-[9px] font-black uppercase tracking-widest rounded-md">Triage Data</span>
            </div>
            
            <div class="p-4">
                @php
                    $prev = $recentConsultations->first();
                @endphp

                @if($consultation->blood_pressure || $consultation->pulse_rate || $consultation->temperature || $consultation->weight)
                    <div class="space-y-3">
                        <!-- Blood Pressure -->
                        <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-blue-200 hover:shadow transition-all group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-4 bg-blue-500 rounded-full"></div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-blue-600 transition-colors">Blood Pressure</span>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">mmHg</span>
                            </div>
                            <div class="flex items-end justify-between pl-3.5">
                                <div>
                                    <p class="text-xl font-black text-gray-900 leading-none">{{ $consultation->blood_pressure ?? '--' }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest mt-1.5">Current</p>
                                </div>
                                @if($prev && $prev->blood_pressure)
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-400 leading-none">{{ $prev->blood_pressure }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last ({{ $prev->consultation_date->format('M d') }})</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Heart Rate -->
                        <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-red-200 hover:shadow transition-all group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-4 bg-red-500 rounded-full"></div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-red-600 transition-colors">Heart Rate</span>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">bpm</span>
                            </div>
                            <div class="flex items-end justify-between pl-3.5">
                                <div>
                                    <p class="text-xl font-black text-gray-900 leading-none">{{ $consultation->pulse_rate ?? '--' }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest mt-1.5">Current</p>
                                </div>
                                @if($prev && $prev->pulse_rate)
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-400 leading-none">{{ $prev->pulse_rate }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last ({{ $prev->consultation_date->format('M d') }})</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Temperature -->
                        <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-orange-200 hover:shadow transition-all group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-4 bg-orange-500 rounded-full"></div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-orange-600 transition-colors">Temperature</span>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">°C</span>
                            </div>
                            <div class="flex items-end justify-between pl-3.5">
                                <div>
                                    <p class="text-xl font-black text-gray-900 leading-none">{{ $consultation->temperature ?? '--' }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest mt-1.5">Current</p>
                                </div>
                                @if($prev && $prev->temperature)
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-400 leading-none">{{ $prev->temperature }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last ({{ $prev->consultation_date->format('M d') }})</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Respiratory Rate -->
                        <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-emerald-200 hover:shadow transition-all group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-emerald-600 transition-colors">Resp. Rate</span>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">/min</span>
                            </div>
                            <div class="flex items-end justify-between pl-3.5">
                                <div>
                                    <p class="text-xl font-black text-gray-900 leading-none">{{ $consultation->respiratory_rate ?? '--' }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest mt-1.5">Current</p>
                                </div>
                                @if($prev && $prev->respiratory_rate)
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-400 leading-none">{{ $prev->respiratory_rate }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last ({{ $prev->consultation_date->format('M d') }})</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Weight -->
                            <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-purple-200 hover:shadow transition-all group">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-purple-600 transition-colors">Weight</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">kg</span>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-gray-900 leading-none">{{ $consultation->weight ?? '--' }}</p>
                                    @if($prev && $prev->weight)
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last: {{ $prev->weight }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Height -->
                            <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:border-indigo-200 hover:shadow transition-all group">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Height</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">cm</span>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-gray-900 leading-none">{{ $consultation->height ?? '--' }}</p>
                                    @if($prev && $prev->height)
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1.5">Last: {{ $prev->height }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-8 text-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No vitals recorded yet</p>
                    </div>
                @endif
            </div>
        </div>

    @elseif($activeView === 'labs')
        <!-- LABS & IMAGING VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-purple-900">Labs & Imaging</h3>
                    <button type="button" 
                            wire:click="$dispatch('open-lab-upload-modal', { patientId: {{ $patient->id }}, consultationId: {{ $consultation->id ?? 'null' }} })"
                            class="px-3 py-1.5 text-xs font-bold text-white bg-purple-600 rounded-lg hover:bg-purple-700 shadow-sm transition-transform active:scale-95">
                        + Upload Result
                    </button>
                </div>

                @if($diagnosticTests && $diagnosticTests->count() > 0)
                    <div class="space-y-3">
                        @foreach($diagnosticTests as $test)
                            <div wire:click="viewLabDetail({{ $test->id }})" 
                                 class="p-3 rounded-lg border-2 cursor-pointer transition-all hover:shadow-md active:scale-95 {{ $test->status === 'resulted' ? 'border-green-100 bg-green-50' : 'border-gray-100 bg-gray-50' }}">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-black uppercase tracking-tighter {{ $test->category === 'imaging' ? 'text-indigo-600' : 'text-purple-600' }}">
                                        {{ $test->category }}
                                    </span>
                                    <span class="px-1.5 py-0.5 text-[9px] font-bold rounded uppercase
                                        {{ $test->status === 'resulted' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $test->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                        {{ $test->status === 'requested' ? 'bg-blue-200 text-blue-800' : '' }}">
                                        {{ $test->status }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-900">{{ $test->test_name }}</h4>
                                <p class="text-[10px] text-gray-500">Ordered: {{ $test->requested_at->format('M d, Y') }}</p>
                                
                                @if($test->results_findings)
                                    <div class="mt-2 text-xs text-gray-700 bg-white p-2 rounded border border-gray-200 line-clamp-2">
                                        {{ $test->results_findings }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 text-purple-600 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">No diagnostic tests recorded yet.</p>
                        <p class="text-xs text-gray-400 mt-1">Orders placed during consultation will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    @elseif($activeView === 'lab_detail' && $viewingLab)
        <!-- LAB DETAIL VIEW -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
            
            <div class="bg-white rounded-lg shadow-lg border-2 border-purple-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-purple-600 px-4 py-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-purple-100 uppercase tracking-widest">{{ $viewingLab->category }}</h3>
                        <p class="text-sm font-bold text-white">{{ $viewingLab->test_name }}</p>
                    </div>
                    <button wire:click="closeLabDetail" class="text-white hover:text-purple-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4 space-y-4 max-h-[70vh] overflow-y-auto">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</span>
                        <p class="text-sm font-bold {{ $viewingLab->status === 'resulted' ? 'text-green-600' : 'text-blue-600' }}">
                            {{ strtoupper($viewingLab->status) }}
                        </p>
                    </div>

                    @if($viewingLab->results_findings)
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Results / Findings</span>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm text-gray-900 whitespace-pre-wrap font-mono">
                                {{ $viewingLab->results_findings }}
                            </div>
                        </div>
                    @endif

                    @if($viewingLab->request_notes)
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Request Notes</span>
                            <p class="text-xs text-gray-600 italic mt-1">{{ $viewingLab->request_notes }}</p>
                        </div>
                    @endif

                    @if($viewingLab->attachment_path)
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Attachment</span>
                            @php
                                $extension = strtolower(pathinfo($viewingLab->attachment_path, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp

                            @if($isImage)
                                <div class="relative group overflow-hidden rounded-xl border border-gray-200 bg-gray-50 shadow-inner">
                                    <img src="{{ asset('storage/' . $viewingLab->attachment_path) }}" 
                                         alt="{{ $viewingLab->test_name }}" 
                                         class="w-full h-auto object-cover max-h-60 rounded-xl transition-transform duration-300 hover:scale-105">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                        <a href="{{ asset('storage/' . $viewingLab->attachment_path) }}" 
                                           target="_blank" 
                                           class="px-3 py-1.5 bg-white text-gray-900 rounded-lg text-xs font-bold shadow-md hover:bg-gray-100 transition-all flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Open Full View
                                        </a>
                                    </div>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $viewingLab->attachment_path) }}" 
                                   target="_blank" 
                                   class="flex items-center gap-3 p-3 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl text-red-700 transition-all group">
                                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-red-500 shadow-sm group-hover:scale-105 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold truncate">View Lab PDF Document</p>
                                        <p class="text-[10px] text-red-500/80 font-semibold uppercase tracking-wider">PDF Document</p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-red-400 group-hover:translate-x-0.5 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="pt-4 border-t border-gray-100 flex justify-between text-[10px] text-gray-500 font-medium">
                        <span>Ordered: {{ $viewingLab->requested_at->format('M d, Y') }}</span>
                        @if($viewingLab->resulted_at)
                            <span>Resulted: {{ $viewingLab->resulted_at->format('M d, Y') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-4 py-2 border-t border-gray-100">
                    <button wire:click="closeLabDetail" class="w-full text-center text-xs font-bold text-purple-600 hover:text-purple-700">
                        ← Back to Lab List
                    </button>
                </div>
            </div>
        </div>
    @elseif($activeView === 'history_detail' && $viewingConsultation)
        <!-- PAST CONSULTATION DETAIL VIEW (DUAL-VIEW) -->
        <div 
            x-data 
            x-init="$el.style.opacity = '0'; $el.style.transform = 'translateX(20px)'; setTimeout(() => { $el.style.transition = 'all 0.3s ease-out'; $el.style.opacity = '1'; $el.style.transform = 'translateX(0)'; }, 10)">
            
            <div class="bg-white rounded-lg shadow-lg border-2 border-blue-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-600 px-4 py-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-blue-100 uppercase tracking-widest">Past Consultation</h3>
                        <p class="text-sm font-bold text-white">{{ $viewingConsultation->consultation_date->format('M d, Y') }}</p>
                    </div>
                    <button wire:click="closeHistoryDetail" class="text-white hover:text-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    <!-- Summary content (Reusing the summary style) -->
                    <div class="space-y-4">
                        <!-- Symptoms -->
                        @if($viewingConsultation->selected_complaints)
                            <div class="border-b border-gray-100 pb-3">
                                <h4 class="text-[10px] font-black text-gray-400 uppercase mb-1">Subjective (Symptoms)</h4>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($viewingConsultation->selected_complaints as $c)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-[10px] font-medium">{{ $c }}</span>
                                    @endforeach
                                </div>
                                @if($viewingConsultation->symptom_notes_final)
                                    <div class="mt-2 text-xs text-gray-600 italic line-clamp-3">
                                        {!! strip_tags($viewingConsultation->symptom_notes_final) !!}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Diagnosis -->
                        @if($viewingConsultation->diagnoses)
                            <div class="border-b border-gray-100 pb-3">
                                <h4 class="text-[10px] font-black text-gray-400 uppercase mb-1">Assessment (Diagnosis)</h4>
                                <div class="space-y-1">
                                    @foreach($viewingConsultation->diagnoses as $d)
                                        <div class="text-xs font-bold text-gray-800">
                                            <span class="text-blue-600">{{ $d['code'] }}</span> {{ $d['description'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Plan/Prescriptions -->
                        @if($viewingConsultation->prescriptions)
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase mb-1">Plan (Prescriptions)</h4>
                                <div class="space-y-2">
                                    @foreach($viewingConsultation->prescriptions as $p)
                                        <div class="p-2 bg-blue-50 rounded border border-blue-100">
                                            <p class="text-xs font-bold text-blue-900">{{ $p['medicine_name'] }}</p>
                                            <p class="text-[10px] text-blue-700">{{ $p['dosage'] }} - {{ $p['duration'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-4 py-2 border-t border-gray-100">
                    <button wire:click="closeHistoryDetail" class="w-full text-center text-xs font-bold text-blue-600 hover:text-blue-700">
                        ← Back to Patient Info
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
