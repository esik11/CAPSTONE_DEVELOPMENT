<div
    x-data="{ show: @entangle('isOpen') }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    wire:ignore.self
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    {{-- Overlay --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    {{-- Modal Content --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 z-10 w-screen overflow-y-auto"
    >
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:p-6 max-h-[90vh] overflow-y-auto">
                <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="w-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-teal-100">
                                <svg class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Lifestyle & Family History</h3>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Parents Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Parents</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Marital Status</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="parents_status" value="Married" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Married</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="parents_status" value="Unmarried" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Unmarried</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="parents_status" value="Divorced" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Divorced</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="parents_status" value="Separated" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Separated</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="parents_status" value="Unknown" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Unknown</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                                    <textarea wire:model="parents_comments" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Any additional information about parents..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Lifestyle Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Lifestyle</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Smoking Section -->
                                <div class="p-4 bg-gray-50 rounded-lg space-y-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Smoking</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="smoking" value="Never" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Never smoke</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="smoking" value="Smoker" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Smoker</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="smoking" value="Ex-smoker" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Ex-smoker</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="smoking" value="Social smoker" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Social smoker</span>
                                        </label>
                                    </div>

                                    @if(in_array($smoking, ['Smoker', 'Ex-smoker', 'Social smoker']))
                                    <div class="mt-4 space-y-3 pl-6 border-l-2 border-teal-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">For how many years have you smoked?</label>
                                            <input type="number" wire:model="smoking_years" min="0" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Years">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Average Daily Cigarettes</label>
                                            <input type="number" wire:model="smoking_daily_cigarettes" min="0" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Number of cigarettes">
                                        </div>
                                        @if($smoking_years && $smoking_daily_cigarettes)
                                        <div class="p-2 bg-teal-50 rounded text-sm">
                                            <span class="font-medium text-teal-900">Your smoking exposure is {{ number_format(($smoking_years * $smoking_daily_cigarettes) / 20, 1) }} pack-years</span>
                                        </div>
                                        @endif
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                                            <textarea wire:model="smoking_comments" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Any additional information..."></textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Alcohol Section -->
                                <div class="p-4 bg-gray-50 rounded-lg space-y-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alcohol</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="alcohol" value="None" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">None</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="alcohol" value="Social" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Social</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="alcohol" value="Light" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Light</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="alcohol" value="Heavy" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Heavy</span>
                                        </label>
                                    </div>

                                    @if(in_array($alcohol, ['Social', 'Light', 'Heavy']))
                                    <div class="mt-4 pl-6 border-l-2 border-teal-200">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                                        <textarea wire:model="alcohol_comments" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Frequency, type of alcohol, etc..."></textarea>
                                    </div>
                                    @endif
                                </div>

                                <!-- Drug Use Section -->
                                <div class="p-4 bg-gray-50 rounded-lg space-y-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Drug Use</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="drug_use" value="Never" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Never</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="drug_use" value="Former" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Former</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="drug_use" value="Current" class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2 text-sm text-gray-700">Current</span>
                                        </label>
                                    </div>

                                    @if(in_array($drug_use, ['Former', 'Current']))
                                    <div class="mt-4 space-y-3 pl-6 border-l-2 border-teal-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">What type of drugs?</label>
                                            <input type="text" wire:model="drug_type" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="e.g., Marijuana, Cocaine, etc.">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                                            <textarea wire:model="drug_comments" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Frequency, duration, treatment history, etc..."></textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Diet & Exercise</label>
                                    <textarea wire:model="diet_exercise" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Describe diet and exercise habits..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                    <input type="text" wire:model="occupation" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Enter occupation">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Living Situation</label>
                                    <textarea wire:model="living_situation" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="Describe living situation..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Family History Section -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Family History</h4>
                                <button type="button" wire:click="addFamilyHistory" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                                    + Add Family History
                                </button>
                            </div>

                            @if(count($familyHistories) > 0)
                                <div class="space-y-3">
                                    @foreach($familyHistories as $index => $history)
                                    <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1 grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Relative</label>
                                                <select wire:model="familyHistories.{{ $index }}.relative" class="w-full text-sm rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                                                    <option value="">Select</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Grandfather">Grandfather</option>
                                                    <option value="Grandmother">Grandmother</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Aunt">Aunt</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Condition</label>
                                                <input type="text" wire:model="familyHistories.{{ $index }}.condition" class="w-full text-sm rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500" placeholder="e.g., Diabetes, Hypertension">
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeFamilyHistory({{ $index }})" class="mt-6 text-red-600 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic text-center py-4">No family history recorded yet</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
