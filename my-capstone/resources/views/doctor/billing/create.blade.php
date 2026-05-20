<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-slate-900 leading-tight tracking-tighter uppercase">{{ __('Billing & Invoicing') }}</h2>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">Professional Fee Settlement • Case #{{ $consultation->id }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-[1600px] mx-auto px-6 py-8">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            <!-- LEFT COLUMN: ORIGINAL FORM STYLED -->
            <div class="flex-1 w-full lg:max-w-2xl">
                <form action="{{ route('doctor.billing.store', $consultation) }}" method="POST" id="billingForm" class="space-y-6">
                    @csrf

                    <!-- Patient & Consultation Info (Condensed) -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest">Account Information</h2>
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-full uppercase">{{ $consultation->appointment ? ucfirst($consultation->appointment->appointment_type) : 'Walk-in' }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-y-4 text-sm">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Patient Name</p>
                                <p class="font-black text-slate-900 uppercase tracking-tighter">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Consultation Date</p>
                                <p class="font-black text-slate-900">{{ $consultation->consultation_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Items Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100">
                            <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest">Invoiced Services</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Consultation Fee -->
                            <div class="flex justify-between items-center py-4 px-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div>
                                    <p class="text-xs font-black text-slate-900 uppercase tracking-tight">Professional Consultation Fee</p>
                                    <p class="text-[10px] text-slate-500 italic">{{ $consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine' ? 'Telemedicine Session' : 'Clinic Walk-in' }}</p>
                                </div>
                                <p class="text-lg font-black text-slate-900">₱{{ number_format($consultationFee, 2) }}</p>
                            </div>

                            <!-- Additional Items -->
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Additional Services (Optional)</label>
                                <div id="additionalItems" class="space-y-3">
                                    <!-- Items will be added here -->
                                </div>
                                <button type="button" onclick="addItem()" class="w-full py-3 border-2 border-dashed border-slate-200 rounded-xl text-xs font-black text-slate-400 hover:border-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">
                                    + Add Custom Line Item
                                </button>
                            </div>

                            <!-- Total -->
                            <div class="pt-6 border-t-2 border-slate-900 mt-6 flex justify-between items-center">
                                <p class="text-sm font-black text-slate-900 uppercase tracking-widest">Total Amount Due</p>
                                <p class="text-2xl font-black text-slate-900 tracking-tighter" id="totalAmount">₱{{ number_format($consultationFee, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100">
                            <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest">Payment Settlement</h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Waive Payment Option -->
                            <label class="flex items-center gap-4 p-4 bg-amber-50 rounded-xl border border-amber-100 cursor-pointer group hover:bg-amber-100 transition-all">
                                <input type="checkbox" id="waive_payment" name="waive_payment" value="1" onchange="togglePaymentFields()" class="w-5 h-5 text-amber-600 border-amber-300 rounded focus:ring-amber-500">
                                <div>
                                    <span class="text-xs font-black text-amber-900 uppercase">Waive Professional Fee</span>
                                    <p class="text-[10px] text-amber-700 leading-tight mt-0.5 italic">Check this for pro-bono, family, or staff consultations.</p>
                                </div>
                            </label>

                            <div id="payment-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Payment Method -->
                                <div>
                                    <label for="payment_method" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Payment Method <span class="text-red-500">*</span></label>
                                    <select name="payment_method" id="payment_method" required onchange="updateLivePreview()" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none">
                                        <option value="">Select method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Credit/Debit Card</option>
                                        <option value="gcash">GCash</option>
                                        <option value="paymaya">PayMaya</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <!-- Payment Status -->
                                <div>
                                    <label for="payment_status" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Current Status <span class="text-red-500">*</span></label>
                                    <select name="payment_status" id="payment_status" required onchange="updateLivePreview()" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none">
                                        <option value="paid">Paid (Settled)</option>
                                        <option value="pending">Pending</option>
                                        <option value="partial">Partial Payment</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Waive Reason (shown when waived) -->
                            <div id="waive-reason" style="display: none;">
                                <label for="waive_reason_select" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Reason for Waiving <span class="text-red-500">*</span></label>
                                <select name="waive_reason" id="waive_reason_select" onchange="updateLivePreview()" class="w-full px-4 py-3 bg-amber-50 border border-amber-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-amber-500 outline-none">
                                    <option value="">Select reason</option>
                                    <option value="family_member">Family Member</option>
                                    <option value="pro_bono">Pro Bono Service</option>
                                    <option value="staff_dependent">Staff/Dependent</option>
                                    <option value="charity_case">Charity Case</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Transaction Notes <span id="notes-label" class="text-slate-400">(Optional)</span></label>
                                <textarea name="notes" id="notes" rows="3" oninput="updateLivePreview()" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-slate-900 transition-all outline-none" placeholder="Any additional transaction details..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $consultationFee }}">
                    <input type="hidden" name="items" id="itemsInput" value="">

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('patients.show', $consultation->patient) }}" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition-all">Cancel Transaction</a>
                        <button type="submit" class="px-12 py-4 bg-slate-900 text-white rounded-xl font-black text-sm shadow-xl shadow-slate-200 hover:bg-slate-800 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest">
                            Authorize & Generate Receipt
                        </button>
                    </div>
                </form>
            </div>

            <!-- RIGHT COLUMN: LIVE RECEIPT PREVIEW -->
            <div class="hidden lg:block w-[450px] xl:w-[500px] sticky top-8">
                <div class="flex items-center gap-2 mb-4 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Formal Receipt Preview</span>
                </div>

                <div class="bg-white shadow-2xl p-[12mm] relative flex flex-col font-serif text-slate-900 min-h-[600px] border border-slate-100 rounded-sm">
                    <!-- Letterhead -->
                    <div class="border-b-2 border-slate-900 pb-4 mb-6 text-center">
                        <h1 class="font-sans text-xl font-black uppercase tracking-tighter leading-none">SalamatDoc</h1>
                        <p class="font-sans text-[7px] font-bold text-slate-500 mt-1 uppercase tracking-widest">
                            {{ auth()->user()->clinic_address ?? 'Family Clinic & Diagnostic Center' }}
                        </p>
                        <p class="font-sans text-[6px] text-slate-400 mt-0.5 uppercase tracking-tighter">
                            {{ auth()->user()->email }} • {{ auth()->user()->contact_number ?? '+63 (02) 888-0000' }}
                        </p>
                    </div>

                    <div class="flex justify-between items-start mb-6 font-sans">
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-tighter mb-1">Official Receipt</h2>
                            <p class="text-[7px] text-slate-400 uppercase">Draft #{{ date('YmdHi') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest">Issue Date</p>
                            <p class="text-[10px] font-black">{{ date('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-6 font-sans">
                        <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest mb-1">Patient Details</p>
                        <p class="text-xs font-black uppercase">{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</p>
                        <p class="text-[8px] text-slate-500 italic">ID: {{ $consultation->patient->patient_id }}</p>
                    </div>

                    <!-- Items -->
                    <div class="flex-1 font-sans">
                        <table class="w-full text-[10px]">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="text-left py-2 font-black uppercase tracking-tighter text-slate-400">Description</th>
                                    <th class="text-right py-2 font-black uppercase tracking-tighter text-slate-400">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="preview-items-body">
                                <tr>
                                    <td class="py-3 font-bold border-b border-slate-50">Professional Fee (Consultation)</td>
                                    <td class="py-3 text-right font-black border-b border-slate-50">₱{{ number_format($consultationFee, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Details -->
                    <div class="mt-8 pt-4 border-t-2 border-slate-900 font-sans">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status / Method</p>
                                <p class="text-xs font-black uppercase tracking-tighter" id="preview-status">Paid • Cash</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[7px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Paid</p>
                                <p class="text-xl font-black tracking-tighter" id="preview-total">₱{{ number_format($consultationFee, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-100 flex justify-between items-end">
                            <div class="max-w-[150px]">
                                <p class="text-[6px] text-slate-400 italic leading-tight italic">
                                    * This electronic receipt is a true reflection of the services rendered at SalamatDoc Family Clinic.
                                </p>
                            </div>
                            <div class="text-center w-24 border-t border-slate-900 pt-1">
                                <p class="text-[7px] font-black uppercase tracking-tighter">Authorized</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const consultationFee = {{ $consultationFee }};
        let itemCounter = 0;
        let additionalItemsTotal = 0;

        function togglePaymentFields() {
            const waiveCheckbox = document.getElementById('waive_payment');
            const paymentFields = document.getElementById('payment-fields');
            const waiveReason = document.getElementById('waive-reason');
            const paymentMethod = document.getElementById('payment_method');
            const paymentStatus = document.getElementById('payment_status');
            const waiveReasonSelect = document.getElementById('waive_reason_select');
            const notesLabel = document.getElementById('notes-label');

            if (waiveCheckbox.checked) {
                paymentFields.style.display = 'none';
                waiveReason.style.display = 'block';
                paymentMethod.removeAttribute('required');
                paymentStatus.removeAttribute('required');
                waiveReasonSelect.setAttribute('required', 'required');
                paymentStatus.value = 'waived';
                notesLabel.textContent = '(Recommended)';
            } else {
                paymentFields.style.display = 'flex';
                waiveReason.style.display = 'none';
                paymentMethod.setAttribute('required', 'required');
                paymentStatus.setAttribute('required', 'required');
                waiveReasonSelect.removeAttribute('required');
                paymentStatus.value = 'paid';
                notesLabel.textContent = '(Optional)';
            }
            updateLivePreview();
        }

        function addItem() {
            itemCounter++;
            const container = document.getElementById('additionalItems');
            const itemDiv = document.createElement('div');
            itemDiv.className = 'flex gap-3 items-center bg-slate-50 p-2 rounded-xl border border-slate-100 animate-in fade-in slide-in-from-left-2 duration-300';
            itemDiv.id = `item-${itemCounter}`;
            
            itemDiv.innerHTML = `
                <div class="flex-1">
                    <input type="text" class="item-desc w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold outline-none focus:ring-1 focus:ring-slate-900 transition-all" placeholder="Item Description" oninput="updateLivePreview()">
                </div>
                <div class="w-28">
                    <input type="number" class="item-amount w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-black outline-none focus:ring-1 focus:ring-slate-900 transition-all text-right" placeholder="Amount" step="0.01" oninput="updateLivePreview()">
                </div>
                <button type="button" onclick="removeItem(${itemCounter})" class="p-2 text-slate-300 hover:text-red-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            `;
            container.appendChild(itemDiv);
            updateLivePreview();
        }

        function removeItem(id) {
            document.getElementById(`item-${id}`).remove();
            updateLivePreview();
        }

        function updateLivePreview() {
            const container = document.getElementById('additionalItems');
            const itemsBody = document.getElementById('preview-items-body');
            const totalDisplay = document.getElementById('totalAmount');
            const previewTotal = document.getElementById('preview-total');
            const previewStatus = document.getElementById('preview-status');
            const isWaived = document.getElementById('waive_payment').checked;
            
            let total = consultationFee;
            let items = [];

            // Reset Preview Body
            itemsBody.innerHTML = `
                <tr>
                    <td class="py-3 font-bold border-b border-slate-50">Professional Fee (Consultation)</td>
                    <td class="py-3 text-right font-black border-b border-slate-50">₱${consultationFee.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                </tr>
            `;

            // Process Additional Items
            const rows = container.querySelectorAll('[id^="item-"]');
            rows.forEach(row => {
                const desc = row.querySelector('.item-desc').value;
                const amount = parseFloat(row.querySelector('.item-amount').value) || 0;
                
                if (desc || amount > 0) {
                    total += amount;
                    items.push({ description: desc || 'Unnamed Service', amount: amount });
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="py-3 font-bold border-b border-slate-50">${desc || 'Unnamed Service'}</td>
                        <td class="py-3 text-right font-black border-b border-slate-50">₱${amount.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                    `;
                    itemsBody.appendChild(tr);
                }
            });

            // Update Totals
            const displayTotal = isWaived ? 0 : total;
            const formattedTotal = `₱${displayTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            
            totalDisplay.textContent = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            previewTotal.textContent = formattedTotal;
            if(isWaived) previewTotal.classList.add('text-amber-600');
            else previewTotal.classList.remove('text-amber-600');

            // Update Status & Method
            const method = document.getElementById('payment_method').value || '---';
            const status = document.getElementById('payment_status').value || '---';
            previewStatus.textContent = isWaived ? `Waived • ${document.getElementById('waive_reason_select').value}` : `${status} • ${method}`;

            // Sync hidden inputs
            document.getElementById('totalAmountInput').value = total;
            document.getElementById('itemsInput').value = JSON.stringify(items);
        }

        // Initial update
        updateLivePreview();

        document.getElementById('billingForm').addEventListener('submit', function(e) {
            updateLivePreview();
        });
    </script>
</x-doctor-layout>
