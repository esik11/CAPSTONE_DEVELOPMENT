<section>
    <header class="mb-6 pb-4 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">
            {{ __('Security Validation') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-sm shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest">
                {{ __('Update Security Key') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-black text-emerald-500 uppercase tracking-widest"
                >{{ __('Secured.') }}</p>
            @endif
        </div>
    </form>
</section>
