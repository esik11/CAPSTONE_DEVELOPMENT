<div x-data="{ show: @entangle('show') }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
             aria-hidden="true"
             @click="show = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-purple-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Upload Lab Result</h3>
                    <p class="text-sm text-gray-500 mb-4">Attach images or findings for the physician to review.</p>
                </div>
            </div>

            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                <!-- Test Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" wire:model="category" value="laboratory" class="text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Laboratory</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="category" value="imaging" class="text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Imaging</span>
                        </label>
                    </div>
                </div>

                <!-- Test Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Test Name</label>
                    <input type="text" wire:model="test_name" placeholder="e.g., Chest X-Ray, CBC"
                           class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                    @error('test_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Findings -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Results & Findings</label>
                    <textarea wire:model="results_findings" rows="3" placeholder="Brief summary of findings..."
                              class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"></textarea>
                </div>

                <!-- Attachment -->
                <div x-data="{ isUploading: false, progress: 0 }"
                     x-on:livewire-upload-start="isUploading = true"
                     x-on:livewire-upload-finish="isUploading = false"
                     x-on:livewire-upload-error="isUploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image Attachment</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-purple-400 transition-colors">
                        <div class="space-y-1 text-center">
                            @if($attachment)
                                <div class="mb-3 relative inline-block">
                                    <img src="{{ $attachment->temporaryUrl() }}" class="h-32 w-auto rounded shadow-lg border-2 border-purple-200">
                                    <button type="button" @click="$wire.set('attachment', null)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-green-600 font-bold">Image Ready!</p>
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500">
                                        <span>Upload a file</span>
                                        <input type="file" wire:model="attachment" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 10MB</p>
                            @endif

                            <!-- Uploading Progress -->
                            <div x-show="isUploading" class="mt-4">
                                <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-1 bg-purple-500" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1">Uploading... <span x-text="progress"></span>%</p>
                            </div>
                        </div>
                    </div>
                    @error('attachment') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <span wire:loading.remove>Save Result</span>
                        <span wire:loading>Saving...</span>
                    </button>
                    <button type="button" @click="show = false"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
