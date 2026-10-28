<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                    {{ __('Billing Summary') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Receipt #{{ $billing->receipt_number }}</p>
            </div>
        </div>
    </x-slot>

    <div class="h-full flex flex-col">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('doctor.billing.receipt', $billing) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Receipt
            </a>
        </div>

        <!-- Billing Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Patient Information</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $billing->consultation->patient->first_name }} {{ $billing->consultation->patient->last_name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="font-medium">{{ $billing->billing_date->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Items -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Billing Items</h3>
                <div class="space-y-2">
                    @foreach($billing->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700">{{ $item['description'] }}</span>
                            <span class="font-medium">₱{{ number_format($item['amount'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="border-t-2 border-gray-300 mt-4 pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                    <span class="text-2xl font-bold text-gray-900">₱{{ number_format($billing->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
            
            @if($billing->isWaived())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-yellow-900">Payment Waived</p>
                            <p class="text-sm text-yellow-700 mt-1">Reason: {{ $billing->getWaiveReasonLabel() }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                @if(!$billing->isWaived())
                    <div>
                        <span class="text-gray-500">Payment Method:</span>
                        <span class="ml-2 font-medium">{{ ucfirst(str_replace('_', ' ', $billing->payment_method)) }}</span>
                    </div>
                @endif
                <div>
                    <span class="text-gray-500">Payment Status:</span>
                    <span class="ml-2">
                        @if($billing->payment_status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Paid
                            </span>
                        @elseif($billing->payment_status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($billing->payment_status === 'waived')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Waived
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Partial
                            </span>
                        @endif
                    </span>
                </div>
                @if($billing->notes)
                    <div class="col-span-2">
                        <span class="text-gray-500">Notes:</span>
                        <p class="mt-1 text-gray-700">{{ $billing->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('doctor.billing.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                View All Billings
            </a>
            <a href="{{ route('patients.show', $billing->consultation->patient) }}" 
               class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Back to Patient
            </a>
        </div>
    </div>
</x-doctor-layout>
