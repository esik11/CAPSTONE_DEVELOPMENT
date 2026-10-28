<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Add Medical Record') }}
                </h2>
                <p class="text-sm text-gray-600 mt-0.5">For {{ $patient->first_name }} {{ $patient->last_name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <div class="p-6 text-gray-900" x-data="{ activeTab: 'medical-history' }">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-green-800 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex flex-wrap gap-1" aria-label="Tabs">
                            <button type="button" @click="activeTab = 'medical-history'" :class="activeTab === 'medical-history' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="hidden sm:inline">Medical History</span>
                                <span class="sm:hidden">Medical</span>
                            </button>
                            <button type="button" @click="activeTab = 'surgical'" :class="activeTab === 'surgical' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <span class="hidden sm:inline">Surgical</span>
                                <span class="sm:hidden">Surgery</span>
                            </button>
                            <button type="button" @click="activeTab = 'medications'" :class="activeTab === 'medications' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                <span class="hidden sm:inline">Medications</span>
                                <span class="sm:hidden">Meds</span>
                            </button>
                            <button type="button" @click="activeTab = 'allergies'" :class="activeTab === 'allergies' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Allergies
                            </button>
                            <button type="button" @click="activeTab = 'family'" :class="activeTab === 'family' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Family</span>
                                <span class="sm:hidden">Family</span>
                            </button>
                            <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="hidden sm:inline">Social</span>
                                <span class="sm:hidden">Social</span>
                            </button>
                            <button type="button" @click="activeTab = 'immunization'" :class="activeTab === 'immunization' ? 'border-teal-500 text-teal-600 bg-teal-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 px-3 border-b-2 font-medium text-xs transition-colors flex items-center gap-1.5 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="hidden sm:inline">Immunizations</span>
                                <span class="sm:hidden">Vaccines</span>
                            </button>
                        </nav>
                    </div>
                    
                    <form method="POST" action="{{ route('patients.medicalRecords.store', $patient) }}" x-data="{ errors: {{ $errors->toJson() }} }">
                        @csrf

                        <!-- Tab Content -->

                        <!-- Tab Panel: Medical History -->
                        <div x-show="activeTab === 'medical-history'" x-transition class="space-y-6">
                        <!-- Past Medical History -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
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
                        </div>

                        <!-- Tab Panel: Surgical & Hospitalizations -->
                        <div x-show="activeTab === 'surgical'" x-transition class="space-y-6">
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
                        </div>

                        <!-- Tab Panel: Medications -->
                        <div x-show="activeTab === 'medications'" x-transition class="space-y-6">
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
                        </div>

                        <!-- Tab Panel: Allergies -->
                        <div x-show="activeTab === 'allergies'" x-transition class="space-y-6">
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
                        </div>

                        <!-- Tab Panel: Family History -->
                        <div x-show="activeTab === 'family'" x-transition class="space-y-6">
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
                        </div>

                        <!-- Tab Panel: Social History -->
                        <div x-show="activeTab === 'social'" x-transition class="space-y-6">
                        <!-- Social History -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Social History</h3>
                                    <p class="text-sm text-gray-600">Lifestyle and social factors</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Smoking Status -->
                                <div>
                                    <x-input-label for="smoking_status" :value="__('Smoking Status')" class="text-sm text-gray-700 font-semibold"/>
                                    <select id="smoking_status" name="social_history[smoking_status]" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="">Select Status</option>
                                        <option value="Never smoker" {{ old('social_history.smoking_status') == 'Never smoker' ? 'selected' : '' }}>Never smoker</option>
                                        <option value="Former smoker" {{ old('social_history.smoking_status') == 'Former smoker' ? 'selected' : '' }}>Former smoker</option>
                                        <option value="Current smoker" {{ old('social_history.smoking_status') == 'Current smoker' ? 'selected' : '' }}>Current smoker</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('social_history.smoking_status')" class="mt-2" />
                                </div>

                                <!-- Smoking Details -->
                                <div>
                                    <x-input-label for="smoking_details" :value="__('Smoking Details (Optional)')" class="text-sm text-gray-700 font-semibold"/>
                                    <x-text-input id="smoking_details" class="block mt-2 w-full rounded-lg" type="text" name="social_history[smoking_details]" :value="old('social_history.smoking_details')" placeholder="e.g., 1 pack/day for 10 years" />
                                    <x-input-error :messages="$errors->get('social_history.smoking_details')" class="mt-2" />
                                </div>

                                <!-- Alcohol Consumption -->
                                <div>
                                    <x-input-label for="alcohol_consumption" :value="__('Alcohol Consumption')" class="text-sm text-gray-700 font-semibold"/>
                                    <select id="alcohol_consumption" name="social_history[alcohol_consumption]" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="">Select Frequency</option>
                                        <option value="None" {{ old('social_history.alcohol_consumption') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Occasional" {{ old('social_history.alcohol_consumption') == 'Occasional' ? 'selected' : '' }}>Occasional</option>
                                        <option value="Moderate" {{ old('social_history.alcohol_consumption') == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="Heavy" {{ old('social_history.alcohol_consumption') == 'Heavy' ? 'selected' : '' }}>Heavy</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('social_history.alcohol_consumption')" class="mt-2" />
                                </div>

                                <!-- Alcohol Details -->
                                <div>
                                    <x-input-label for="alcohol_details" :value="__('Alcohol Details (Optional)')" class="text-sm text-gray-700 font-semibold"/>
                                    <x-text-input id="alcohol_details" class="block mt-2 w-full rounded-lg" type="text" name="social_history[alcohol_details]" :value="old('social_history.alcohol_details')" placeholder="e.g., 2-3 drinks per week" />
                                    <x-input-error :messages="$errors->get('social_history.alcohol_details')" class="mt-2" />
                                </div>

                                <!-- Drug Use -->
                                <div>
                                    <x-input-label for="drug_use" :value="__('Drug Use')" class="text-sm text-gray-700 font-semibold"/>
                                    <select id="drug_use" name="social_history[drug_use]" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="">Select Status</option>
                                        <option value="None" {{ old('social_history.drug_use') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Past use" {{ old('social_history.drug_use') == 'Past use' ? 'selected' : '' }}>Past use</option>
                                        <option value="Current use" {{ old('social_history.drug_use') == 'Current use' ? 'selected' : '' }}>Current use</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('social_history.drug_use')" class="mt-2" />
                                </div>

                                <!-- Drug Details -->
                                <div>
                                    <x-input-label for="drug_details" :value="__('Drug Details (Optional)')" class="text-sm text-gray-700 font-semibold"/>
                                    <x-text-input id="drug_details" class="block mt-2 w-full rounded-lg" type="text" name="social_history[drug_details]" :value="old('social_history.drug_details')" placeholder="Specify substances if applicable" />
                                    <x-input-error :messages="$errors->get('social_history.drug_details')" class="mt-2" />
                                </div>

                                <!-- Occupation -->
                                <div>
                                    <x-input-label for="occupation" :value="__('Occupation')" class="text-sm text-gray-700 font-semibold"/>
                                    <x-text-input id="occupation" class="block mt-2 w-full rounded-lg" type="text" name="social_history[occupation]" :value="old('social_history.occupation')" placeholder="Current or former occupation" />
                                    <x-input-error :messages="$errors->get('social_history.occupation')" class="mt-2" />
                                </div>

                                <!-- Living Situation -->
                                <div>
                                    <x-input-label for="living_situation" :value="__('Living Situation')" class="text-sm text-gray-700 font-semibold"/>
                                    <select id="living_situation" name="social_history[living_situation]" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="">Select Situation</option>
                                        <option value="Lives alone" {{ old('social_history.living_situation') == 'Lives alone' ? 'selected' : '' }}>Lives alone</option>
                                        <option value="Lives with family" {{ old('social_history.living_situation') == 'Lives with family' ? 'selected' : '' }}>Lives with family</option>
                                        <option value="Lives with spouse/partner" {{ old('social_history.living_situation') == 'Lives with spouse/partner' ? 'selected' : '' }}>Lives with spouse/partner</option>
                                        <option value="Assisted living" {{ old('social_history.living_situation') == 'Assisted living' ? 'selected' : '' }}>Assisted living</option>
                                        <option value="Other" {{ old('social_history.living_situation') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('social_history.living_situation')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mt-6">
                                <x-input-label for="social_notes" :value="__('Additional Social History Notes (Optional)')" class="text-sm text-gray-700 font-semibold"/>
                                <textarea id="social_notes" name="social_history[notes]" rows="3" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Any other relevant social history information">{{ old('social_history.notes') }}</textarea>
                                <x-input-error :messages="$errors->get('social_history.notes')" class="mt-2" />
                            </div>
                        </div>
                        </div>

                        <!-- Tab Panel: Immunization Records -->
                        <div x-show="activeTab === 'immunization'" x-transition class="space-y-6">
                        <!-- Immunization Records -->
                        <div x-data="{ immunizations: {{ old('immunizations') ? json_encode(old('immunizations')) : '[]' }} }" class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Immunization Records</h3>
                                    <p class="text-sm text-gray-600">Vaccination history</p>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-green-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Vaccine Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date Administered</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Dose Number</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Next Due Date</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Remove</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(immunization, index) in immunizations" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'vaccine_name-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500" type="text" x-bind:name="'immunizations[' + index + '][vaccine_name]'" x-model="immunization.vaccine_name" placeholder="e.g., COVID-19, Flu" />
                                                    <x-input-error :messages="[]" x-bind:messages="errors['immunizations.' + index + '.vaccine_name'] ? [errors['immunizations.' + index + '.vaccine_name']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'date_administered-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500 flatpickr" type="date" x-bind:name="'immunizations[' + index + '][date_administered]'" x-model="immunization.date_administered" />
                                                    <x-input-error :messages="[]" x-bind:messages="errors['immunizations.' + index + '.date_administered'] ? [errors['immunizations.' + index + '.date_administered']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'dose_number-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500" type="text" x-bind:name="'immunizations[' + index + '][dose_number]'" x-model="immunization.dose_number" placeholder="e.g., 1st, 2nd, Booster" />
                                                    <x-input-error :messages="[]" x-bind:messages="errors['immunizations.' + index + '.dose_number'] ? [errors['immunizations.' + index + '.dose_number']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <x-text-input x-bind:id="'next_due_date-' + index" class="block mt-1 w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500 flatpickr" type="date" x-bind:name="'immunizations[' + index + '][next_due_date]'" x-model="immunization.next_due_date" />
                                                    <x-input-error :messages="[]" x-bind:messages="errors['immunizations.' + index + '.next_due_date'] ? [errors['immunizations.' + index + '.next_due_date']] : []" class="mt-2" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" x-show="immunizations.length > 0" @click="immunizations.splice(index, 1)" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-if="immunizations.length === 0">
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No immunization records added yet.</td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" @click="immunizations.push({ vaccine_name: '', date_administered: '', dose_number: '', next_due_date: '' })" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-colors">
                                <i class="fa-solid fa-plus"></i> Add Immunization Record
                            </button>
                        </div>
                        </div>

                        <!-- Submit Button (Always Visible) -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <svg class="w-5 h-5 inline mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                All fields are optional. Fill in what's available.
                            </div>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-teal-500/50 transition-all duration-200 hover:shadow-xl hover:shadow-teal-500/60">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Save Medical Record') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>