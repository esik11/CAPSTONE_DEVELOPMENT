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
                <!-- MEDICINE TAB (Coming soon) -->
                <div class="text-center py-12 text-gray-500">
                    <p class="text-lg font-medium mb-2">Medicine Prescription</p>
                    <p class="text-sm">Coming in next step...</p>
                </div>
            @endif
        </div>
    </div>

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
