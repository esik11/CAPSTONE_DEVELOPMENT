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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Upcoming Appointments</h3>

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

                    @if ($appointments->isEmpty())
                        <p>No appointments found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Doctor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment['doctor']['name'] ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($appointment['start_time'])->format('F j, Y h:i A') }}
                                                - {{ \Carbon\Carbon::parse($appointment['end_time'])->format('h:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $appointment['reason'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">
                                                @if ($appointment['status'] === 'pending')
                                                    <span class="text-blue-500 dark:text-blue-400">{{ $appointment['status'] }}</span>
                                                @elseif ($appointment['status'] === 'approved')
                                                    <span class="text-green-500 dark:text-green-400">{{ $appointment['status'] }}</span>
                                                @elseif ($appointment['status'] === 'cancelled' || $appointment['status'] === 'declined')
                                                    <span class="text-red-500 dark:text-red-400">{{ $appointment['status'] }}</span>
                                                @else
                                                    <span class="text-yellow-500 dark:text-yellow-400">{{ $appointment['status'] }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('patient.appointments.show', $appointment['id']) }}" class="text-clinic-green-medium hover:text-clinic-green-dark mr-3"><x-heroicon-o-eye class="w-5 h-5 inline" /> View</a>
                                                @if ($appointment['status'] === 'pending' || $appointment['status'] === 'approved')
                                                    <a href="{{ route('patient.appointments.edit', $appointment['id']) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><x-heroicon-o-pencil-square class="w-5 h-5 inline" /> Reschedule</a>
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('cancel-appointment-{{ $appointment['id'] }}').submit();" class="text-red-600 hover:text-red-900"><x-heroicon-o-x-circle class="w-5 h-5 inline" /> Cancel</a>
                                                    <form id="cancel-appointment-{{ $appointment['id'] }}" action="{{ route('patient.appointments.cancel', $appointment['id']) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-patient-layout>
