<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book New Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Validation Error!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <script>
                        window.initialDoctors = @json($doctors);
                    </script>
                    <form action="{{ route('patient.appointments.store') }}" method="POST" enctype="multipart/form-data" x-data="{
                        showSuccessModal: false,
                        appointmentMode: 'online',
                        doctors: window.initialDoctors,
                        selectedDoctorId: null,
                        filter: '',
                        open: false,
                        bookingDetails: { doctorName: '', date: '', time: '', mode: '', reason: '' },
                        initFlatpickr: () => {
                            flatpickr('#appointment_date', {
                                minDate: 'today',
                                dateFormat: 'Y-m-d',
                            });
                            flatpickr('#appointment_time', {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: 'H:i',
                                altInput: true,
                                altFormat: 'h:i K',
                                time_24hr: false,
                            });
                        }
                    }" x-init="initFlatpickr()" @submit.prevent="console.log('Submitting appointment_time:', $el.querySelector('#appointment_time').value); $el.submit();" class="space-y-4">
                        @csrf
                        <!-- Form fields will go here in subsequent steps -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="appointment_date" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Appointment Date</label>
                                <div class="relative mt-1">
                                    <input type="text" id="appointment_date" name="appointment_date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-clinic-green-dark focus:ring focus:ring-clinic-green-light focus:ring-opacity-50 pr-10 placeholder-gray-400 text-gray-900" placeholder="Select Date">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fa-regular fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="appointment_time" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Appointment Time</label>
                                <div class="relative mt-1">
                                    <input type="text" id="appointment_time" name="appointment_time" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-clinic-green-dark focus:ring focus:ring-clinic-green-light focus:ring-opacity-50 pr-10 placeholder-gray-400 text-gray-900" placeholder="Select Time">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fa-regular fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mode of Appointment -->
                        <div class="space-y-4">
                            <label class="block font-semibold text-sm text-gray-700">Mode of Appointment</label>
                            <div class="mt-1 flex space-x-2">
                                <label class="flex-1 flex items-center justify-center py-2 px-4 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg cursor-pointer transition-all duration-200 ease-in-out hover:bg-gray-100" :class="{'bg-clinic-green-dark text-white': appointmentMode === 'online'}">
                                    <input type="radio" name="appointment_mode" value="online" class="sr-only" x-model="appointmentMode">
                                    Online
                                </label>
                                <label class="flex-1 flex items-center justify-center py-2 px-4 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg cursor-pointer transition-all duration-200 ease-in-out hover:bg-gray-100" :class="{'bg-clinic-green-dark text-white': appointmentMode === 'walk-in'}">
                                    <input type="radio" name="appointment_mode" value="walk-in" class="sr-only" x-model="appointmentMode">
                                    Walk-in
                                </label>
                                <label class="flex-1 flex items-center justify-center py-2 px-4 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg cursor-pointer transition-all duration-200 ease-in-out hover:bg-gray-100" :class="{'bg-clinic-green-dark text-white': appointmentMode === 'follow-up'}">
                                    <input type="radio" name="appointment_mode" value="follow-up" class="sr-only" x-model="appointmentMode">
                                    Follow-up
                                </label>
                            </div>
                        </div>

                        <!-- Urgency/Priority -->
                        <div class="space-y-4">
                            <label for="urgency_priority" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Urgency/Priority</label>
                            <select id="urgency_priority" name="urgency_priority" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-clinic-green-dark focus:ring focus:ring-clinic-green-light focus:ring-opacity-50 text-gray-900">
                                <option value="routine">Routine</option>
                                <option value="urgent">Urgent</option>
                                <option value="emergency">Emergency</option>
                            </select>
                        </div>

                        <!-- Doctor Selection -->
                        <div @click.away="open = false" class="space-y-4">
                            <label for="doctor_selection" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Doctor Selection</label>
                            <div class="relative mt-1">
                                <input type="text" id="doctor_selection" name="doctor_selection" x-model="filter" @focus="open = true" placeholder="Search for a doctor" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-clinic-green-dark focus:ring focus:ring-clinic-green-light focus:ring-opacity-50 placeholder-gray-400 text-gray-900">
                                <input type="hidden" name="doctor_id" x-model="selectedDoctorId">

                                <div x-show="open" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border border-gray-200 dark:border-gray-600 max-h-60 overflow-auto" style="display: none;">
                                    <template x-for="doctor in doctors.filter(d => d.name.toLowerCase().includes(filter.toLowerCase()))" :key="doctor.id">
                                        <div @click="selectedDoctorId = doctor.id; open = false; filter = doctor.name" class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-3">
                                            <img :src="doctor.image" alt="" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="doctor.name"></p>
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400" x-text="doctor.specialty"></p>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="filter && doctors.filter(d => d.name.toLowerCase().includes(filter.toLowerCase())).length === 0" class="p-2 text-sm text-gray-500 dark:text-gray-400">
                                        No doctors found.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Symptoms/Chief Complaint -->
                        <div class="space-y-4">
                            <label for="symptoms_complaint" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Symptoms/Chief Complaint</label>
                            <textarea id="symptoms_complaint" name="symptoms_complaint" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-clinic-green-dark focus:ring focus:ring-clinic-green-light focus:ring-opacity-50 placeholder-gray-400 text-gray-900" placeholder="Briefly describe your condition"></textarea>
                        </div>

                        <!-- Optional File Upload -->
                        <div x-data="{ fileName: null }" class="space-y-4">
                            <label for="file_upload" class="block font-semibold text-sm text-gray-700 dark:text-gray-300">Optional File Upload (Lab Results/Reports)</label>
                            <input type="file" id="file_upload" name="file_upload" class="sr-only" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null">
                            <div class="mt-1 flex justify-center items-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg appearance-none cursor-pointer hover:border-clinic-green-dark hover:bg-gray-50 focus:outline-none">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-clinic-green-dark text-xl"></i>
                                    <span class="font-medium text-gray-600">Drop files to Attach, or <label for="file_upload" class="text-clinic-green-dark underline cursor-pointer" role="button" tabindex="0">browse</label></span>
                                    <span x-text="fileName" class="ml-3 text-sm text-gray-500" x-show="fileName"></span>
                                </span>
                            </div>
                        </div>

                        <!-- Consent Checkbox -->
                        <div class="flex items-center space-y-4">
                            <input type="checkbox" name="consent" id="consent" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="consent" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                I consent to share my medical records with the doctor.
                            </label>
                        </div>

                        <!-- Submit and Cancel buttons -->
                        <div class="flex items-center justify-end gap-4 mt-4">
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-clinic-green-dark border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Request Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-data="{
        showSuccessModal: {{ session('bookingDetails') ? 'true' : 'false' }},
        bookingDetails: @json(session('bookingDetails', []))
    }" x-show="showSuccessModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Appointment Booked!</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Your appointment with <span class="font-semibold" x-text="bookingDetails.doctorName"></span> has been successfully requested.
                    </p>
                    <ul class="mt-4 text-sm text-gray-600 dark:text-gray-300 text-left space-y-1">
                        <li><strong>Date:</strong> <span x-text="bookingDetails.date"></span></li>
                        <li><strong>Time:</strong> <span x-text="bookingDetails.time"></span></li>
                        <li><strong>Mode:</strong> <span x-text="bookingDetails.mode"></span></li>
                        <li><strong>Reason:</strong> <span x-text="bookingDetails.reason"></span></li>
                    </ul>
                </div>
                <div class="items-center px-4 py-3">
                    <button @click="showSuccessModal = false" class="px-4 py-2 bg-clinic-green-dark text-white text-base font-medium rounded-lg w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Got it!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History Prompt -->
    <div x-data="{ showMedicalHistoryPrompt: true }" x-show="showMedicalHistoryPrompt" class="fixed top-4 right-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg shadow-md" role="alert" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-notes-medical mr-2"></i>
                <p class="font-semibold">Complete your medical history!</p>
            </div>
            <button @click="showMedicalHistoryPrompt = false" class="text-blue-600 hover:text-blue-800 ml-4">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <p class="text-sm mt-2">Would you like to complete your medical history before your visit?</p>
        <div class="mt-3">
            <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-clinic-green-dark hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-clinic-green-dark">
                <i class="fa-solid fa-arrow-right mr-2"></i> Go to Medical History
            </a>
        </div>
    </div>
</x-patient-layout>
