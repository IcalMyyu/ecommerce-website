<section class="space-y-6">
    <header class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua data dan sumber daya di dalamnya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data apa pun yang ingin Anda pertahankan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl px-6 py-3 font-bold"
    >{{ __('Hapus Akun Saja') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-4">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                {{ __('Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mb-8">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition shadow-sm"
                    placeholder="{{ __('Kata Sandi Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-4 py-2 font-bold bg-white border-gray-300 text-gray-700 hover:bg-gray-50 uppercase text-xs tracking-widest transition shadow-sm">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-4 py-2 font-bold bg-red-600 text-white hover:bg-red-700 uppercase text-xs tracking-widest transition shadow-sm border-none bg-transparent cursor-pointer">
                    {{ __('Konfirmasi Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
