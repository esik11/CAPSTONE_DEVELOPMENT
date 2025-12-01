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
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl sm:p-6">
                <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
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
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-pink-100">
                                <svg class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Gynecological History</h3>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Contraception Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Contraception</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.oral_contraceptive_pill"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Oral Contraceptive Pill</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.contraceptive_implant"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Contraceptive Implant</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.uid"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">IUD</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.contraceptive_injection"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Contraceptive Injection</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.contraceptive_ring"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Contraceptive Ring</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.diaphragm"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Diaphragm</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="contraceptionMethods.sterilisation"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Sterilisation</span>
                                </label>
                            </div>
                            
                            <!-- Additional Comments -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Comments</label>
                                <textarea 
                                    wire:model="contraceptionComments"
                                    rows="2"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                    placeholder="Add any additional notes about contraception..."></textarea>
                            </div>
                        </div>
                        
                        <!-- Menstrual History Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Menstrual History</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Age at Menarche</label>
                                    <input 
                                        type="number" 
                                        wire:model="ageAtMenarche"
                                        min="8"
                                        max="20"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Age">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Menstrual Period</label>
                                    <input 
                                        type="date" 
                                        wire:model="lastMenstrualPeriod"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cycle Regularity</label>
                                    <select 
                                        wire:model="cycleRegularity"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                                        <option value="">Select</option>
                                        <option value="regular">Regular</option>
                                        <option value="irregular">Irregular</option>
                                        <option value="stopped">Stopped</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cycle Length (Days)</label>
                                    <input 
                                        type="number" 
                                        wire:model="cycleLengthDays"
                                        min="21"
                                        max="45"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="Days">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Menstrual Issues</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <input 
                                            type="checkbox" 
                                            wire:model="menstrualIssues.heavy_bleeding"
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-900">Heavy Bleeding (Menorrhagia)</span>
                                    </label>
                                    
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <input 
                                            type="checkbox" 
                                            wire:model="menstrualIssues.painful_periods"
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-900">Painful Periods (Dysmenorrhea)</span>
                                    </label>
                                    
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <input 
                                            type="checkbox" 
                                            wire:model="menstrualIssues.irregular_periods"
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-900">Irregular Periods</span>
                                    </label>
                                    
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <input 
                                            type="checkbox" 
                                            wire:model="menstrualIssues.spotting"
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-900">Spotting Between Periods</span>
                                    </label>
                                    
                                    <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <input 
                                            type="checkbox" 
                                            wire:model="menstrualIssues.amenorrhea"
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-900">Amenorrhea (Absent Periods)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Comments</label>
                                <textarea 
                                    wire:model="menstrualComments"
                                    rows="2"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                    placeholder="Add any additional notes about menstrual history..."></textarea>
                            </div>
                        </div>
                        
                        <!-- Pregnancies Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Pregnancy History</h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Pregnancies</label>
                                    <input 
                                        type="number" 
                                        wire:model="numberOfPregnancies"
                                        min="0"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Children</label>
                                    <input 
                                        type="number" 
                                        wire:model="numberOfChildren"
                                        min="0"
                                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pregnancy Complications Section -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Pregnancy Complications</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="pregnancyComplications.miscarriage"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Miscarriage</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="pregnancyComplications.gestational_diabetes"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Gestational Diabetes</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="pregnancyComplications.preeclampsia"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Preeclampsia</span>
                                </label>
                                
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input 
                                        type="checkbox" 
                                        wire:model="pregnancyComplications.ectopic_pregnancy"
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-900">Ectopic Pregnancy</span>
                                </label>
                            </div>
                            
                            <!-- Additional Comments -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Comments</label>
                                <textarea 
                                    wire:model="pregnancyComplicationsComments"
                                    rows="2"
                                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                    placeholder="Add any additional notes about pregnancy complications..."></textarea>
                            </div>
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
                                class="px-4 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg hover:bg-pink-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
