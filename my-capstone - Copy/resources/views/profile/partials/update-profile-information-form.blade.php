<section>
    <header class="mb-6 pb-4 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="first_name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('First Name') }}</label>
                <div class="relative">
                    @if(auth()->user()->isDoctor())
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-sm font-black text-slate-400">Dr.</span>
                        </div>
                        <input id="first_name" name="first_name" type="text" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('first_name', $user->first_name) }}" required autofocus />
                    @else
                        <input id="first_name" name="first_name" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('first_name', $user->first_name) }}" required autofocus />
                    @endif
                </div>
                @error('first_name')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="middle_name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Middle Name') }} <span class="text-slate-300 font-medium">(Optional)</span></label>
                <input id="middle_name" name="middle_name" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('middle_name', $user->middle_name) }}" />
                @error('middle_name')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="last_name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Last Name') }}</label>
                <input id="last_name" name="last_name" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('last_name', $user->last_name) }}" required />
                @error('last_name')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-sm shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest">
                {{ __('Save Account Details') }}
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
