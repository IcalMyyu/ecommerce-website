<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui nama profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 mb-1" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#3b5d50] focus:ring-[#3b5d50] transition" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-gray-700 mb-1" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#3b5d50] focus:ring-[#3b5d50] transition" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800">
                            {{ __('Email Anda belum diverifikasi.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3b5d50]">
                                {{ __('Kirim ulang verifikasi') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('Link verifikasi baru telah dikirim.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <x-primary-button class="bg-[#3b5d50] hover:bg-black rounded-lg border-none cursor-pointer">{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
