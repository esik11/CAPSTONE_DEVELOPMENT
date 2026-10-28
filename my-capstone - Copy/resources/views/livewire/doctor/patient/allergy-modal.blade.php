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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:p-6">
                <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="w-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                                <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Allergies</h3>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Medication Allergies Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Medication Allergies</h4>
                            </div>
                            
                            <!-- Add Custom Medication Allergy -->
                            <div class="mb-4 flex gap-2">
                                <input 
                                    type="text" 
                                    wire:model="newMedicationAllergy"
                                    placeholder="Add custom medication allergy..."
                                    class="flex-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                                <button 
                                    type="button"
                                    wire:click="addCustomMedicationAllergy"
                                    class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm font-medium">
                                    Add
                                </button>
                            </div>
                            @error('newMedicationAllergy')
                                <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($medicationAllergies as $allergen => $severity)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200" wire:key="med-{{ $loop->index }}">
                                    <div class="flex items-start gap-3">
                                        <input 
                                            type="checkbox" 
                                            id="med_{{ $loop->index }}"
                                            @if($severity) checked @endif
                                            @change="if($event.target.checked) { $wire.set('medicationAllergies.{{ $allergen }}', 'mild') } else { $wire.set('medicationAllergies.{{ $allergen }}', null) }"
                                            class="mt-1 h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="med_{{ $loop->index }}" class="block text-sm font-medium text-gray-900">
                                                    {{ $allergen }}
                                                </label>
                                                @if(!in_array($allergen, ['Penicillin', 'Sulphur', 'Aspirin', 'Sulfonamides']))
                                                <button 
                                                    type="button"
                                                    wire:click="removeAllergy('medication', '{{ $allergen }}')"
                                                    class="text-red-600 hover:text-red-700 text-xs">
                                                    Remove
                                                </button>
                                                @endif
                                            </div>
                                            @if($severity)
                                            <div class="space-y-1 ml-1">
                                                <label class="flex items-center">
                                                    <input type="radio" name="med_severity_{{ $allergen }}" wire:model.live="medicationAllergies.{{ $allergen }}" value="mild" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Mild</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="med_severity_{{ $allergen }}" wire:model.live="medicationAllergies.{{ $allergen }}" value="moderate" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Moderate</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="med_severity_{{ $allergen }}" wire:model.live="medicationAllergies.{{ $allergen }}" value="severe" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Severe</span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Non-Medication Allergies Section -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Non-Medication Allergies</h4>
                            </div>
                            
                            <!-- Add Custom Non-Medication Allergy -->
                            <div class="mb-4 flex gap-2">
                                <input 
                                    type="text" 
                                    wire:model="newNonMedicationAllergy"
                                    placeholder="Add custom non-medication allergy..."
                                    class="flex-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                                <button 
                                    type="button"
                                    wire:click="addCustomNonMedicationAllergy"
                                    class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm font-medium">
                                    Add
                                </button>
                            </div>
                            @error('newNonMedicationAllergy')
                                <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($nonMedicationAllergies as $allergen => $severity)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200" wire:key="non-med-{{ $loop->index }}">
                                    <div class="flex items-start gap-3">
                                        <input 
                                            type="checkbox" 
                                            id="non_med_{{ $loop->index }}"
                                            @if($severity) checked @endif
                                            @change="if($event.target.checked) { $wire.set('nonMedicationAllergies.{{ $allergen }}', 'mild') } else { $wire.set('nonMedicationAllergies.{{ $allergen }}', null) }"
                                            class="mt-1 h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="non_med_{{ $loop->index }}" class="block text-sm font-medium text-gray-900">
                                                    {{ $allergen }}
                                                </label>
                                                @if(!in_array($allergen, ['Dust', 'Pollen', 'Latex', 'Elastoplast']))
                                                <button 
                                                    type="button"
                                                    wire:click="removeAllergy('non_medication', '{{ $allergen }}')"
                                                    class="text-red-600 hover:text-red-700 text-xs">
                                                    Remove
                                                </button>
                                                @endif
                                            </div>
                                            @if($severity)
                                            <div class="space-y-1 ml-1">
                                                <label class="flex items-center">
                                                    <input type="radio" name="non_med_severity_{{ $allergen }}" wire:model.live="nonMedicationAllergies.{{ $allergen }}" value="mild" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Mild</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="non_med_severity_{{ $allergen }}" wire:model.live="nonMedicationAllergies.{{ $allergen }}" value="moderate" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Moderate</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="non_med_severity_{{ $allergen }}" wire:model.live="nonMedicationAllergies.{{ $allergen }}" value="severe" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Severe</span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Food Allergies Section -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Food Allergies</h4>
                            </div>
                            
                            <!-- Add Custom Food Allergy -->
                            <div class="mb-4 flex gap-2">
                                <input 
                                    type="text" 
                                    wire:model="newFoodAllergy"
                                    placeholder="Add custom food allergy..."
                                    class="flex-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                                <button 
                                    type="button"
                                    wire:click="addCustomFoodAllergy"
                                    class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-sm font-medium">
                                    Add
                                </button>
                            </div>
                            @error('newFoodAllergy')
                                <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($foodAllergies as $allergen => $severity)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200" wire:key="food-{{ $loop->index }}">
                                    <div class="flex items-start gap-3">
                                        <input 
                                            type="checkbox" 
                                            id="food_{{ $loop->index }}"
                                            @if($severity) checked @endif
                                            @change="if($event.target.checked) { $wire.set('foodAllergies.{{ $allergen }}', 'mild') } else { $wire.set('foodAllergies.{{ $allergen }}', null) }"
                                            class="mt-1 h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="food_{{ $loop->index }}" class="block text-sm font-medium text-gray-900">
                                                    {{ $allergen }}
                                                </label>
                                                @if(!in_array($allergen, ['Dairy', 'Fish']))
                                                <button 
                                                    type="button"
                                                    wire:click="removeAllergy('food', '{{ $allergen }}')"
                                                    class="text-red-600 hover:text-red-700 text-xs">
                                                    Remove
                                                </button>
                                                @endif
                                            </div>
                                            @if($severity)
                                            <div class="space-y-1 ml-1">
                                                <label class="flex items-center">
                                                    <input type="radio" name="food_severity_{{ $allergen }}" wire:model.live="foodAllergies.{{ $allergen }}" value="mild" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Mild</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="food_severity_{{ $allergen }}" wire:model.live="foodAllergies.{{ $allergen }}" value="moderate" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Moderate</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="food_severity_{{ $allergen }}" wire:model.live="foodAllergies.{{ $allergen }}" value="severe" class="text-orange-600 focus:ring-orange-500">
                                                    <span class="ml-2 text-sm text-gray-700">Severe</span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
