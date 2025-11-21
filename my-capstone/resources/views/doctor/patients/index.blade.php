<x-doctor-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Patients') }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage patient records and medical history</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                <!-- Header with Search, Filter, and Add Button -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                        <!-- Search and Filter -->
                        <div class="flex flex-col sm:flex-row gap-3 flex-1 w-full lg:w-auto">
                            <div class="relative flex-1 min-w-0">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="search-patient" placeholder="Search patients by name..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            </div>
                            <select id="filter-gender" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition w-full sm:w-auto">
                                <option value="">All Genders</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        
                        <!-- Add New Patient Button -->
                        <div class="w-full lg:w-auto">
                            <a href="{{ route('patients.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-teal-500/50 transition-all duration-200 hover:shadow-xl hover:shadow-teal-500/60 w-full lg:w-auto whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Add New Patient
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Photo</th>
                                <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Patient Name</th>
                                <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Age</th>
                                <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Gender</th>
                                <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Contact</th>
                                <th scope="col" class="px-6 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="patients-table-body">
                                @forelse ($patients as $patient)
                                    <tr class="hover:bg-gradient-to-r hover:from-teal-50 hover:to-emerald-50 transition-all duration-200 cursor-pointer group" @click="$dispatch('show-patient-details', { patientId: {{ $patient->id }} })">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if ($patient->photo)
                                                <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-12 h-12 object-cover rounded-full border-2 border-gray-200 group-hover:border-teal-400 transition-colors shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold text-sm border-2 border-gray-200 group-hover:border-teal-400 transition-colors shadow-sm">
                                                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900 whitespace-nowrap">{{ $patient->first_name }} {{ $patient->middle_name ? $patient->middle_name . ' ' : '' }}{{ $patient->last_name }}</div>
                                                    <div class="text-xs text-gray-500 whitespace-nowrap">Patient ID: #{{ $patient->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium {{ $patient->gender === 'Male' ? 'bg-indigo-100 text-indigo-800' : 'bg-pink-100 text-pink-800' }}">
                                                @if($patient->gender === 'Male')
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                    </svg>
                                                @endif
                                                {{ $patient->gender }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <span>{{ $patient->phone_number }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right" @click.stop>
                                            <div class="flex items-center justify-end gap-1">
                                                <button @click.prevent="$dispatch('show-patient-details', { patientId: {{ $patient->id }} })" class="p-2.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Profile">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>
                                                <a href="{{ route('patients.edit', $patient) }}" class="p-2.5 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125l-4.5-4.5" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('patients.medicalRecords.index', $patient) }}" class="p-2.5 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Medical Records">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="lete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <p class="text-gray-500 font-medium text-lg">No patients found</p>
                                                <p class="text-gray-400 text-sm mt-1">Start by adding your first patient</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($patients->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $patients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Simple client-side filtering
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-patient');
            const genderFilter = document.getElementById('filter-gender');
            const tableBody = document.getElementById('patients-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedGender = genderFilter.value;

                rows.forEach(row => {
                    const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const gender = row.querySelector('td:nth-child(4)')?.textContent.trim() || '';
                    
                    const matchesSearch = name.includes(searchTerm);
                    const matchesGender = !selectedGender || gender === selectedGender;

                    if (matchesSearch && matchesGender) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput?.addEventListener('input', filterTable);
            genderFilter?.addEventListener('change', filterTable);
        });
    </script>
    @endpush
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

