<x-assistant-layout>
    <x-slot name="title">Patient Details</x-slot>
    <x-slot name="subtitle">{{ $patient->first_name }} {{ $patient->last_name }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Header Actions -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('assistant.patients.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-violet-600 font-bold text-xs uppercase tracking-widest transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
                <span>Back to Patients</span>
            </a>
            
            <a href="{{ route('assistant.patients.edit', $patient) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-violet-600 hover:text-white hover:border-violet-600 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.154-1.262a.5.5 0 00.173-.11l9.452-9.452a1.5 1.5 0 00-2.122-2.122L3.33 13.59a.5.5 0 00-.11.173z" />
                    <path d="M16.5 3.5a1.5 1.5 0 012.122 2.122l-1.241 1.241-2.122-2.122L16.5 3.5z" />
                </svg>
                <span>Edit Profile</span>
            </a>
        </div>

        <!-- Main Info Card -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="w-32 h-32 rounded-2xl bg-violet-50 border-2 border-violet-100 flex items-center justify-center text-violet-600 font-bold text-4xl shadow-sm flex-shrink-0">
                        {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                    </div>
                    <div class="text-center md:text-left flex-1">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ $patient->first_name }} {{ $patient->last_name }}</h2>
                            <span class="px-3 py-1 bg-violet-50 text-violet-600 border border-violet-100 rounded-full text-[10px] font-bold uppercase tracking-widest">Patient</span>
                        </div>
                        <p class="text-gray-500 font-medium mb-6 flex items-center justify-center md:justify-start gap-2">
                            <span>{{ $age }} Years Old</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="uppercase tracking-widest text-[10px] font-bold text-gray-400">{{ $patient->gender }}</span>
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2">Contact Details</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3 group">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-violet-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-violet-500 transition-colors">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700">{{ $patient->phone_number }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 group">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-violet-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-violet-500 transition-colors">
                                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1 1 0 00.918 0L19 7.161V6a2 2 0 00-2-2H3z" />
                                                    <path d="M19 8.839l-7.77 3.885a2.002 2.002 0 01-1.83 0L1.769 8.839V15a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700">{{ $patient->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2">System Info</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                                                    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v10.5A2.75 2.75 0 0115.25 20H4.75A2.75 2.75 0 012 17.25V6.75A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v8.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-8.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">DOB</p>
                                                <p class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if($patient->philhealth_number)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-400">
                                                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">PhilHealth</p>
                                                    <p class="text-xs font-bold text-gray-700">{{ $patient->philhealth_number }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Address Section -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 tracking-tight">Residential Address</h3>
                </div>
                
                @if($patient->region || $patient->province || $patient->city || $patient->barangay)
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-sm font-bold text-gray-800 leading-relaxed">
                                {{ $patient->barangay ? $patient->barangay . ', ' : '' }}
                                {{ $patient->city ? $patient->city . ', ' : '' }}
                                {{ $patient->province ? $patient->province . ', ' : '' }}
                                {{ $patient->region ?? '' }}
                                {{ $patient->zip_code ? ' ' . $patient->zip_code : '' }}
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-gray-400 italic">No address information provided.</p>
                @endif
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 tracking-tight">Emergency Contact</h3>
                </div>

                @if($patient->emergency_first_name || $patient->emergency_last_name)
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Name & Relationship</p>
                            <p class="text-sm font-bold text-gray-800">{{ $patient->emergency_first_name }} {{ $patient->emergency_last_name }} 
                                <span class="text-xs text-red-500 ml-1">({{ $patient->emergency_relationship ?? 'Unknown' }})</span>
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Home Phone</p>
                                <p class="text-xs font-bold text-gray-700">{{ $patient->emergency_home_phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Work Phone</p>
                                <p class="text-xs font-bold text-gray-700">{{ $patient->emergency_work_phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-gray-400 italic">No emergency contact provided.</p>
                @endif
            </div>
        </div>
    </div>
</x-assistant-layout>
