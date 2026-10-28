<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-slate-900 leading-tight tracking-tighter uppercase">{{ __('Profile Settings') }}</h2>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">Account & Professional Details</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-[1600px] mx-auto px-6 py-8">
        <div class="max-w-4xl space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(auth()->user()->isDoctor())
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-8">
                        @include('profile.partials.update-clinical-credentials-form')
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-doctor-layout>
