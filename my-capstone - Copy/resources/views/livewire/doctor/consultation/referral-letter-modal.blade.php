<div x-data="{ show: @entangle('show') }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity" 
             aria-hidden="true"
             @click="show = false"></div>

        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-5xl overflow-hidden text-left align-bottom transition-all transform bg-slate-100 rounded-xl shadow-2xl sm:my-8 sm:align-middle">
            
            <div class="flex h-[85vh]">
                <!-- LEFT SIDE: FORM INPUTS -->
                <div class="w-1/3 bg-white border-r border-slate-200 p-6 overflow-y-auto custom-scrollbar">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Referral Editor</h3>
                    <p class="text-xs text-slate-500 mb-6">Fill in the details to generate the formal letter.</p>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Receiver Info -->
                        <div class="space-y-3">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Receiving Provider</h4>
                            <div class="space-y-2">
                                <input type="text" wire:model="receiving_provider_name" placeholder="Specialist Full Name"
                                       class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500 placeholder:text-slate-300">
                                <input type="text" wire:model="receiving_specialty" placeholder="Specialty (e.g. Neurology)"
                                       class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500 placeholder:text-slate-300">
                                <input type="text" wire:model="receiving_facility" placeholder="Hospital / Facility"
                                       class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500 placeholder:text-slate-300">
                            </div>
                        </div>

                        <!-- Clinical Details -->
                        <div class="space-y-3">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Clinical Content</h4>
                            <textarea wire:model="reason_for_referral" rows="3" placeholder="Reason for Referral..."
                                      class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500"></textarea>
                            <textarea wire:model="medical_history_summary" rows="4" placeholder="Brief Medical History..."
                                      class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500 text-xs"></textarea>
                        </div>

                        <!-- Insurance -->
                        <div class="space-y-3">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Insurance (Optional)</h4>
                            <input type="text" wire:model="insurance_provider" placeholder="Insurance Provider"
                                   class="w-full text-sm border-slate-200 rounded-lg focus:ring-slate-500 focus:border-slate-500 placeholder:text-slate-300">
                        </div>

                        <!-- Action -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="is_digitally_signed" id="sign_ref_side"
                                       class="w-4 h-4 text-slate-900 border-slate-300 rounded focus:ring-slate-500">
                                <label for="sign_ref_side" class="ml-2 text-xs font-semibold text-slate-700 cursor-pointer">Sign Document</label>
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 text-xs font-bold text-white bg-slate-900 rounded-lg hover:bg-slate-800 shadow-md transition-all active:scale-95">
                                Save Document
                            </button>
                        </div>
                    </form>
                </div>

                <!-- RIGHT SIDE: LIVE PREVIEW (THE ACTUAL LETTER) -->
                <div class="flex-1 p-12 overflow-y-auto bg-slate-100 flex justify-center">
                    <!-- THE PAPER -->
                    <div class="bg-white w-full max-w-[210mm] min-h-[297mm] shadow-2xl p-[20mm] relative flex flex-col font-serif text-slate-900">
                        
                        <!-- Formal Header -->
                        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-8 mb-12">
                            <div class="text-left">
                                <h1 class="text-2xl font-black tracking-tighter uppercase font-sans">Medical Referral</h1>
                                <p class="text-xs font-sans text-slate-500 mt-1">Ref No: REF-{{ date('Ymd') }}-{{ $consultation->id ?? '000' }}</p>
                            </div>
                            <div class="text-right font-sans">
                                <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-slate-500">{{ auth()->user()->specialization ?? 'Practicing Physician' }}</p>
                                <p class="text-[10px] text-slate-500">License No: {{ auth()->user()->license_number ?? 'PRC-000000' }}</p>
                                <p class="text-[10px] text-slate-500">Date: {{ date('F d, Y') }}</p>
                                <p class="text-[10px] text-slate-500">Consultation ID: {{ $consultation->id ?? '---' }}</p>
                            </div>
                        </div>

                        <!-- Receiver Section -->
                        <div class="mb-10 font-sans">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">To:</p>
                            <p class="text-base font-bold text-slate-900">{{ $receiving_provider_name ?: '__________________________' }}</p>
                            <p class="text-sm text-slate-600">{{ $receiving_specialty ?: 'Specialist' }}</p>
                            <p class="text-sm text-slate-600">{{ $receiving_facility ?: 'Medical Facility' }}</p>
                        </div>

                        <!-- Subject Line -->
                        <div class="mb-10">
                            <p class="text-sm font-bold uppercase underline decoration-1 underline-offset-4">
                                RE: Referral for 
                                @if($patient)
                                    {{ $patient->first_name }} {{ $patient->last_name }} 
                                    (DOB: {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : '---' }})
                                @else
                                    [Patient Name] (DOB: ---)
                                @endif
                            </p>
                        </div>

                        <!-- Body Content -->
                        <div class="space-y-8 flex-1">
                            <div class="space-y-3">
                                <p class="text-sm font-bold text-slate-400 uppercase font-sans tracking-widest">Reason for Referral</p>
                                <p class="text-base leading-relaxed text-slate-800">
                                    {{ $reason_for_referral ?: 'Please evaluate and manage the patient for...' }}
                                </p>
                            </div>

                            <div class="space-y-3">
                                <p class="text-sm font-bold text-slate-400 uppercase font-sans tracking-widest">Clinical Summary</p>
                                <div class="text-sm leading-relaxed text-slate-700 whitespace-pre-wrap">
                                    {{ $medical_history_summary ?: 'No clinical summary provided.' }}
                                </div>
                            </div>

                            <div class="space-y-3">
                                <p class="text-sm font-bold text-slate-400 uppercase font-sans tracking-widest">Current Medications</p>
                                <div class="text-xs leading-relaxed text-slate-600 font-mono italic">
                                    {{ $current_medications ?: 'None documented.' }}
                                </div>
                            </div>

                            @if($insurance_provider)
                            <div class="p-4 bg-slate-50 rounded border border-slate-200 font-sans">
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Insurance Information</p>
                                <p class="text-xs text-slate-700">{{ $insurance_provider }} - Policy: {{ $policy_number ?: 'N/A' }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Footer / Signature -->
                        <div class="mt-12 pt-8 border-t border-slate-100 flex justify-between items-end">
                            <div class="text-[10px] text-slate-400 font-sans italic">
                                * This document is generated electronically for clinical reference.
                            </div>
                            <div class="text-center w-64">
                                <div class="h-16 flex items-center justify-center mb-1">
                                    @if($is_digitally_signed)
                                        <span class="font-serif italic text-3xl text-slate-900 select-none opacity-80" style="font-family: 'Dancing Script', cursive, serif;">
                                            {{ auth()->user()->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="border-t border-slate-900 pt-2 font-sans">
                                    <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter">Authorized Physician Signature</p>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Watermark (Optional) -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
                            <h1 class="text-9xl font-black uppercase rotate-45">OFFICIAL</h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CLOSE BUTTON -->
            <button @click="show = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
