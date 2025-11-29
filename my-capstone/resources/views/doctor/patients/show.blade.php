<x-patient-overview-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('patients.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                
                @if ($patient->photo)
                    <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-12 h-12 rounded-full object-cover border-2 border-blue-200">
                @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-lg font-bold border-2 border-blue-200">
                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                    </div>
                @endif
                
                <div>
                    <h2 class="font-bold text-xl text-gray-900">
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </h2>
                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old • ID: #{{ $patient->id }}</p>
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

    <div class="h-full flex" x-data="{ sidebarOpen: true }">
        <!-- Patient Sidebar -->
        <div 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="w-64 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto">
            
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900 text-sm uppercase tracking-wide">Patient Sections</h3>
            </div>
            
            <nav class="p-2 space-y-1">
                <a href="#overview" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer bg-blue-50 text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium text-sm">Overview</span>
                </a>
                
                <a href="#conditions" 
                   @click.prevent="$dispatch('openConditionModal')"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-medium text-sm">Conditions</span>
                </a>
                
                <a href="#medications" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="font-medium text-sm">Medications</span>
                </a>
                
                <a href="#allergies" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="font-medium text-sm">Allergies</span>
                </a>
                
                <a href="#family-history" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-medium text-sm">Family History</span>
                </a>
                
                <a href="#vitals" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium text-sm">Vitals</span>
                </a>
                
                <a href="#surgical-history" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="font-medium text-sm">Surgical History</span>
                </a>
            </nav>
        </div>

        <!-- Toggle Sidebar Button -->
        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white border border-gray-200 rounded-r-lg p-2 shadow-lg hover:bg-gray-50 transition-colors z-10"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'">
            <svg x-show="!sidebarOpen" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <svg x-show="sidebarOpen" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Center Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            <!-- Talking Points -->
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl shadow-sm border border-orange-200">
                <livewire:doctor.patient.talking-points :patient="$patient" />
            </div>

            <!-- Lifestyle & Family History -->
            <livewire:doctor.patient.lifestyle-family-history-card :patient="$patient" />

            <!-- Family Members -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Family members
                </h3>
                @if($patient->emergency_first_name)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="font-medium text-gray-900">{{ $patient->emergency_first_name }} {{ $patient->emergency_last_name }}</p>
                    <p class="text-sm text-gray-600">{{ $patient->emergency_relationship ?? 'Emergency Contact' }}</p>
                </div>
                @else
                <p class="text-sm text-gray-500 italic text-center py-4">No family members recorded</p>
                @endif
            </div>

            <!-- Surgical & Hospital History -->
            <livewire:doctor.patient.surgical-hospital-history-card :patient="$patient" />
        </div>

        <!-- Right Sidebar - Executive Summary -->
        <div class="w-80 flex-shrink-0 bg-white border-l border-gray-200 overflow-y-auto p-6 space-y-4">
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

            <!-- Latest Vitals -->
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

            <!-- Conditions & Medications -->
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
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-medium text-gray-700 text-sm">Active Medications</p>
                            <button 
                                @click="$dispatch('openMedicationModal')"
                                class="text-green-600 hover:text-green-700 text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
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
                        <livewire:doctor.patient.conditions-display :patient="$patient" :showInSummary="true" :key="'conditions-summary-'.$patient->id" />
                    </div>
                </div>
            </div>

            <!-- Allergies -->
            <livewire:doctor.patient.allergies-display :patient="$patient" :key="'allergies-'.$patient->id" />


        </div>
    </div>

    <!-- Modals -->
    <livewire:doctor.patient.allergy-modal :patient="$patient" />
    <livewire:doctor.patient.medication-modal :patient="$patient" />
    <livewire:doctor.patient.condition-modal :patient="$patient" />
    <livewire:doctor.patient.lifestyle-family-history-modal :patient="$patient" />
    <livewire:doctor.patient.surgical-hospital-history-modal :patient="$patient" />
</x-patient-overview-layout>
