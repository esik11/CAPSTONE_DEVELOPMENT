<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinical Summary - {{ $consultation->patient->last_name }}, {{ $consultation->patient->first_name }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&family=Dancing+Script:wght@700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }

        @media print {
            @page {
                margin: 10mm 15mm;
                size: A4;
            }
            body { 
                background: white !important; 
                color: black !important;
                font-size: 10pt !important;
                -webkit-print-color-adjust: exact;
            }
            .print\:hidden { display: none !important; }
            .no-print-shadow { box-shadow: none !important; }
            .page-break { page-break-before: always; }
            
            /* COMPACT PRINT RESET */
            .paper-container { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .side-by-side-pane { display: block !important; }
            .left-pane, .right-pane { width: 100% !important; margin-bottom: 1rem !important; border: none !important; }
            
            /* FORMAL MONOCHROME CARDS */
            .clinical-card { 
                border: 1px solid #000 !important; 
                border-radius: 0 !important; 
                margin-bottom: 0.5rem !important;
                padding: 1rem !important;
                box-shadow: none !important;
                background: white !important;
            }
            .clinical-header { 
                padding: 1rem !important;
                background: #f1f5f9 !important; 
                border-bottom: 2px solid black !important;
                color: black !important;
            }
            .clinical-header * { color: black !important; }
            .clinical-header h2 { font-size: 1.5rem !important; font-weight: 800 !important; }
            
            /* REMOVE ALL COLORS FROM TAGS */
            .soap-tag { 
                border: 1px solid #000 !important; 
                background: #000 !important; 
                color: #fff !important;
                font-weight: 900 !important;
                padding: 0.1rem 0.4rem !important;
            }

            .soap-grid-print {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 0.5rem !important;
            }

            .font-serif {
                font-family: 'Libre Baskerville', serif !important;
                line-height: 1.5 !important;
                color: #1a1a1a !important;
            }
            
            .print-only { display: block !important; }
            .print-no-mb { margin-bottom: 0 !important; }
            
            /* Force grayscale for all icons and accents */
            svg { color: black !important; }
            .text-blue-400, .text-emerald-400, .text-purple-400, .text-orange-400 { color: black !important; }
            .bg-blue-50, .bg-emerald-50, .bg-purple-50, .bg-orange-50 { background: white !important; border: 1px solid black !important; }
        }

        .print-only { display: none; }

        .clinical-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }

        .clinical-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .soap-tag {
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-slate-50 antialiased text-slate-900">
    <div class="min-h-screen pb-20">
        
        <!-- TOP NAVIGATION BAR -->
        <div class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 print:hidden">
            <div class="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ route('consultations.show', $consultation) }}" 
                       class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-full transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-extrabold tracking-tight text-slate-900">Clinical Summary</h1>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">Verification & Finalization</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="window.print()" 
                            class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Complete Record
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-[1600px] mx-auto px-6 py-8 paper-container">
            <!-- FORMAL PRINT HEADER (ONLY VISIBLE ON PAPER) -->
            <div class="print-only mb-10">
                <div class="flex justify-between items-end border-b-4 border-slate-900 pb-6">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter uppercase">{{ config('app.name', 'SalamatDoc') }}</h1>
                        <p class="text-sm font-bold text-slate-600">SalamatDoc Family Clinic</p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $consultation->doctor->clinic_address ?? 'Aparente St. Purok Malakas, G.S.C' }} • 
                            {{ $consultation->doctor->email }} • 
                            {{ $consultation->doctor->contact_number ?? '+63 (02) 888-0000' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-black text-slate-900 uppercase">Consultation Summary</h2>
                        <p class="text-xs text-slate-500 font-bold">Documented on: {{ $consultation->consultation_date->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start justify-center side-by-side-pane">
                
                <!-- LEFT PANE: CLINICAL SUMMARY -->
                <div class="w-full lg:w-[800px] flex-shrink-0 left-pane">
                    <!-- CLINICAL INSIGHTS HEADER -->
                    <div class="clinical-card mb-8 overflow-hidden shadow-xl no-print-shadow border-none">
                        <div class="clinical-header p-8 text-white">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="soap-tag bg-blue-500 text-white">CASE FILE</span>
                                        <span class="text-xs font-mono text-slate-400">ID: #{{ str_pad($consultation->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <h2 class="text-2xl font-black tracking-tighter">{{ $consultation->patient->last_name }}, {{ $consultation->patient->first_name }}</h2>
                                    <p class="text-slate-400 font-medium text-xs">
                                        {{ $consultation->patient->age }}Y / {{ ucfirst($consultation->patient->gender) }} • DOB: {{ $consultation->patient->date_of_birth ? $consultation->patient->date_of_birth->format('M d, Y') : '---' }}
                                    </p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/10 text-right min-w-[180px]">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Primary Diagnosis</p>
                                    <p class="text-base font-bold text-white leading-tight">
                                        {{ $consultation->diagnoses[0]['description'] ?? 'Pending Assessment' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QUICK VITALS BAR -->
                        <div class="bg-white border-b border-slate-100 p-4 grid grid-cols-2 md:grid-cols-5 gap-4">
                            @php
                                $vitals = [
                                    ['label' => 'Temp', 'val' => $consultation->temperature, 'unit' => '°C', 'icon' => 'M9 19c-1.104 0-2-.896-2-2V5c0-1.104.896-2 2-2s2 .896 2 2v12c0 1.104-.896 2-2 2z'],
                                    ['label' => 'BP', 'val' => $consultation->blood_pressure, 'unit' => '', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                    ['label' => 'Pulse', 'val' => $consultation->pulse_rate, 'unit' => 'bpm', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                                    ['label' => 'SpO2', 'val' => $consultation->spo2, 'unit' => '%', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                                    ['label' => 'Weight', 'val' => $consultation->weight, 'unit' => 'kg', 'icon' => 'M3 6l3 1']
                                ];
                            @endphp
                            @foreach($vitals as $v)
                                @if($v['val'])
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-slate-50 rounded text-slate-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $v['icon'] ?? 'M13 10V3L4 14h7v7l9-11h-7z' }}"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">{{ $v['label'] }}</p>
                                        <p class="text-xs font-black text-slate-900">{{ $v['val'] }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- CLINICAL SECTIONS -->
                    <div class="space-y-6">
                        <section class="clinical-card p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="soap-tag bg-blue-100 text-blue-700">SUBJECTIVE</span>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">History</h3>
                            </div>
                            <div class="text-sm text-slate-700 whitespace-pre-wrap font-serif italic border-l-2 border-slate-200 pl-4 py-1">
                                {{ $consultation->symptom_notes_final ?? $consultation->symptom_notes_manual ?? 'No subjective notes.' }}
                            </div>
                        </section>

                        <section class="clinical-card p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="soap-tag bg-emerald-100 text-emerald-700">OBJECTIVE</span>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Examination</h3>
                            </div>
                            <p class="text-sm text-slate-700 whitespace-pre-wrap font-mono bg-slate-50 p-4 rounded-lg">
                                {{ $consultation->examination_notes ?: 'Examination completed.' }}
                            </p>
                        </section>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 soap-grid-print">
                            <section class="clinical-card p-6 shadow-sm print-no-mb">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="soap-tag bg-purple-100 text-purple-700">ASSESSMENT</span>
                                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Impression</h3>
                                </div>
                                <div class="space-y-2">
                                    @forelse($consultation->diagnoses ?? [] as $d)
                                        <div class="p-2 rounded border {{ $d['is_primary'] ? 'bg-purple-50 border-purple-100' : 'bg-slate-50 border-slate-100' }}">
                                            <p class="text-xs font-bold text-slate-900">{{ $d['description'] }}</p>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400 italic">No diagnoses.</p>
                                    @endforelse
                                </div>
                            </section>

                            <section class="clinical-card p-6 shadow-sm print-no-mb">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="soap-tag bg-orange-100 text-orange-700">PLAN</span>
                                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Treatment</h3>
                                </div>
                                <div class="space-y-2">
                                    @forelse($consultation->prescriptions ?? [] as $p)
                                        <div class="text-xs border-b border-slate-100 pb-2 last:border-0">
                                            <p class="font-bold text-slate-900">{{ $p['medicine_name'] }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $p['dosage'] }}</p>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400 italic">No prescriptions.</p>
                                    @endforelse
                                </div>
                            </section>
                        </div>

                        <!-- SIGNATURE BLOCK -->
                        <div class="mt-8 pt-8 border-t border-slate-200 flex justify-between items-end">
                            <div class="max-w-[300px]">
                                <p class="text-[10px] text-slate-500 leading-tight italic">
                                    Authorized via SalamatDoc Secure Interface. 
                                    @if($consultation->doctor->license_number)
                                        License No: {{ $consultation->doctor->license_number }}
                                    @else
                                        License No: PRC-000000 (Demo Mode)
                                    @endif
                                </p>
                            </div>
                            <div class="text-center w-64">
                                <div class="h-14 flex items-center justify-center mb-1">
                                    @if($consultation->isCompleted())
                                        <span class="font-serif italic text-3xl text-slate-900 opacity-90" style="font-family: 'Dancing Script', cursive;">
                                            {{ $consultation->doctor->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="border-t-2 border-slate-900 pt-2">
                                    <p class="text-sm font-black text-slate-900">Dr. {{ $consultation->doctor->name }}</p>
                                    <p class="text-[9px] text-slate-500 uppercase font-bold tracking-tighter">
                                        Attending Physician • {{ $consultation->doctor->specialization ?? 'Practitioner' }}
                                    </p>
                                    @if($consultation->doctor->license_number)
                                        <p class="text-[8px] text-slate-400 font-bold">PRC: {{ $consultation->doctor->license_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANE: REFERRAL ATTACHMENT -->
                @if($consultation->referral)
                    <div class="w-full lg:w-[600px] flex-shrink-0 right-pane print:mt-12 print:page-break">
                        <div class="flex items-center justify-between mb-4 print:hidden">
                            <div class="flex items-center gap-2">
                                <span class="p-1.5 bg-indigo-600 text-white rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Formal Referral Attachment</h3>
                            </div>
                        </div>

                        <div class="bg-white w-full shadow-2xl p-[15mm] relative flex flex-col font-serif text-slate-900 clinical-card border-none">
                            <div class="flex justify-between items-start border-b border-slate-900 pb-4 mb-8">
                                <div class="text-left font-sans">
                                    <h1 class="text-xl font-black tracking-tighter uppercase">Medical Referral</h1>
                                    <p class="text-[8px] text-slate-500">Ref No: REF-{{ $consultation->id }}</p>
                                </div>
                                <div class="text-right font-sans">
                                    <p class="text-xs font-bold">{{ $consultation->doctor->name }}</p>
                                    <p class="text-[8px] text-slate-500">{{ date('F d, Y') }}</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-1">Recipient specialist:</p>
                                    <p class="text-sm font-bold">{{ $consultation->referral->receiving_provider_name }}</p>
                                    <p class="text-xs text-slate-600">{{ $consultation->referral->receiving_specialty }}</p>
                                </div>

                                <div class="border-l-2 border-slate-100 pl-4 py-1">
                                    <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Reason for referral:</p>
                                    <p class="text-sm leading-relaxed italic text-slate-800">
                                        {{ $consultation->referral->reason_for_referral }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Clinical Context:</p>
                                    <div class="text-[11px] leading-relaxed text-slate-600">
                                        {{ $consultation->referral->medical_history_summary ?: 'Consult primary dashboard for full history.' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-10 flex justify-end">
                                <div class="text-center w-56">
                                    <div class="h-12 flex items-center justify-center mb-1">
                                        @if($consultation->isCompleted())
                                            <span class="font-serif italic text-2xl text-slate-900 opacity-90" style="font-family: 'Dancing Script', cursive;">
                                                {{ $consultation->doctor->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="border-t border-slate-900 pt-2">
                                        <p class="text-xs font-bold">Dr. {{ $consultation->doctor->name }}</p>
                                        <p class="text-[7px] text-slate-500 uppercase tracking-widest font-bold">
                                            Referring Physician • {{ $consultation->doctor->specialization ?? 'Practitioner' }}
                                        </p>
                                        @if($consultation->doctor->license_number)
                                            <p class="text-[6px] text-slate-400 font-bold">PRC: {{ $consultation->doctor->license_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 text-[10px] text-slate-400 italic text-center print:hidden">System will auto-break page for official printing.</p>
                    </div>
                @endif
            </div>

            <!-- ACTION BAR -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4 print:hidden shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-40">
                <div class="max-w-[1600px] mx-auto flex justify-between items-center px-6">
                    <a href="{{ route('consultations.show', $consultation) }}" 
                       class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/></svg>
                        Edit Records
                    </a>

                    @if(!$consultation->isCompleted())
                        <form action="{{ route('consultations.finalize', $consultation) }}" method="POST" 
                              onsubmit="return confirm('Authorize and finalize this medical record?');">
                            @csrf
                            <button type="submit" 
                                    class="px-10 py-3 bg-emerald-600 text-white rounded-xl font-black text-sm shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition-all flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Finalize & Sign Record
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-4">
                            <div class="px-6 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                Record Authorized
                            </div>
                            <a href="{{ route('doctor.billing.create', $consultation) }}" 
                               class="px-8 py-2.5 bg-slate-900 text-white rounded-xl font-black text-sm shadow-xl hover:bg-slate-800 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Proceed to Billing
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>
</html>
