import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

// Initialize doctor appointments functionality
export function initDoctorAppointments() {
    // Only initialize if we're on the appointments page (calendar element exists)
    const calendarEl = document.getElementById('doctor-calendar');
    if (!calendarEl) {
        // Not on the appointments page, skip initialization
        return;
    }

    // Wait for data to be available
    if (!window.doctorAppointments) {
        console.warn('Doctor appointments data not yet available, retrying...');
        setTimeout(initDoctorAppointments, 100);
        return;
    }

    updateStats();
    initCalendar();
    initEventHandlers();
    initFiltering();
}

// Update statistics cards
function updateStats() {
    const appointments = window.doctorAppointments;
    const today = new Date().toDateString();
    
    const todayAppointments = appointments.filter(apt => 
        new Date(apt.start_time).toDateString() === today
    );
    
    document.getElementById('stat-total').textContent = todayAppointments.length;
    document.getElementById('stat-pending').textContent = appointments.filter(a => a.status === 'pending').length;
    document.getElementById('stat-approved').textContent = appointments.filter(a => a.status === 'approved').length;
    document.getElementById('stat-scheduled').textContent = appointments.filter(a => a.status === 'scheduled').length;
}

// Initialize FullCalendar
function initCalendar() {
    const calendarEl = document.getElementById('doctor-calendar');
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        height: 'auto',
        eventDisplay: 'block',
        displayEventTime: true,
        displayEventEnd: false,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: 'short'
        },
        events: window.doctorAppointments.map(appointment => {
            // Color code based on status
            const statusColors = {
                'pending': { bg: '#FEF3C7', border: '#F59E0B', text: '#92400E' },
                'approved': { bg: '#D1FAE5', border: '#10B981', text: '#065F46' },
                'declined': { bg: '#FEE2E2', border: '#EF4444', text: '#991B1B' },
                'scheduled': { bg: '#DBEAFE', border: '#3B82F6', text: '#1E40AF' }
            };
            
            const colors = statusColors[appointment.status] || { bg: '#F3F4F6', border: '#6B7280', text: '#1F2937' };
            
            return {
                title: `${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${appointment.patient.user.name}`,
                start: appointment.start_time,
                end: appointment.end_time,
                backgroundColor: colors.bg,
                borderColor: colors.border,
                textColor: colors.text,
                extendedProps: {
                    patientName: appointment.patient.user.name,
                    reason: appointment.reason,
                    status: appointment.status,
                    appointmentId: appointment.id,
                    patientId: appointment.patient.id
                }
            };
        }),
        eventClick: function(info) {
            const appointment = window.doctorAppointments.find(
                app => app.id == info.event.extendedProps.appointmentId
            );
            
            if (appointment) {
                // Trigger the view details modal
                const event = new MouseEvent('click', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                
                const button = document.querySelector(`[data-appointment-id="${appointment.id}"]`);
                if (button) {
                    button.dispatchEvent(event);
                }
            }
        },
        eventDidMount: function(info) {
            // Add tooltip on hover
            const tooltip = document.createElement('div');
            tooltip.className = 'calendar-tooltip';
            tooltip.innerHTML = `
                <div class="bg-gray-900 text-white text-xs rounded-lg p-3 shadow-xl max-w-xs">
                    <p class="font-bold mb-1">${info.event.extendedProps.patientName}</p>
                    <p class="text-gray-300 mb-1">${info.event.extendedProps.reason}</p>
                    <p class="text-gray-400">Status: <span class="capitalize">${info.event.extendedProps.status}</span></p>
                    <p class="text-gray-400 mt-1 text-xs">Click to view details</p>
                </div>
            `;
            
            info.el.addEventListener('mouseenter', function() {
                document.body.appendChild(tooltip);
                const rect = info.el.getBoundingClientRect();
                tooltip.style.position = 'fixed';
                tooltip.style.left = rect.left + 'px';
                tooltip.style.top = (rect.bottom + 5) + 'px';
                tooltip.style.zIndex = '9999';
            });
            
            info.el.addEventListener('mouseleave', function() {
                if (tooltip.parentNode) {
                    tooltip.parentNode.removeChild(tooltip);
                }
            });
            
            // Add cursor pointer
            info.el.style.cursor = 'pointer';
        },
        dayCellDidMount: function(info) {
            // Count appointments for this day
            const dayAppointments = window.doctorAppointments.filter(apt => {
                const aptDate = new Date(apt.start_time).toDateString();
                return aptDate === info.date.toDateString();
            });
            
            if (dayAppointments.length > 0) {
                const badge = document.createElement('div');
                badge.className = 'absolute top-1 right-1 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
                badge.textContent = dayAppointments.length;
                info.el.style.position = 'relative';
                info.el.appendChild(badge);
            }
        }
    });

    calendar.render();
}

// Initialize event handlers for view details buttons
function initEventHandlers() {
    document.querySelectorAll('.view-details-button').forEach(button => {
        button.addEventListener('click', handleViewDetails);
    });
}

