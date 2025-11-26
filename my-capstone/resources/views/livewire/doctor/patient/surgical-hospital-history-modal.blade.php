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
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
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
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Surgical & Hospital History</h3>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Surgical History Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Surgical History</h4>
                                <button type="button" wire:click="addSurgicalHistory" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                    + Add Surgery
                                </button>
                            </div>

                            @if(count($surgicalHistories) > 0)
                                <div class="space-y-3">
                                    @foreach($surgicalHistories as $index => $history)
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex gap-3 items-start">
                                            <div class="flex-1 space-y-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Surgery Type</label>
                                                    <input 
                                                        type="text" 
                                                        wire:model="surgicalHistories.{{ $index }}.surgery_type" 
                                                        list="common-procedures"
                                                        class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" 
                                                        placeholder="e.g., Appendectomy, Cholecystectomy">
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                                                        <input type="number" wire:model="surgicalHistories.{{ $index }}.year" min="1900" max="{{ date('Y') }}" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="YYYY">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                                    <textarea wire:model="surgicalHistories.{{ $index }}.notes" rows="2" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Additional details..."></textarea>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeSurgicalHistory({{ $index }})" class="mt-8 text-red-600 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic text-center py-4">No surgical history recorded yet</p>
                            @endif

                            {{-- Datalist for common procedures --}}
                            <datalist id="common-procedures">
                                @foreach($commonProcedures as $category => $procedures)
                                    @foreach($procedures as $procedure)
                                        <option value="{{ $procedure->name }}">{{ $category }}</option>
                                    @endforeach
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Hospitalization History Section -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Hospitalization History</h4>
                                <button type="button" wire:click="addHospitalization" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                    + Add Hospitalization
                                </button>
                            </div>

                            @if(count($hospitalizations) > 0)
                                <div class="space-y-3">
                                    @foreach($hospitalizations as $index => $hosp)
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex gap-3 items-start">
                                            <div class="flex-1 space-y-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Hospitalization</label>
                                                    <input type="text" wire:model="hospitalizations.{{ $index }}.reason" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="e.g., Pneumonia, Heart Attack">
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Hospital Name</label>
                                                        <input type="text" wire:model="hospitalizations.{{ $index }}.hospital_name" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Hospital name">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                                                        <input type="number" wire:model="hospitalizations.{{ $index }}.year" min="1900" max="{{ date('Y') }}" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeHospitalization({{ $index }})" class="mt-8 text-red-600 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic text-center py-4">No hospitalization records yet</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
