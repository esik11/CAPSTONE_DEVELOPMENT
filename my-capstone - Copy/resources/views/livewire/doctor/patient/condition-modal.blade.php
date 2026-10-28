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
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Manage Medical Conditions</h3>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    @if (session()->has('condition_added'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
                            {{ session('condition_added') }}
                        </div>
                    @endif
                    
                    @if (session()->has('condition_deleted'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800">
                            {{ session('condition_deleted') }}
                        </div>
                    @endif

                    <!-- Search Box & Add Custom -->
                    <div class="mb-4 space-y-3">
                        <input 
                            type="text" 
                            wire:model.live="searchTerm"
                            placeholder="Search conditions..."
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                        
                        <!-- Add Custom Condition -->
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                wire:model="newConditionName"
                                placeholder="Add custom condition..."
                                class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >
                            <button 
                                type="button"
                                wire:click="addCustomCondition"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                                Add
                            </button>
                        </div>
                        @error('newConditionName')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Show All Toggle -->
                        @if(!$searchTerm)
                        <button 
                            type="button"
                            wire:click="$toggle('showAllConditions')"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            {{ $showAllConditions ? '← Show Common Conditions Only' : 'Show All Conditions →' }}
                        </button>
                        @endif
                    </div>

                    <form wire:submit.prevent="save" class="space-y-4">
                        <div class="max-h-96 overflow-y-auto pr-2 space-y-4" wire:key="conditions-list-{{ count($patientConditions) }}-{{ count($availableConditions) }}">
                            <!-- Patient's Existing Conditions -->
                            @if($patientConditions->count() > 0)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Patient's Current Conditions
                                </h4>
                                <div class="space-y-2">
                                    @foreach($patientConditions as $condition)
                                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200" wire:key="patient-cond-{{ $condition->id }}">
                                        <div class="flex items-start gap-3">
                                            <input 
                                                type="checkbox" 
                                                id="condition_{{ $condition->id }}"
                                                wire:click="toggleCondition({{ $condition->id }})"
                                                @if(isset($selectedConditions[$condition->id]['selected']) && $selectedConditions[$condition->id]['selected']) checked @endif
                                                class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="condition_{{ $condition->id }}" class="block text-sm font-medium text-gray-900 cursor-pointer">
                                                        {{ $condition->condition_name }}
                                                    </label>
                                                    <button 
                                                        type="button"
                                                        wire:click="togglePin({{ $condition->id }})"
                                                        class="text-yellow-600 hover:text-yellow-700">
                                                        @if(isset($selectedConditions[$condition->id]['is_pinned']) && $selectedConditions[$condition->id]['is_pinned'])
                                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                            <path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z" />
                                                        </svg>
                                                        @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                                        </svg>
                                                        @endif
                                                    </button>
                                                </div>
                                                
                                                @if(isset($selectedConditions[$condition->id]['selected']) && $selectedConditions[$condition->id]['selected'])
                                                <div class="space-y-2 ml-1">
                                                    <!-- Status Toggle -->
                                                    <div class="flex items-center gap-4">
                                                        <span class="text-sm text-gray-700">Status:</span>
                                                        <label class="flex items-center cursor-pointer">
                                                            <input 
                                                                type="radio" 
                                                                wire:model="selectedConditions.{{ $condition->id }}.status" 
                                                                value="1"
                                                                class="text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm text-gray-700">Active</span>
                                                        </label>
                                                        <label class="flex items-center cursor-pointer">
                                                            <input 
                                                                type="radio" 
                                                                wire:model="selectedConditions.{{ $condition->id }}.status" 
                                                                value="0"
                                                                class="text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                                        </label>
                                                    </div>
                                                    
                                                    <!-- Notes -->
                                                    <div>
                                                        <textarea 
                                                            wire:model="selectedConditions.{{ $condition->id }}.notes"
                                                            rows="2"
                                                            class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                                            placeholder="Add notes about this condition..."></textarea>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Available Conditions -->
                            @if($availableConditions->count() > 0)
                            <div>
                                @if($patientConditions->count() > 0)
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Common Medical Conditions</h4>
                                @endif
                                <div class="space-y-2">
                                    @foreach($availableConditions as $condition)
                                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200" wire:key="avail-cond-{{ $condition->id }}">
                                        <div class="flex items-start gap-3">
                                            <input 
                                                type="checkbox" 
                                                id="condition_{{ $condition->id }}"
                                                wire:click="toggleCondition({{ $condition->id }})"
                                                @if(isset($selectedConditions[$condition->id]['selected']) && $selectedConditions[$condition->id]['selected']) checked @endif
                                                class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="condition_{{ $condition->id }}" class="block text-sm font-medium text-gray-900 cursor-pointer">
                                                        {{ $condition->condition_name }}
                                                    </label>
                                                    @if($searchTerm || $showAllConditions)
                                                    <button 
                                                        type="button"
                                                        wire:click="deleteCondition({{ $condition->id }})"
                                                        wire:confirm="Are you sure you want to delete this condition?"
                                                        class="text-red-600 hover:text-red-700 text-xs">
                                                        Delete
                                                    </button>
                                                    @endif
                                                </div>
                                                
                                                @if(isset($selectedConditions[$condition->id]['selected']) && $selectedConditions[$condition->id]['selected'])
                                                <div class="space-y-2 ml-1">
                                                    <!-- Status Toggle -->
                                                    <div class="flex items-center gap-4">
                                                        <span class="text-sm text-gray-700">Status:</span>
                                                        <label class="flex items-center cursor-pointer">
                                                            <input 
                                                                type="radio" 
                                                                wire:model="selectedConditions.{{ $condition->id }}.status" 
                                                                value="1"
                                                                class="text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm text-gray-700">Active</span>
                                                        </label>
                                                        <label class="flex items-center cursor-pointer">
                                                            <input 
                                                                type="radio" 
                                                                wire:model="selectedConditions.{{ $condition->id }}.status" 
                                                                value="0"
                                                                class="text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                                        </label>
                                                    </div>
                                                    
                                                    <!-- Pin Toggle -->
                                                    <div class="flex items-center gap-2">
                                                        <label class="flex items-center cursor-pointer">
                                                            <input 
                                                                type="checkbox" 
                                                                wire:model="selectedConditions.{{ $condition->id }}.is_pinned"
                                                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                                            <span class="ml-2 text-sm text-gray-700">Pin to summary</span>
                                                        </label>
                                                    </div>
                                                    
                                                    <!-- Notes -->
                                                    <div>
                                                        <textarea 
                                                            wire:model="selectedConditions.{{ $condition->id }}.notes"
                                                            rows="2"
                                                            class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                                            placeholder="Add notes about this condition..."></textarea>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

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
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Save Conditions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
