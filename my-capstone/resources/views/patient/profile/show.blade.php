<x-patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Patient Profile') }}: {{ $patient->first_name }} {{ $patient->last_name }}
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

                    <!-- Personal Details -->
                    <div class="flex-1">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
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
                        <div><strong>Email:</strong> {{ $patient->user->email ?? 'N/A' }}</div>
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
        </div>
    </div>
</x-patient-layout>

