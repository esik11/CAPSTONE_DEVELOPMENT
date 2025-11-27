<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('patients.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        Patient Overview
                    </h2>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $patient->first_name }} {{ $patient->last_name }} - ID: #{{ $patient->id }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors text-sm font-medium">
                    Repeat Script
                </button>
                <button class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors text-sm font-medium">
                    Sick Note
                </button>
                <button class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg transition-colors text-sm font-medium">
                    Telehealth Consult
                </button>
            </div>
        </div>
    </x-slot>

    <div class="h-full flex gap-4 p-4" x-data="{}"
        <!-- Left Sidebar - Patient Info -->
        <div class="w-64 flex-shrink-0 space-y-4">
            <!-- Patient Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex flex-col items-center">
                    @if ($patient->photo)
                        <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-24 h-24 rounded-full object-cover border-4 border-blue-100 mb-3">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold border-4 border-blue-100 mb-3">
                            {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                        </div>
                    @endif
                    <h3 class="font-bold text-lg text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old</p>
                </div>
            </div>

            <!-- Talking Points -->
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl shadow-sm border border-orange-200">
                <livewire:doctor.patient.talking-points :patient="$patient" />
            </div>

            <!-- Lifestyle & Family Hx -->
            <livewire:doctor.patient.lifestyle-family-history-card :patient="$patient" />

            <livewire:doctor.patient.lifestyle-family-history-modal :patient="$patient" />
        </div>

        <!-- Center Panel - Medical History -->
        <div class="flex-1 space-y-4 overflow-y-auto">
            <!-- Family Members -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Family members
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @if($patient->emergency_first_name)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-900">{{ $patient->emergency_first_name }} {{ $patient->emergency_last_name }}</p>
                        <p class="text-sm text-gray-600">{{ $patient->emergency_relationship ?? 'Emergency Contact' }}</p>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->subYears(rand(20, 60))->age }} years old</p>
                    </div>
                    @else
                    <div class="p-3 bg-gray-50 rounded-lg text-center text-gray-500 text-sm">
                        No family members recorded
                    </div>
                    @endif
                </div>
            </div>

            <!-- Surgical & Hospitalization History -->
            <livewire:doctor.patient.surgical-hospital-history-card :patient="$patient" />

            <livewire:doctor.patient.surgical-hospital-history-modal :patient="$patient" />
        </div>

        <!-- Right Panel - Conditions & Medications -->
        <div class="w-80 flex-shrink-0 space-y-4 overflow-y-auto">
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl shadow-sm border border-orange-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Conditions & Medications
                </h3>
                
                <div class="space-y-4">
                    <!-- Active Medications -->
                    <div>
                        <p class="font-medium text-gray-700 mb-2 text-sm">Active Medications</p>
                        @php
                            $medications = $patient->medicalRecords->flatMap->medications ?? collect();
                        @endphp
                        @if($medications->count() > 0)
                            <div class="space-y-2">
                                @foreach($medications->take(5) as $med)
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $med->medicine_name }}</p>
                                    <p class="text-gray-600">{{ $med->dosage }} - {{ $med->frequency }}</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">No active medications</p>
                        @endif
                    </div>
                    
                    <!-- Current Conditions -->
                    <div class="pt-3 border-t border-orange-200">
                        <p class="font-medium text-gray-700 mb-2 text-sm">Current Conditions</p>
                        @php
                            $conditions = $patient->medicalRecords->flatMap->medicalConditions ?? collect();
                        @endphp
                        @if($conditions->count() > 0)
                            <div class="space-y-2">
                                @foreach($conditions->take(3) as $condition)
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $condition->name }}</p>
                                    @if($condition->pivot && $condition->pivot->notes)
                                    <p class="text-gray-600 text-xs">{{ $condition->pivot->notes }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">No conditions recorded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Far Right Sidebar - Vital Info -->
        <div class="w-64 flex-shrink-0 space-y-4 overflow-y-auto">
            <!-- Contact Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900">{{ $patient->first_name }}</h4>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ $patient->phone_number }}</span>
                    </div>
                </div>
            </div>

            <!-- Growth/Vitals -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900">Latest Vitals</h4>
                    @php
                        $latestVitals = $patient->latestVitalSigns;
                    @endphp
                    @if($latestVitals)
                        <span class="text-xs text-gray-500">{{ $latestVitals->recorded_at->format('M d, Y') }}</span>
                    @endif
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Weight</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals ? $latestVitals->weight . ' kg' : '--' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Height</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals ? $latestVitals->height . ' cm' : '--' }}</span>
                    </div>
                    @if($latestVitals && $latestVitals->bmi)
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <span class="text-gray-600">BMI</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->bmi }}</span>
                    </div>
                    @endif
                    @if($latestVitals && ($latestVitals->systolic || $latestVitals->diastolic))
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Blood Pressure</span>
                        <span class="font-medium text-gray-900">{{ $latestVitals->systolic }}/{{ $latestVitals->diastolic }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Medical Aid Plan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h4 class="font-semibold text-gray-900 mb-2">Medical aid plan</h4>
                <p class="text-sm text-gray-600">Not specified</p>
            </div>

            <!-- Allergies -->
            <livewire:doctor.patient.allergy-card :patient="$patient" />
            
            <livewire:doctor.patient.allergy-modal :patient="$patient" />

            <!-- Conditions List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Conditions</h4>
                @if($conditions->count() > 0)
                    <div class="space-y-2">
                        @foreach($conditions as $condition)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-900">{{ $condition->name }}</span>
                            <span class="text-xs text-gray-500">Active</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">No conditions recorded</p>
                @endif
            </div>
        </div>
    </div>
</x-doctor-layout>
