<div
    @click="window.Livewire.dispatch('openSurgicalModal')"
    class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 cursor-pointer hover:shadow-md transition-shadow duration-200"
>
    <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
        </svg>
        Surgical & Hospital Hx
    </h3>
    
    <div class="space-y-4">
        <div>
            <p class="font-medium text-gray-700 mb-2">Surgical</p>
            @if($surgeries->count() > 0)
                <ul class="space-y-1 text-sm text-gray-600">
                    @foreach($surgeries->take(3) as $surgery)
                    <li>• {{ $surgery->surgery_type }} ({{ $surgery->year }})</li>
                    @endforeach
                    @if($surgeries->count() > 3)
                    <li class="text-xs text-gray-500 italic">+ {{ $surgeries->count() - 3 }} more</li>
                    @endif
                </ul>
            @else
                <p class="text-sm text-gray-500 italic">No surgical history recorded</p>
            @endif
        </div>
        
        <div>
            <p class="font-medium text-gray-700 mb-2">Hospitalization notes</p>
            @if($hospitalizations->count() > 0)
                <ul class="space-y-1 text-sm text-gray-600">
                    @foreach($hospitalizations->take(3) as $hosp)
                    <li>• {{ $hosp->reason }} - {{ $hosp->hospital_name }} ({{ $hosp->year }})</li>
                    @endforeach
                    @if($hospitalizations->count() > 3)
                    <li class="text-xs text-gray-500 italic">+ {{ $hospitalizations->count() - 3 }} more</li>
                    @endif
                </ul>
            @else
                <p class="text-sm text-gray-500 italic">No hospitalization records</p>
            @endif
        </div>
    </div>
</div>
