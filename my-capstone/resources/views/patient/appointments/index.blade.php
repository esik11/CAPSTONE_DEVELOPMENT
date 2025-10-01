<x-patient-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Appointments') }}
            </h2>
            <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-clinic-green-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-clinic-green-medium focus:bg-clinic-green-medium active:bg-clinic-green-dark focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Request New Appointment') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div id="calendar-container" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 font-inter relative">
                <div id="calendar" class="mb-6"></div>
                {{-- The request new appointment button is moved to the header --}}
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 font-inter">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Appointment List</h3>

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

                <div id="appointments-list-container" class="space-y-4">
                    <p id="no-appointments-message" class="text-gray-600 dark:text-gray-400 hidden">No appointments found for the selected date.</p>
                    {{-- Appointment cards will be rendered here by JavaScript --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.appointments = @json($appointments);
    </script>

    <!-- Appointment Details Modal -->
    <div id="appointment-details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Appointment Details</h3>
                <div class="mt-2 px-7 py-3 text-left">
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Doctor:</span> <span id="modal-doctor-name"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Reason:</span> <span id="modal-reason"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Date:</span> <span id="modal-date"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Time:</span> <span id="modal-time"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Status:</span> <span id="modal-status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-2"><span class="font-semibold">Medical Records:</span> <span id="modal-medical-records"></span></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="close-modal-button" class="px-4 py-2 bg-clinic-green-dark text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-clinic-green-medium focus:outline-none focus:ring-2 focus:ring-clinic-green-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-patient-layout>
