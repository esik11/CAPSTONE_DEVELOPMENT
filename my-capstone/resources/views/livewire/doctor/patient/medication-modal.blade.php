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
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
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
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Manage Medications</h3>
                        </div>
                        <button 
                            type="button" 
                            wire:click="addMedication"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                            + Add Medication
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-4">
                        @if(count($medications) > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                                @foreach($medications as $index => $medication)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex gap-3 items-start">
                                        <div class="flex-1 space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Medicine Name <span class="text-red-500">*</span>
                                                </label>
                                                <input 
                                                    type="text" 
                                                    wire:model="medications.{{ $index }}.medicine_name"
                                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                                    placeholder="e.g., Metformin, Amlodipine">
                                                @error('medications.' . $index . '.medicine_name')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                                                    <input 
                                                        type="text" 
                                                        wire:model="medications.{{ $index }}.dosage"
                                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                                        placeholder="e.g., 500mg, 5ml">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Frequency</label>
                                                    <input 
                                                        type="text" 
                                                        wire:model="medications.{{ $index }}.frequency"
                                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                                        placeholder="e.g., Twice daily, As needed">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button 
                                            type="button" 
                                            wire:click="removeMedication({{ $index }})"
                                            class="mt-8 text-red-600 hover:text-red-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p class="mb-4">No medications added yet</p>
                                <button 
                                    type="button" 
                                    wire:click="addMedication"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                                    + Add First Medication
                                </button>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button 
                                type="button" 
                                wire:click="closeModal" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                Save Medications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
