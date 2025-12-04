<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultation - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('patients.show', $consultation->patient) }}" 
                           class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $consultation->patient->full_name }}
                            </h1>
                            <p class="text-sm text-gray-500">
                                {{ $consultation->patient->age }} years old • {{ ucfirst($consultation->patient->gender) }} • 
                                {{ $consultation->consultation_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500" id="auto-save-indicator">
                            <!-- Auto-save indicator will be updated by Livewire -->
                        </span>
                        <button type="button" 
                                onclick="confirm('Are you sure you want to delete this draft?') && document.getElementById('delete-form').submit()"
                                class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700">
                            Delete Draft
                        </button>
                        <form id="delete-form" action="{{ route('consultations.destroy', $consultation) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="flex space-x-8 border-t border-gray-200" x-data="{ navigating: false }">
                    <button 
                        @click="if (!navigating) { navigating = true; Livewire.dispatch('save-and-navigate', { section: 'symptoms' }); }"
                        :disabled="navigating"
                        class="px-1 py-4 text-sm font-medium border-b-2 {{ $consultation->current_section === 'symptoms' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Symptoms
                    </button>
                    <button 
                        @click="if (!navigating) { navigating = true; Livewire.dispatch('save-and-navigate', { section: 'examination' }); }"
                        :disabled="navigating"
                        class="px-1 py-4 text-sm font-medium border-b-2 {{ $consultation->current_section === 'examination' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Examination
                    </button>
                    <button 
                        @click="if (!navigating) { navigating = true; Livewire.dispatch('save-and-navigate', { section: 'diagnosis' }); }"
                        :disabled="navigating"
                        class="px-1 py-4 text-sm font-medium border-b-2 {{ $consultation->current_section === 'diagnosis' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Diagnosis & Prescribe
                    </button>
                    <button 
                        @click="if (!navigating) { navigating = true; Livewire.dispatch('save-and-navigate', { section: 'plan' }); }"
                        :disabled="navigating"
                        class="px-1 py-4 text-sm font-medium border-b-2 {{ $consultation->current_section === 'plan' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Plan & Notes
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex gap-6">
                <!-- Left: Consultation Form (70%) -->
                <div class="flex-1" style="width: 70%;">
                    @if($consultation->current_section === 'symptoms')
                        <livewire:doctor.consultation.symptoms-form :consultation="$consultation" />
                    @endif
                    
                    @if($consultation->current_section === 'examination')
                        <livewire:doctor.consultation.examination-form :consultation="$consultation" />
                    @endif
                    
                    @if($consultation->current_section === 'diagnosis')
                        <livewire:doctor.consultation.diagnosis-prescribe-form :consultation="$consultation" />
                    @endif
                    
                    @if($consultation->current_section === 'plan')
                        <livewire:doctor.consultation.plan-form :consultation="$consultation" />
                    @endif
                </div>

                <!-- Right: Patient Sidebar (30%) with Icon Navigation -->
                <div class="w-96 flex-shrink-0 flex gap-2">
                    <!-- Main Sidebar Content -->
                    <div class="flex-1">
                        <livewire:doctor.consultation.patient-sidebar 
                            :patient="$consultation->patient"
                            :consultation="$consultation"
                            :latestVitals="$latestVitals"
                            :activeConditions="$activeConditions"
                            :activeMedications="$activeMedications"
                            :allergies="$allergies"
                            :recentConsultations="$recentConsultations"
                        />
                    </div>                    
                    <!-- Vertical Icon Navigation -->
                    <div class="w-14 flex-shrink-0" x-data="{ 
                        activeView: localStorage.getItem('consultation_sidebar_view') || 'consultation',
                        init() {
                            // Set initial view in Livewire
                            Livewire.dispatch('switch-sidebar-view', { view: this.activeView });
                        },
                        switchView(view) {
                            this.activeView = view;
                            localStorage.setItem('consultation_sidebar_view', view);
                            Livewire.dispatch('switch-sidebar-view', { view: view });
                        }
                    }">
                        <div class="bg-white rounded-lg shadow sticky top-24">
                            <div class="flex flex-col">
                                <!-- Executive Summary Icon -->
                                <button 
                                    @click="switchView('executive')"
                                    :class="activeView === 'executive' ? 'bg-blue-50 border-l-4 border-l-blue-600' : ''"
                                    class="p-3 hover:bg-gray-50 border-b border-gray-200 transition-colors group"
                                    title="Executive Summary">
                                    <svg :class="activeView === 'executive' ? 'text-blue-600' : 'text-gray-600 group-hover:text-blue-600'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>
                                
                                <!-- Consultation Notes Icon -->
                                <button 
                                    @click="switchView('consultation')"
                                    :class="activeView === 'consultation' ? 'bg-blue-50 border-l-4 border-l-blue-600' : ''"
                                    class="p-3 hover:bg-gray-50 border-b border-gray-200 transition-colors group"
                                    title="Consultation Notes">
                                    <svg :class="activeView === 'consultation' ? 'text-blue-600' : 'text-gray-600 group-hover:text-blue-600'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <!-- Alerts/Warnings Icon -->
                                <button 
                                    @click="switchView('alerts')"
                                    :class="activeView === 'alerts' ? 'bg-red-50 border-l-4 border-l-red-600' : ''"
                                    class="p-3 hover:bg-gray-50 border-b border-gray-200 transition-colors group relative"
                                    title="Alerts & Warnings">
                                    <svg :class="activeView === 'alerts' ? 'text-red-600' : 'text-gray-600 group-hover:text-red-600'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    @if($allergies && $allergies->count() > 0)
                                        <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                                    @endif
                                </button>
                                
                                <!-- Vitals Icon -->
                                <button 
                                    @click="switchView('vitals')"
                                    :class="activeView === 'vitals' ? 'bg-green-50 border-l-4 border-l-green-600' : ''"
                                    class="p-3 hover:bg-gray-50 transition-colors group"
                                    title="Vital Signs">
                                    <svg :class="activeView === 'vitals' ? 'text-green-600' : 'text-gray-600 group-hover:text-green-600'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Modals -->
    <livewire:doctor.patient.condition-modal :patient="$consultation->patient" />
    <livewire:doctor.patient.medication-modal :patient="$consultation->patient" />
    <livewire:doctor.patient.allergy-modal :patient="$consultation->patient" />

    @livewireScripts
    
    <!-- Quill Editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        // Listen for draft-saved event
        document.addEventListener('livewire:init', () => {
            Livewire.on('draft-saved', () => {
                const indicator = document.getElementById('auto-save-indicator');
                const now = new Date().toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    second: '2-digit'
                });
                indicator.textContent = `Saved at ${now}`;
                indicator.classList.add('text-green-600');
                
                setTimeout(() => {
                    indicator.classList.remove('text-green-600');
                }, 2000);
            });
        });
    </script>
</body>
</html>
