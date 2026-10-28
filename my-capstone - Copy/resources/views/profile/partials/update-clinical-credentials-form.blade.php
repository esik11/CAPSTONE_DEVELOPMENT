<section>
    <header class="mb-6 pb-4 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">
            {{ __('Clinical Credentials') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            {{ __("Update your professional medical credentials to ensure legitimacy in clinical documents.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Specialization -->
            <div>
                <label for="specialization" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Medical Specialization') }}</label>
                <input id="specialization" name="specialization" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('specialization', $user->specialization) }}" placeholder="e.g. Pediatrician, Surgeon" />
                @error('specialization')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- License Number -->
            <div>
                <label for="license_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('PRC License Number') }}</label>
                <input id="license_number" name="license_number" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('license_number', $user->license_number) }}" placeholder="e.g. 0123456" />
                @error('license_number')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- PTR Number -->
            <div>
                <label for="ptr_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('PTR Number') }}</label>
                <input id="ptr_number" name="ptr_number" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('ptr_number', $user->ptr_number) }}" placeholder="e.g. 9876543A" />
                @error('ptr_number')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- S2 Number -->
            <div>
                <label for="s2_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('S2 License Number (Optional)') }}</label>
                <input id="s2_number" name="s2_number" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('s2_number', $user->s2_number) }}" placeholder="e.g. S2-12345" />
                @error('s2_number')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Number -->
            <div>
                <label for="contact_number" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Professional Contact Number') }}</label>
                <input id="contact_number" name="contact_number" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('contact_number', $user->contact_number) }}" placeholder="e.g. +63 912 345 6789" />
                @error('contact_number')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Clinic Address -->
        <div>
            <label for="clinic_address" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Clinic/Hospital Address') }}</label>
            <textarea id="clinic_address" name="clinic_address" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-slate-900 transition-all outline-none" placeholder="Full clinic address for document headers">{{ old('clinic_address', $user->clinic_address) }}</textarea>
            @error('clinic_address')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-sm shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest">
                {{ __('Save Credentials') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-black text-emerald-500 uppercase tracking-widest"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
