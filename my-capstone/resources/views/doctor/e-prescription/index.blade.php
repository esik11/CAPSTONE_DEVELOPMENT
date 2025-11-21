<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('E-Prescription Module') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Patient Selection & Context -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Patient Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="patient-search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search Patient:</label>
                        <input type="text" id="patient-search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Enter patient name or ID">
                    </div>
                    <div class="md:col-span-2 mt-4 p-4 border rounded-md bg-gray-50 dark:bg-gray-700">
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100" id="selected-patient-name">Selected Patient: [Patient Name]</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400" id="selected-patient-dob">Date of Birth: [DD/MM/YYYY]</p>
                        <p class="text-sm text-red-600 dark:text-red-400" id="selected-patient-allergies">Allergies: [List of Allergies or "None"]</p>
                        <p class="text-sm text-orange-600 dark:text-orange-400" id="selected-patient-conditions">Active Conditions: [List of Conditions or "None"]</p>
                    </div>
                </div>
            </div>

            <!-- Prescription Creation Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">New Prescription</h3>
                <div id="medication-inputs" class="space-y-4">
                    <!-- Medication 1 -->
                    <div class="medication-item p-4 border rounded-md bg-gray-50 dark:bg-gray-700">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Medication 1</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="drug-name-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Drug Name & Strength:</label>
                                <input type="text" id="drug-name-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., Amoxicillin 500mg">
                            </div>
                            <div>
                                <label for="dosage-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dosage:</label>
                                <input type="text" id="dosage-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., 1 tablet">
                            </div>
                            <div>
                                <label for="frequency-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Frequency:</label>
                                <input type="text" id="frequency-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., twice daily">
                            </div>
                            <div>
                                <label for="route-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Route:</label>
                                <input type="text" id="route-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., Oral">
                            </div>
                            <div>
                                <label for="duration-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration:</label>
                                <input type="text" id="duration-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., for 7 days">
                            </div>
                            <div>
                                <label for="quantity-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity:</label>
                                <input type="text" id="quantity-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., 30 tablets">
                            </div>
                            <div>
                                <label for="refills-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Refills:</label>
                                <input type="number" id="refills-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" value="0" min="0">
                            </div>
                            <div class="md:col-span-3">
                                <label for="instructions-1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructions for Patient:</label>
                                <textarea id="instructions-1" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200" placeholder="e.g., Take with food"></textarea>
                            </div>
                        </div>
                        <button type="button" class="mt-4 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-medication-button" class="mt-4 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Add Another Medication</button>
            </div>

            <!-- Current Prescription Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Prescription Summary</h3>
                <div id="prescription-summary-list" class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-400">[No medications added yet]</p>
                    <!-- Example of a summarized medication item -->
                    <!--
                    <div class="p-3 border rounded-md bg-gray-50 dark:bg-gray-700 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Amoxicillin 500mg</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">1 tablet, twice daily, for 7 days (Oral) - Qty: 30, Refills: 0</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Instructions: Take with food</p>
                        </div>
                        <div>
                            <button class="px-2 py-1 text-sm bg-blue-500 text-white rounded-md">Edit</button>
                            <button class="px-2 py-1 text-sm bg-red-500 text-white rounded-md ml-2">Remove</button>
                        </div>
                    </div>
                    -->
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button type="button" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Print Prescription</button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700">Save Prescription</button>
            </div>

            <!-- Patient's Prescription History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Patient's Prescription History</h3>
                <div id="prescription-history-list" class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-400">[No past prescriptions for this patient]</p>
                    <!-- Example of a past prescription item -->
                    <!--
                    <div class="p-3 border rounded-md bg-gray-50 dark:bg-gray-700 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Prescribed on: [Date]</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Medication: [Drug Name] - [Dosage], [Frequency], [Duration]</p>
                        </div>
                        <div>
                            <button class="px-2 py-1 text-sm bg-blue-500 text-white rounded-md">View Details</button>
                            <button class="px-2 py-1 text-sm bg-purple-500 text-white rounded-md ml-2">Re-prescribe</button>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>
