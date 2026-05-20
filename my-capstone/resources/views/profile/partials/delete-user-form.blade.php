<section class="space-y-6">
    <header class="mb-6 pb-4 border-b border-red-100">
        <h2 class="text-lg font-black text-red-600 uppercase tracking-widest">
            {{ __('Account Termination') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-red-400 uppercase tracking-widest">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 bg-red-50 text-red-600 rounded-xl font-black text-sm border border-red-200 shadow-sm hover:bg-red-600 hover:text-white transition-all active:scale-95 uppercase tracking-widest"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm font-medium text-slate-500 mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all outline-none"
                    placeholder="{{ __('Password') }}"
                />
                @error('password', 'userDeletion')
                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all uppercase tracking-widest">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-black text-sm shadow-xl shadow-red-200 hover:bg-red-700 transition-all active:scale-95 uppercase tracking-widest">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
