<x-doctor-layout>
    <div class="py-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">E-Prescription</h1>
            <p class="text-gray-600 mt-2">Create or modify prescriptions for your patients</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Patient Selection & Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Patient Search -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Patient</h3>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="patient-search" 
                            placeholder="Search by name or phone..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <div id="search-results" class="absolute z-10 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-64 overflow-y-auto"></div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div id="patient-info" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p id="patient-name" class="font-semibold text-gray-900"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-sm text-gray-600">Age</p>
                                <p id="patient-age" class="font-semibold text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Sex</p>
                                <p id="patient-sex" class="font-semibold text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Allergies Warning -->
                <div id="allergies-section" class="bg-red-50 border border-red-200 rounded-xl p-6 hidden">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-red-900 mb-2">⚠️ Allergies</h4>
                            <div id="allergies-list" class="text-sm text-red-800 space-y-1"></div>
                        </div>
                    </div>
                </div>

                <!-- Active Conditions -->
                <div id="conditions-section" class="bg-blue-50 border border-blue-200 rounded-xl p-6 hidden">
                    <h4 class="font-semibold text-blue-900 mb-2">Active Conditions</h4>
                    <div id="conditions-list" class="text-sm text-blue-800 space-y-1"></div>
                </div>

                <!-- Current Medications -->
                <div id="medications-section" class="bg-purple-50 border border-purple-200 rounded-xl p-6 hidden">
                    <h4 class="font-semibold text-purple-900 mb-2">Current Medications</h4>
                    <div id="medications-list" class="text-sm text-purple-800 space-y-1"></div>
                </div>
            </div>

            <!-- Right Column - Prescription Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Prescription Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">New Prescription</h3>
                        <button 
                            id="add-medication-btn" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            + Add Medication
                        </button>
                    </div>

                    <div id="medications-container" class="space-y-4">
                        <p class="text-center text-gray-500 py-8">Select a patient to start prescribing</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div id="action-buttons" class="flex justify-end gap-3 hidden">
                    <button id="clear-btn" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Clear All
                    </button>
                    <button id="save-btn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Save Prescription
                    </button>
                </div>

                <!-- Recent Prescriptions -->
                <div id="recent-prescriptions" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Prescriptions</h3>
                    <div id="recent-prescriptions-list" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let selectedPatient = null;
        let medicationCounter = 0;

        // Patient Search
        const searchInput = document.getElementById('patient-search');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/doctor/e-prescription/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(patients => {
                        if (patients.length === 0) {
                            searchResults.innerHTML = '<div class="p-4 text-gray-500 text-sm">No patients found</div>';
                        } else {
                            searchResults.innerHTML = patients.map(patient => `
                                <div class="p-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0" onclick="selectPatient(${patient.id})">
                                    <p class="font-medium text-gray-900">${patient.name}</p>
                                    <p class="text-sm text-gray-600">${patient.age} yrs, ${patient.sex} • ${patient.phone}</p>
                                </div>
                            `).join('');
                        }
                        searchResults.classList.remove('hidden');
                    });
            }, 300);
        });

        // Select Patient
        window.selectPatient = function(patientId) {
            fetch(`/doctor/e-prescription/patient/${patientId}`)
                .then(res => res.json())
                .then(data => {
                    selectedPatient = data.patient;
                    
                    // Update patient info
                    document.getElementById('patient-name').textContent = data.patient.name;
                    document.getElementById('patient-age').textContent = data.patient.age + ' years';
                    document.getElementById('patient-sex').textContent = data.patient.sex;
                    document.getElementById('patient-info').classList.remove('hidden');

                    // Show allergies
                    if (data.allergies.length > 0) {
                        document.getElementById('allergies-list').innerHTML = data.allergies.map(allergy => 
                            `<div class="flex items-start gap-2">
                                <span class="font-semibold">${allergy.allergen}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full ${
                                    allergy.severity === 'severe' ? 'bg-red-200 text-red-800' :
                                    allergy.severity === 'moderate' ? 'bg-orange-200 text-orange-800' :
                                    'bg-yellow-200 text-yellow-800'
                                }">${allergy.severity}</span>
                            </div>`
                        ).join('');
                        document.getElementById('allergies-section').classList.remove('hidden');
                    } else {
                        document.getElementById('allergies-section').classList.add('hidden');
                    }

                    // Show conditions
                    if (data.conditions.length > 0) {
                        document.getElementById('conditions-list').innerHTML = data.conditions.map(condition => 
                            `<div>• ${condition.condition}</div>`
                        ).join('');
                        document.getElementById('conditions-section').classList.remove('hidden');
                    } else {
                        document.getElementById('conditions-section').classList.add('hidden');
                    }

                    // Show current medications
                    if (data.current_medications.length > 0) {
                        document.getElementById('medications-list').innerHTML = data.current_medications.map(med => 
                            `<div>• ${med.medication} - ${med.dosage}, ${med.frequency}</div>`
                        ).join('');
                        document.getElementById('medications-section').classList.remove('hidden');
                    } else {
                        document.getElementById('medications-section').classList.add('hidden');
                    }

                    // Store prescriptions data globally for repeat script
                    recentPrescriptionsData = data.recent_prescriptions;

                    // Show recent prescriptions with Repeat Script button
                    if (data.recent_prescriptions.length > 0) {
                        document.getElementById('recent-prescriptions-list').innerHTML = data.recent_prescriptions.map((rx, index) => 
                            `<div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium text-gray-900">${rx.date}</p>
                                        <p class="text-sm text-gray-600">${rx.diagnosis || 'N/A'}</p>
                                    </div>
                                    <button onclick="repeatScript(${index})" class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors font-medium flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Repeat Script
                                    </button>
                                </div>
                                <div class="text-sm text-gray-700 space-y-1">
                                    ${rx.prescriptions.map(p => `<div>• ${p.medicine_name} ${p.strength} - ${p.dosage}, ${p.frequency}</div>`).join('')}
                                </div>
                            </div>`
                        ).join('');
                        document.getElementById('recent-prescriptions').classList.remove('hidden');
                    }

                    // Enable add medication button
                    document.getElementById('add-medication-btn').disabled = false;
                    document.getElementById('medications-container').innerHTML = '';
                    
                    // Hide search results
                    searchResults.classList.add('hidden');
                    searchInput.value = '';
                });
        };

        // Store recent prescriptions globally
        let recentPrescriptionsData = [];

        // Repeat Script - Load previous prescription
        window.repeatScript = function(index) {
            const prescriptions = recentPrescriptionsData[index];
            if (!prescriptions || !prescriptions.prescriptions) {
                alert('Unable to load prescription data');
                return;
            }

            if (confirm('This will replace current medications with the selected prescription. Continue?')) {
                document.getElementById('medications-container').innerHTML = '';
                medicationCounter = 0; // Reset counter
                
                prescriptions.prescriptions.forEach(med => {
                    addMedicationForm(med);
                });
                document.getElementById('action-buttons').classList.remove('hidden');
                
                // Scroll to medications
                document.getElementById('medications-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        // Add Medication
        document.getElementById('add-medication-btn').addEventListener('click', function() {
            addMedicationForm();
        });

        function addMedicationForm(data = null) {
            const id = medicationCounter++;
            const medication = data || {
                medicine_name: '',
                strength: '',
                dosage: '',
                frequency: '',
                duration: '',
                quantity: '',
                instructions: '',
                additional_instructions: ''
            };

            const html = `
                <div class="medication-item p-4 border border-gray-200 rounded-lg bg-gray-50" data-id="${id}">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-semibold text-gray-900">Medication ${document.querySelectorAll('.medication-item').length + 1}</h4>
                        <button type="button" onclick="removeMedication(${id})" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name *</label>
                            <input type="text" name="medicine_name" value="${medication.medicine_name}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Strength *</label>
                            <input type="text" name="strength" value="${medication.strength}" placeholder="e.g., 500mg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosage *</label>
                            <input type="text" name="dosage" value="${medication.dosage}" placeholder="e.g., 1 tablet" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Frequency *</label>
                            <input type="text" name="frequency" value="${medication.frequency}" placeholder="e.g., Twice daily" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration *</label>
                            <input type="text" name="duration" value="${medication.duration}" placeholder="e.g., 7 days" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                            <input type="text" name="quantity" value="${medication.quantity}" placeholder="e.g., 14 tablets" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instructions *</label>
                            <input type="text" name="instructions" value="${medication.instructions}" placeholder="e.g., After meals" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Instructions (Optional)</label>
                            <textarea name="additional_instructions" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">${medication.additional_instructions || ''}</textarea>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('medications-container').insertAdjacentHTML('beforeend', html);
            document.getElementById('action-buttons').classList.remove('hidden');
        }

        window.removeMedication = function(id) {
            document.querySelector(`[data-id="${id}"]`).remove();
            if (document.querySelectorAll('.medication-item').length === 0) {
                document.getElementById('action-buttons').classList.add('hidden');
            }
        };

        // Clear All
        document.getElementById('clear-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear all medications?')) {
                document.getElementById('medications-container').innerHTML = '';
                document.getElementById('action-buttons').classList.add('hidden');
            }
        });

        // Save Prescription
        document.getElementById('save-btn').addEventListener('click', function() {
            if (!selectedPatient) {
                alert('Please select a patient first');
                return;
            }

            const medicationItems = document.querySelectorAll('.medication-item');
            if (medicationItems.length === 0) {
                alert('Please add at least one medication');
                return;
            }

            const prescriptions = [];
            let isValid = true;

            medicationItems.forEach(item => {
                const inputs = item.querySelectorAll('input, textarea');
                const medication = {};
                
                inputs.forEach(input => {
                    if (input.required && !input.value.trim()) {
                        isValid = false;
                    }
                    medication[input.name] = input.value.trim();
                });

                prescriptions.push(medication);
            });

            if (!isValid) {
                alert('Please fill in all required fields');
                return;
            }

            // Save prescription
            fetch('/doctor/e-prescription/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    patient_id: selectedPatient.id,
                    prescriptions: prescriptions
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Prescription saved successfully!');
                    document.getElementById('medications-container').innerHTML = '';
                    document.getElementById('action-buttons').classList.add('hidden');
                    // Reload patient to show new prescription in history
                    selectPatient(selectedPatient.id);
                }
            })
            .catch(error => {
                alert('Error saving prescription. Please try again.');
                console.error(error);
            });
        });
    </script>
    @endpush
</x-doctor-layout>