// Handle view details button click
function handleViewDetails(event) {
    event.preventDefault();
    const appointmentId = this.dataset.appointmentId;
    const appointment = window.doctorAppointments.find(app => app.id == appointmentId);

    if (!appointment) return;

    // Populate modal with appointment data
    document.getElementById('modal-patient-name').textContent = appointment.patient.user.name;
    document.getElementById('modal-appointment-date').textContent = new Date(appointment.start_time).toLocaleDateString();
    document.getElementById('modal-appointment-time').textContent = `${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(appointment.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
    document.getElementById('modal-appointment-reason').textContent = appointment.reason;
    
    // Update status badge
    const statusBadge = document.getElementById('modal-appointment-status-badge');
    const statusClasses = {
        'pending': 'bg-yellow-100 text-yellow-700 border border-yellow-300',
        'approved': 'bg-green-100 text-green-700 border border-green-300',
        'declined': 'bg-red-100 text-red-700 border border-red-300',
        'scheduled': 'bg-blue-100 text-blue-700 border border-blue-300',
    };
    statusBadge.className = 'inline-block px-3 py-1 text-xs font-bold rounded-lg ' + (statusClasses[appointment.status] || 'bg-gray-100 text-gray-700');
    statusBadge.textContent = appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1);
    
    // Show loading state
    document.getElementById('modal-medical-history').innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div></div>';
    document.getElementById('modal-uploaded-reports').innerHTML = '<p class="text-sm text-gray-600 dark:text-gray-400">Loading reports...</p>';
    
    // Fetch patient details
    fetchPatientDetails(appointment.patient_id);
    fetchMedicalHistory(appointment.patient_id);
    
    // Show modal
    document.getElementById('appointment-details-modal').classList.remove('hidden');
}

// Fetch patient details via AJAX
function fetchPatientDetails(patientId) {
    fetch(`/doctor/patients/${patientId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modal-patient-contact').textContent = data.contact_number;
            document.getElementById('modal-patient-dob').textContent = new Date(data.date_of_birth).toLocaleDateString();
        })
        .catch(error => {
            console.error('Error fetching patient details:', error);
            document.getElementById('modal-patient-contact').textContent = 'N/A';
            document.getElementById('modal-patient-dob').textContent = 'N/A';
        });
}

// Fetch medical history via AJAX
function fetchMedicalHistory(patientId) {
    fetch(`/doctor/patients/${patientId}/medical-records`)
        .then(response => response.json())
        .then(data => {
            const medicalHistoryDiv = document.getElementById('modal-medical-history');
            if (data.length > 0) {
                medicalHistoryDiv.innerHTML = data.map(record => `
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">${record.medical_condition.name}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${record.notes || 'No additional notes'}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">${new Date(record.date).toLocaleDateString()}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                medicalHistoryDiv.innerHTML = '<p class="text-sm text-gray-600 dark:text-gray-400 text-center py-4">No medical history available.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching medical history:', error);
            document.getElementById('modal-medical-history').innerHTML = '<p class="text-sm text-red-600 dark:text-red-400 text-center py-4">Error loading medical history.</p>';
        });
}

// Initialize filtering functionality
function initFiltering() {
    const searchPatientName = document.getElementById('search-patient-name');
    const filterDate = document.getElementById('filter-date');
    const filterStatus = document.getElementById('filter-status');
    const appointmentsListContainer = document.getElementById('doctor-appointments-list');

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

        renderAppointments(filtered, appointmentsListContainer);
    }

    searchPatientName.addEventListener('input', filterAppointments);
    filterDate.addEventListener('change', filterAppointments);
    filterStatus.addEventListener('change', filterAppointments);

    // Initial render
    renderAppointments(window.doctorAppointments, appointmentsListContainer);
}

// Render appointments list
function renderAppointments(appointmentsToRender, container) {
    if (appointmentsToRender.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No appointments found</p>
            </div>
        `;
        return;
    }

    container.innerHTML = appointmentsToRender.map(appointment => {
        const statusClass = {
            'pending': 'bg-yellow-100 text-yellow-700 border border-yellow-300',
            'approved': 'bg-green-100 text-green-700 border border-green-300',
            'declined': 'bg-red-100 text-red-700 border border-red-300',
            'scheduled': 'bg-blue-100 text-blue-700 border border-blue-300',
        }[appointment.status] || 'bg-gray-100 text-gray-700 border border-gray-300';
        
        const initial = appointment.patient.user.name.charAt(0).toUpperCase();

        return `
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 p-4 rounded-xl border border-gray-200 dark:border-gray-600 flex flex-col space-y-3 transition-all duration-300 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-500 hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                            ${initial}
                        </div>
                        <div>
                            <p class="text-base font-bold text-gray-900 dark:text-gray-100">${appointment.patient.user.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Patient ID: #${appointment.patient.id}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-lg ${statusClass}">
                        ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>${new Date(appointment.start_time).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>${new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">Reason:</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">${appointment.reason}</p>
                </div>
                
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                    <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Approve</span>
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Decline</span>
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Reschedule</span>
                    </button>
                    <a href="#" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition shadow-sm view-details-button" data-appointment-id="${appointment.id}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>View Medical Record</span>
                    </a>
                </div>
            </div>
        `;
    }).join('');

    // Re-attach event listeners for newly rendered buttons
    container.querySelectorAll('.view-details-button').forEach(button => {
        button.addEventListener('click', handleViewDetails);
    });
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDoctorAppointments);
} else {
    initDoctorAppointments();
}
