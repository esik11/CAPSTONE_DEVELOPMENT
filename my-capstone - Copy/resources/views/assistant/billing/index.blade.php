<x-assistant-layout>
    <x-slot name="title">Billing & Payments</x-slot>
    <x-slot name="subtitle">Process patient transaction invoices and manage receipts</x-slot>

    <div class="max-w-6xl mx-auto space-y-6" x-data="{ activeTab: 'pending' }">
        
        <!-- Notifications / Flash Messages -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-emerald-900">Payment Processed Successfully</h4>
                    <p class="text-xs text-emerald-600 font-medium mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center text-white flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.708.286.41.82a.75.75 0 01-1.07 1.05l-1.425-1.14a.75.75 0 01.48-1.348zM12 21a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-blue-900">Information</h4>
                    <p class="text-xs text-blue-600 font-medium mt-0.5">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <!-- Filters Block -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('assistant.billing.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-80">
                    <input type="text" name="search" placeholder="Search Receipt, Patient, MRN..." value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <input type="date" name="date" value="{{ request('date') }}"
                       class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">

                <button type="submit" class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-md transition-all active:scale-[0.98]">
                    Filter
                </button>
                
                @if(request()->filled('search') || request()->filled('date'))
                    <a href="{{ route('assistant.billing.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 hover:text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
                        Clear
                    </a>
                @endif
            </form>

            <!-- Navigation Tabs -->
            <div class="flex bg-gray-50 p-1 rounded-xl border border-gray-100 self-end md:self-auto">
                <button @click="activeTab = 'pending'"
                        :class="activeTab === 'pending' ? 'bg-white text-violet-700 shadow-sm border border-gray-100' : 'text-gray-400 hover:text-gray-600'"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all">
                    Pending ({{ $pendingInvoices->count() }})
                </button>
                <button @click="activeTab = 'history'"
                        :class="activeTab === 'history' ? 'bg-white text-violet-700 shadow-sm border border-gray-100' : 'text-gray-400 hover:text-gray-600'"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all">
                    Billing History
                </button>
            </div>
        </div>

        <!-- Dynamic Content Lists -->
        
        <!-- PENDING PAYMENTS TAB -->
        <div x-show="activeTab === 'pending'" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-6 bg-amber-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 tracking-tight">Pending & Unpaid Invoices</h3>
                </div>
            </div>

            @if($pendingInvoices->isEmpty())
                <div class="p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0110 18a3.745 3.745 0 01-3.296-1.043A3.745 3.745 0 013.408 13.66 3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.745 3.745 0 013.296-1.043A3.745 3.745 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <h4 class="text-gray-900 font-bold tracking-tight">No pending invoices</h4>
                    <p class="text-gray-400 text-xs mt-1 max-w-[280px] mx-auto">Outstanding invoices sent from doctor consultations will appear here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Receipt #</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Patient</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Attending Doctor</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Billing Date</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Amount Due</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($pendingInvoices as $invoice)
                                <tr class="hover:bg-gray-50/50 transition-all duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-900">{{ $invoice->receipt_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-bold text-gray-900">{{ $invoice->consultation->patient->first_name }} {{ $invoice->consultation->patient->last_name }}</div>
                                        <div class="text-[9px] font-medium text-gray-400">MRN: {{ str_pad($invoice->consultation->patient->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium">Dr. {{ $invoice->consultation->doctor->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">{{ $invoice->billing_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold text-gray-900">₱{{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">
                                            {{ $invoice->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('assistant.billing.process', $invoice) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg shadow-sm transition-all active:scale-[0.98]">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5M5.25 7.5h13.5m-12 3h10.5m-12 3h10.5m-12 3h10.5" />
                                            </svg>
                                            Process Payment
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- BILLING HISTORY / PAID REGISTRY TAB -->
        <div x-show="activeTab === 'history'" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-cloak>
            <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 tracking-tight">Settled Transactions</h3>
                </div>
            </div>

            @if($historyInvoices->isEmpty())
                <div class="p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h4 class="text-gray-900 font-bold tracking-tight">No settled bills found</h4>
                    <p class="text-gray-400 text-xs mt-1 max-w-[280px] mx-auto">All paid or waived clinic invoices will be catalogued here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Receipt #</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Patient</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Attending Doctor</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Settled Date</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Amount</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Method</th>
                                <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($historyInvoices as $invoice)
                                <tr class="hover:bg-gray-50/50 transition-all duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-900">{{ $invoice->receipt_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-bold text-gray-900">{{ $invoice->consultation->patient->first_name }} {{ $invoice->consultation->patient->last_name }}</div>
                                        <div class="text-[9px] font-medium text-gray-400">MRN: {{ str_pad($invoice->consultation->patient->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium">Dr. {{ $invoice->consultation->doctor->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">{{ $invoice->billing_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold text-gray-900">₱{{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                        {{ $invoice->payment_method ? ucfirst($invoice->payment_method) : '--' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider
                                            {{ $invoice->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-gray-50 text-gray-500 border border-gray-200' }}">
                                            {{ $invoice->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('assistant.billing.receipt', $invoice) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-violet-50 text-gray-500 hover:text-violet-600 text-[10px] font-bold uppercase tracking-widest rounded-lg transition-all active:scale-[0.98]">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            Receipt PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-gray-50 bg-gray-50/10">
                    {{ $historyInvoices->links() }}
                </div>
            @endif
        </div>

    </div>
</x-assistant-layout>
