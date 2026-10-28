<x-patient-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-violet-100 rounded-xl">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">
                        Billing & Invoices
                    </h2>
                    <p class="text-sm text-gray-500">View your payment history and download official receipts</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Sended Invoices -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between shadow-sm relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-2xl"></div>
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Sattled Amount</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">
                        ₱{{ number_format($billings->where('payment_status', 'paid')->sum('total_amount'), 2) }}
                    </p>
                    <p class="text-xs font-medium text-gray-400 mt-1">Fully paid consultations</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
            </div>

            <!-- Outstanding Dues -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between shadow-sm relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-500 rounded-l-2xl"></div>
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Pending Bills</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">
                        ₱{{ number_format($billings->whereIn('payment_status', ['pending', 'partial'])->sum('total_amount'), 2) }}
                    </p>
                    <p class="text-xs font-medium text-gray-400 mt-1">Settle at front desk</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Total Invoices Count -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between shadow-sm relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-violet-500 rounded-l-2xl"></div>
                <div>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Total Invoices</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">
                        {{ $billings->count() }}
                    </p>
                    <p class="text-xs font-medium text-gray-400 mt-1">All billing entries</p>
                </div>
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="font-bold text-gray-900 tracking-tight">Invoice History</h3>
            </div>
            
            @if($billings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                <th class="p-4 pl-6">Receipt No.</th>
                                <th class="p-4">Billing Date</th>
                                <th class="p-4">Attending Doctor</th>
                                <th class="p-4">Amount</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 pr-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($billings as $billing)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="p-4 pl-6 font-semibold text-gray-900">{{ $billing->receipt_number }}</td>
                                    <td class="p-4 text-gray-500">{{ $billing->billing_date->format('M d, Y') }}</td>
                                    <td class="p-4 font-medium text-gray-700">Dr. {{ $billing->consultation->doctor->name }}</td>
                                    <td class="p-4 font-bold text-gray-900">₱{{ number_format($billing->total_amount, 2) }}</td>
                                    <td class="p-4">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'partial' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'waived' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            ];
                                            $currentClass = $statusClasses[$billing->payment_status] ?? 'bg-gray-50 text-gray-600';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider border {{ $currentClass }}">
                                            {{ $billing->payment_status }}
                                        </span>
                                    </td>
                                    <td class="p-4 pr-6 text-right">
                                        <a href="{{ route('patient.billing.receipt', $billing) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shadow-violet-500/10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Receipt PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 font-semibold text-lg">No billing history found</p>
                    <p class="text-sm text-gray-400 mt-1">When you complete consultations, your invoices will show up here.</p>
                </div>
            @endif
        </div>
    </div>
</x-patient-layout>
