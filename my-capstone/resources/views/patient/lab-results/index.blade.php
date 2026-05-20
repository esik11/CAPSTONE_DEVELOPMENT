<x-patient-layout>
    <x-slot name="title">Lab Results & Diagnostics</x-slot>
    <x-slot name="subtitle">Upload and manage your laboratory and imaging results</x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Upload Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 tracking-tight">Upload New Result</h3>
                    </div>

                    <form action="{{ route('patient.lab-results.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Test Name</label>
                            <input type="text" name="test_name" required placeholder="e.g. Complete Blood Count, X-ray"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                                   value="{{ old('test_name') }}">
                            @error('test_name')
                                <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Category</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="laboratory" class="peer hidden" checked>
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Laboratory
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="imaging" class="peer hidden">
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all">
                                        Imaging
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="category" value="others" class="peer hidden">
                                    <div class="px-3 py-2 rounded-lg border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-500 text-center uppercase tracking-wider peer-checked:border-violet-500 peer-checked:bg-violet-50 peer-checked:text-violet-700 transition-all">
                                        Others
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Notes (Optional)</label>
                            <textarea name="results_findings" rows="3" placeholder="Any relevant findings or notes..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all resize-none">{{ old('results_findings') }}</textarea>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Attach File</label>
                            <div class="relative">
                                <input type="file" name="attachment" id="attachment" required accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 bg-gray-50 border border-dashed border-gray-300 rounded-xl text-sm font-medium text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-emerald-50 file:text-emerald-700 file:uppercase file:tracking-wider hover:file:bg-emerald-100 transition-all cursor-pointer">
                            </div>
                            <p class="text-[9px] text-gray-400 mt-1 font-medium">Accepted: JPG, PNG, PDF — Max 10MB</p>
                            @error('attachment')
                                <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-[0.98]">
                            Upload Result
                        </button>
                    </form>

                    <div class="mt-5 bg-blue-50 p-4 rounded-xl flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-[10px] text-blue-700 font-medium leading-relaxed">
                            Uploaded results will be visible to your doctor during consultations for a complete clinical picture.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Results History -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 tracking-tight">Your Lab Results</h3>
                        </div>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-emerald-200">
                            {{ $labResults->count() }} Records
                        </span>
                    </div>

                    @if($labResults->isEmpty())
                        <div class="p-16 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 5.607A1.063 1.063 0 0120.178 22H3.822a1.063 1.063 0 01-1.024-1.343L4.2 15.3" />
                                </svg>
                            </div>
                            <h4 class="text-gray-900 font-bold tracking-tight">No lab results yet</h4>
                            <p class="text-gray-400 text-xs mt-1 max-w-[280px] mx-auto">Upload your first lab result or diagnostic image using the form on the left.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-50">
                            @foreach($labResults as $result)
                                <div class="p-5 hover:bg-gray-50/50 transition-colors group">
                                    <div class="flex items-center gap-4">
                                        <!-- Category Icon -->
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 
                                            {{ $result->category === 'laboratory' ? 'bg-emerald-50 border border-emerald-100' : ($result->category === 'imaging' ? 'bg-blue-50 border border-blue-100' : 'bg-violet-50 border border-violet-100') }}">
                                            @if($result->category === 'laboratory')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600">
                                                    <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 01-.879 2.121l-2.377 2.377a9.845 9.845 0 015.091 1.013 8.315 8.315 0 005.713.636l.285-.071-3.954-3.955a3 3 0 01-.879-2.121v-5.02a23.614 23.614 0 00-3 0zm4.5.138a.75.75 0 00.093-1.495A24.837 24.837 0 0012 2.25a25.048 25.048 0 00-3.093.191A.75.75 0 009 3.936v4.882a1.5 1.5 0 01-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.471-4.881L15.44 9.879A1.5 1.5 0 0115 8.818V3.936z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif($result->category === 'imaging')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600">
                                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-violet-600">
                                                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Details -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition-colors truncate">{{ $result->test_name }}</h4>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded
                                                    {{ $result->category === 'laboratory' ? 'bg-emerald-50 text-emerald-600' : ($result->category === 'imaging' ? 'bg-blue-50 text-blue-600' : 'bg-violet-50 text-violet-600') }}">
                                                    {{ ucfirst($result->category) }}
                                                </span>
                                                <span class="text-[10px] text-gray-400 font-medium">{{ $result->requested_at->format('M d, Y \a\t g:i A') }}</span>
                                            </div>
                                            @if($result->results_findings)
                                                <p class="text-xs text-gray-500 mt-1.5 line-clamp-1">{{ $result->results_findings }}</p>
                                            @endif
                                        </div>

                                        <!-- Status & Actions -->
                                        <div class="flex items-center gap-3 flex-shrink-0">
                                            <span class="px-2 py-1 text-[9px] font-black uppercase tracking-widest rounded-lg
                                                {{ $result->status === 'resulted' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                                {{ ucfirst($result->status) }}
                                            </span>
                                            @if($result->attachment_path)
                                                <a href="{{ asset('storage/' . $result->attachment_path) }}" target="_blank" 
                                                   class="px-3 py-2 bg-gray-100 hover:bg-emerald-50 text-gray-500 hover:text-emerald-600 text-[9px] font-bold uppercase tracking-widest rounded-lg transition-all">
                                                    View
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-patient-layout>
