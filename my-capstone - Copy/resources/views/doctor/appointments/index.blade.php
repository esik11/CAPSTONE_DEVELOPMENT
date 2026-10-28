<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                    {{ __('My Appointments') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Manage your schedule and patient appointments</p>
            </div>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Today</p>
                            <p class="text-3xl font-bold mt-1" id="stat-total">0</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <x-heroicon-o-calendar class="w-8 h-8" />
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold mt-1" id="stat-pending">0</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <x-heroicon-o-clock class="w-8 h-8" />
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Approved</p>
                            <p class="text-3xl font-bold mt-1" id="stat-approved">0</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <x-heroicon-o-check-circle class="w-8 h-8" />
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Scheduled</p>
                            <p class="text-3xl font-bold mt-1" id="stat-scheduled">0</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <x-heroicon-o-calendar-days class="w-8 h-8" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left Section: Calendar -->
                <div class="lg:w-3/5 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <x-heroicon-o-calendar class="w-6 h-6 text-blue-600" />
                            My Schedule
                        </h3>
                    </div>
                    <div id="doctor-calendar" class="mb-4"></div>
                </div>

                <!-- Right Section: Interactive Appointment Panel -->
                <div class="lg:w-2/5 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <x-heroicon-o-user-group class="w-6 h-6 text-indigo-600" />
                            Patient Appointments
                        </h3>
                    </div>

                    <!-- Search and Filter Bar -->
                    <div class="mb-5 space-y-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="text" id="search-patient-name" placeholder="Search by patient name..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-lg shadow-sm transition">
                        </div>
                        <div class="flex gap-3">
                            <input type="date" id="filter-date" class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-lg shadow-sm transition px-3 py-2">
                            <select id="filter-status" class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-lg shadow-sm transition px-3 py-2">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
                                <option value="scheduled">Scheduled</option>
                            </select>
                        </div>
                    </div>

                    <div id="doctor-appointments-list" class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @if ($appointments->isEmpty())
                            <div class="text-center py-12">
                                <x-heroicon-o-calendar-days class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-3" />
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No appointments found</p>
                            </div>
                        @else
                            @foreach ($appointments as $appointment)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-750 p-4 rounded-xl border border-gray-200 dark:border-gray-600 flex flex-col space-y-3 transition-all duration-300 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-500 hover:-translate-y-1">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($appointment->patient->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $appointment->patient->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Patient ID: #{{ $appointment->patient->id }}</p>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-lg {{ [
                                            'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                                            'approved' => 'bg-green-100 text-green-700 border border-green-300',
                                            'declined' => 'bg-red-100 text-red-700 border border-red-300',
                                            'scheduled' => 'bg-blue-100 text-blue-700 border border-blue-300',
                                        ][$appointment->status] ?? 'bg-gray-100 text-gray-700 border border-gray-300' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                            <x-heroicon-o-calendar class="w-4 h-4 text-indigo-500" />
                                            <span>{{ $appointment->start_time->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                            <x-heroicon-o-clock class="w-4 h-4 text-indigo-500" />
                                            <span>{{ $appointment->start_time->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-2.5 border border-gray-200 dark:border-gray-600">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">Reason:</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $appointment->reason }}</p>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition shadow-sm">
                                            <x-heroicon-o-check class="w-4 h-4" />
                                            <span>Approve</span>
                                        </button>
                                        <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition shadow-sm">
                                            <x-heroicon-o-x-mark class="w-4 h-4" />
                                            <span>Decline</span>
                                        </button>
                                        <button class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition shadow-sm">
                                            <x-heroicon-o-pencil class="w-4 h-4" />
                                            <span>Reschedule</span>
                                        </button>
                                        <a href="#" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-transparent rounded-lg font-semibold text-xs text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition shadow-sm view-details-button" data-appointment-id="{{ $appointment->id }}">
                                            <x-heroicon-o-document-text class="w-4 h-4" />
                                            <span>View Medical Record</span>
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

    <!-- Appointment Details Modal -->
    <div id="appointment-details-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="relative mx-auto w-full max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 transform transition-all" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <x-heroicon-o-document-text class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Patient Details</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Complete medical information</p>
                    </div>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg p-2 transition" onclick="document.getElementById('appointment-details-modal').classList.add('hidden')">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <!-- Patient Information Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-750 rounded-xl p-5 border border-blue-200 dark:border-gray-600">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-user class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">Patient Information</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Full Name</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-patient-name">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Contact Number</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-patient-contact">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Date of Birth</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-patient-dob">-</p>
                        </div>
                    </div>
                </div>

                <!-- Appointment Details Card -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-750 rounded-xl p-5 border border-purple-200 dark:border-gray-600">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">Appointment Details</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Date</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-appointment-date">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Time</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-appointment-time">-</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Reason for Visit</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="modal-appointment-reason">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-1">Status</p>
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg" id="modal-appointment-status-badge">-</span>
                        </div>
                    </div>
                </div>

                <!-- Medical History Card -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-750 rounded-xl p-5 border border-green-200 dark:border-gray-600">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5 text-green-600 dark:text-green-400" />
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">Medical History</h4>
                    </div>
                    <div id="modal-medical-history" class="space-y-3">
                        <div class="flex items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Reports Card -->
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 dark:from-gray-700 dark:to-gray-750 rounded-xl p-5 border border-orange-200 dark:border-gray-600">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-document-arrow-up class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">Uploaded Reports</h4>
                    </div>
                    <div id="modal-uploaded-reports" class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">No reports uploaded yet.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-2xl">
                <button class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition shadow-sm" onclick="document.getElementById('appointment-details-modal').classList.add('hidden')">
                    Close
                </button>
                <button class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                    <span class="flex items-center gap-2">
                        <x-heroicon-o-printer class="w-4 h-4" />
                        Print Record
                    </span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Pass appointments data to JavaScript before modules load
        window.doctorAppointments = @json($appointments);
    </script>


</x-doctor-layout>
