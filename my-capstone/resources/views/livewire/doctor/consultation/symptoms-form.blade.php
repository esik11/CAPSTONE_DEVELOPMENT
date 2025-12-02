<div class="space-y-6" wire:poll.30s="autoSave">
    <!-- Documentation Mode Toggle -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Documentation Mode</h3>
            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                <button type="button"
                        wire:click="switchMode('template')"
                        class="px-4 py-2 text-sm font-medium {{ $documentationMode === 'template' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Smart Templates
                </button>
                <button type="button"
                        wire:click="switchMode('free-text')"
                        class="px-4 py-2 text-sm font-medium {{ $documentationMode === 'free-text' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Free Text
                </button>
            </div>
        </div>
    </div>

    @if($documentationMode === 'template')
        <!-- Visit Type Selection -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Visit Type (Optional)</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($availableVisitTypes as $vt)
                    <button type="button"
                            wire:click="selectVisitType('{{ $vt['visit_type_name'] }}')"
                            class="px-4 py-3 text-sm font-medium rounded-lg border-2 transition-all
                                {{ $visitType === $vt['visit_type_name'] 
                                    ? 'border-blue-500 bg-blue-50 text-blue-700' 
                                    : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                        {{ $vt['visit_type_name'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Complaint Selection -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Chief Complaints</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($availableComplaints as $complaint)
                    <button type="button"
                            wire:click="selectComplaint('{{ $complaint['complaint_name'] }}')"
                            class="px-4 py-3 text-sm font-medium rounded-lg border-2 transition-all text-left
                                {{ in_array($complaint['complaint_name'], $selectedComplaints) 
                                    ? 'border-blue-500 bg-blue-50 text-blue-700' 
                                    : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                        {{ $complaint['complaint_name'] }}
                    </button>
                @endforeach
            </div>
            
            @error('selectedComplaints')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Template Questions -->
        @if(!empty($mergedQuestions))
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Template Questions</h3>
                <div class="space-y-6">
                    @foreach($mergedQuestions as $question)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $question['label'] }}
                                @if($question['required'] ?? false)
                                    <span class="text-red-500">*</span>
                                @endif
                                <span class="text-xs text-gray-500">({{ $question['complaint'] }})</span>
                            </label>

                            @if($question['type'] === 'text')
                                <input type="text"
                                       wire:model.live.debounce.500ms="templateResponses.{{ $question['id'] }}"
                                       placeholder="{{ $question['placeholder'] ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            
                            @elseif($question['type'] === 'number')
                                <input type="number"
                                       wire:model.live.debounce.500ms="templateResponses.{{ $question['id'] }}"
                                       placeholder="{{ $question['placeholder'] ?? '' }}"
                                       step="0.1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            
                            @elseif($question['type'] === 'radio')
                                <div class="space-y-2">
                                    @foreach($question['options'] as $option)
                                        <label class="flex items-center">
                                            <input type="radio"
                                                   wire:model.live="templateResponses.{{ $question['id'] }}"
                                                   value="{{ $option }}"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            
                            @elseif($question['type'] === 'checkbox')
                                <div class="space-y-2">
                                    @foreach($question['options'] as $option)
                                        @php
                                            $isChecked = is_array($templateResponses[$question['id']] ?? null) 
                                                && in_array($option, $templateResponses[$question['id']]);
                                        @endphp
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   wire:click="toggleCheckbox('{{ $question['id'] }}', '{{ $option }}')"
                                                   @if($isChecked) checked @endif
                                                   id="checkbox_{{ $question['id'] }}_{{ $loop->index }}"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Auto-Generated Notes -->
        @if(!empty($symptomNotesAuto))
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Auto-Generated Clinical Notes
                    <span class="text-sm font-normal text-gray-500">(Editable)</span>
                </h3>
                <textarea wire:model.live.debounce.500ms="symptomNotesAuto"
                          rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"></textarea>
            </div>
        @endif
    @endif

    <!-- Manual Notes (Always Available) -->
    <div class="bg-white rounded-lg shadow p-6" x-data="{ 
        content: @entangle('symptomNotesManual'),
        quill: null,
        init() {
            this.$nextTick(() => {
                if (typeof Quill !== 'undefined') {
                    this.quill = new Quill(this.$refs.editor, {
                        theme: 'snow',
                        placeholder: 'Enter additional clinical notes here...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['clean']
                            ]
                        }
                    });
                    
                    // Set initial content
                    if (this.content) {
                        this.quill.root.innerHTML = this.content;
                    }
                    
                    // Update Livewire when content changes
                    this.quill.on('text-change', () => {
                        this.content = this.quill.root.innerHTML;
                    });
                    
                    // Update Quill when Livewire changes
                    this.$watch('content', (value) => {
                        if (this.quill && this.quill.root.innerHTML !== value) {
                            this.quill.root.innerHTML = value || '';
                        }
                    });
                }
            });
        }
    }">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            {{ $documentationMode === 'free-text' ? 'Clinical Notes' : 'Additional Notes' }}
        </h3>
        <div x-ref="editor" class="bg-white border border-gray-300 rounded-lg" style="min-height: 200px;"></div>
        @error('symptomNotesManual')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Additional Symptom Details -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Onset</label>
                <input type="text"
                       wire:model.live.debounce.500ms="symptomOnset"
                       placeholder="e.g., Sudden, Gradual"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                <div class="flex gap-2">
                    <input type="number"
                           wire:model.live.debounce.500ms="symptomDuration"
                           placeholder="Duration"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <select wire:model.live="symptomDurationUnit"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="hours">Hours</option>
                        <option value="days">Days</option>
                        <option value="weeks">Weeks</option>
                        <option value="months">Months</option>
                        <option value="years">Years</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Aggravating Factors</label>
                <input type="text"
                       wire:model.live.debounce.500ms="aggravatingFactors"
                       placeholder="What makes it worse?"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Relieving Factors</label>
                <input type="text"
                       wire:model.live.debounce.500ms="relievingFactors"
                       placeholder="What makes it better?"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox"
                       wire:model.live="previousEpisodes"
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="ml-2 text-sm font-medium text-gray-700">Previous similar episodes?</span>
            </label>
            
            @if($previousEpisodes)
                <textarea wire:model.live.debounce.500ms="previousEpisodesDetails"
                          rows="3"
                          placeholder="Describe previous episodes..."
                          class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <button type="button"
                    wire:click="saveDraft"
                    wire:loading.attr="disabled"
                    class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50">
                <span wire:loading.remove wire:target="saveDraft">Save Draft</span>
                <span wire:loading wire:target="saveDraft">Saving...</span>
            </button>

            <button type="button"
                    wire:click="continueToExamination"
                    wire:loading.attr="disabled"
                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 disabled:opacity-50">
                <span wire:loading.remove wire:target="continueToExamination">Continue to Examination</span>
                <span wire:loading wire:target="continueToExamination">Processing...</span>
            </button>
        </div>
    </div>

    <!-- Auto-save indicator -->
    @if($lastSaved)
        <div class="text-center text-sm text-gray-500">
            Last saved at {{ $lastSaved }}
        </div>
    @endif
</div>
