<x-patient-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Schedule Your Visit</h1>
                <p class="text-sm text-gray-600 mt-0.5">Book an appointment with our healthcare professionals</p>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen flex flex-col appointment-booking-container">
        <!-- Progress Steps -->
        <div class="progress-steps">
            <button type="button" id="step1" class="progress-step completed">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-white">Select Doctor</span>
            </button>
            
            <button type="button" id="step2" class="progress-step active">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-white">Pick Time</span>
            </button>
            
            <button type="button" id="step3" class="progress-step pending">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-white">Confirm Details</span>
            </button>
        </div>

        <form action="{{ route('patient.appointments.store') }}" method="POST" class="appointment-form-grid">
            @csrf

            <!-- Column 1: Select Doctor -->
            <div id="column1" class="appointment-column">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h2 class="text-base font-bold text-white">Select Your Doctor</h2>
                </div>

                <div class="space-y-2.5 mb-4 flex-shrink-0">
                    @foreach($doctors as $index => $doctor)
                    <button type="button" onclick="selectDoctor({{ $doctor->id }}, '{{ $doctor->name }}', '{{ $index }}')" 
                            class="doctor-card w-full p-4 rounded-lg text-left transition-all {{ $index === 0 ? 'bg-blue-600' : 'bg-slate-700/70 hover:bg-slate-600' }}"
                            data-doctor-id="{{ $doctor->id }}">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold text-sm">Dr. {{ $doctor->name }}</h3>
                                <p class="text-gray-400 text-xs">General Medicine</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-yellow-400 text-xs">★ 4.{{ 7 + $index }}</span>
                                    <span class="text-green-400 text-xs">Next: Dec {{ 8 + $index }}</span>
                                </div>
                            </div>
                        </div>
                    </button>
                    @endforeach
                </div>

                <div id="doctorInfo" class="p-4 bg-blue-900/40 rounded-lg border border-blue-700/50 flex-grow">
                    <h3 class="text-white font-semibold mb-3 text-sm">Doctor Info</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Specialization:</span>
                            <span class="text-white" id="docSpecialty">Cardiology</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Rating:</span>
                            <span class="text-white" id="docRating">4.9/5.0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Next Available:</span>
                            <span class="text-white" id="docNext">Dec 9</span>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctors->first()->id ?? '' }}" required>
                @error('doctor_id')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Column 2: Schedule Time -->
            <div id="column2" class="appointment-column active">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h2 class="text-base font-bold text-white">Pick Date & Time</h2>
                </div>

                <!-- Calendar -->
                <div class="mb-4 flex-shrink-0">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-white font-semibold text-sm" id="current-month">December 2025</h3>
                        <div class="flex gap-1">
                            <button type="button" id="prev-month" class="p-1.5 hover:bg-slate-700 rounded">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button type="button" id="next-month" class="p-1.5 hover:bg-slate-700 rounded">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="calendar-grid" id="calendar"></div>
                    <p class="text-gray-400 text-xs flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                        Available dates
                    </p>
                    <input type="hidden" name="appointment_date" id="appointment_date" required>
                    @error('appointment_date')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Selection -->
                <div id="timeSelection" class="mb-3 flex-grow flex flex-col">
                    <h3 class="text-white font-semibold mb-3 flex items-center gap-1 text-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Select Your Time
                    </h3>
                    
                    <div class="space-y-3">
                        <!-- Start Time -->
                        <div>
                            <label class="text-gray-300 text-sm mb-1.5 block">Start Time *</label>
                            <input type="time" 
                                   name="start_time" 
                                   id="start_time" 
                                   onchange="updateEndTimeMin(); checkFormComplete();"
                                   class="w-full p-3 bg-slate-700/70 text-white rounded-lg border border-slate-600 focus:border-blue-500 focus:outline-none text-sm"
                                   required>
                            @error('start_time')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- End Time -->
                        <div>
                            <label class="text-gray-300 text-sm mb-1.5 block">End Time *</label>
                            <input type="time" 
                                   name="end_time" 
                                   id="end_time" 
                                   onchange="checkFormComplete();"
                                   class="w-full p-3 bg-slate-700/70 text-white rounded-lg border border-slate-600 focus:border-blue-500 focus:outline-none text-sm"
                                   required>
                            @error('end_time')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Duration Display -->
                        <div id="durationDisplay" class="hidden p-3 bg-blue-900/30 rounded-lg border border-blue-700/50">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-300">Duration:</span>
                                <span class="text-blue-300 font-semibold" id="durationText">--</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-amber-900/30 rounded-lg border border-amber-700/50 flex-shrink-0">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-xs text-amber-300">
                            <p class="font-semibold mb-1">Appointment Guidelines:</p>
                            <ul class="space-y-0.5 text-amber-200">
                                <li>• Minimum duration: 30 minutes</li>
                                <li>• Recommended: 45-60 minutes</li>
                                <li>• Choose any available date & time</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3: Confirm Details -->
            <div id="column3" class="appointment-column">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-base font-bold text-white">Confirm Details</h2>
                </div>

                <!-- Appointment Type -->
                <div class="mb-3">
                    <label class="text-white font-semibold mb-2 block text-sm">Appointment Type *</label>
                    <div class="space-y-2">
                        <button type="button" onclick="selectAppointmentType('in-clinic')" id="inClinic" class="w-full p-2.5 rounded-lg text-left transition-all bg-slate-700/70 hover:bg-slate-600 border border-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🏥</span>
                                <div class="flex-1">
                                    <span class="text-white font-medium text-sm block">In-Clinic Visit</span>
                                    <span class="text-gray-400 text-xs">Visit clinic in person</span>
                                </div>
                            </div>
                        </button>
                        <button type="button" onclick="selectAppointmentType('telemedicine')" id="telemedicine" class="w-full p-2.5 rounded-lg text-left transition-all bg-blue-600 border border-blue-500">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">💻</span>
                                <div class="flex-1">
                                    <span class="text-white font-medium text-sm block">Telemedicine</span>
                                    <span class="text-gray-300 text-xs">Online video call</span>
                                </div>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" name="appointment_mode" id="appointment_mode" value="telemedicine" required>
                    @error('appointment_mode')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urgency Level -->
                <div class="mb-3">
                    <label class="text-white font-semibold mb-2 block text-sm">Urgency Level *</label>
                    <select name="urgency_priority" class="w-full p-2.5 bg-slate-700/70 text-white rounded-lg border border-slate-600 focus:border-blue-500 focus:outline-none text-sm" required>
                        <option value="routine">🟢 Routine</option>
                        <option value="urgent">🟡 Urgent</option>
                        <option value="emergency">🔴 Emergency</option>
                    </select>
                    @error('urgency_priority')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Symptoms -->
                <div class="mb-3 flex-grow flex flex-col">
                    <label class="text-white font-semibold mb-2 block text-sm">Describe Your Symptoms *</label>
                    <textarea id="symptoms" name="symptoms_complaint" onkeyup="checkSymptoms()" placeholder="Example: Headaches for 3 days with mild fever..." class="symptoms-textarea" required>{{ old('symptoms_complaint') }}</textarea>
                    <p class="text-gray-400 text-xs mt-1">Be specific to help the doctor prepare</p>
                    @error('symptoms_complaint')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quick Tips -->
                <div class="p-4 bg-blue-900/40 rounded-lg border border-blue-700/50 mb-3 flex-shrink-0">
                    <h3 class="text-blue-300 font-semibold mb-2 flex items-center gap-2 text-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Tips:
                    </h3>
                    <ul class="text-gray-300 text-xs space-y-1">
                        <li>• Book 24hrs ahead for routine visits</li>
                        <li>• Arrive 10min early for in-clinic</li>
                        <li>• Have medical history ready</li>
                    </ul>
                </div>

                <!-- Consent Checkbox -->
                <div class="mb-3 flex-shrink-0">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" name="consent" value="1" onchange="checkFormComplete()" class="mt-1 w-4 h-4 text-blue-600 bg-slate-700 border-slate-600 rounded focus:ring-blue-500" required>
                        <span class="text-gray-300 text-xs">I agree to the terms and conditions and consent to the appointment booking *</span>
                    </label>
                    @error('consent')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" id="confirmBtn" disabled class="submit-btn bg-slate-600 text-gray-400 w-full flex-shrink-0">
                    Complete All Fields
                </button>
            </div>
        </form>
    </div>

    <style>
        .doctor-card { transition: all 0.2s; }
        .doctor-card:hover { transform: translateY(-1px); }
        .calendar-day { transition: all 0.2s; }
        .calendar-day:hover:not(:disabled) { transform: scale(1.05); }
        .time-slot { transition: all 0.2s; }
        .time-slot:hover:not(:disabled) { transform: translateY(-1px); }
        
        /* Full screen layout */
        @media (min-width: 1024px) {
            form.grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                min-height: calc(100vh - 220px);
            }
            #column1, #column2, #column3 {
                display: flex;
                flex-direction: column;
                height: 100%;
            }
        }
        
        /* Custom scrollbar */
        #timeSlotsGrid::-webkit-scrollbar {
            width: 5px;
        }
        #timeSlotsGrid::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 4px;
        }
        #timeSlotsGrid::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }
    </style>

    <script>
        let selectedDoctor = { name: '{{ $doctors->first()->name ?? "Not selected" }}', specialty: 'Cardiology', rating: '4.9', next: 'Dec 9' };
        let selectedDate = null;
        let appointmentType = 'telemedicine';

        function selectDoctor(id, name, index) {
            selectedDoctor = { name, specialty: 'Cardiology', rating: (4.7 + parseInt(index) * 0.1).toFixed(1), next: 'Dec ' + (8 + parseInt(index)) };
            document.getElementById('doctor_id').value = id;
            document.getElementById('docSpecialty').textContent = 'Cardiology';
            document.getElementById('docRating').textContent = selectedDoctor.rating + '/5.0';
            document.getElementById('docNext').textContent = selectedDoctor.next;
            
            document.querySelectorAll('.doctor-card').forEach(btn => {
                btn.classList.remove('bg-blue-600');
                btn.classList.add('bg-slate-700/70');
            });
            event.currentTarget.classList.remove('bg-slate-700/70');
            event.currentTarget.classList.add('bg-blue-600');
            
            updateStep(2);
            checkFormComplete();
        }

        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            const dayNames = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
            const today = new Date();
            const currentDay = today.getDate();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();
            
            dayNames.forEach(day => {
                const header = document.createElement('div');
                header.className = 'text-center text-gray-400 text-sm font-medium p-2';
                header.textContent = day;
                calendar.appendChild(header);
            });
            
            // Get days in current month
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            
            for (let day = 1; day <= daysInMonth; day++) {
                const isPast = day < currentDay;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `calendar-day ${
                    !isPast ? 'bg-slate-700/50 text-white cursor-pointer hover:bg-blue-600' : 'text-gray-600 cursor-not-allowed opacity-50'
                }`;
                btn.textContent = day;
                btn.disabled = isPast;
                
                if (!isPast) {
                    btn.onclick = () => selectDate(day, btn);
                }
                calendar.appendChild(btn);
            }
        }

        function selectDate(day, btn) {
            selectedDate = day;
            const year = new Date().getFullYear();
            const month = String(new Date().getMonth() + 1).padStart(2, '0');
            const dayStr = String(day).padStart(2, '0');
            document.getElementById('appointment_date').value = `${year}-${month}-${dayStr}`;
            
            document.querySelectorAll('.calendar-day').forEach(b => {
                b.classList.remove('selected');
            });
            btn.classList.add('selected');
            
            checkFormComplete();
        }

        function updateEndTimeMin() {
            const startTime = document.getElementById('start_time').value;
            const endTimeInput = document.getElementById('end_time');
            
            if (startTime) {
                // Set minimum end time to 30 minutes after start time
                const [hours, minutes] = startTime.split(':');
                const startDate = new Date();
                startDate.setHours(parseInt(hours), parseInt(minutes));
                startDate.setMinutes(startDate.getMinutes() + 30);
                
                const minEndTime = `${String(startDate.getHours()).padStart(2, '0')}:${String(startDate.getMinutes()).padStart(2, '0')}`;
                endTimeInput.min = minEndTime;
                
                // Auto-set end time to 1 hour after start if not set
                if (!endTimeInput.value) {
                    startDate.setMinutes(startDate.getMinutes() + 30); // Total 1 hour
                    endTimeInput.value = `${String(startDate.getHours()).padStart(2, '0')}:${String(startDate.getMinutes()).padStart(2, '0')}`;
                }
                
                calculateDuration();
            }
        }

        function calculateDuration() {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const durationDisplay = document.getElementById('durationDisplay');
            const durationText = document.getElementById('durationText');
            
            if (startTime && endTime) {
                const [startHours, startMinutes] = startTime.split(':').map(Number);
                const [endHours, endMinutes] = endTime.split(':').map(Number);
                
                const startTotalMinutes = startHours * 60 + startMinutes;
                const endTotalMinutes = endHours * 60 + endMinutes;
                const durationMinutes = endTotalMinutes - startTotalMinutes;
                
                if (durationMinutes > 0) {
                    const hours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60;
                    
                    let durationStr = '';
                    if (hours > 0) durationStr += `${hours} hour${hours > 1 ? 's' : ''}`;
                    if (minutes > 0) durationStr += `${hours > 0 ? ' ' : ''}${minutes} min`;
                    
                    durationText.textContent = durationStr;
                    durationDisplay.classList.remove('hidden');
                } else {
                    durationDisplay.classList.add('hidden');
                }
            }
        }

        // Add event listeners for duration calculation
        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            
            if (startTimeInput) {
                startTimeInput.addEventListener('change', calculateDuration);
            }
            if (endTimeInput) {
                endTimeInput.addEventListener('change', calculateDuration);
            }
        });

        function selectAppointmentType(type) {
            appointmentType = type;
            document.getElementById('appointment_mode').value = type;
            const inClinic = document.getElementById('inClinic');
            const telemedicine = document.getElementById('telemedicine');
            
            if (type === 'in-clinic') {
                inClinic.classList.remove('bg-slate-700/70', 'border-slate-600');
                inClinic.classList.add('bg-blue-600', 'border-blue-500');
                telemedicine.classList.remove('bg-blue-600', 'border-blue-500');
                telemedicine.classList.add('bg-slate-700/70', 'border-slate-600');
            } else {
                telemedicine.classList.remove('bg-slate-700/70', 'border-slate-600');
                telemedicine.classList.add('bg-blue-600', 'border-blue-500');
                inClinic.classList.remove('bg-blue-600', 'border-blue-500');
                inClinic.classList.add('bg-slate-700/70', 'border-slate-600');
            }
            checkFormComplete();
        }

        function checkSymptoms() {
            checkFormComplete();
        }

        function checkFormComplete() {
            const symptoms = document.getElementById('symptoms').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const consent = document.querySelector('input[name="consent"]').checked;
            const btn = document.getElementById('confirmBtn');
            
            if (selectedDate && startTime && endTime && symptoms.trim() && consent) {
                btn.disabled = false;
                btn.classList.remove('bg-slate-600', 'text-gray-400');
                btn.classList.add('bg-green-600', 'text-white');
                btn.textContent = '✓ Confirm Appointment';
            } else {
                btn.disabled = true;
                btn.classList.remove('bg-green-600', 'text-white');
                btn.classList.add('bg-slate-600', 'text-gray-400');
                btn.textContent = 'Complete All Fields';
            }
        }

        function updateStep(step) {
            const steps = [1, 2, 3];
            steps.forEach(s => {
                const stepEl = document.getElementById(`step${s}`);
                const columnEl = document.getElementById(`column${s}`);
                
                if (s === step) {
                    stepEl.classList.remove('pending', 'completed');
                    stepEl.classList.add('active');
                    columnEl.classList.add('active');
                } else if (s < step) {
                    stepEl.classList.remove('pending', 'active');
                    stepEl.classList.add('completed');
                    columnEl.classList.remove('active');
                } else {
                    stepEl.classList.remove('active', 'completed');
                    stepEl.classList.add('pending');
                    columnEl.classList.remove('active');
                }
            });
        }

        // Initialize
        generateCalendar();
    </script>
</x-patient-layout>
