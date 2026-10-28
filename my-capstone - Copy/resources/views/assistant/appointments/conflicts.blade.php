<x-assistant-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 leading-tight">
                    {{ __('Clinical Conflict Manager') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Proactively identify and resolve appointments requested outside of doctor availability.</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-100 rounded-xl">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">{{ $conflicts->count() }} Conflicts Detected</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($conflicts->isEmpty())
                <div class="bg-white rounded-3xl border border-dashed border-gray-200 p-20 text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Schedule is Clear!</h3>
                    <p class="text-gray-500 text-sm mt-2 max-w-sm mx-auto">All current appointments fall within the defined clinical hours of our physicians.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($conflicts as $appointment)
                        <div id="appointment-card-{{ $appointment->id }}" class="appointment-card-container bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-500 group">
                            <div class="p-6 flex flex-col md:flex-row items-center gap-8">
                                <!-- Status & Time -->
                                <div class="flex flex-col items-center justify-center min-w-[120px] p-4 bg-red-50 rounded-2xl border border-red-100">
                                    <span class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Out of Hours</span>
                                    <span class="text-lg font-black text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                                    <span class="text-[10px] font-bold text-gray-400">{{ \Carbon\Carbon::parse($appointment->start_time)->format('M d, Y') }}</span>
                                </div>

                                <!-- Patient & Doctor Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                            {{ substr($appointment->patient->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-violet-600 transition-colors">{{ $appointment->patient->user->name }}</h4>
                                            <p class="text-[10px] text-gray-400 font-medium">Patient ID: #{{ str_pad($appointment->patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Assigned to:</span>
                                        <span class="text-[10px] font-black text-violet-600 bg-violet-50 px-2 py-0.5 rounded">Dr. {{ $appointment->doctor->name }}</span>
                                    </div>
                                </div>

                                <!-- Conflict Reason -->
                                <div class="flex-1 max-w-md">
                                    <div class="flex items-start gap-3 p-4 bg-amber-50/50 border border-amber-100 rounded-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-amber-500 flex-shrink-0">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-0.5">Availability Conflict</p>
                                            <p class="text-xs text-amber-800 leading-relaxed font-medium">
                                                Dr. {{ $appointment->doctor->name }} is not scheduled for clinical duties during this time block on {{ \Carbon\Carbon::parse($appointment->start_time)->format('l') }}s.
                                            </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-3">
                                    <button onclick="rescheduleConflict({{ $appointment->id }})" class="px-6 py-3 bg-violet-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-violet-700 transition-all shadow-lg shadow-violet-600/20">
                                        Reschedule
                                    </button>
                                    <button onclick="cancelConflict({{ $appointment->id }})" class="px-4 py-3 bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-100 font-bold text-[10px] uppercase tracking-widest rounded-xl transition-all">
                                        Decline
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div id="rescheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRescheduleModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-gray-900 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest">Reschedule Appointment</h3>
                    <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="rescheduleForm" onsubmit="submitReschedule(event)">
                    @csrf
                    <input type="hidden" id="reschedule_appointment_id">
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Select New Date</label>
                            <input type="date" id="new_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">New Start Time</label>
                                <input type="time" id="new_start" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">New End Time</label>
                                <input type="time" id="new_end" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition-all">
                            </div>
                        </div>

                        <div class="bg-violet-50 p-4 rounded-2xl flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-violet-500 flex-shrink-0">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-[10px] text-violet-700 font-medium leading-relaxed">
                                Rescheduling will automatically notify the patient of the new time slot. Please ensure the new slot matches the doctor's clinical availability.
                            </p>
                        </div>
                    </div>

                    <div class="px-8 pb-8 flex gap-3">
                        <button type="button" onclick="closeRescheduleModal()" class="flex-1 py-3 bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-violet-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-violet-700 transition-all shadow-lg shadow-violet-600/20">
                            Confirm New Time
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification System -->
    <div id="toast-container" class="fixed top-6 right-6 z-[100] space-y-3"></div>

    @push('scripts')
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const colors = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
            
            toast.className = `${colors} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in slide-in-from-right-full duration-300 transform transition-all`;
            toast.innerHTML = `
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest">${message}</p>
            `;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function updateConflictCount() {
            const counter = document.querySelector('.tracking-widest.uppercase');
            if (counter) {
                const currentCount = document.querySelectorAll('.appointment-card-container').length;
                if (currentCount === 0) {
                    location.reload(); // Show empty state
                } else {
                    counter.innerText = `${currentCount} Conflicts Detected`;
                }
            }
        }

        function rescheduleConflict(id) {
            document.getElementById('reschedule_appointment_id').value = id;
            document.getElementById('rescheduleModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function submitReschedule(e) {
            e.preventDefault();
            const id = document.getElementById('reschedule_appointment_id').value;
            const date = document.getElementById('new_date').value;
            const start = document.getElementById('new_start').value;
            const end = document.getElementById('new_end').value;

            if (!date || !start || !end) return;

            fetch(`/assistant/appointments/${id}/reschedule`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    start_time: `${date} ${start}`,
                    end_time: `${date} ${end}`
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeRescheduleModal();
                    const card = document.getElementById(`appointment-card-${id}`);
                    card.classList.add('opacity-0', '-translate-x-full', 'scale-95');
                    setTimeout(() => {
                        card.remove();
                        updateConflictCount();
                        showToast('Appointment Rescheduled Successfully');
                    }, 500);
                } else {
                    showToast(data.message || 'Error rescheduling', 'error');
                }
            });
        }

        function cancelConflict(id) {
            if (confirm('Decline this appointment due to clinical conflict?')) {
                fetch(`/assistant/appointments/${id}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = document.getElementById(`appointment-card-${id}`);
                        card.classList.add('opacity-0', 'scale-90');
                        setTimeout(() => {
                            card.remove();
                            updateConflictCount();
                            showToast('Appointment Declined', 'success');
                        }, 500);
                    }
                });
            }
        }
    </script>
    @endpush
</x-assistant-layout>
