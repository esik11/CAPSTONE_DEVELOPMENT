<x-assistant-layout>
    <x-slot name="title">Walk-in Triage</x-slot>
    <x-slot name="subtitle">Record vital signs before check-in</x-slot>

    <div class="max-w-[1200px] mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('assistant.appointments.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Schedule
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">{{ $appointment->patient->full_name }}</h2>
                        <p class="text-xs font-bold text-gray-500 mt-1 uppercase tracking-widest">Patient ID: {{ str_pad($appointment->patient->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-violet-600">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Scheduled Time</p>
                    </div>
                </div>
            </div>

            <!-- Triage Form -->
            <div class="p-8">
                <form action="{{ route('assistant.appointments.storeTriage', $appointment) }}" method="POST">
                    @csrf
                    
                    <div class="mb-8">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            Vital Signs Assessment
                        </h3>
                        <p class="text-xs text-gray-500">Please accurately record the patient's current vital signs. This data will be automatically forwarded to Dr. {{ $appointment->doctor->last_name }}'s consultation dashboard.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Blood Pressure -->
                        <div>
                            <label for="blood_pressure" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Blood Pressure</label>
                            <div class="relative">
                                <input type="text" id="blood_pressure" name="blood_pressure" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="120/80" value="{{ old('blood_pressure') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">mmHg</span>
                                </div>
                            </div>
                            @error('blood_pressure') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Pulse Rate -->
                        <div>
                            <label for="pulse_rate" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Heart Rate</label>
                            <div class="relative">
                                <input type="number" id="pulse_rate" name="pulse_rate" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="75" value="{{ old('pulse_rate') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">bpm</span>
                                </div>
                            </div>
                            @error('pulse_rate') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Temperature -->
                        <div>
                            <label for="temperature" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Temperature</label>
                            <div class="relative">
                                <input type="number" step="0.1" id="temperature" name="temperature" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="36.5" value="{{ old('temperature') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">°C</span>
                                </div>
                            </div>
                            @error('temperature') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Respiratory Rate -->
                        <div>
                            <label for="respiratory_rate" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Respiratory Rate</label>
                            <div class="relative">
                                <input type="number" id="respiratory_rate" name="respiratory_rate" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="16" value="{{ old('respiratory_rate') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">/min</span>
                                </div>
                            </div>
                            @error('respiratory_rate') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Weight</label>
                            <div class="relative">
                                <input type="number" step="0.1" id="weight" name="weight" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="65.5" value="{{ old('weight') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">kg</span>
                                </div>
                            </div>
                            @error('weight') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Height -->
                        <div>
                            <label for="height" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Height</label>
                            <div class="relative">
                                <input type="number" id="height" name="height" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-violet-500 transition-all outline-none" placeholder="170" value="{{ old('height') }}">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">cm</span>
                                </div>
                            </div>
                            @error('height') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                        <a href="{{ route('assistant.appointments.index') }}" class="px-8 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-widest hover:text-gray-900 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-10 py-3 bg-violet-600 text-white rounded-xl font-black text-sm shadow-xl shadow-violet-200 hover:bg-violet-700 transition-all active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Complete Triage & Check-In
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-assistant-layout>
