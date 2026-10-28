@if($showInSummary)
    {{-- Summary View (for Conditions & Medications card) - Only Pinned --}}
    <div wire:key="conditions-summary-{{ $refreshKey }}" 
         x-data 
         @conditions-updated.window="$wire.$refresh()">
        <div class="flex items-center justify-between mb-2">
            <p class="font-medium text-gray-700 text-sm flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-600 fill-current" viewBox="0 0 24 24">
                    <path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z" />
                </svg>
                Pinned Conditions
            </p>
            <button 
                @click="$dispatch('openConditionModal')"
                class="text-blue-600 hover:text-blue-700 text-xs font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>
        @if($conditions->count() > 0)
            <div class="space-y-2">
                @foreach($conditions as $condition)
                <div class="text-sm p-2 bg-yellow-50 rounded border border-yellow-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $condition->condition_name }}</p>
                            @if($condition->pivot && $condition->pivot->notes)
                            <p class="text-gray-600 text-xs mt-1">{{ $condition->pivot->notes }}</p>
                            @endif
                        </div>
                        <span class="px-2 py-0.5 text-xs rounded-full ml-2 {{ $condition->pivot->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $condition->pivot->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">No pinned conditions</p>
        @endif
    </div>
@else
    {{-- Full List View (for sidebar) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between mb-3">
            <h4 class="font-semibold text-gray-900">Conditions</h4>
            <button 
                @click="$dispatch('openConditionModal')"
                class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>
        @if($conditions->count() > 0)
            <div class="space-y-2">
                @foreach($conditions as $condition)
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-1">
                        @if($condition->pivot && $condition->pivot->is_pinned)
                        <svg class="w-3 h-3 text-yellow-600 fill-current" viewBox="0 0 24 24">
                            <path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z" />
                        </svg>
                        @endif
                        <span class="text-gray-900">{{ $condition->condition_name }}</span>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $condition->pivot->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $condition->pivot->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">No conditions recorded</p>
        @endif
    </div>
@endif
