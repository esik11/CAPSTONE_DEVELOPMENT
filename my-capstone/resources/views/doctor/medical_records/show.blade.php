<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Record for') }}: {{ $patient->first_name }} {{ $patient->last_name }} ({{ \Carbon\Carbon::parse($medicalRecord->visit_date)->format('M d, Y') }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Visit Details</h3>
                    <a href="{{ route('patients.medicalRecords.index', $patient) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Back to Records
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500"><strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($medicalRecord->visit_date)->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-500"><strong>Doctor:</strong> {{ $medicalRecord->doctor->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500"><strong>Chief Complaint:</strong> {{ $medicalRecord->chief_complaint ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500"><strong>History of Present Illness:</strong> {{ $medicalRecord->history_of_present_illness ?? '-' }}</p>
                        <p class="text-sm text-gray-500"><strong>Consent Signed:</strong> {{ $medicalRecord->consent_signed ? 'Yes' : 'No' }}</p>
                    </div>
                </div>

                <!-- Medical Conditions -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Medical Conditions</h4>
                    @if ($medicalRecord->medicalConditions->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->medicalConditions as $condition)
                                <li>{{ $condition->condition_name }} @if($condition->pivot->notes) (Notes: {{ $condition->pivot->notes }}) @endif</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Surgical History -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Surgical History</h4>
                    @if ($medicalRecord->surgicalHistories->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->surgicalHistories as $surgicalHistory)
                                <li>{{ $surgicalHistory->surgery_type }} ({{ $surgicalHistory->year }}) @if($surgicalHistory->notes) - {{ $surgicalHistory->notes }} @endif</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Hospitalizations -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Hospitalizations</h4>
                    @if ($medicalRecord->hospitalizations->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->hospitalizations as $hospitalization)
                                <li>{{ $hospitalization->hospital_name }} ({{ $hospitalization->year }}) - {{ $hospitalization->reason }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Medications -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Medications</h4>
                    @if ($medicalRecord->medications->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->medications as $medication)
                                <li>{{ $medication->medicine_name }} @if($medication->dosage) ({{ $medication->dosage }}) @endif @if($medication->frequency) - {{ $medication->frequency }} @endif</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Allergies -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Allergies</h4>
                    @if ($medicalRecord->allergies->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->allergies as $allergy)
                                <li>{{ ucfirst($allergy->allergy_type) }}: {{ $allergy->description }} @if($allergy->reaction) (Reaction: {{ $allergy->reaction }}) @endif</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Family History -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Family History</h4>
                    @if ($medicalRecord->familyHistories->count() > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($medicalRecord->familyHistories as $familyHistory)
                                <li>{{ $familyHistory->relative }}: {{ $familyHistory->condition }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>

                <!-- Social History -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Social History</h4>
                    @if ($medicalRecord->socialHistories->count() > 0)
                        @php
                            $socialHistory = $medicalRecord->socialHistories->first();
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <p><strong>Smoking:</strong> {{ $socialHistory->smoking ?? '-' }}</p>
                            <p><strong>Alcohol:</strong> {{ $socialHistory->alcohol ?? '-' }}</p>
                            <p><strong>Drug Use:</strong> {{ $socialHistory->drug_use ?? '-' }}</p>
                            <p><strong>Diet & Exercise:</strong> {{ $socialHistory->diet_exercise ?? '-' }}</p>
                            <p><strong>Occupation:</strong> {{ $socialHistory->occupation ?? '-' }}</p>
                            <p><strong>Living Situation:</strong> {{ $socialHistory->living_situation ?? '-' }}</p>
                        </div>
                    @else
                        <p class="text-gray-600">-</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>
