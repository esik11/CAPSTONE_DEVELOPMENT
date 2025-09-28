<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Details') }}: {{ $patient->first_name }} {{ $patient->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8 mb-6">
                    <!-- Patient Photo -->
                    <div class="flex-shrink-0">
                        @if ($patient->photo)
                            <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-48 h-48 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-48 h-48 bg-gray-200 rounded-lg shadow-md flex items-center justify-center text-gray-500 text-lg font-semibold">
                                No Photo
                            </div>
                        @endif
                    </div>

                    <!-- Personal Details and Edit Button -->
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                            <a href="{{ route('patients.edit', $patient) }}" class="bg-clinic-green-dark hover:bg-clinic-green-light text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14.25v4.5a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Edit Patient
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                            <div><strong>Patient ID:</strong> {{ $patient->id }}</div>
                            <div><strong>Nickname:</strong> {{ $patient->nickname ?? 'N/A' }}</div>
                            <div><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</div>
                            <div><strong>Gender:</strong> {{ $patient->gender }}</div>
                            <div><strong>Marital Status:</strong> {{ $patient->marital_status ?? 'N/A' }}</div>
                            <div><strong>Language:</strong> {{ $patient->language ?? 'N/A' }}</div>
                            <div><strong>Race:</strong> {{ $patient->race ?? 'N/A' }}</div>
                            <div><strong>SSN:</strong> {{ $patient->social_security_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Section: Home Address -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Home Address</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Region:</strong> {{ $patient->region ?? 'N/A' }}</div>
                        <div><strong>Province:</strong> {{ $patient->province ?? 'N/A' }}</div>
                        <div><strong>City:</strong> {{ $patient->city ?? 'N/A' }}</div>
                        <div><strong>Barangay:</strong> {{ $patient->barangay ?? 'N/A' }}</div>
                        <div><strong>Zip Code:</strong> {{ $patient->zip_code ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Section: Contact Information -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Phone Number:</strong> {{ $patient->phone_number }}</div>
                        <div><strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Section: Employment Status -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Employment Details</h3>
                    <div><strong>Employment Status:</strong> {{ $patient->employment_status ?? 'N/A' }}</div>
                </div>
            </div>

            <!-- Section: Emergency/Next of Kin Contact Information -->
            @if($patient->emergency_last_name || $patient->emergency_first_name || $patient->emergency_relationship || $patient->emergency_address || $patient->emergency_apt_num || $patient->emergency_city || $patient->emergency_state || $patient->emergency_zip_code || $patient->emergency_home_phone || $patient->emergency_work_phone || $patient->emergency_other_phone)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">EMERGENCY/NEXT OF KIN CONTACT INFORMATION</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div><strong>Name:</strong> {{ $patient->emergency_first_name ?? 'N/A' }} {{ $patient->emergency_last_name ?? 'N/A' }}</div>
                    <div><strong>Relationship:</strong> {{ $patient->emergency_relationship ?? 'N/A' }}</div>
                    <div class="col-span-2"><strong>Address:</strong> {{ $patient->emergency_address ?? 'N/A' }} {{ $patient->emergency_apt_num ? ', Apt #' . $patient->emergency_apt_num : '' }}, {{ $patient->emergency_city ?? 'N/A' }}, {{ $patient->emergency_state ?? 'N/A' }} {{ $patient->emergency_zip_code ?? 'N/A' }}</div>
                    <div><strong>Home Phone:</strong> {{ $patient->emergency_home_phone ?? 'N/A' }}</div>
                    <div><strong>Work Phone:</strong> {{ $patient->emergency_work_phone ?? 'N/A' }}</div>
                    <div><strong>Other Phone:</strong> {{ $patient->emergency_other_phone ?? 'N/A' }}
                        @if($patient->emergency_other_phone_cell) <span class="text-xs text-gray-500">(Cell)</span> @endif
                        @if($patient->emergency_other_phone_pager) <span class="text-xs text-gray-500">(Pager)</span> @endif
                        @if($patient->emergency_other_phone_fax) <span class="text-xs text-gray-500">(Fax)</span> @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Section: Other Contact Information (Not Living with Patient) -->
            @if($patient->other_last_name || $patient->other_first_name || $patient->other_relationship || $patient->other_address || $patient->other_apt_num || $patient->other_city || $patient->other_state || $patient->other_zip_code || $patient->other_home_phone || $patient->other_work_phone || $patient->other_other_phone)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">OTHER CONTACT INFORMATION (NOT LIVING WITH PATIENT)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div><strong>Name:</strong> {{ $patient->other_first_name ?? 'N/A' }} {{ $patient->other_last_name ?? 'N/A' }}</div>
                    <div><strong>Relationship:</strong> {{ $patient->other_relationship ?? 'N/A' }}</div>
                    <div class="col-span-2"><strong>Address:</strong> {{ $patient->other_address ?? 'N/A' }} {{ $patient->other_apt_num ? ', Apt #' . $patient->other_apt_num : '' }}, {{ $patient->other_city ?? 'N/A' }}, {{ $patient->other_state ?? 'N/A' }} {{ $patient->other_zip_code ?? 'N/A' }}</div>
                    <div><strong>Home Phone:</strong> {{ $patient->other_home_phone ?? 'N/A' }}</div>
                    <div><strong>Work Phone:</strong> {{ $patient->other_work_phone ?? 'N/A' }}</div>
                    <div><strong>Other Phone:</strong> {{ $patient->other_other_phone ?? 'N/A' }}
                        @if($patient->other_other_phone_cell) <span class="text-xs text-gray-500">(Cell)</span> @endif
                        @if($patient->other_other_phone_pager) <span class="text-xs text-gray-500">(Pager)</span> @endif
                        @if($patient->other_other_phone_fax) <span class="text-xs text-gray-500">(Fax)</span> @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Medical Records</h3>
                    <a href="{{ route('patients.medicalRecords.create', $patient) }}" class="bg-clinic-blue-dark hover:bg-clinic-blue-medium text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Add New Medical Record
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-clinic-green-light border border-clinic-green-dark text-clinic-green-dark px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    @if ($patient->medicalRecords->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-clinic-yellow-light">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Visit Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($patient->medicalRecords as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $record->visit_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $record->doctor->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($record->diagnosis, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-2">View Details</a>
                                            <a href="#" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                            <form action="#" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this medical record?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No medical records found for this patient.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>
