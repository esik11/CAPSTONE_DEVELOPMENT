<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4" 
     wire:key="allergies-{{ $refreshKey }}"
     x-data 
     @allergies-updated.window="$wire.$refresh()">
    <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-gray-900">Allergies</h4>
        <button 
            @click="$dispatch('openAllergyModal')"
            class="text-orange-600 hover:text-orange-700 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
    </div>
    @if($allergies->count() > 0)
        <div class="space-y-2">
            @foreach($allergies as $allergy)
            <div class="p-2 bg-orange-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-900">{{ $allergy->allergen_name }}</span>
                    <span class="px-2 py-0.5 bg-orange-100 text-orange-800 text-xs rounded font-medium">{{ ucfirst($allergy->severity) }}</span>
                </div>
                <span class="text-xs text-gray-600">{{ ucfirst(str_replace('_', ' ', $allergy->type)) }}</span>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No known allergies</p>
    @endif
</div>
