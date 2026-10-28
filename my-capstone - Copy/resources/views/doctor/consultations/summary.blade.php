<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medical Chart - {{ $consultation->patient->last_name }}, {{ $consultation->patient->first_name }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&family=Libre+Franklin:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-feature-settings: "ss01", "ss02", "cv05", "cv10";
            letter-spacing: -0.011em;
        }
        
        .font-medical {
            font-family: 'Libre Franklin', 'Inter', sans-serif;
        }
        
        .clinical-mono {
            font-family: 'IBM Plex Mono', 'Courier New', monospace;
            font-size: 0.9em;
        }

        /* Split Screen Layout */
        .split-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            height: calc(100vh - 220px); /* Adjusted for header (60px) + action bar (80px) + padding */
            overflow: hidden;
        }
        
        .split-panel {
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 0.5rem;
            padding-bottom: 2rem;
        }
        
        .split-panel::-webkit-scrollbar {
            width: 8px;
        }
        
        .split-panel::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .split-panel::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .split-panel::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media print {
            @page {
                margin: 6mm 8mm;
                size: letter; /* US Letter / Bond paper */
            }

            body {
                background: white !important;
                font-size: 8pt !important;
                line-height: 1.2 !important;
                color: #000 !important;
                font-family: Arial, sans-serif !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .print\:hidden {
                display: none !important;
            }
            
            /* Ensure print content fills the page */
            .print\:block {
                display: block !important;
                width: 100% !important;
                height: 100% !important;
            }
        }
        
        @media (max-width: 1280px) {
            .split-container {
                grid-template-columns: 1fr;
                height: auto;
            }
            .split-panel {
                overflow-y: visible;
            }
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    {{-- Compact print layout (hidden on screen, shown when printing) --}}
    <div class="hidden print:block">
        @include('doctor.consultations.partials.print-chart')
    </div>

    <!-- Header Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 print:hidden shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('consultations.show', $consultation) }}" 
                       class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <div>
                        <h1 class="text-base font-semibold text-gray-900">Medical Chart Review</h1>
                        <p class="text-xs text-gray-500">Case #{{ str_pad($consultation->id, 6, '0', STR_PAD_LEFT) }} • {{ $consultation->consultation_date->format('F d, Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.print()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Chart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1800px] mx-auto px-6 py-6 print:hidden">
        
        <!-- Medical Chart Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden mb-4 print-patient-header">
            <!-- Dark Professional Header -->
            <div class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 px-6 py-5">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-5">
                        <!-- Patient Avatar -->
                        <div class="w-16 h-16 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border-2 border-white/20 shadow-lg">
                            <span class="text-2xl font-bold text-white">{{ substr($consultation->patient->first_name, 0, 1) }}{{ substr($consultation->patient->last_name, 0, 1) }}</span>
                        </div>
                        
                        <!-- Patient Info -->
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1.5">{{ $consultation->patient->last_name }}, {{ $consultation->patient->first_name }} {{ $consultation->patient->middle_name ? substr($consultation->patient->middle_name, 0, 1).'.' : '' }}</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-5 gap-y-1 text-xs demographics">
                                <div class="flex items-center gap-2 text-gray-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>{{ $consultation->patient->age }} years • {{ ucfirst($consultation->patient->gender) }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>DOB: {{ $consultation->patient->date_of_birth ? $consultation->patient->date_of_birth->format('M d, Y') : 'Not specified' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-300 clinical-mono text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                    <span>MRN: {{ $consultation->patient->patient_id }}</span>
                                </div>
                                @if($consultation->patient->contact_number)
                                <div class="flex items-center gap-2 text-gray-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $consultation->patient->contact_number }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Consultation Badge -->
                    <div class="text-right">
                        <div class="inline-flex items-center px-3 py-2 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                <div class="text-left">
                                    <p class="text-[10px] font-semibold text-emerald-300 uppercase tracking-wide">Consultation Date</p>
                                    <p class="text-xs font-bold text-white">{{ $consultation->consultation_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vital Signs Strip -->
            @if($consultation->temperature || $consultation->blood_pressure || $consultation->pulse_rate || $consultation->spo2 || $consultation->weight || $consultation->height)
            <div class="border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white px-6 py-4 print-vitals">
                <div class="flex items-center justify-between mb-2.5">
                    <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Vital Signs</h3>
                    <span class="text-[10px] text-gray-400">Recorded at {{ $consultation->consultation_time->format('g:i A') }}</span>
                </div>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-3 print-vitals-grid">
                    @if($consultation->temperature)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-blue-100">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19c-1.104 0-2-.896-2-2V5c0-1.104.896-2 2-2s2 .896 2 2v12c0 1.104-.896 2-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">Temp</p>
                            <p class="text-sm font-bold text-gray-900">{{ $consultation->temperature }}<span class="text-xs text-gray-500">°C</span></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->blood_pressure)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-red-100">
                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">BP</p>
                            <p class="text-sm font-bold text-gray-900">{{ $consultation->blood_pressure }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->pulse_rate)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-purple-100">
                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">Pulse</p>
                            <p class="text-sm font-bold text-gray-900">{{ $consultation->pulse_rate }}<span class="text-xs text-gray-500">bpm</span></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->respiratory_rate)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-teal-100">
                        <div class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">RR</p>
                            <p class="text-sm font-bold text-gray-900">{{ $consultation->respiratory_rate }}<span class="text-xs text-gray-500">/min</span></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->spo2)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-cyan-100">
                        <div class="w-8 h-8 bg-cyan-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">SpO₂</p>
                            <p class="text-sm font-bold text-gray-900">{{ $consultation->spo2 }}<span class="text-xs text-gray-500">%</span></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->weight || $consultation->height)
                    <div class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-amber-100">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500">Wt/Ht</p>
                            <p class="text-xs font-bold text-gray-900">
                                @if($consultation->weight){{ $consultation->weight }}<span class="text-[10px] text-gray-500">kg</span>@endif
                                @if($consultation->weight && $consultation->height) / @endif
                                @if($consultation->height){{ $consultation->height }}<span class="text-[10px] text-gray-500">cm</span>@endif
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        @php
        $diagnosisList = $consultation->diagnoses ?? [];
        $primaryDiagnosis = collect($diagnosisList)->firstWhere('is_primary', true);
        @endphp

        <!-- Primary Diagnosis Banner -->
        @if($primaryDiagnosis)
        <div class="bg-gradient-to-r from-indigo-50 via-purple-50 to-indigo-50 border-2 border-indigo-200 rounded-lg px-5 py-3 mb-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider mb-0.5">Primary Diagnosis</p>
                    <p class="text-lg font-bold text-gray-900">{{ $primaryDiagnosis['description'] ?? $primaryDiagnosis['name'] ?? 'Unknown' }}</p>
                    @if(isset($primaryDiagnosis['code']) && $primaryDiagnosis['code'])
                    <p class="text-xs text-gray-600 clinical-mono mt-0.5">ICD-10: {{ $primaryDiagnosis['code'] }}</p>
                    @endif
                </div>
                <div class="px-3 py-2 bg-white rounded-lg border border-indigo-200 shadow-sm">
                    <p class="text-[10px] text-gray-500 font-medium">Visit Type</p>
                    <p class="text-xs font-bold text-gray-900">{{ $consultation->visit_type ?? 'General' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- SPLIT SCREEN LAYOUT -->
        <div class="split-container">
            
            <!-- LEFT PANEL: SUBJECTIVE & OBJECTIVE -->
            <div class="split-panel space-y-4">
            
            <!-- SUBJECTIVE Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden print-soap-section print-avoid-break">
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4 flex items-center gap-3 print-soap-header">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                        <span class="text-lg font-black text-white">S</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-white">Subjective</h3>
                        <p class="text-sm text-blue-100">Patient History, Complaints & Symptoms</p>
                    </div>
                </div>
                <div class="px-6 py-6 print-soap-content">
                    <!-- Chief Complaints -->
                    @if($consultation->selected_complaints && count($consultation->selected_complaints) > 0)
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Chief Complaints</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($consultation->selected_complaints as $complaint)
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-100">{{ $complaint }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- History of Present Illness -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">History of Present Illness</h4>
                        <div class="prose prose-sm max-w-none">
                            <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded-lg border border-gray-100">
{!! strip_tags($consultation->symptom_notes_final ?? $consultation->symptom_notes_manual ?? $consultation->symptom_notes_auto ?? 'No history documented.') !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Symptom Details -->
                    @if($consultation->symptom_onset || $consultation->symptom_duration || $consultation->aggravating_factors || $consultation->relieving_factors)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($consultation->symptom_onset)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Onset</p>
                            <p class="text-sm text-gray-900 font-medium">{{ $consultation->symptom_onset }}</p>
                        </div>
                        @endif
                        
                        @if($consultation->symptom_duration)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Duration</p>
                            <p class="text-sm text-gray-900 font-medium">{{ $consultation->symptom_duration }} {{ $consultation->symptom_duration_unit ?? 'days' }}</p>
                        </div>
                        @endif
                        
                        @if($consultation->aggravating_factors)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Aggravating Factors</p>
                            <p class="text-sm text-gray-900">{!! strip_tags($consultation->aggravating_factors) !!}</p>
                        </div>
                        @endif
                        
                        @if($consultation->relieving_factors)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Relieving Factors</p>
                            <p class="text-sm text-gray-900">{!! strip_tags($consultation->relieving_factors) !!}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Previous Episodes -->
                    @if($consultation->previous_episodes && $consultation->previous_episodes_details)
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-wide mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            Previous Episodes
                        </p>
                        <p class="text-sm text-gray-800">{!! strip_tags($consultation->previous_episodes_details) !!}</p>
                    </div>
                    @endif
                    
                    <!-- Associated Symptoms -->
                    @if($consultation->associated_symptoms && count($consultation->associated_symptoms) > 0)
                    <div class="mt-4">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Associated Symptoms</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($consultation->associated_symptoms as $symptom)
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-medium rounded border border-blue-100">{{ $symptom }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- OBJECTIVE Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden print-soap-section print-avoid-break">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-4 flex items-center gap-3 print-soap-header">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                        <span class="text-lg font-black text-white">O</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-white">Objective</h3>
                        <p class="text-sm text-emerald-100">Physical Examination Findings</p>
                    </div>
                </div>
                <div class="px-6 py-6 print-soap-content">
                    <!-- General Appearance -->
                    @if($consultation->general_appearance)
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">General Appearance</h4>
                        <p class="text-sm text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ strip_tags($consultation->general_appearance) }}</p>
                    </div>
                    @endif
                    
                    <!-- System Examinations -->
                    <div class="space-y-4">
                        @php
                        $examinations = [
                            ['field' => 'heent_exam', 'findings' => 'heent_findings', 'label' => 'HEENT', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                            ['field' => 'cardiovascular_exam', 'findings' => 'cardiovascular_findings', 'label' => 'Cardiovascular', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                            ['field' => 'respiratory_exam', 'findings' => 'respiratory_findings', 'label' => 'Respiratory', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                            ['field' => 'abdominal_exam', 'findings' => 'abdominal_findings', 'label' => 'Abdominal', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['field' => 'neurological_exam', 'findings' => 'neurological_findings', 'label' => 'Neurological', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                            ['field' => 'musculoskeletal_exam', 'findings' => 'musculoskeletal_findings', 'label' => 'Musculoskeletal', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['field' => 'skin_exam', 'findings' => 'skin_findings', 'label' => 'Skin', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z']
                        ];
                        @endphp
                        
                        @foreach($examinations as $exam)
                            @if($consultation->{$exam['field']} || ($consultation->{$exam['findings']} && count($consultation->{$exam['findings']}) > 0))
                            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $exam['icon'] }}"/></svg>
                                    <h5 class="text-sm font-bold text-gray-900">{{ $exam['label'] }}</h5>
                                    @if($consultation->{$exam['field']})
                                    <span class="ml-auto px-2 py-0.5 text-xs font-semibold rounded {{ strip_tags($consultation->{$exam['field']}) === 'normal' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst(strip_tags($consultation->{$exam['field']})) }}
                                    </span>
                                    @endif
                                </div>
                                @if($consultation->{$exam['findings']} && count($consultation->{$exam['findings']}) > 0)
                                <div class="text-sm text-gray-800 pl-6">
                                    @foreach($consultation->{$exam['findings']} as $finding)
                                    <p class="mb-1">• {{ strip_tags($finding) }}</p>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <!-- Overall Examination Notes -->
                    @if($consultation->examination_notes)
                    <div class="mt-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Additional Examination Notes</h4>
                        <div class="text-sm text-gray-800 clinical-mono bg-gray-50 p-4 rounded-lg border border-gray-100 leading-relaxed">
{{ strip_tags($consultation->examination_notes) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            </div>
            <!-- END LEFT PANEL -->

            <!-- RIGHT PANEL: ASSESSMENT & PLAN -->
            <div class="split-panel space-y-4">

            <!-- ASSESSMENT Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden print-soap-section print-avoid-break">
                    <div class="bg-gradient-to-r from-violet-600 to-violet-500 px-6 py-4 flex items-center gap-3 print-soap-header">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                            <span class="text-lg font-black text-white">A</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white">Assessment</h3>
                            <p class="text-sm text-violet-100">Diagnosis & Clinical Impression</p>
                        </div>
                    </div>
                    <div class="px-6 py-6">
                        <div class="space-y-3">
                            @forelse($consultation->diagnoses ?? [] as $index => $diagnosis)
                                <div class="flex items-start gap-3 p-4 {{ isset($diagnosis['is_primary']) && $diagnosis['is_primary'] ? 'bg-violet-50 border-2 border-violet-300' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                                    <div class="w-8 h-8 {{ isset($diagnosis['is_primary']) && $diagnosis['is_primary'] ? 'bg-violet-600' : 'bg-gray-400' }} rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                                        @if(isset($diagnosis['is_primary']) && $diagnosis['is_primary'])
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        @else
                                        <span class="text-sm text-white font-bold">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        @if(isset($diagnosis['is_primary']) && $diagnosis['is_primary'])
                                        <span class="inline-block px-2 py-0.5 bg-violet-600 text-white text-[10px] font-bold rounded uppercase tracking-wide mb-1.5">Primary</span>
                                        @endif
                                        <p class="text-sm font-bold text-gray-900">{{ $diagnosis['description'] ?? $diagnosis['name'] ?? 'Unknown diagnosis' }}</p>
                                        @if(isset($diagnosis['code']) && $diagnosis['code'])
                                        <p class="text-xs text-gray-600 clinical-mono mt-1">ICD-10: {{ $diagnosis['code'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="text-sm text-gray-500">No diagnoses documented</p>
                                </div>
                            @endforelse
                        </div>
                        
                        @if($consultation->diagnosis_notes)
                        <div class="mt-4 p-4 bg-violet-50 border border-violet-100 rounded-lg">
                            <p class="text-xs font-semibold text-violet-700 uppercase tracking-wide mb-2">Clinical Notes</p>
                            <p class="text-sm text-gray-800">{{ strip_tags($consultation->diagnosis_notes) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

            <!-- PLAN Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden print-soap-section print-avoid-break">
                    <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-6 py-4 flex items-center gap-3 print-soap-header">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                            <span class="text-lg font-black text-white">P</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white">Plan</h3>
                            <p class="text-sm text-orange-100">Treatment & Prescriptions</p>
                        </div>
                    </div>
                    <div class="px-6 py-6">
                        <div class="space-y-3">
                            @forelse($consultation->prescriptions ?? [] as $prescription)
                                <div class="flex items-start gap-3 p-4 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition-colors">
                                    <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">{{ $prescription['medicine_name'] ?? $prescription['name'] ?? 'Unknown medication' }}</p>
                                        @if(isset($prescription['dosage']) && $prescription['dosage'])
                                        <p class="text-xs text-gray-700 mt-1 font-medium">{{ $prescription['dosage'] }}</p>
                                        @endif
                                        @if(isset($prescription['frequency']) && $prescription['frequency'])
                                        <p class="text-xs text-gray-600 mt-1">
                                            {{ $prescription['frequency'] }}
                                            @if(isset($prescription['duration'])) • {{ $prescription['duration'] }}@endif
                                        </p>
                                        @endif
                                        @if(isset($prescription['instructions']) && $prescription['instructions'])
                                        <p class="text-xs text-gray-500 mt-2 italic bg-white p-2 rounded border border-gray-100">ℹ️ {{ $prescription['instructions'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    <p class="text-sm text-gray-500">No prescriptions documented</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            <!-- Additional Clinical Documentation -->
            @if($consultation->treatment_plan || $consultation->patient_education || $consultation->followup_instructions || $consultation->referral_details || $consultation->doctor_notes)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Additional Clinical Documentation</h3>
                </div>
                <div class="px-6 py-6 space-y-6">
                    
                    @if($consultation->treatment_plan)
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                            Treatment Plan
                        </h4>
                        <div class="text-sm text-gray-800 bg-teal-50 p-4 rounded-lg border border-teal-100 whitespace-pre-wrap">
{{ strip_tags($consultation->treatment_plan) }}
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->patient_education)
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
                            Patient Education
                        </h4>
                        <div class="text-sm text-gray-800 bg-blue-50 p-4 rounded-lg border border-blue-100 whitespace-pre-wrap">
{{ strip_tags($consultation->patient_education) }}
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->followup_instructions)
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                            Follow-up Instructions
                        </h4>
                        <div class="text-sm text-gray-800 bg-purple-50 p-4 rounded-lg border border-purple-100 whitespace-pre-wrap">
{{ strip_tags($consultation->followup_instructions) }}
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->referral_details)
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                            Referral Details
                        </h4>
                        <div class="text-sm text-gray-800 bg-indigo-50 p-4 rounded-lg border border-indigo-100 whitespace-pre-wrap">
{{ strip_tags($consultation->referral_details) }}
                        </div>
                    </div>
                    @endif
                    
                    @if($consultation->doctor_notes)
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                            Provider Notes (Internal)
                        </h4>
                        <div class="text-sm text-gray-800 bg-gray-100 p-4 rounded-lg border border-gray-200 whitespace-pre-wrap clinical-mono">
{{ strip_tags($consultation->doctor_notes) }}
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
            @endif

            </div>
            <!-- END RIGHT PANEL -->

        </div>
        <!-- END SPLIT CONTAINER -->

        <!-- Physician Signature (Full Width Below Split) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-300 px-8 py-6 mb-24 mt-4">
                <div class="flex items-end justify-between">
                    <div class="max-w-xl">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            This medical chart has been electronically documented and authenticated through the {{ config('app.name') }} secure medical records system. 
                            All information contained herein is confidential and protected under HIPAA regulations.
                        </p>
                        @if($consultation->doctor->license_number)
                        <p class="text-xs text-gray-500 clinical-mono mt-2">
                            Physician License: {{ $consultation->doctor->license_number }}
                        </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="border-t-2 border-gray-900 pt-3 min-w-[300px]">
                            @if($consultation->isCompleted())
                            <div class="h-14 flex items-center justify-center mb-2">
                                <span class="text-4xl text-gray-700" style="font-family: 'Brush Script MT', cursive;">{{ $consultation->doctor->name ?? ($consultation->doctor->first_name . ' ' . $consultation->doctor->last_name) }}</span>
                            </div>
                            @endif
                            <p class="text-base font-bold text-gray-900">
                                @if($consultation->doctor->first_name && $consultation->doctor->last_name)
                                    {{ $consultation->doctor->first_name }} {{ $consultation->doctor->middle_name ? substr($consultation->doctor->middle_name, 0, 1).'. ' : '' }}{{ $consultation->doctor->last_name }}, MD
                                @else
                                    {{ $consultation->doctor->name ?? 'Doctor' }}, MD
                                @endif
                            </p>
                            <p class="text-xs text-gray-600 font-medium">{{ $consultation->doctor->specialization ?? 'General Practitioner' }}</p>
                            @if($consultation->doctor->license_number)
                            <p class="text-xs text-gray-500 clinical-mono mt-1">PRC #{{ $consultation->doctor->license_number }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-3">Signed: {{ $consultation->completed_at ? $consultation->completed_at->format('F d, Y g:i A') : $consultation->updated_at->format('F d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Action Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 shadow-2xl print:hidden z-50">
        <div class="max-w-7xl mx-auto px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('consultations.show', $consultation) }}" 
                   class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Medical Chart
                </a>

                @if(!$consultation->isCompleted())
                    <form action="{{ route('consultations.finalize', $consultation) }}" method="POST" 
                          onsubmit="return confirm('Finalize and electronically sign this medical chart? This action cannot be undone.');">
                        @csrf
                        <button type="submit" 
                                class="px-10 py-3 bg-emerald-600 text-white rounded-lg font-bold text-sm shadow-lg hover:bg-emerald-700 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Finalize & Sign Medical Chart
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 px-5 py-3 bg-gray-100 text-gray-600 rounded-lg border border-gray-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm font-semibold">Chart Finalized & Signed</span>
                        </div>
                        <a href="{{ route('doctor.billing.create', $consultation) }}" 
                           class="px-10 py-3 bg-slate-900 text-white rounded-lg font-bold text-sm shadow-lg hover:bg-slate-800 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Proceed to Billing
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($autoPrint ?? false)
    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
    @endif

</body>
</html>
