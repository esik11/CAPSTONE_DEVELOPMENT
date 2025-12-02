<div class="space-y-3" wire:poll.30s="autoSave">
    
    <!-- General Section with Vitals -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: true }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">General</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <!-- Vital Signs Grid -->
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Temperature</label>
                        <div class="flex items-center gap-1">
                            <input type="number" step="0.1" wire:model.blur="temperature" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="37.0">
                            <span class="text-xs text-gray-500">°C</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Pulse rate</label>
                        <div class="flex items-center gap-1">
                            <input type="number" wire:model.blur="pulseRate" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="72">
                            <span class="text-xs text-gray-500">bpm</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Blood pressure</label>
                        <div class="flex items-center gap-1">
                            <input type="text" wire:model.blur="bloodPressure" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="120/80">
                            <span class="text-xs text-gray-500">mmHg</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Respiratory rate</label>
                        <div class="flex items-center gap-1">
                            <input type="number" wire:model.blur="respiratoryRate" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="16">
                            <span class="text-xs text-gray-500">/min</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">SpO2</label>
                        <div class="flex items-center gap-1">
                            <input type="number" wire:model.blur="spo2" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="98">
                            <span class="text-xs text-gray-500">%</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Weight</label>
                        <div class="flex items-center gap-1">
                            <input type="number" step="0.1" wire:model.blur="weight" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="70">
                            <span class="text-xs text-gray-500">kg</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Height</label>
                        <div class="flex items-center gap-1">
                            <input type="number" wire:model.blur="height" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="170">
                            <span class="text-xs text-gray-500">cm</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Waist circumference</label>
                        <div class="flex items-center gap-1">
                            <input type="number" wire:model.blur="waistCircumference" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="85">
                            <span class="text-xs text-gray-500">cm</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">BMI</label>
                        <input type="text" value="{{ $this->bmi }}" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 bg-gray-50" placeholder="--" readonly>
                    </div>
                </div>
                
                <!-- General Appearance -->
                <div x-data="{ 
                    content: @entangle('generalAppearance'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'General appearance notes...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">General Appearance</label>
                        <button type="button" wire:click="useNormalFinding('general')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cardiovascular & Heart Function -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Cardiovascular & heart function</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <!-- Cardiovascular Findings Checkboxes -->
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $cardiovascularFindings = [
                                'Regular rate and rhythm',
                                'S1 and S2 normal',
                                'No murmurs',
                                'No rubs',
                                'No gallops',
                                'Peripheral pulses normal',
                                'No edema',
                                'JVP normal'
                            ];
                        @endphp
                        @foreach($cardiovascularFindings as $finding)
                            @php
                                $isChecked = is_array($cardiovascularFindings_selected ?? null) 
                                    && in_array($finding, $cardiovascularFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('cardiovascularFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Additional Comments -->
                <div x-data="{ 
                    content: @entangle('cardiovascularExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional cardiovascular findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('cardiovascular')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Respiratory System -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Respiratory system</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <!-- Respiratory Findings Checkboxes -->
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $respiratoryFindings = [
                                'Clear to auscultation bilaterally',
                                'Good air entry',
                                'No wheezes',
                                'No rales/crackles',
                                'No rhonchi',
                                'Normal respiratory effort',
                                'No use of accessory muscles',
                                'Chest expansion equal'
                            ];
                        @endphp
                        @foreach($respiratoryFindings as $finding)
                            @php
                                $isChecked = is_array($respiratoryFindings_selected ?? null) 
                                    && in_array($finding, $respiratoryFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('respiratoryFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Additional Comments -->
                <div x-data="{ 
                    content: @entangle('respiratoryExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional respiratory findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('respiratory')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Abdominal Examination -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Abdominal examination</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $abdominalFindings = [
                                'Soft',
                                'Non-tender',
                                'Non-distended',
                                'Bowel sounds present',
                                'No organomegaly',
                                'No rebound',
                                'No guarding',
                                'No masses palpable'
                            ];
                        @endphp
                        @foreach($abdominalFindings as $finding)
                            @php
                                $isChecked = is_array($abdominalFindings_selected ?? null) 
                                    && in_array($finding, $abdominalFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('abdominalFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ 
                    content: @entangle('abdominalExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional abdominal findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('abdominal')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Neurological Examination -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Neurological examination</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $neurologicalFindings = [
                                'Alert and oriented x3',
                                'Cranial nerves II-XII intact',
                                'Motor strength 5/5',
                                'Sensation intact',
                                'Reflexes 2+ symmetric',
                                'Gait normal',
                                'Coordination normal',
                                'No focal deficits'
                            ];
                        @endphp
                        @foreach($neurologicalFindings as $finding)
                            @php
                                $isChecked = is_array($neurologicalFindings_selected ?? null) 
                                    && in_array($finding, $neurologicalFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('neurologicalFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ 
                    content: @entangle('neurologicalExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional neurological findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('neurological')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Musculoskeletal Examination -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Musculoskeletal examination</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $musculoskeletalFindings = [
                                'Full range of motion',
                                'No joint swelling',
                                'No erythema',
                                'No warmth',
                                'No deformities',
                                'Gait normal',
                                'Muscle strength normal',
                                'No tenderness'
                            ];
                        @endphp
                        @foreach($musculoskeletalFindings as $finding)
                            @php
                                $isChecked = is_array($musculoskeletalFindings_selected ?? null) 
                                    && in_array($finding, $musculoskeletalFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('musculoskeletalFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ 
                    content: @entangle('musculoskeletalExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional musculoskeletal findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('musculoskeletal')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- HEENT (Head, Eyes, Ears, Nose, Throat) -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">HEENT</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $heentFindings = [
                                'Normocephalic',
                                'Atraumatic',
                                'PERRLA',
                                'TMs intact',
                                'Oropharynx clear',
                                'No erythema',
                                'Neck supple',
                                'No lymphadenopathy'
                            ];
                        @endphp
                        @foreach($heentFindings as $finding)
                            @php
                                $isChecked = is_array($heentFindings_selected ?? null) 
                                    && in_array($finding, $heentFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('heentFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ 
                    content: @entangle('heentExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional HEENT findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('heent')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skin Examination -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Skin examination</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Findings</label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $skinFindings = [
                                'Warm',
                                'Dry',
                                'Intact',
                                'No rashes',
                                'No lesions',
                                'No discoloration',
                                'Good turgor',
                                'Capillary refill <2 sec'
                            ];
                        @endphp
                        @foreach($skinFindings as $finding)
                            @php
                                $isChecked = is_array($skinFindings_selected ?? null) 
                                    && in_array($finding, $skinFindings_selected);
                            @endphp
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       wire:click="toggleExamCheckbox('skinFindings', '{{ $finding }}')"
                                       @if($isChecked) checked @endif
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $finding }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ 
                    content: @entangle('skinExam'),
                    quill: null,
                    init() {
                        this.$nextTick(() => {
                            if (typeof Quill !== 'undefined') {
                                this.quill = new Quill(this.$refs.editor, {
                                    theme: 'snow',
                                    placeholder: 'Additional skin findings or comments...',
                                    modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                                });
                                if (this.content) { this.quill.root.innerHTML = this.content; }
                                this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                            }
                        });
                    }
                }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-gray-700">Additional Comments</label>
                        <button type="button" wire:click="useNormalFinding('skin')" 
                                class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Use Normal
                        </button>
                    </div>
                    <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Examination Notes -->
    <div class="bg-white rounded-lg shadow" x-data="{ open: false }">
        <div class="p-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="open = !open">
            <h3 class="text-sm font-semibold text-gray-900">Additional notes</h3>
            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" x-collapse>
            <div class="p-4" x-data="{ 
                content: @entangle('examinationNotes'),
                quill: null,
                init() {
                    this.$nextTick(() => {
                        if (typeof Quill !== 'undefined') {
                            this.quill = new Quill(this.$refs.editor, {
                                theme: 'snow',
                                placeholder: 'Any additional examination notes or observations...',
                                modules: { toolbar: [['bold', 'italic'], [{ 'list': 'bullet' }]] }
                            });
                            if (this.content) { this.quill.root.innerHTML = this.content; }
                            this.quill.on('text-change', () => { this.content = this.quill.root.innerHTML; });
                        }
                    });
                }
            }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Examination Notes</label>
                <div x-ref="editor" class="bg-white border border-gray-300 rounded" style="min-height: 80px;"></div>
            </div>
        </div>
    </div>

    <!-- Save Status & Navigation -->
    <div class="flex items-center justify-between pt-4 border-t">
        <div class="flex items-center gap-3">
            <button type="button" wire:click="backToSymptoms" 
                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                ← Back to Symptoms
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
            <button type="button" wire:click="continueToDiagnosis" 
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                Continue to Diagnosis →
            </button>
        </div>
    </div>
</div>
