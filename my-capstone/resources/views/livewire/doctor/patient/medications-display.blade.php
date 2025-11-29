<div wire:key="medications-{{ $refreshKey }}" 
     x-data 
     @medications-updated.window="$wire.$refresh()">
    <div class="flex items-center justify-between mb-2">
        <p class="font-medium text-gray-700 text-sm">Active Medications</p>
        <button 
            @click="$dispatch('openMedicationModal')"
            class="text-green-600 hover:text-green-700 text-xs font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
    </div>
    @if($medications->count() > 0)
        <div class="space-y-2">
            @foreach($medications->take(5) as $med)
            <div class="text-sm">
                <p class="font-medium text-gray-900">{{ $med->medicine_name }}</p>
                <p class="text-gray-600">{{ $med->dosage }} - {{ $med->frequency }}</p>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No active medications</p>
    @endif
</div>
