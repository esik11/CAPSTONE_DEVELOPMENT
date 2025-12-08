<x-patient-layout>
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
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">View and manage your appointments</p>
            </div>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Book Appointment
        </a>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-lg overflow-hidden" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Appointment Booked Successfully!</h3>
                                    <p class="text-sm text-gray-600 mb-4">Your appointment request has been submitted and is pending doctor approval.</p>
                                    
                                    @if(session('bookingDetails'))
                                        <div class="bg-white rounded-lg p-4 border border-green-200">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Appointment Details</h4>
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs">Doctor</p>
                                                    <p class="font-semibold text-gray-900">Dr. {{ session('bookingDetails')['doctorName'] }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Date</p>
                                                    <p class="font-semibold text-gray-900">{{ session('bookingDetails')['date'] }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Time</p>
                                                    <p class="font-semibold text-gray-900">{{ session('bookingDetails')['time'] }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Mode</p>
                                                    <p class="font-semibold text-gray-900">{{ session('bookingDetails')['mode'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex items-start gap-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div class="text-xs text-blue-800">
                                                <p class="font-semibold mb-1">What's Next?</p>
                                                <ul class="space-y-1">
                                                    <li>• You'll receive a notification once the doctor approves</li>
                                                    <li>• Check your email for confirmation details</li>
                                                    <li>• Arrive 10 minutes early for in-clinic visits</li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Calendar and Appointments Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calendar and Info (Left - 2 columns) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Calendar -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div id="patient-calendar"></div>
                    </div>

                    @if($appointments->where('status', 'pending')->count() > 0)
                    <!-- Pending Appointments Info -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-sm border border-amber-200 dark:border-gray-600 p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Appointment Pending Approval</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Your appointment request is being reviewed by the doctor. You'll be notified once it's confirmed.</p>
                                
                                <!-- Status Timeline -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">Approval Progress</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-500">Typically within 24 hours</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 flex items-center gap-2">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 h-1 bg-amber-300 rounded"></div>
                                        </div>
                                        <div class="flex-1 flex items-center gap-2">
                                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center animate-pulse">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-600 rounded"></div>
                                        </div>
                                        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-2 text-xs">
                                        <span class="text-green-600 dark:text-green-400 font-semibold">Submitted</span>
                                        <span class="text-amber-600 dark:text-amber-400 font-semibold">Under Review</span>
                                        <span class="text-gray-400">Confirmed</span>
                                    </div>
                                </div>

                                <!-- Preparation Checklist -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 mb-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Prepare for Your Appointment
                                    </h4>
                                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>List your current medications and dosages</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Note down your symptoms and when they started</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Prepare questions you want to ask the doctor</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Bring any relevant medical records or test results</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Quick Actions -->
                                <div class="flex flex-wrap gap-3">
                                    <button onclick="window.location.reload()" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Refresh Status
                                    </button>
                                    <a href="mailto:support@clinic.com" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Contact Support
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($appointments->where('status', 'confirmed')->count() > 0)
                    <!-- Upcoming Confirmed Appointments -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-sm border border-green-200 dark:border-gray-600 p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Appointment Confirmed!</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Your appointment has been confirmed. Here's what you need to know:</p>
                                
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Arrive Early</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Please arrive 10-15 minutes before your scheduled time</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Bring ID & Insurance</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Valid ID and insurance card (if applicable)</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Notification Sent</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Check your email for appointment details and reminders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Appointments List (Right - 1 column) -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">My Appointments</h3>
                    
                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button onclick="filterAppointments('upcoming')" class="filter-btn active px-3 py-1.5 rounded-lg font-medium text-xs transition-colors">
                            Upcoming
                        </button>
                        <button onclick="filterAppointments('pending')" class="filter-btn px-3 py-1.5 rounded-lg font-medium text-xs transition-colors">
                            Pending
                        </button>
                        <button onclick="filterAppointments('all')" class="filter-btn px-3 py-1.5 rounded-lg font-medium text-xs transition-colors">
                            All
                        </button>
                    </div>

                    <!-- Appointments List -->
                    <div class="space-y-3 max-h-[600px] overflow-y-auto" id="appointments-container">
                @forelse($appointments as $appointment)
                    <div class="appointment-card bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors cursor-pointer" 
                         data-status="{{ $appointment->status }}"
                         data-date="{{ $appointment->start_time->format('Y-m-d') }}"
                         onclick="window.location='{{ route('patient.appointments.show', $appointment) }}'">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                    Dr. {{ $appointment->doctor->name }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $appointment->start_time->format('M d, g:i A') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 truncate">
                                    {{ $appointment->reason }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full flex-shrink-0 {{ 
                                $appointment->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                                ($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                ($appointment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 
                                ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : 
                                'bg-gray-100 text-gray-700'))) 
                            }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No appointments yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Book your first appointment to get started</p>
                        <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Book Appointment
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .filter-btn {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        .filter-btn:hover {
            background-color: #e5e7eb;
        }
        .filter-btn.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>

    <script>
        function filterAppointments(filter) {
            const cards = document.querySelectorAll('.appointment-card');
            const buttons = document.querySelectorAll('.filter-btn');
            const today = new Date().toISOString().split('T')[0];

            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            cards.forEach(card => {
                const status = card.dataset.status;
                const date = card.dataset.date;
                let show = false;

                switch(filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'upcoming':
                        show = date >= today && (status === 'pending' || status === 'confirmed');
                        break;
                    case 'pending':
                        show = status === 'pending';
                        break;
                    case 'confirmed':
                        show = status === 'confirmed';
                        break;
                    case 'completed':
                        show = status === 'completed';
                        break;
                    case 'cancelled':
                        show = status === 'cancelled';
                        break;
                }

                card.style.display = show ? 'block' : 'none';
            });
        }
    </script>
</x-patient-layout>
