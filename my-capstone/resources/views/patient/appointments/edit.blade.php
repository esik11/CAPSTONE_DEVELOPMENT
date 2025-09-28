<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reschedule Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @else
                        @if ($appointment)
                            <form method="POST" action="{{ route('patient.appointments.update', $appointment->id) }}">
                                @csrf
                                @method('PATCH')

                                <!-- Doctor Selection (Read-only for existing appointments) -->
                                <div class="mb-4">
                                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Doctor</label>
                                    <input type="text" id="doctor_name" value="{{ $appointment->doctor->name ?? 'N/A' }}" disabled
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400">
                                    <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                                </div>

                                <!-- Start Time -->
                                <div class="mb-4">
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                                    <input type="text" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($appointment->start_time)->format('Y-m-d H:i')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                                </div>

                                <!-- End Time -->
                                <div class="mb-4">
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                                    <input type="text" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($appointment->end_time)->format('Y-m-d H:i')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                                </div>

                                <!-- Reason -->
                                <div class="mb-4">
                                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Appointment</label>
                                    <textarea id="reason" name="reason" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('reason', $appointment->reason) }}</textarea>
                                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                                </div>

                                <!-- Reschedule Reason (for audit trail) -->
                                <div class="mb-4">
                                    <label for="reschedule_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Rescheduling</label>
                                    <textarea id="reschedule_reason" name="reschedule_reason" rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                    <x-input-error :messages="$errors->get('reschedule_reason')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                        <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                                        {{ __('Back') }}
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-clinic-green-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-clinic-green-medium focus:bg-clinic-green-medium active:bg-clinic-green-dark focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <x-heroicon-o-arrow-path class="w-4 h-4 mr-2" />
                                        {{ __('Reschedule Appointment') }}
                                    </button>
                                </div>
                            </form>
                        @else
                            <p>Appointment not found or unauthorized to reschedule.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            flatpickr("#start_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                altInput: true,
                altFormat: "F j, Y h:i K",
                minDate: "today",
            });

            flatpickr("#end_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                altInput: true,
                altFormat: "F j, Y h:i K",
                minDate: "today",
            });
        </script>
    @endpush
</x-patient-layout>


