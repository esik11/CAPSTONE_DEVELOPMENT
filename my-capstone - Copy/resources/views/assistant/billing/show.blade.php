<x-assistant-layout>
    <x-slot name="title">Invoice Details</x-slot>
    <x-slot name="subtitle">View billing details for Receipt {{ $billing->receipt_number }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Paper Invoice Replication Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden p-8 space-y-8 relative">
            
            <!-- Watermark / Stamp badge based on status -->
            <div class="absolute right-8 top-8">
                @if($billing->isPaid())
                    <span class="px-4 py-2 border-2 border-emerald-500 rounded-lg text-emerald-600 text-xs font-black uppercase tracking-[0.2em] transform rotate-12 inline-block shadow-inner bg-emerald-50/50">
                        Paid / Settled
                    </span>
                @elseif($billing->isWaived())
                    <span class="px-4 py-2 border-2 border-gray-400 rounded-lg text-gray-500 text-xs font-black uppercase tracking-[0.2em] transform rotate-12 inline-block bg-gray-50">
                        Waived
                    </span>
                @else
                    <span class="px-4 py-2 border-2 border-amber-500 rounded-lg text-amber-600 text-xs font-black uppercase tracking-[0.2em] transform rotate-12 inline-block bg-amber-50">
                        Unpaid / Pending
                    </span>
                @endif
            </div>

            <!-- Clinic Header -->
            <div class="text-center pb-6 border-b border-gray-100">
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">{{ config('app.name', 'SalamatDoc') }}</h2>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Official Clinical Invoice Details</p>
                <p class="text-[10px] text-gray-400 font-medium mt-0.5">
                    {{ $billing->consultation->doctor->clinic_address ?? 'Family Clinic & Diagnostic Center' }} | Contact: {{ $billing->consultation->doctor->contact_number ?? '+63 (02) 888-0000' }}
                </p>
            </div>

            <!-- Invoice Details Metadata Block -->
            <div class="grid grid-cols-2 gap-8 text-xs font-semibold text-gray-600">
                <div class="space-y-2">
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Receipt Number</span>
                        <span class="text-gray-900 font-black text-sm">{{ $billing->receipt_number }}</span>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Patient Details</span>
                        <span class="text-gray-900 font-bold">
                            {{ $billing->consultation->patient->first_name }} {{ $billing->consultation->patient->last_name }} 
                            (#{{ str_pad($billing->consultation->patient->id, 5, '0', STR_PAD_LEFT) }})
                        </span>
                    </div>
                </div>
                
                <div class="space-y-2 text-right">
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Billing Date</span>
                        <span class="text-gray-900 font-bold">{{ $billing->billing_date->format('F d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Attending Physician</span>
                        <span class="text-gray-900 font-bold">Dr. {{ $billing->consultation->doctor->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Breakdown Table -->
            <div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-3">Service Breakdown</span>
                
                <div class="border border-gray-100 rounded-xl overflow-hidden shadow-inner">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-[9px] font-bold text-gray-400 uppercase tracking-wider">Description</th>
                                <th class="px-5 py-3 text-right text-[9px] font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs font-semibold text-gray-700">
                            @foreach($billing->items as $item)
                                <tr>
                                    <td class="px-5 py-3.5">{{ $item['description'] }}</td>
                                    <td class="px-5 py-3.5 text-right text-gray-900">₱{{ number_format($item['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Grand Total -->
                <div class="flex justify-end mt-4">
                    <div class="bg-gray-50 rounded-xl px-5 py-3.5 flex items-center gap-6 border border-gray-100">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Amount Due</span>
                        <span class="text-xl font-black text-gray-900">₱{{ number_format($billing->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Details Block -->
            <div class="bg-gray-50/50 rounded-xl p-5 border border-gray-100 grid grid-cols-2 gap-4 text-xs font-semibold text-gray-600">
                <div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Payment Method</span>
                    <span class="text-gray-900 font-bold uppercase">{{ $billing->payment_method ? str_replace('_', ' ', $billing->payment_method) : 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Waive Reason</span>
                    <span class="text-gray-900 font-bold">{{ $billing->is_waived ? $billing->getWaiveReasonLabel() : 'N/A' }}</span>
                </div>
                <div class="col-span-2">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Transaction Notes</span>
                    <p class="text-gray-700 italic mt-0.5">{{ $billing->notes ?? 'No additional transaction notes registered.' }}</p>
                </div>
            </div>

            <!-- Action buttons inside card -->
            <div class="pt-6 border-t border-gray-150 flex items-center justify-between">
                <a href="{{ route('assistant.billing.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-wider hover:underline transition-colors">
                    ← Back to Invoices
                </a>

                <div class="flex gap-2">
                    @if(!$billing->isPaid() && !$billing->isWaived())
                        <a href="{{ route('assistant.billing.process', $billing) }}" 
                           class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-[10px] font-black uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center gap-1">
                            Process Payment
                        </a>
                    @else
                        <a href="{{ route('assistant.billing.receipt', $billing) }}" 
                           class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Print Receipt PDF
                        </a>
                    @endif
                </div>
            </div>

        </div>

    </div>
</x-assistant-layout>
