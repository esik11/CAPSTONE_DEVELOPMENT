<x-assistant-layout>
    <x-slot name="title">Collect Payment</x-slot>
    <x-slot name="subtitle">Settle payment for Receipt {{ $billing->receipt_number }}</x-slot>

    <div class="max-w-5xl mx-auto" x-data="{ 
        paymentMethod: 'cash', 
        amountTendered: 0, 
        totalDue: {{ $billing->total_amount }},
        init() {
            this.amountTendered = this.totalDue;
        },
        setQuickCash(amount) {
            this.amountTendered = amount;
        }
    }">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Invoice summary (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Invoice Items Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 tracking-tight">Invoice Items</h3>
                        </div>
                        <span class="text-[10px] font-black text-violet-600 bg-violet-50 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            {{ $billing->receipt_number }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="divide-y divide-gray-100">
                            @foreach($billing->items as $item)
                                <div class="py-4 flex justify-between items-center first:pt-0 last:pb-0">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800">{{ $item['description'] }}</h4>
                                        <p class="text-[10px] text-gray-400 font-medium">Standard Clinical Rate</p>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">₱{{ number_format($item['amount'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Grand Total section -->
                        <div class="mt-6 pt-6 border-t border-gray-150 flex justify-between items-center bg-gray-50/50 p-4 rounded-xl">
                            <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Total Amount Due</span>
                            <span class="text-2xl font-black text-gray-900">₱{{ number_format($billing->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Patient Demographics Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 tracking-tight">Patient Details</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-gray-600">
                        <div>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Full Name</span>
                            <span class="text-gray-900 font-bold text-sm">{{ $billing->consultation->patient->first_name }} {{ $billing->consultation->patient->last_name }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">MRN ID</span>
                            <span class="text-gray-900 font-bold text-sm">#{{ str_pad($billing->consultation->patient->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Attending Physician</span>
                            <span class="text-gray-900 font-bold">Dr. {{ $billing->consultation->doctor->name }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Consultation Date</span>
                            <span class="text-gray-900 font-bold">{{ $billing->consultation->consultation_date->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('assistant.billing.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-wider hover:underline transition-colors pl-2">
                    ← Back to Invoices List
                </a>
            </div>

            <!-- Right: Pay processor (1 col) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 tracking-tight">Process Settlement</h3>
                    </div>

                    <form action="{{ route('assistant.billing.pay', $billing) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Payment Method selection -->
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Payment Method</label>
                            <select name="payment_method" x-model="paymentMethod" @change="if(paymentMethod !== 'cash') { amountTendered = totalDue; }"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                                <option value="cash">Cash Register</option>
                                <option value="gcash">GCash</option>
                                <option value="paymaya">PayMaya</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <!-- Cash register calculator (visible if Cash selected) -->
                        <div x-show="paymentMethod === 'cash'" class="space-y-4 bg-violet-50/30 border border-violet-100 p-4 rounded-xl animate-fade-in">
                            <div>
                                <label class="text-[9px] font-bold text-violet-700 uppercase tracking-wider mb-2 block">Amount Tendered</label>
                                <div class="relative">
                                    <span class="text-sm font-bold text-gray-400 absolute left-3 top-3.5">₱</span>
                                    <input type="number" step="any" name="amount_tendered" x-model.number="amountTendered"
                                           class="w-full pl-7 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-800 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                                </div>
                                
                                <!-- Quick-cash buttons -->
                                <div class="grid grid-cols-3 gap-1.5 mt-2">
                                    <button type="button" @click="setQuickCash(totalDue)" class="px-2 py-1.5 bg-white border border-gray-200 text-[10px] font-bold text-gray-500 rounded-lg hover:bg-violet-50 hover:text-violet-700 hover:border-violet-200 transition-all">Exact</button>
                                    <button type="button" @click="setQuickCash(500)" class="px-2 py-1.5 bg-white border border-gray-200 text-[10px] font-bold text-gray-500 rounded-lg hover:bg-violet-50 hover:text-violet-700 hover:border-violet-200 transition-all" x-show="totalDue <= 500">₱500</button>
                                    <button type="button" @click="setQuickCash(1000)" class="px-2 py-1.5 bg-white border border-gray-200 text-[10px] font-bold text-gray-500 rounded-lg hover:bg-violet-50 hover:text-violet-700 hover:border-violet-200 transition-all" x-show="totalDue <= 1000">₱1,000</button>
                                </div>
                            </div>

                            <!-- Real-time change box -->
                            <div class="pt-3 border-t border-violet-100 flex justify-between items-center">
                                <span class="text-[9px] font-black text-violet-700 uppercase tracking-wider">Change Due</span>
                                <span class="text-lg font-black text-violet-800" x-text="'₱' + Math.max(0, amountTendered - totalDue).toFixed(2)">₱0.00</span>
                            </div>

                            <!-- Error Message -->
                            <template x-if="amountTendered < totalDue">
                                <div class="text-[10px] text-red-500 font-bold flex items-center gap-1 mt-2">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Tendered cash must be greater than total amount!
                                </div>
                            </template>
                        </div>

                        <!-- Non-cash instructions -->
                        <div x-show="paymentMethod !== 'cash'" class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-2 animate-fade-in" x-cloak>
                            <p class="text-[10px] text-gray-500 font-semibold leading-relaxed">
                                Please scan/confirm transaction via <span class="text-gray-900 font-black uppercase" x-text="paymentMethod"></span> payment channel before submitting.
                            </p>
                            <input type="hidden" name="amount_tendered" :value="totalDue">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Transaction Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Reference numbers, check detail, or logs..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" :disabled="amountTendered < totalDue"
                                :class="amountTendered < totalDue ? 'bg-gray-200 text-gray-400 cursor-not-allowed shadow-none' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-600/20 shadow-lg hover:shadow-emerald-600/30 active:scale-[0.98]'"
                                class="w-full py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all">
                            Complete Settlement
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-assistant-layout>
