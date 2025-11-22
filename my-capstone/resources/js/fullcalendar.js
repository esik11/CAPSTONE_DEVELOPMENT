import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    // Only initialize if calendar element exists (on appointments page)
    if (!calendarEl) {
        console.log('Calendar element not found, skipping FullCalendar initialization');
        return;
    }
    
    var appointments = window.appointments || []; // Initialize appointments here
    var currentFilteredAppointments = appointments;

    // Function to determine initial view based on screen size
    function getInitialView() {
        return window.innerWidth <= 768 ? 'listWeek' : 'dayGridMonth';
    }

    function getStatusColor(status) {
        switch (status) {
            case 'approved':
                return '#16a750'; // Using the specific green accent for confirmed
            case 'pending':
                return '#f97316'; // Orange for pending
            case 'cancelled':
            case 'declined':
                return '#ef4444'; // Red for canceled
            case 'rescheduled':
                return '#2563eb'; // Blue for rescheduled
            default:
                return '#6b7280'; // Gray for default
        }
    }

    function formatAppointmentForCalendar(appointment) {
        return {
            id: appointment.id,
            title: appointment.reason,
            start: appointment.start_time,
            end: appointment.end_time,
            color: getStatusColor(appointment.status), // Background color for the event
            extendedProps: {
                status: appointment.status,
                doctorName: appointment.doctor ? appointment.doctor.name : 'N/A',
                reason: appointment.reason,
                medicalRecords: appointment.medical_records_attached, // Assuming this prop exists
                start: appointment.start_time,
                end: appointment.end_time,
                // Add any other details you want to show in the modal
            }
        };
    }

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
        initialView: getInitialView(), // Set initial view dynamically
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: appointments.map(formatAppointmentForCalendar),
        eventDisplay: 'block', // Ensure events are always rendered as blocks for better visibility
        dateClick: function(info) {
            const clickedDate = info.dateStr;
            filterAppointmentsByDate(clickedDate);
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault(); // Prevent page reload
            showAppointmentDetailsModal(info.event);
        },
        eventDidMount: function(info) {
            // Add a custom class based on status for more granular styling if needed
            info.el.classList.add(`fc-event-${info.event.extendedProps.status}`);
        },
        customButtons: {
            // You can add custom buttons here if needed
        },
        eventContent: function(arg) {
            const status = arg.event.extendedProps.status;
            const doctorName = arg.event.extendedProps.doctorName;
            // const hasMedicalRecords = arg.event.extendedProps.hasMedicalRecords; // Assuming this prop exists
            const startTime = new Date(arg.event.start).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

            let iconDoctor = '<i class="fa-solid fa-user-doctor mr-1"></i>'; // Lucide/Font Awesome icon for doctor
            let iconTime = '<i class="fa-solid fa-clock mr-1"></i>'; // Lucide/Font Awesome icon for time
            // let iconMedicalRecord = hasMedicalRecords ? '<i class="fa-solid fa-file-medical mr-1"></i>' : ''; // Lucide/Font Awesome icon for medical records

            let arrayOfDomNodes = [];

            let titleEl = document.createElement('div');
            titleEl.innerHTML = arg.event.title;
            titleEl.classList.add('fc-event-title', 'font-semibold', 'text-sm'); // semibold, smaller text
            // titleEl.style.color = '#1f2937'; // Dark gray for readability

            let doctorEl = document.createElement('div');
            doctorEl.innerHTML = `${iconDoctor} ${doctorName}`;
            doctorEl.classList.add('fc-event-doctor', 'text-xs', 'text-gray-600'); // Muted secondary text
            // doctorEl.style.color = '#4b5563';

            let timeEl = document.createElement('div');
            timeEl.innerHTML = `${iconTime} ${startTime}`;
            timeEl.classList.add('fc-event-time', 'text-xs', 'text-gray-600'); // Muted secondary text
            // timeEl.style.color = '#4b5563';

            // let medicalRecordEl = document.createElement('div');
            // medicalRecordEl.innerHTML = `${iconMedicalRecord} ${hasMedicalRecords ? 'Records Attached' : ''}`;
            // medicalRecordEl.classList.add('fc-event-medical-records', 'text-xs', 'text-gray-200'); // Muted secondary text
            // medicalRecordEl.style.color = 'white';

            arrayOfDomNodes.push(titleEl);
            arrayOfDomNodes.push(doctorEl);
            arrayOfDomNodes.push(timeEl);
            // if (hasMedicalRecords) {
            //     arrayOfDomNodes.push(medicalRecordEl);
            // }
            return { domNodes: arrayOfDomNodes };
        },
        // Custom view for small screens (chronological list)
        views: {
            listWeek: {
                buttonText: 'list',
                // Set default options for listWeek view if needed
            }
        }
    });

    calendar.render();

    // Initial render of the appointment list (for larger screens, this will be hidden by CSS)
    // Initially display all appointments or filter by today's date if desired
    appointments = window.appointments || []; // Re-fetch appointments to ensure it's updated after Blade renders
    renderAppointmentList(appointments); // Render all appointments initially

    // Handle window resize to switch between calendar and list view
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            calendar.changeView('listWeek');
        } else {
            calendar.changeView('dayGridMonth');
        }
    });

    function filterAppointmentsByDate(dateStr) {
        const filtered = appointments.filter(app => {
            const appDate = new Date(app.start_time).toISOString().split('T')[0];
            return appDate === dateStr;
        });
        currentFilteredAppointments = filtered;
        renderAppointmentList(filtered);
    }

    function showAppointmentDetailsModal(event) {
        const modal = document.getElementById('appointment-details-modal');
        document.getElementById('modal-doctor-name').innerText = event.extendedProps.doctorName;
        document.getElementById('modal-reason').innerText = event.extendedProps.reason;
        document.getElementById('modal-date').innerText = new Date(event.extendedProps.start).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('modal-time').innerText = `${new Date(event.extendedProps.start).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })} - ${new Date(event.extendedProps.end).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })}`;

        const statusElement = document.getElementById('modal-status');
        statusElement.innerText = event.extendedProps.status;
        // Remove previous status classes and add new one
        statusElement.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full '; // Reset classes
        statusElement.classList.add(getStatusBadgeClass(event.extendedProps.status));

        document.getElementById('modal-medical-records').innerText = event.extendedProps.medicalRecords ? 'Yes' : 'No';

        modal.classList.remove('hidden');
    }

    // Close modal functionality
    document.getElementById('close-modal-button').addEventListener('click', function() {
        document.getElementById('appointment-details-modal').classList.add('hidden');
    });

    function renderAppointmentList(filteredAppointments) {
        const container = document.getElementById('appointments-list-container');
        const noAppointmentsMessage = document.getElementById('no-appointments-message');
        container.innerHTML = ''; // Clear existing content

        if (filteredAppointments.length === 0) {
            noAppointmentsMessage.classList.remove('hidden');
            noAppointmentsMessage.style.display = 'block';
        } else {
            noAppointmentsMessage.classList.add('hidden');
            noAppointmentsMessage.style.display = 'none';

            const gridDiv = document.createElement('div');
            gridDiv.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-4');

            filteredAppointments.forEach(appointment => {
                // Determine status classes and icons dynamically
                const statusClasses = {
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'approved': 'bg-green-100 text-green-800',
                    'cancelled': 'bg-red-100 text-red-800',
                    'declined': 'bg-red-100 text-red-800',
                    'rescheduled': 'bg-blue-100 text-blue-800',
                };
                const statusIcons = {
                    'pending': 'fas fa-clock',
                    'approved': 'fas fa-check-circle',
                    'cancelled': 'fas fa-times-circle',
                    'declined': 'fas fa-times-circle',
                    'rescheduled': 'fas fa-calendar-alt',
                };
                const currentStatusClass = statusClasses[appointment.status] || 'bg-gray-100 text-gray-800';
                const currentStatusIcon = statusIcons[appointment.status] || 'fas fa-info-circle';

                const doctorName = appointment.doctor ? appointment.doctor.name : 'N/A';
                const formattedStartTime = new Date(appointment.start_time).toLocaleString('en-US', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true });
                const formattedEndTime = new Date(appointment.end_time).toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

                const cardHtml = `
                    <div class="appointment-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 border border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-102">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center text-gray-800 dark:text-gray-200">
                                <i class="fas fa-user-md text-clinic-green-medium mr-3 text-lg"></i>
                                <span class="font-semibold text-md">${doctorName}</span>
                            </div>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${currentStatusClass} capitalize">
                                <i class="${currentStatusIcon} mr-1"></i> ${appointment.status}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                <span>${formattedStartTime} - ${formattedEndTime}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <i class="fas fa-notes-medical mr-3"></i>
                                <span>${appointment.reason}</span>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            ${(appointment.status === 'pending' || appointment.status === 'approved') ? `
                                <a href="/patient/appointments/${appointment.id}/edit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <i class="fas fa-edit mr-2"></i> Reschedule
                                </a>
                                <button onclick="event.preventDefault(); document.getElementById('cancel-appointment-${appointment.id}').submit();" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                    <i class="fas fa-times-circle mr-2"></i> Cancel
                                </button>
                                <form id="cancel-appointment-${appointment.id}" action="/patient/appointments/${appointment.id}/cancel" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                    <input type="hidden" name="_method" value="PATCH">
                                </form>
                            ` : ''}
                            <a href="/patient/appointments/${appointment.id}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                <i class="fas fa-eye mr-2"></i> View Details
                            </a>
                        </div>
                    </div>
                `;
                gridDiv.insertAdjacentHTML('beforeend', cardHtml);
            });
            container.appendChild(gridDiv);
        }
    }

    function getStatusBadgeClass(status) {
        switch (status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'approved':
                return 'bg-green-100 text-green-800';
            case 'cancelled':
            case 'declined':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
});
