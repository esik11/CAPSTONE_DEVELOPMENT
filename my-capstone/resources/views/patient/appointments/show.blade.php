<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Appointment Details') }}
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
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Appointment #{{ $appointment->id }}</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Doctor:</p>
                                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $appointment->doctor->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Patient:</p>
                                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $appointment->patient->user->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Start Time:</p>
                                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($appointment->start_time)->format('F j, Y h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">End Time:</p>
                                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($appointment->end_time)->format('F j, Y h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Reason:</p>
                                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $appointment->reason }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Status:</p>
                                        <p class="mt-1 text-lg capitalize @if ($appointment->status === 'pending') text-blue-500 @elseif ($appointment->status === 'approved') text-green-500 @elseif ($appointment->status === 'cancelled' || $appointment->status === 'declined') text-red-500 @else text-yellow-500 @endif">{{ $appointment->status }}</p>
                                    </div>
                                    @if ($appointment->notes)
                                        <div class="col-span-full">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Doctor's Notes:</p>
                                            <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $appointment->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-3 mt-6">
                                <a href="{{ route('patient.appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                                    {{ __('Back to Appointments') }}
                                </a>

                                @if ($appointment->status === 'pending' || $appointment->status === 'approved')
                                    <a href="{{ route('patient.appointments.edit', $appointment->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                                        {{ __('Reschedule') }}
                                    </a>
                                    <button type="button" onclick="event.preventDefault(); document.getElementById('cancel-appointment-form').submit();" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <x-heroicon-o-x-circle class="w-4 h-4 mr-2" />
                                        {{ __('Cancel Appointment') }}
                                    </button>
                                    <form id="cancel-appointment-form" action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                            </div>

                            <!-- Reschedule History -->
                            @if (!empty($appointment->reschedules) && count($appointment->reschedules) > 0)
                                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Reschedule History</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Old Time</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">New Time</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rescheduled By</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                @foreach ($appointment->reschedules as $reschedule)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($reschedule->old_start_time)->format('F j, Y h:i A') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($reschedule->new_start_time)->format('F j, Y h:i A') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $reschedule->reason ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $reschedule->rescheduled_by->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($reschedule->created_at)->format('F j, Y h:i A') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @else
                            <p>Appointment not found.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-patient-layout>


