<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                    {{ __('Patients') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Manage patient records and medical history</p>
            </div>
        </div>
    </x-slot>

    <div class="h-full flex flex-col">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Total Patients -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-xs font-medium">Total Patients</p>
                                <p class="text-2xl font-bold mt-1">{{ $patients->total() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Active Patients -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-xs font-medium">Active Patients</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\Patient::where('status', 'active')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Male Patients -->
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-xs font-medium">Male Patients</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\Patient::where('gender', 'Male')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Female Patients -->
                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-pink-100 text-xs font-medium">Female Patients</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\Patient::where('gender', 'Female')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-3 rounded-lg shadow-sm" role="alert">
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

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 flex-1 flex flex-col">
                    <!-- Header with Search, Filter, and Add Button -->
                    <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                            <!-- Search and Filter -->
                            <div class="flex flex-col sm:flex-row gap-3 flex-1">
                                <div class="relative flex-1 min-w-0 max-w-md">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="search-patient" placeholder="Search patients by name or ID..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                                </div>
                                <select id="filter-gender" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition w-full sm:w-auto min-w-[140px]">
                                    <option value="">All Genders</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <select id="filter-status" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition w-full sm:w-auto min-w-[130px]">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            
                            <!-- Add New Patient Button -->
                            <div class="w-auto">
                                <a href="{{ route('patients.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-teal-500/50 transition-all duration-200 hover:shadow-xl hover:shadow-teal-500/60 w-full lg:w-auto whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Add New Patient
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Photo</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Patient Name</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Age</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Gender</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Last Updated</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="patients-table-body">
                                    @forelse ($patients as $patient)
                                        <tr class="hover:bg-gradient-to-r hover:from-teal-50 hover:to-emerald-50 transition-all duration-200 cursor-pointer group" onclick="window.location='{{ route('patients.show', $patient) }}'">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($patient->photo)
                                                    <img src="{{ Storage::url($patient->photo) }}" alt="Patient Photo" class="w-12 h-12 object-cover rounded-full border-2 border-gray-200 group-hover:border-teal-400 transition-colors shadow-sm">
                                                @else
                                                    <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold text-sm border-2 border-gray-200 group-hover:border-teal-400 transition-colors shadow-sm">
                                                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900 whitespace-nowrap">{{ $patient->first_name }} {{ $patient->middle_name ? $patient->middle_name . ' ' : '' }}{{ $patient->last_name }}</div>
                                                        <div class="text-xs text-gray-500 whitespace-nowrap">Patient ID: #{{ $patient->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $patient->gender === 'Male' ? 'bg-indigo-100 text-indigo-800' : 'bg-pink-100 text-pink-800' }}">
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
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <form method="POST" action="{{ route('patients.toggleStatus', $patient) }}" class="inline" @click.stop>
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium transition-colors {{ $patient->status === 'active' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                                        <span class="w-2 h-2 rounded-full {{ $patient->status === 'active' ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                                        {{ ucfirst($patient->status) }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                                @php
                                                    $latestLog = $patient->latestAuditLog();
                                                @endphp
                                                @if($latestLog)
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-medium text-gray-900">{{ $latestLog->description }}</span>
                                                        <span class="text-xs text-gray-500">{{ $latestLog->created_at->diffForHumans() }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400">No activity</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right" @click.stop>
                                                <div class="flex items-center justify-end gap-0.5">
                                                    <button @click.prevent="$dispatch('show-patient-details', { patientId: {{ $patient->id }} })" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Profile">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </button>
                                                    <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125l-4.5-4.5" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('patients.medicalRecords.index', $patient) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Medical Records">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                    </a>
                                                    <button @click.prevent="$dispatch('show-audit-logs', { patientId: {{ $patient->id }} })" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Audit Logs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-8 text-center">
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
                            <div class="py-3 border-t border-gray-200 bg-gray-50">
                                {{ $patients->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Enhanced client-side filtering
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-patient');
            const genderFilter = document.getElementById('filter-gender');
            const statusFilter = document.getElementById('filter-status');
            const tableBody = document.getElementById('patients-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedGender = genderFilter.value;
                const selectedStatus = statusFilter.value;

                let visibleCount = 0;

                rows.forEach(row => {
                    // Skip empty state row
                    if (row.querySelector('td[colspan]')) {
                        return;
                    }

                    const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const gender = row.querySelector('td:nth-child(4)')?.textContent.trim() || '';
                    const status = row.querySelector('td:nth-child(5)')?.textContent.trim() || '';
                    
                    const matchesSearch = name.includes(searchTerm);
                    const matchesGender = !selectedGender || gender === selectedGender;
                    const matchesStatus = !selectedStatus || status === selectedStatus;

                    if (matchesSearch && matchesGender && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state
                const emptyRow = tableBody.querySelector('tr td[colspan]')?.parentElement;
                if (emptyRow) {
                    emptyRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            }

            searchInput?.addEventListener('input', filterTable);
            genderFilter?.addEventListener('change', filterTable);
            statusFilter?.addEventListener('change', filterTable);
        });
    </script>
    @endpush
</x-doctor-layout>

<x-modal name="view-patient-details-modal" :show="false" focusable maxWidth="4xl" x-cloak>
    <div class="bg-gradient-to-br from-gray-50 to-white" x-data="{
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
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">
                    Patient Profile
                </h2>
            </div>
            <button @click="$dispatch('close')" class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="p-12 text-center">
            <div class="inline-flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600 font-medium">Loading patient details...</span>
            </div>
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

<x-modal name="audit-logs-modal" :show="false" focusable maxWidth="2xl" x-cloak>
    <div class="bg-gradient-to-br from-gray-50 to-white" x-data="{
        auditLogs: [],
        loading: false,
        patientName: '',
        openModal(patientId) {
            this.loading = true;
            this.auditLogs = [];
            fetch(`/patients/${patientId}/audit-logs`)
                .then(response => response.json())
                .then(data => {
                    this.auditLogs = data;
                    this.loading = false;
                    this.$dispatch('open-modal', 'audit-logs-modal');
                })
                .catch(error => {
                    console.error('Error fetching audit logs:', error);
                    this.loading = false;
                });
        }
    }" x-on:show-audit-logs.window="openModal($event.detail.patientId)">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Audit Logs</h2>
                    <p class="text-sm text-white/80">Patient activity history</p>
                </div>
            </div>
            <button @click="$dispatch('close')" class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="p-12 text-center">
            <div class="inline-flex items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600 font-medium">Loading audit logs...</span>
            </div>
        </div>

        <!-- Audit Logs Content -->
        <div x-show="!loading" class="p-6 max-h-[70vh] overflow-y-auto">
            <template x-if="auditLogs.length === 0">
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">No audit logs found</p>
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="log in auditLogs" :key="log.id">
                    <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                     :class="{
                                         'bg-green-100': log.action === 'created',
                                         'bg-blue-100': log.action === 'updated',
                                         'bg-purple-100': log.action === 'viewed' || log.action === 'accessed',
                                         'bg-red-100': log.action === 'deleted',
                                         'bg-yellow-100': log.action === 'status_changed'
                                     }">
                                    <svg class="w-4 h-4"
                                         :class="{
                                             'text-green-600': log.action === 'created',
                                             'text-blue-600': log.action === 'updated',
                                             'text-purple-600': log.action === 'viewed' || log.action === 'accessed',
                                             'text-red-600': log.action === 'deleted',
                                             'text-yellow-600': log.action === 'status_changed'
                                         }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <template x-if="log.action === 'created'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </template>
                                        <template x-if="log.action === 'updated'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </template>
                                        <template x-if="log.action === 'viewed' || log.action === 'accessed'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </template>
                                        <template x-if="log.action === 'deleted'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </template>
                                        <template x-if="log.action === 'status_changed'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </template>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900" x-text="log.description"></p>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span x-text="log.user_name"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span x-text="log.created_at_human"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end">
            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold rounded-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ __('Close') }}
            </button>
        </div>
    </div>
</x-modal>

