<x-patient-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">
                        My Prescriptions
                    </h2>
                    <p class="text-sm text-gray-500">View and download your electronic prescriptions (Rx)</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        @if($consultations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($consultations as $consultation)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md hover:border-emerald-100 transition-all flex flex-col justify-between">
                        <div>
                            <!-- Card Header -->
                            <div class="flex justify-between items-start border-b border-gray-50 pb-4 mb-4">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Prescribed Date</span>
                                    <p class="text-lg font-extrabold text-gray-900 mt-0.5">
                                        {{ $consultation->consultation_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Attending Doctor</span>
                                    <p class="text-sm font-bold text-emerald-600 mt-0.5">
                                        Dr. {{ $consultation->doctor->name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Prescription Items -->
                            <div class="space-y-4 my-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Medications</p>
                                <div class="divide-y divide-gray-50">
                                    @foreach($consultation->prescriptions as $prescription)
                                        <div class="py-2.5 first:pt-0 last:pb-0">
                                            <div class="flex justify-between">
                                                <p class="font-bold text-gray-900 text-sm">
                                                    {{ $prescription['medicine_name'] }}
                                                    @if(!empty($prescription['strength']))
                                                        <span class="text-xs text-gray-500 font-normal">({{ $prescription['strength'] }})</span>
                                                    @endif
                                                </p>
                                                <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-lg border border-orange-100">
                                                    Qty: {{ $prescription['quantity'] }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $prescription['dosage'] }} &bull; {{ $prescription['duration'] }} &bull; {{ $prescription['instructions'] }}
                                            </p>
                                            @if(!empty($prescription['additional_instructions']))
                                                <p class="text-[11px] text-gray-400 italic mt-1 bg-gray-50 p-1.5 rounded border border-gray-100">
                                                    {{ $prescription['additional_instructions'] }}
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action -->
                        <div class="border-t border-gray-50 pt-4 mt-6 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                Consultation ID: #{{ $consultation->id }}
                            </span>
                            <a href="{{ route('patient.prescriptions.pdf', $consultation) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-500/10 group">
                                <svg class="w-4 h-4 text-emerald-100 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Rx PDF
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <p class="text-gray-500 font-semibold text-lg">No prescriptions found</p>
                <p class="text-sm text-gray-400 mt-1">Your doctor-issued prescriptions will appear here once consultations are complete.</p>
            </div>
        @endif
    </div>
</x-patient-layout>
