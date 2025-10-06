<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Left Section: Calendar -->
                <div class="md:w-1/2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 font-inter">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">My Schedule</h3>
                    <div id="doctor-calendar" class="mb-6"></div>
                </div>

                <!-- Right Section: Interactive Appointment Panel -->
                <div class="md:w-1/2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 font-inter">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Patient Appointments</h3>

                    <!-- Search and Filter Bar -->
                    <div class="mb-4 flex flex-col sm:flex-row gap-4">
                        <input type="text" id="search-patient-name" placeholder="Search by Patient Name" class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <input type="date" id="filter-date" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <select id="filter-status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="declined">Declined</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                    </div>

                    <div id="doctor-appointments-list" class="space-y-4">
                        @if ($appointments->isEmpty())
                            <p class="text-gray-600 dark:text-gray-400">No appointments found.</p>
                        @else
                            @foreach ($appointments as $appointment)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow flex flex-col space-y-3 transition-all duration-200 ease-in-out hover:shadow-lg hover:scale-[1.02]">
                                    <div class="flex justify-between items-center">
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->user->name }}</p>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'declined' => 'bg-red-100 text-red-800',
                                            'scheduled' => 'bg-blue-100 text-blue-800',
                                        ][$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Date: {{ $appointment->start_time->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Time: {{ $appointment->start_time->format('h:i A') }} - {{ $appointment->end_time->format('h:i A') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Reason: {{ $appointment->reason }}</p>
                                    <div class="flex space-x-2 mt-3">
                                        <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <x-heroicon-o-check class="w-4 h-4" /> <span class="ml-1">Approve</span>
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <x-heroicon-o-x-mark class="w-4 h-4" /> <span class="ml-1">Decline</span>
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <x-heroicon-o-pencil class="w-4 h-4" /> <span class="ml-1">Reschedule</span>
                                        </button>
                                        <a href="#" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 view-details-button" data-appointment-id="{{ $appointment->id }}">
                                            <x-heroicon-o-document-text class="w-4 h-4" /> <span class="ml-1">Medical Record</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointment-details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="modal-title">Appointment Details</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" onclick="document.getElementById('appointment-details-modal').classList.add('hidden')">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
            <div class="mt-2 text-gray-700 dark:text-gray-300 space-y-4">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Patient Information</h4>
                    <p><strong>Name:</strong> <span id="modal-patient-name"></span></p>
                    <p><strong>Contact:</strong> <span id="modal-patient-contact"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="modal-patient-dob"></span></p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Appointment Details</h4>
                    <p><strong>Date:</strong> <span id="modal-appointment-date"></span></p>
                    <p><strong>Time:</strong> <span id="modal-appointment-time"></span></p>
                    <p><strong>Reason:</strong> <span id="modal-appointment-reason"></span></p>
                    <p><strong>Status:</strong> <span id="modal-appointment-status"></span></p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Medical History <i class="fa-solid fa-notes-medical text-clinic-green-dark"></i></h4>
                    <div id="modal-medical-history" class="ml-4 text-sm">
                        <p>Loading medical history...</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Uploaded Reports <i class="fa-solid fa-file-medical text-clinic-green-dark"></i></h4>
                    <div id="modal-uploaded-reports" class="ml-4 text-sm">
                        <p>No reports uploaded.</p>
                    </div>
                </div>
            </div>
            <div class="items-center px-4 py-3 border-t border-gray-200 dark:border-gray-700 mt-4 text-right">
                <button id="close-modal-button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300" onclick="document.getElementById('appointment-details-modal').classList.add('hidden')">Close</button>
            </div>
        </div>
    </div>

    <script>
        window.doctorAppointments = @json($appointments);
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('doctor-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: window.doctorAppointments.map(appointment => ({
                    title: `Dr. {{ Auth::user()->name }} with ${appointment.patient.user.name}`,
                    start: appointment.start_time,
                    end: appointment.end_time,
                    extendedProps: {
                        patientName: appointment.patient.user.name,
                        reason: appointment.reason,
                        status: appointment.status,
                        appointmentId: appointment.id,
                        patientId: appointment.patient.id
                    }
                })),
                eventClick: function(info) {
                    // Handle event click - perhaps open a modal for details/actions
                    console.log('Event: ', info.event.extendedProps);
                    alert('Appointment with ' + info.event.extendedProps.patientName + ' for ' + info.event.extendedProps.reason);
                }
            });
            calendar.render();

            // View Details Button Handler
            document.querySelectorAll('.view-details-button').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.dataset.appointmentId;
                    const appointment = window.doctorAppointments.find(app => app.id == appointmentId);

                    if (appointment) {
                        document.getElementById('modal-patient-name').textContent = appointment.patient.user.name;
                        document.getElementById('modal-appointment-date').textContent = new Date(appointment.start_time).toLocaleDateString();
                        document.getElementById('modal-appointment-time').textContent = `${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(appointment.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                        document.getElementById('modal-appointment-reason').textContent = appointment.reason;
                        document.getElementById('modal-appointment-status').textContent = appointment.status;
                        
                        // Placeholder for medical history and reports - will fetch via AJAX later
                        document.getElementById('modal-medical-history').innerHTML = '<p>Loading medical history...</p>';
                        document.getElementById('modal-uploaded-reports').innerHTML = '<p>Loading reports...</p>';
                        
                        // For now, let's fetch patient details and medical history via a simple AJAX call if possible
                        // This will be expanded in later steps

                        fetch(`/doctor/patients/${appointment.patient_id}/details`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('modal-patient-contact').textContent = data.contact_number;
                                document.getElementById('modal-patient-dob').textContent = new Date(data.date_of_birth).toLocaleDateString();
                            })
                            .catch(error => console.error('Error fetching patient details:', error));

                        fetch(`/doctor/patients/${appointment.patient_id}/medical-records`)
                            .then(response => response.json())
                            .then(data => {
                                const medicalHistoryDiv = document.getElementById('modal-medical-history');
                                if (data.length > 0) {
                                    medicalHistoryDiv.innerHTML = data.map(record => `
                                        <div class="border-b border-gray-200 dark:border-gray-700 py-2">
                                            <strong>Condition:</strong> ${record.medical_condition.name}<br>
                                            <strong>Notes:</strong> ${record.notes || 'N/A'}<br>
                                            <strong>Date:</strong> ${new Date(record.date).toLocaleDateString()}
                                        </div>
                                    `).join('');
                                } else {
                                    medicalHistoryDiv.innerHTML = '<p>No medical history available.</p>';
                                }
                            })
                            .catch(error => console.error('Error fetching medical history:', error));

                        // Fetch reports (placeholder for now)
                        document.getElementById('appointment-details-modal').classList.remove('hidden');
                    }
                });
            });

            // Filtering Logic
            const searchPatientName = document.getElementById('search-patient-name');
            const filterDate = document.getElementById('filter-date');
            const filterStatus = document.getElementById('filter-status');
            const appointmentsListContainer = document.getElementById('doctor-appointments-list');

            function renderAppointments(appointmentsToRender) {
                if (appointmentsToRender.length === 0) {
                    appointmentsListContainer.innerHTML = '<p class="text-gray-600 dark:text-gray-400">No appointments found for the selected criteria.</p>';
                    return;
                }

                appointmentsListContainer.innerHTML = appointmentsToRender.map(appointment => {
                    const statusClass = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'approved': 'bg-green-100 text-green-800',
                        'declined': 'bg-red-100 text-red-800',
                        'scheduled': 'bg-blue-100 text-blue-800',
                    }[appointment.status] || 'bg-gray-100 text-gray-800';

                    return `
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow flex flex-col space-y-3 transition-all duration-200 ease-in-out hover:shadow-lg hover:scale-[1.02]">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">${appointment.patient.user.name}</p>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                    ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Date: ${new Date(appointment.start_time).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Time: ${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(appointment.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Reason: ${appointment.reason}</p>
                            <div class="flex space-x-2 mt-3">
                                <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <x-heroicon-o-check class="w-4 h-4" /> <span class="ml-1">Approve</span>
                                </button>
                                <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <x-heroicon-o-x-mark class="w-4 h-4" /> <span class="ml-1">Decline</span>
                                </button>
                                <button class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> <span class="ml-1">Reschedule</span>
                                </button>
                                <a href="#" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 view-details-button" data-appointment-id="${appointment.id}">
                                    <x-heroicon-o-document-text class="w-4 h-4" /> <span class="ml-1">Medical Record</span>
                                </a>
                            </div>
                        </div>
                    `;
                }).join('');

                // Re-attach event listeners for newly rendered buttons
                document.querySelectorAll('.view-details-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const appointmentId = this.dataset.appointmentId;
                        const appointment = window.doctorAppointments.find(app => app.id == appointmentId);

                        if (appointment) {
                            document.getElementById('modal-patient-name').textContent = appointment.patient.user.name;
                            document.getElementById('modal-appointment-date').textContent = new Date(appointment.start_time).toLocaleDateString();
                            document.getElementById('modal-appointment-time').textContent = `${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(appointment.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                            document.getElementById('modal-appointment-reason').textContent = appointment.reason;
                            document.getElementById('modal-appointment-status').textContent = appointment.status;
                            
                            document.getElementById('modal-medical-history').innerHTML = '<p>Loading medical history...</p>';
                            document.getElementById('modal-uploaded-reports').innerHTML = '<p>Loading reports...</p>';

                            fetch(`/doctor/patients/${appointment.patient_id}/details`)
                                .then(response => response.json())
                                .then(data => {
                                    document.getElementById('modal-patient-contact').textContent = data.contact_number;
                                    document.getElementById('modal-patient-dob').textContent = new Date(data.date_of_birth).toLocaleDateString();
                                })
                                .catch(error => console.error('Error fetching patient details:', error));

                            fetch(`/doctor/patients/${appointment.patient_id}/medical-records`)
                                .then(response => response.json())
                                .then(data => {
                                    const medicalHistoryDiv = document.getElementById('modal-medical-history');
                                    if (data.length > 0) {
                                        medicalHistoryDiv.innerHTML = data.map(record => `
                                            <div class="border-b border-gray-200 dark:border-gray-700 py-2">
                                                <strong>Condition:</strong> ${record.medical_condition.name}<br>
                                                <strong>Notes:</strong> ${record.notes || 'N/A'}<br>
                                                <strong>Date:</strong> ${new Date(record.date).toLocaleDateString()}
                                            </div>
                                        `).join('');
                                    } else {
                                        medicalHistoryDiv.innerHTML = '<p>No medical history available.</p>';
                                    }
                                })
                                .catch(error => console.error('Error fetching medical history:', error));

                            document.getElementById('appointment-details-modal').classList.remove('hidden');
                        }
                    });
                });
            }

            function filterAppointments() {
                const searchText = searchPatientName.value.toLowerCase();
                const selectedDate = filterDate.value;
                const selectedStatus = filterStatus.value;

                const filtered = window.doctorAppointments.filter(appointment => {
                    const matchesName = appointment.patient.user.name.toLowerCase().includes(searchText);
                    const appointmentDate = new Date(appointment.start_time).toISOString().split('T')[0];
                    const matchesDate = !selectedDate || appointmentDate === selectedDate;
                    const matchesStatus = !selectedStatus || appointment.status === selectedStatus;

                    return matchesName && matchesDate && matchesStatus;
                });

                renderAppointments(filtered);
            }

            searchPatientName.addEventListener('input', filterAppointments);
            filterDate.addEventListener('change', filterAppointments);
            filterStatus.addEventListener('change', filterAppointments);

            // Initial render
            renderAppointments(window.doctorAppointments);
        });
    </script>
</x-doctor-layout>
