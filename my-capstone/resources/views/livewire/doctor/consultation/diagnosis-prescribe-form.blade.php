<div class="space-y-3" wire:poll.30s="autoSave">
    
    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button 
                    wire:click="$set('activeTab', 'diagnosis')"
                    class="px-6 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'diagnosis' ? 'border-teal-600 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    🔍 Diagnosis
                </button>
                <button 
                    wire:click="$set('activeTab', 'medicine')"
                    class="px-6 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'medicine' ? 'border-teal-600 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    💊 Medicine
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'diagnosis')
                <!-- DIAGNOSIS TAB -->
                <div class="space-y-4">
                    <!-- Search Box -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Search by ICD-10 code or name
                        </label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="diagnosisSearch"
                            placeholder="Type to search... (e.g., 'bronch' or 'J20')"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        
                        <!-- Search Results -->
                        @if(!empty($diagnosisResults))
                            <div class="mt-2 border border-gray-200 rounded-lg max-h-64 overflow-y-auto">
                                @foreach($diagnosisResults as $result)
                                    <button 
                                        type="button"
                                        wire:click="addDiagnosis('{{ $result['code'] }}', '{{ addslashes($result['description']) }}')"
                                        class="w-full px-4 py-2 text-left hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                        <span class="font-medium text-gray-900">{{ $result['code'] }}</span>: 
                                        <span class="text-gray-700">{{ $result['description'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Selected Diagnoses -->
                    @if(!empty($selectedDiagnoses))
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Selected Diagnoses ({{ count($selectedDiagnoses) }})</h3>
                            <div class="space-y-2">
                                @foreach($selectedDiagnoses as $index => $diagnosis)
                                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                @if($diagnosis['is_primary'])
                                                    <span class="text-yellow-500">⭐</span>
                                                @endif
                                                <span class="font-semibold text-gray-900">{{ $diagnosis['code'] }}</span>
                                                <span class="text-gray-700">- {{ $diagnosis['description'] }}</span>
                                            </div>
                                            @if($diagnosis['is_primary'])
                                                <span class="text-xs text-gray-500 ml-6">(Primary Diagnosis)</span>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            @if(!$diagnosis['is_primary'])
                                                <button 
                                                    type="button"
                                                    wire:click="setPrimary({{ $index }})"
                                                    class="px-2 py-1 text-xs text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded">
                                                    Set as Primary
                                                </button>
                                            @endif
                                            <button 
                                                type="button"
                                                wire:click="removeDiagnosis({{ $index }})"
                                                class="px-2 py-1 text-xs text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-sm">No diagnoses added yet. Search and select from above.</p>
                        </div>
                    @endif

                    <!-- Additional Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Clinical Notes (Optional)
                        </label>
                        <textarea 
                            wire:model.blur="diagnosisNotes"
                            rows="4"
                            placeholder="Any additional diagnostic notes or clinical impressions..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"></textarea>
                    </div>
                </div>

            @elseif($activeTab === 'medicine')
                <!-- MEDICINE TAB -->
                <div class="space-y-4">
                    <!-- Search Box -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Search Medicine
                        </label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="medicineSearch"
                            placeholder="Type medicine name... (e.g., 'amox' or 'paracetamol')"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        
                        <!-- Search Results -->
                        @if(!empty($medicineResults))
                            <div class="mt-2 border border-gray-200 rounded-lg max-h-64 overflow-y-auto">
                                @foreach($medicineResults as $result)
                                    <button 
                                        type="button"
                                        wire:click="addPrescription({{ $result['id'] }}, '{{ addslashes($result['name']) }}', '{{ addslashes($result['strength'] ?? '') }}', '{{ addslashes($result['form']) }}')"
                                        class="w-full px-4 py-2 text-left hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                        <span class="font-medium text-gray-900">{{ $result['name'] }}</span>
                                        @if($result['strength'])
                                            <span class="text-gray-700">{{ $result['strength'] }}</span>
                                        @endif
                                        <span class="text-gray-500 text-sm">({{ $result['form'] }})</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Selected Prescriptions -->
                    @if(!empty($selectedPrescriptions))
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Prescription List ({{ count($selectedPrescriptions) }})</h3>
                            <div class="space-y-2">
                                @foreach($selectedPrescriptions as $index => $prescription)
                                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 hover:border-blue-300 transition-colors">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 text-sm">
                                                    {{ $prescription['medicine_name'] }}
                                                    @if($prescription['strength'])
                                                        {{ $prescription['strength'] }}
                                                    @endif
                                                    <span class="text-gray-600 font-normal">({{ $prescription['form'] }})</span>
                                                </h4>
                                                <p class="text-xs text-gray-700 mt-1">
                                                    {{ $prescription['dosage'] }} • {{ $prescription['duration'] }} • {{ $prescription['instructions'] }}
                                                </p>
                                            </div>
                                            <div class="flex gap-2 ml-3">
                                                <button 
                                                    type="button"
                                                    wire:click="editPrescription({{ $index }})"
                                                    class="px-3 py-1 text-xs text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded font-medium">
                                                    Edit
                                                </button>
                                                <button 
                                                    type="button"
                                                    wire:click="removePrescription({{ $index }})"
                                                    class="px-3 py-1 text-xs text-red-600 hover:text-red-700 hover:bg-red-100 rounded font-medium">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-sm">No prescriptions added yet. Search and select medicines above.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Prescription Edit Modal -->
    @if($showPrescriptionModal && $editingIndex !== null)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" wire:click="closePrescriptionModal">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <!-- Modal Header -->
                <div class="bg-orange-500 px-6 py-4 flex items-center justify-between rounded-t-lg">
                    <h3 class="text-lg font-semibold text-white">Medicine Options</h3>
                    <button wire:click="closePrescriptionModal" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <!-- Medicine Name -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">
                            {{ $selectedPrescriptions[$editingIndex]['medicine_name'] }}
                            @if($selectedPrescriptions[$editingIndex]['strength'])
                                {{ $selectedPrescriptions[$editingIndex]['strength'] }}
                            @endif
                        </h4>
                        <p class="text-sm text-gray-600">{{ $selectedPrescriptions[$editingIndex]['form'] }}</p>
                    </div>

                    <!-- Dosage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dosage</label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="setDosage('1 tablet, 3x daily')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDosage === '1 tablet, 3x daily' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                1 tablet, 3x daily
                            </button>
                            <button type="button" wire:click="setDosage('1 tablet, 2x daily')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDosage === '1 tablet, 2x daily' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                1 tablet, 2x daily
                            </button>
                            <button type="button" wire:click="setDosage('1 tablet, 1x daily')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDosage === '1 tablet, 1x daily' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                1 tablet, 1x daily
                            </button>
                            <button type="button" wire:click="setDosage('2 tablets, 2x daily')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDosage === '2 tablets, 2x daily' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                2 tablets, 2x daily
                            </button>
                        </div>
                        <input type="text" wire:model.blur="editDosage" placeholder="Or enter custom dosage"
                               class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="setDuration('3 days')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDuration === '3 days' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                3 days
                            </button>
                            <button type="button" wire:click="setDuration('5 days')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDuration === '5 days' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                5 days
                            </button>
                            <button type="button" wire:click="setDuration('7 days')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDuration === '7 days' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                7 days
                            </button>
                            <button type="button" wire:click="setDuration('14 days')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDuration === '14 days' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                14 days
                            </button>
                            <button type="button" wire:click="setDuration('30 days')" 
                                    class="px-4 py-2 text-sm rounded-lg border {{ $editDuration === '30 days' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                30 days
                            </button>
                        </div>
                    </div>

                    <!-- Quantity (Auto-calculated) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input type="number" wire:model="editQuantity" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-xs text-gray-500 mt-1">Auto-calculated based on dosage and duration</p>
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instructions</label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="setInstructions('After meals')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'After meals' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                After meals
                            </button>
                            <button type="button" wire:click="setInstructions('Before meals')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'Before meals' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                Before meals
                            </button>
                            <button type="button" wire:click="setInstructions('With food')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'With food' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                With food
                            </button>
                            <button type="button" wire:click="setInstructions('Bedtime')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'Bedtime' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                Bedtime
                            </button>
                            <button type="button" wire:click="setInstructions('A.M.')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'A.M.' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                A.M.
                            </button>
                            <button type="button" wire:click="setInstructions('P.M.')" 
                                    class="px-3 py-1.5 text-sm rounded-lg border {{ $editInstructions === 'P.M.' ? 'bg-gray-200 border-gray-400' : 'bg-gray-100 border-gray-300 hover:bg-gray-200' }}">
                                P.M.
                            </button>
                        </div>
                    </div>

                    <!-- Additional Instructions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Instructions</label>
                        <textarea wire:model="editAdditionalInstructions" rows="3" placeholder="Any special instructions..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-lg">
                    <button type="button" wire:click="closePrescriptionModal" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" wire:click="savePrescriptionEdit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Save Status & Navigation -->
    <div class="flex items-center justify-between pt-4 border-t">
        <div class="flex items-center gap-3">
            <button type="button" wire:click="backToExamination" 
                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                ← Back to Examination
            </button>
            <button type="button" wire:click="saveDraft" 
                    class="px-4 py-2 text-sm text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                Save Draft
            </button>
        </div>
        
        <div class="flex items-center gap-3">
            @if($lastSaved)
                <span class="text-xs text-gray-500">Last saved: {{ $lastSaved }}</span>
            @endif
            <button type="button" wire:click="completeConsultation" 
                    class="px-4 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700">
                Complete Consultation ✓
            </button>
        </div>
    </div>
</div>
