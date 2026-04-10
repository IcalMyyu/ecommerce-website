<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
            {{ __('Keamanan Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="max-w-xl space-y-6">
            <div>
                <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-bold text-gray-700 mb-1" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#3b5d50] focus:ring-[#3b5d50] transition" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-bold text-gray-700 mb-1" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#3b5d50] focus:ring-[#3b5d50] transition" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-bold text-gray-700 mb-1" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#3b5d50] focus:ring-[#3b5d50] transition" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <x-primary-button class="bg-[#3b5d50] hover:bg-black rounded-lg border-none cursor-pointer">{{ __('Perbarui Kata Sandi') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Berhasil diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>
