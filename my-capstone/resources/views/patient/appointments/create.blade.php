<x-patient-layout>
    <x-slot name="title">Schedule Your Visit</x-slot>
    <x-slot name="subtitle">Choose a doctor and pick your preferred time slot</x-slot>

    <div class="max-w-6xl mx-auto">
        <!-- Progress Indicator -->
        <div class="mb-10 flex items-center justify-center">
            <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 text-white text-[10px] flex items-center justify-center font-bold">1</div>
                    <span class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Selection</span>
                </div>
                <div class="w-8 h-[2px] bg-gray-100"></div>
                <div class="flex items-center gap-2 opacity-40">
                    <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 text-[10px] flex items-center justify-center font-bold">2</div>
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Confirmation</span>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 p-4 rounded-xl flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-red-900 text-sm font-bold">Booking Error Detected</p>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 pl-11 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-100 p-4 rounded-xl flex items-center gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-red-900 text-sm font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('patient.appointments.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <!-- Left Column: Doctor Selection -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        Choose a Physician
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($doctors as $index => $doctor)
                            <label class="block relative cursor-pointer group">
                                <input type="radio" name="doctor_id" value="{{ $doctor->id }}" class="peer hidden" {{ $index === 0 ? 'checked' : '' }} 
                                       @change="$dispatch('doctor-changed', {{ $doctor->id }})">
                                <div class="p-4 rounded-xl border border-gray-100 bg-white group-hover:border-emerald-200 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30 peer-checked:ring-4 peer-checked:ring-emerald-500/5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs peer-checked:bg-emerald-500 peer-checked:text-white transition-colors">
                                            {{ substr($doctor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">Dr. {{ $doctor->name }}</p>
                                            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-tighter mt-0.5">Clinical Specialist</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden peer-checked:block">
                                    <div class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-white">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-600/20">
                    <h4 class="font-bold text-sm mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        Clinical Schedule
                    </h4>
                    <div x-data='{ 
                        selectedDoctor: {{ $doctors->first()->id }},
                        doctors: @json($doctors->keyBy("id"))
                    }' @doctor-changed.window="selectedDoctor = $event.detail">
                        <div class="space-y-2 mt-3">
                            <template x-for="day in [1,2,3,4,5,6,0]" :key="day">
                                <div class="flex justify-between items-center text-[10px]">
                                    <span class="font-bold opacity-70 uppercase tracking-tighter" x-text="['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][day]"></span>
                                    <span class="font-medium" x-text="
                                        doctors[selectedDoctor].availabilities.filter(a => a.day_of_week == day && a.is_available).length > 0 
                                        ? doctors[selectedDoctor].availabilities.filter(a => a.day_of_week == day && a.is_available)
                                            .map(a => a.start_time.substring(0,5) + '-' + a.end_time.substring(0,5))
                                            .join(' | ')
                                        : 'Off'
                                    "></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Column: Date & Time -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                        <div class="w-2 h-6 bg-blue-500 rounded-full"></div>
                        Select Schedule
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" required min="{{ date('Y-m-d') }}"
                                   class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Start Time</label>
                                <input type="time" name="start_time" id="start_time" required
                                       class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">End Time</label>
                                <input type="time" name="end_time" id="end_time" required
                                       class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Final Details -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                        <div class="w-2 h-6 bg-violet-500 rounded-full"></div>
                        Clinical Notes
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Symptoms & Complaints</label>
                            <textarea name="symptoms_complaint" rows="4" required placeholder="Describe what you are feeling..."
                                      class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all resize-none"></textarea>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Priority Level</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="urgency_priority" value="routine" class="peer hidden" checked>
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Routine
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="urgency_priority" value="urgent" class="peer hidden">
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition-all">
                                        Urgent
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Visit Type</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="appointment_mode" value="in-clinic" class="peer hidden" checked>
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all">
                                        In-Clinic
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="appointment_mode" value="telemedicine" class="peer hidden">
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 transition-all">
                                        Video Call
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-50">
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="consent" required class="mt-1 w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 transition-all">
                                <span class="text-[10px] text-gray-500 font-medium leading-relaxed group-hover:text-gray-700 transition-colors">
                                    I confirm that the information provided is accurate and I agree to the clinic's appointment policy.
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-4 bg-emerald-600 text-white text-xs font-bold uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-[0.98]">
                            Request Appointment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('start_time').addEventListener('change', function() {
            if (this.value) {
                const [hours, minutes] = this.value.split(':');
                const date = new Date();
                date.setHours(parseInt(hours, 10), parseInt(minutes, 10));
                
                // Add 1 hour
                date.setHours(date.getHours() + 1);
                
                const endHours = String(date.getHours()).padStart(2, '0');
                const endMinutes = String(date.getMinutes()).padStart(2, '0');
                document.getElementById('end_time').value = `${endHours}:${endMinutes}`;
            }
        });
    </script>
    @endpush
</x-patient-layout>
