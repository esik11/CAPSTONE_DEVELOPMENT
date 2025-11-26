<div
    @click="window.Livewire.dispatch('openModal')"
    class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 cursor-pointer hover:shadow-md transition-shadow duration-200"
>
    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Lifestyle & Family Hx
    </h4>
    
    <div class="space-y-3 text-sm">
        @if($socialHistory?->parents_status)
        <div class="pb-2 border-b border-gray-200">
            <p class="font-medium text-gray-700">Parents</p>
            <div class="mt-1 text-gray-600">
                <p>Status: <span class="text-gray-900">{{ $socialHistory->parents_status }}</span></p>
                @if($socialHistory->parents_comments)
                <p class="text-xs mt-1 italic">{{ $socialHistory->parents_comments }}</p>
                @endif
            </div>
        </div>
        @endif
        
        <div>
            <p class="font-medium text-gray-700">Lifestyle</p>
            <div class="mt-1 space-y-1 text-gray-600">
                <div>
                    <span class="font-medium">Smoking:</span> 
                    <span class="text-gray-900">{{ $socialHistory?->smoking ?? 'Not recorded' }}</span>
                    @if($socialHistory && in_array($socialHistory->smoking, ['Smoker', 'Ex-smoker', 'Social smoker']))
                        @if($socialHistory->smoking_years || $socialHistory->smoking_daily_cigarettes)
                        <div class="ml-4 mt-1 text-xs space-y-0.5">
                            @if($socialHistory->smoking_years)
                            <p>• Years: {{ $socialHistory->smoking_years }}</p>
                            @endif
                            @if($socialHistory->smoking_daily_cigarettes)
                            <p>• Daily: {{ $socialHistory->smoking_daily_cigarettes }} cigarettes</p>
                            @endif
                            @if($socialHistory->smoking_years && $socialHistory->smoking_daily_cigarettes)
                            <p class="text-teal-700 font-medium">• Pack-years: {{ number_format(($socialHistory->smoking_years * $socialHistory->smoking_daily_cigarettes) / 20, 1) }}</p>
                            @endif
                        </div>
                        @endif
                    @endif
                </div>
                
                <div>
                    <span class="font-medium">Alcohol:</span> 
                    <span class="text-gray-900">{{ $socialHistory?->alcohol ?? 'Not recorded' }}</span>
                    @if($socialHistory?->alcohol_comments)
                    <p class="ml-4 mt-1 text-xs italic">{{ $socialHistory->alcohol_comments }}</p>
                    @endif
                </div>
                
                <div>
                    <span class="font-medium">Drug use:</span> 
                    <span class="text-gray-900">{{ $socialHistory?->drug_use ?? 'Not recorded' }}</span>
                    @if($socialHistory?->drug_type)
                    <p class="ml-4 mt-1 text-xs">Type: {{ $socialHistory->drug_type }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="pt-2 border-t border-gray-200">
            <p class="font-medium text-gray-700">Family history</p>
            @if($familyHistories->count() > 0)
                <ul class="mt-1 space-y-1 text-gray-600">
                    @foreach($familyHistories->take(3) as $history)
                    <li>{{ $history->relative }}: {{ $history->condition }}</li>
                    @endforeach
                </ul>
            @else
                <p class="mt-1 text-gray-600">No family history recorded</p>
            @endif
        </div>
    </div>
</div>
