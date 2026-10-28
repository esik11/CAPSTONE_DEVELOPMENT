<div class="p-4">
    @if (session()->has('success'))
        <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Talking points
        </h4>
        @if ($isEditing)
            <div class="flex gap-2">
                <button wire:click="save" class="inline-flex items-center gap-1.5 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:border-teal-700 focus:ring focus:ring-teal-200 active:bg-teal-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Save
                </button>
                <button wire:click="cancel" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @else
            <button wire:click="edit" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
        @endif
    </div>

    @if ($isEditing)
        <form wire:submit.prevent="save">
            <textarea wire:model="talkingPoints" class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500" rows="6" placeholder="Enter talking points, one per line or separated by newlines."></textarea>
            @error('talkingPoints') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
        </form>
    @else
        <div class="text-sm text-gray-700 space-y-2">
            @forelse (explode("\n", $talkingPoints) as $point)
                @if (trim($point) !== '')
                    <p>• {{ trim($point) }}</p>
                @endif
            @empty
                <p class="italic text-gray-500">No talking points recorded.</p>
            @endforelse
        </div>
    @endif
</div>
