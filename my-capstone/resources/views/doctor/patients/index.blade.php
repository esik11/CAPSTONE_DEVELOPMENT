<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('patients.create') }}" class="bg-clinic-blue-dark hover:bg-clinic-blue-medium text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Add New Patient
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Photo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Age</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Gender</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($patients as $patient)
                                    <tr class="cursor-pointer hover:bg-gray-50" @click="$dispatch('show-patient-details', { patientId: {{ $patient->id }} })">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($patient->photo)
                                                <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-10 h-10 object-cover rounded-full">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-xs">N/A</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $patient->first_name }} {{ $patient->middle_name ? $patient->middle_name . ' ' : '' }}{{ $patient->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $patient->gender }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium relative" @click.stop>
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                        <div>Actions</div>
                                                        <div class="ms-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link href="#" @click.prevent="$dispatch('show-patient-details', { patientId: {{ $patient->id }} })" class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ __('View Profile') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link href="{{ route('patients.edit', $patient) }}" class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.4-8.4z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 12.75V12A2.25 2.25 0 0016.5 9.75H9.75A2.25 2.25 0 007.5 12v7.5A2.25 2.25 0 009.75 21h7.5A2.25 2.25 0 0019.5 18.75V15.75m-1.5-3H15.75m-12 3H12" />
                                                        </svg>
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link href="{{ route('patients.medicalRecords.index', $patient) }}" class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H12V10.5M21 4.5H10.5a2.25 2.25 0 00-2.25 2.25v2.25m-2.25 0v2.25m-2.25 0H3.75a2.25 2.25 0 00-2.25 2.25v2.25m19.5-9V7.5A2.25 2.25 0 0019.5 9h-2.25M8.25 6.75h9.75m0 0v-1.5m0 1.5l3-3m-3 3l-3-3M3.75 14.25h6.75m-6.75 0v-1.5m0 1.5l-3-3m3 3l3-3m-3 3V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25v-2.25" />
                                                        </svg>
                                                        {{ __('View Medical Records') }}
                                                    </x-dropdown-link>
                                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="flex items-center">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-dropdown-link :href="route('patients.destroy', $patient)"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();" class="flex items-center text-red-600 hover:text-red-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m-1.022.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m-1.022.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397M21 6.75V10.5M6 6H4.5M6 6h15M6 6v-.75A2.25 2.25 0 018.25 3h7.5A2.25 2.25 0 0118 5.25v.75M3 6h18" />
                                                            </svg>
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No patients found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>

<x-modal name="view-patient-details-modal" :show="false" focusable maxWidth="4xl" x-cloak>
    <div class="p-6" x-data="{
        patientDetails: {},
        loading: false,
        openModal(patientId) {
            this.loading = true;
            fetch(`/patients/${patientId}/details`)
                .then(response => response.json())
                .then(data => {
                    this.patientDetails = data;
                    this.loading = false;
                    this.$dispatch('open-modal', 'view-patient-details-modal');
                })
                .catch(error => {
                    console.error('Error fetching patient details:', error);
                    this.loading = false;
                });
        }
    }" x-on:show-patient-details.window="openModal($event.detail.patientId)">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Patient Details
        </h2>

        <div x-show="loading" class="text-center">
            Loading patient details...
        </div>

        <div x-show="!loading && Object.keys(patientDetails).length > 0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8 mb-6">
                    <!-- Patient Photo -->
                    <div class="flex-shrink-0">
                        <template x-if="patientDetails.photo">
                            <img :src="'/storage/' + patientDetails.photo" alt="Patient Photo" class="w-48 h-48 object-cover rounded-lg shadow-md">
                        </template>
                        <template x-if="!patientDetails.photo">
                            <div class="w-48 h-48 bg-gray-200 rounded-lg shadow-md flex items-center justify-center text-gray-500 text-lg font-semibold">
                                No Photo
                            </div>
                        </template>
                    </div>

                    <!-- Personal Details -->
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900" x-text="`${patientDetails.first_name} ${patientDetails.last_name}`"></h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mt-4">
                            <div><strong>Patient ID:</strong> <span x-text="patientDetails.id"></span></div>
                            <div><strong>Nickname:</strong> <span x-text="patientDetails.nickname || 'N/A'"></span></div>
                            <div><strong>Date of Birth:</strong> <span x-text="patientDetails.date_of_birth"></span></div>
                            <div><strong>Gender:</strong> <span x-text="patientDetails.gender"></span></div>
                            <div><strong>Marital Status:</strong> <span x-text="patientDetails.marital_status || 'N/A'"></span></div>
                            <div><strong>Language:</strong> <span x-text="patientDetails.language || 'N/A'"></span></div>
                            <div><strong>Race:</strong> <span x-text="patientDetails.race || 'N/A'"></span></div>
                            <div><strong>SSN:</strong> <span x-text="patientDetails.social_security_number || 'N/A'"></span></div>
                        </div>
                    </div>
                </div>

                <!-- Section: Home Address -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Home Address</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Region:</strong> <span x-text="patientDetails.region || 'N/A'"></span></div>
                        <div><strong>Province:</strong> <span x-text="patientDetails.province || 'N/A'"></span></div>
                        <div><strong>City:</strong> <span x-text="patientDetails.city || 'N/A'"></span></div>
                        <div><strong>Barangay:</strong> <span x-text="patientDetails.barangay || 'N/A'"></span></div>
                        <div><strong>Zip Code:</strong> <span x-text="patientDetails.zip_code || 'N/A'"></span></div>
                    </div>
                </div>

                <!-- Section: Contact Information -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Phone Number:</strong> <span x-text="patientDetails.phone_number"></span></div>
                        <div><strong>Email:</strong> <span x-text="patientDetails.email || 'N/A'"></span></div>
                    </div>
                </div>

                <!-- Section: Employment Details -->
                <div class="mb-6 p-4 border rounded-lg bg-clinic-earth-light">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Employment Details</h3>
                    <div><strong>Employment Status:</strong> <span x-text="patientDetails.employment_status || 'N/A'"></span></div>
                </div>
            </div>

            <!-- Section: Emergency/Next of Kin Contact Information -->
            <template x-if="patientDetails.emergency_last_name || patientDetails.emergency_first_name || patientDetails.emergency_relationship || patientDetails.emergency_address || patientDetails.emergency_apt_num || patientDetails.emergency_city || patientDetails.emergency_state || patientDetails.emergency_zip_code || patientDetails.emergency_home_phone || patientDetails.emergency_work_phone || patientDetails.emergency_other_phone">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">EMERGENCY/NEXT OF KIN CONTACT INFORMATION</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Name:</strong> <span x-text="`${patientDetails.emergency_first_name || 'N/A'} ${patientDetails.emergency_last_name || 'N/A'}`"></span></div>
                        <div><strong>Relationship:</strong> <span x-text="patientDetails.emergency_relationship || 'N/A'"></span></div>
                        <div class="col-span-2"><strong>Address:</strong> <span x-text="`${patientDetails.emergency_address || 'N/A'} ${patientDetails.emergency_apt_num ? ', Apt #' + patientDetails.emergency_apt_num : ''}, ${patientDetails.emergency_city || 'N/A'}, ${patientDetails.emergency_state || 'N/A'} ${patientDetails.emergency_zip_code || 'N/A'}`"></span></div>
                        <div><strong>Home Phone:</strong> <span x-text="patientDetails.emergency_home_phone || 'N/A'"></span></div>
                        <div><strong>Work Phone:</strong> <span x-text="patientDetails.emergency_work_phone || 'N/A'"></span></div>
                        <div><strong>Other Phone:</strong> <span x-text="patientDetails.emergency_other_phone || 'N/A'"></span>
                            <template x-if="patientDetails.emergency_other_phone_cell"> <span class="text-xs text-gray-500">(Cell)</span> </template>
                            <template x-if="patientDetails.emergency_other_phone_pager"> <span class="text-xs text-gray-500">(Pager)</span> </template>
                            <template x-if="patientDetails.emergency_other_phone_fax"> <span class="text-xs text-gray-500">(Fax)</span> </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Section: Other Contact Information (Not Living with Patient) -->
            <template x-if="patientDetails.other_last_name || patientDetails.other_first_name || patientDetails.other_relationship || patientDetails.other_address || patientDetails.other_apt_num || patientDetails.other_city || patientDetails.other_state || patientDetails.other_zip_code || patientDetails.other_home_phone || patientDetails.other_work_phone || patientDetails.other_other_phone">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">OTHER CONTACT INFORMATION (NOT LIVING WITH PATIENT)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Name:</strong> <span x-text="`${patientDetails.other_first_name || 'N/A'} ${patientDetails.other_last_name || 'N/A'}`"></span></div>
                        <div><strong>Relationship:</strong> <span x-text="patientDetails.other_relationship || 'N/A'"></span></div>
                        <div class="col-span-2"><strong>Address:</strong> <span x-text="`${patientDetails.other_address || 'N/A'} ${patientDetails.other_apt_num ? ', Apt #' + patientDetails.other_apt_num : ''}, ${patientDetails.other_city || 'N/A'}, ${patientDetails.other_state || 'N/A'} ${patientDetails.other_zip_code || 'N/A'}`"></span></div>
                        <div><strong>Home Phone:</strong> <span x-text="patientDetails.other_home_phone || 'N/A'"></span></div>
                        <div><strong>Work Phone:</strong> <span x-text="patientDetails.other_work_phone || 'N/A'"></span></div>
                        <div><strong>Other Phone:</strong> <span x-text="patientDetails.other_other_phone || 'N/A'"></span>
                            <template x-if="patientDetails.other_other_phone_cell"> <span class="text-xs text-gray-500">(Cell)</span> </template>
                            <template x-if="patientDetails.other_other_phone_pager"> <span class="text-xs text-gray-500">(Pager)</span> </template>
                            <template x-if="patientDetails.other_other_phone_fax"> <span class="text-xs text-gray-500">(Fax)</span> </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </div>
</x-modal>

