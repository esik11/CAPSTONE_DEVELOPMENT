<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Medical Record for') }}: {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('patients.medicalRecords.store', $patient) }}" x-data="{ errors: {{ $errors->toJson() }} }">
                        @csrf

                        <!-- Visit Date -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-calendar-days me-2"></i> Visit Date</h3>
                        <div>
                                <x-input-label for="visit_date" :value="__('Visit Date')" class="text-sm text-gray-500"/>
                                <x-text-input id="visit_date" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 flatpickr" type="date" name="visit_date" :value="old('visit_date', $currentDate)" required autofocus />
                            <x-input-error :messages="$errors->get('visit_date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Chief Complaint -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-notes-medical me-2"></i> Chief Complaint</h3>
                            <div>
                                <x-input-label for="chief_complaint" :value="__('Chief Complaint (Optional)')" class="text-sm text-gray-500"/>
                                <textarea id="chief_complaint" name="chief_complaint" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('chief_complaint') }}</textarea>
                            <x-input-error :messages="$errors->get('chief_complaint')" class="mt-2" />
                            </div>
                        </div>

                        <!-- History of Present Illness -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-clipboard-question me-2"></i> History of Present Illness</h3>
                            <div>
                                <x-input-label for="history_of_present_illness" :value="__('History of Present Illness (Optional)')" class="text-sm text-gray-500"/>
                                <textarea id="history_of_present_illness" name="history_of_present_illness" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('history_of_present_illness') }}</textarea>
                            <x-input-error :messages="$errors->get('history_of_present_illness')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Past Medical History -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-heart-pulse me-2"></i> Past Medical History</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($medicalConditions as $condition)
                                    <div class="flex flex-col items-start p-2 border rounded-md bg-gray-50">
                                        <label for="condition_{{ $condition->id }}" class="flex items-center cursor-pointer">
                                            <input type="hidden" name="medical_conditions[{{ $loop->index }}][status]" value="0">
                                            <input type="checkbox" name="medical_conditions[{{ $loop->index }}][id]" value="{{ $condition->id }}" id="condition_{{ $condition->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                {{ old('medical_conditions') && collect(old('medical_conditions'))->contains('id', $condition->id) ? 'checked' : '' }}>
                                            <x-input-label for="condition_{{ $condition->id }}" class="ms-2 text-base font-medium text-gray-700">{{ $condition->condition_name }}</x-input-label>
                                        </label>
                                        <textarea name="medical_conditions[{{ $loop->index }}][notes]" class="block mt-2 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" rows="2" placeholder="Add notes (optional)">{{ old('medical_conditions.' . $loop->index . '.notes') }}</textarea>
                                        <x-input-error :messages="$errors->get('medical_conditions.' . $loop->index . '.notes')" class="mt-1" />
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('medical_conditions')" class="mt-2" />
                        </div>

                        <!-- Past Surgical History -->
                        <div x-data="{ pastSurgicalHistory: {{ old('past_surgical_history_status', 'false') ? 'true' : 'false' }}, oldSurgicalHistories: {{ old('surgical_histories') ? json_encode(old('surgical_histories')) : '[]' }} }" class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-scissors me-2"></i> Past Surgical History</h3>
                            <div class="flex items-center mb-4">
                                <label for="past_surgical_history_toggle" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="hidden" name="past_surgical_history_status" :value="pastSurgicalHistory ? 1 : 0">
                                        <input type="checkbox" id="past_surgical_history_toggle" class="sr-only" x-model="pastSurgicalHistory">
                                        <div class="block bg-gray-600 w-14 h-8 rounded-full transition" :class="{'bg-indigo-600': pastSurgicalHistory, 'bg-gray-200': !pastSurgicalHistory}"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition shadow-md" :class="{'transform translate-x-full bg-indigo-500': pastSurgicalHistory}"></div>
                                    </div>
                                    <div class="ml-3 text-lg font-medium text-gray-700" x-text="pastSurgicalHistory ? 'Yes' : 'No'"></div>
                                </label>
                            </div>

                            <div x-show="pastSurgicalHistory">
                                <div id="surgical-history-container" class="space-y-4">
                                    <template x-for="(surgicalHistory, index) in oldSurgicalHistories" :key="index">
                                        <div class="flex items-end space-x-2">
                                            <div class="flex-1 grid grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label x-bind:for="'surgical_type-' + index" value="{{ __('Surgery Type') }}" class="text-sm text-gray-500"/>
                                                    <x-text-input x-bind:id="'surgical_type-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'surgical_histories[' + index + '][surgery_type]'" x-model="surgicalHistory.surgery_type" placeholder="e.g., Appendectomy" />
                                                <x-input-error :messages="[]" x-bind:messages="errors['surgical_histories.' + index + '.surgery_type'] ? [errors['surgical_histories.' + index + '.surgery_type']] : []" class="mt-2" />
                                            </div>
                                                <div>
                                                    <x-input-label x-bind:for="'surgical_year-' + index" value="{{ __('Year') }}" class="text-sm text-gray-500"/>
                                                    <x-text-input x-bind:id="'surgical_year-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 flatpickr-year" type="text" x-bind:name="'surgical_histories[' + index + '][year]'" x-model="surgicalHistory.year" min="1900" max="{{ date('Y') }}" placeholder="YYYY" x-ref="surgicalYear" />
                                                <x-input-error :messages="[]" x-bind:messages="errors['surgical_histories.' + index + '.year'] ? [errors['surgical_histories.' + index + '.year']] : []" class="mt-2" />
                                                </div>
                                            <div class="flex-1">
                                                <x-input-label x-bind:for="'surgical_notes-' + index" value="{{ __('Notes (Optional)') }}" class="text-sm text-gray-500"/>
                                                <textarea x-bind:id="'surgical_notes-' + index" x-bind:name="'surgical_histories[' + index + '][notes]'" x-model="surgicalHistory.notes" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Any relevant details"></textarea>
                                                <x-input-error :messages="[]" x-bind:messages="errors['surgical_histories.' + index + '.notes'] ? [errors['surgical_histories.' + index + '.notes']] : []" class="mt-2" />
                                            </div>
                                            <button type="button" x-show="index > 0" @click="oldSurgicalHistories.splice(index, 1)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                <i class="fa-solid fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="oldSurgicalHistories.push({ surgery_type: '', year: '', notes: '' })" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fa-solid fa-plus"></i> Add Surgery
                                </button>
                            </div>
                        </div>

                        <!-- Recent Hospitalizations -->
                        <div x-data="{ hospitalizations: {{ old('hospitalizations') ? json_encode(old('hospitalizations')) : '[]' }} }" class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-hospital me-2"></i> Recent Hospitalizations</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Remove</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(hospitalization, index) in hospitalizations" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <textarea x-bind:id="'hospital_reason-' + index" x-bind:name="'hospitalizations[' + index + '][reason]'" x-model="hospitalization.reason" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Reason for hospitalization"></textarea>
                                            <x-input-error :messages="[]" x-bind:messages="errors['hospitalizations.' + index + '.reason'] ? [errors['hospitalizations.' + index + '.reason']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'hospital_name-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'hospitalizations[' + index + '][hospital_name]'" x-model="hospitalization.hospital_name" placeholder="Hospital Name" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['hospitalizations.' + index + '.hospital_name'] ? [errors['hospitalizations.' + index + '.hospital_name']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'hospital_year-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 flatpickr-year" type="text" x-bind:name="'hospitalizations[' + index + '][year]'" x-model="hospitalization.year" min="1900" max="{{ date('Y') }}" placeholder="Year" x-ref="hospitalYear" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['hospitalizations.' + index + '.year'] ? [errors['hospitalizations.' + index + '.year']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" x-show="hospitalizations.length > 1" @click="hospitalizations.splice(index, 1)" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-if="hospitalizations.length === 0">
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No hospitalizations added yet.</td>
                                            </tr>
                                </template>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" @click="hospitalizations.push({ reason: '', hospital_name: '', year: '' })" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa-solid fa-plus"></i> Add Hospitalization
                            </button>
                        </div>

                        <!-- Medications -->
                        <div x-data="{ medications: {{ old('medications') ? json_encode(old('medications')) : '[]' }} }" class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-pills me-2"></i> Medications</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Remove</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(medication, index) in medications" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'medicine_name-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'medications[' + index + '][medicine_name]'" x-model="medication.medicine_name" placeholder="Medicine Name" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['medications.' + index + '.medicine_name'] ? [errors['medications.' + index + '.medicine_name']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'dosage-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'medications[' + index + '][dosage]'" x-model="medication.dosage" placeholder="e.g., 500mg" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['medications.' + index + '.dosage'] ? [errors['medications.' + index + '.dosage']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'frequency-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'medications[' + index + '][frequency]'" x-model="medication.frequency" placeholder="e.g., BID, QHS" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['medications.' + index + '.frequency'] ? [errors['medications.' + index + '.frequency']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" x-show="medications.length > 1" @click="medications.splice(index, 1)" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-if="medications.length === 0">
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No medications added yet.</td>
                                            </tr>
                                </template>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" @click="medications.push({ medicine_name: '', dosage: '', frequency: '' })" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa-solid fa-plus"></i> Add Medication
                            </button>
                        </div>

                        <!-- Allergies -->
                        <div x-data="{
                            drugAllergy: {{ old('allergies.drug_allergy', 'false') ? 'true' : 'false' }},
                            foodAllergy: {{ old('allergies.food_allergy', 'false') ? 'true' : 'false' }},
                            envAllergy: {{ old('allergies.env_allergy', 'false') ? 'true' : 'false' }},
                            otherAllergy: {{ old('allergies.other_allergy', 'false') ? 'true' : 'false' }},
                            allergies: {{ old('allergies.details') ? json_encode(old('allergies.details')) : '[]' }}
                        }" class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-allergies me-2"></i> Allergies</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allergy Type</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reaction (Optional)</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Remove</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(allergy, index) in allergies" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select x-bind:id="'allergy_type-' + index" x-bind:name="'allergies[' + index + '][allergy_type]'" x-model="allergy.allergy_type" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                        <option value="">Select Type</option>
                                                        <option value="drug">Drug Allergy</option>
                                                        <option value="food">Food Allergy</option>
                                                        <option value="environment">Environmental Allergy</option>
                                                        <option value="other">Other Allergy</option>
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'description-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'allergies[' + index + '][description]'" x-model="allergy.description" placeholder="Description" />
                                                <x-input-error :messages="[]" x-bind:messages="errors['allergies.' + index + '.description'] ? [errors['allergies.' + index + '.description']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <textarea x-bind:id="'reaction-' + index" x-bind:name="'allergies[' + index + '][reaction]'" x-model="allergy.reaction" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Reaction (Optional)"></textarea>
                                                <x-input-error :messages="[]" x-bind:messages="errors['allergies.' + index + '.reaction'] ? [errors['allergies.' + index + '.reaction']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" x-show="allergies.length > 0" @click="allergies.splice(index, 1)" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                    </template>
                                        <template x-if="allergies.length === 0">
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No allergies added yet.</td>
                                            </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" @click="allergies.push({ allergy_type: '', description: '', reaction: '' })" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa-solid fa-plus"></i> Add Allergy
                                    </button>
                        </div>

                        <!-- Family History -->
                        <div x-data="{ familyHistories: {{ old('family_histories') ? json_encode(old('family_histories')) : '[]' }} }" class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><i class="fa-solid fa-people-arrows me-2"></i> Family History</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relative</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Remove</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(familyHistory, index) in familyHistories" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select x-bind:id="'relative-' + index" x-bind:name="'family_histories[' + index + '][relative]'" x-model="familyHistory.relative" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                <option value="">Select Relative</option>
                                                <option value="Father">Father</option>
                                                <option value="Mother">Mother</option>
                                                <option value="Sibling">Sibling</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <x-input-error :messages="[]" x-bind:messages="errors['family_histories.' + index + '.relative'] ? [errors['family_histories.' + index + '.relative']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'family_condition-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" x-bind:name="'family_histories[' + index + '][condition]'" x-model="familyHistory.condition" placeholder="Condition" />
                                            <x-input-error :messages="[]" x-bind:messages="errors['family_histories.' + index + '.condition'] ? [errors['family_histories.' + index + '.condition']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" x-show="familyHistories.length > 1" @click="familyHistories.splice(index, 1)" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-if="familyHistories.length === 0">
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No family history added yet.</td>
                                            </tr>
                                </template>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" @click="familyHistories.push({ relative: '', condition: '' })" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa-solid fa-plus"></i> Add Family History
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <x-primary-button>
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                {{ __('Save Medical Record') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>