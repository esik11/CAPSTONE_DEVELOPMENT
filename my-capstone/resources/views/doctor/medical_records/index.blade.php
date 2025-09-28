<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Records for') }}: {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Patient Header -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                        <div class="flex flex-wrap text-gray-600 text-sm">
                            <span class="mr-4"><strong>Patient ID:</strong> {{ $patient->id }}</span>
                            <span class="mr-4"><strong>Age:</strong> {{ $patient->age }}</span>
                            <span class="mr-4"><strong>Gender:</strong> {{ $patient->gender }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Medical Records</h3>
                        <a href="{{ route('patients.medicalRecords.create', $patient) }}" class="bg-clinic-blue-dark hover:bg-clinic-blue-medium text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Add New Record
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-clinic-green-light border border-clinic-green-dark text-clinic-green-dark px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-clinic-yellow-light">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Chief Complaint</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Diagnosis/Impression</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Doctor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($medicalRecords as $medicalRecord)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($medicalRecord->visit_date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($medicalRecord->chief_complaint, 50) ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $medicalRecord->diagnosis ?? '-' }}</td> <!-- Assuming a 'diagnosis' attribute will be added to MedicalRecord -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $medicalRecord->doctor->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" x-data="{ open: false }">
                                            <div class="relative inline-block text-left">
                                                <div>
                                                    <button type="button" @click="open = !open" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="options-menu-{{ $medicalRecord->id }}" aria-haspopup="true" :aria-expanded="open" aria-expanded="true">
                                                        Actions
                                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $medicalRecord->id }}">
                                                    <div class="py-1" role="none">
                                                        <a href="{{ route('patients.medicalRecords.show', [$patient, $medicalRecord]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">View Details</a>
                                                        <a href="{{ route('patients.medicalRecords.edit', [$patient, $medicalRecord]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Edit Record</a>
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Print Record</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No medical records found for this patient.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $medicalRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout> 