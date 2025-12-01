<div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-sm border border-pink-200 p-4">
    <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Gynae
    </h3>
    
    @if($gynaeHistory)
        <div class="space-y-3 text-sm">
            <!-- Contraception -->
            <div>
                <span class="text-gray-600 font-medium">Contraception</span>
                @if($gynaeHistory->contraception)
                    @php
                        $methods = is_array($gynaeHistory->contraception) 
                            ? $gynaeHistory->contraception 
                            : json_decode($gynaeHistory->contraception, true);
                    @endphp
                    @if(count($methods) > 0)
                        <div class="mt-1 space-y-1">
                            @foreach($methods as $method)
                            <p class="text-gray-900">{{ ucwords(str_replace('_', ' ', $method)) }}</p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-1">None</p>
                    @endif
                @else
                    <p class="text-gray-500 italic mt-1">None</p>
                @endif
                
                @if($gynaeHistory->contraception_comments)
                <p class="text-gray-600 text-xs mt-2">{{ $gynaeHistory->contraception_comments }}</p>
                @endif
            </div>
            
            <!-- Pregnancies Number -->
            <div class="pt-2 border-t border-pink-200">
                <span class="text-gray-600 font-medium">Pregnancies number</span>
                <p class="text-gray-900 mt-1">{{ $gynaeHistory->number_of_pregnancies ?? 0 }}</p>
            </div>
            
            <!-- Children Number -->
            <div>
                <span class="text-gray-600 font-medium">Children number</span>
                <p class="text-gray-900 mt-1">{{ $gynaeHistory->number_of_children ?? 0 }}</p>
            </div>
            
            <!-- Pregnancy Complications -->
            <div class="pt-2 border-t border-pink-200">
                <span class="text-gray-600 font-medium">Pregnancy complications</span>
                @if($gynaeHistory->pregnancy_complications)
                    @php
                        $complications = is_array($gynaeHistory->pregnancy_complications) 
                            ? $gynaeHistory->pregnancy_complications 
                            : json_decode($gynaeHistory->pregnancy_complications, true);
                    @endphp
                    @if(count($complications) > 0)
                        <div class="mt-1 space-y-1">
                            @foreach($complications as $complication)
                            <p class="text-gray-900">{{ ucwords(str_replace('_', ' ', $complication)) }}</p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-1">None</p>
                    @endif
                @else
                    <p class="text-gray-500 italic mt-1">None</p>
                @endif
            </div>
            
            <!-- Pregnancy Details -->
            @if($gynaeHistory->pregnancy_complications_comments)
            <div>
                <span class="text-gray-600 font-medium">Pregnancy details</span>
                <p class="text-gray-900 mt-1">{{ $gynaeHistory->pregnancy_complications_comments }}</p>
            </div>
            @endif
            
            <!-- Menstrual History -->
            <div class="pt-2 border-t border-pink-200">
                <span class="text-gray-600 font-medium">Menstrual history</span>
                @if($gynaeHistory->menstrual_issues)
                    @php
                        $issues = is_array($gynaeHistory->menstrual_issues) 
                            ? $gynaeHistory->menstrual_issues 
                            : json_decode($gynaeHistory->menstrual_issues, true);
                    @endphp
                    @if(count($issues) > 0)
                        <div class="mt-1 space-y-1">
                            @foreach($issues as $issue)
                            <p class="text-gray-900">{{ ucwords(str_replace('_', ' ', $issue)) }}</p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-1">None</p>
                    @endif
                @else
                    <p class="text-gray-500 italic mt-1">None</p>
                @endif
                
                @if($gynaeHistory->menstrual_comments)
                <p class="text-gray-600 text-xs mt-2">{{ $gynaeHistory->menstrual_comments }}</p>
                @endif
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No gynae history recorded</p>
    @endif
</div>
