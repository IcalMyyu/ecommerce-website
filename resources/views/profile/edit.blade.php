<x-app-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Akun Saya</h1>
                <p class="mt-2 text-sm text-gray-600">Halo, {{ $user->name }}. Di sini Anda dapat mengelola profil, alamat pengiriman, dan keamanan akun Anda.</p>
            </div>

            <div class="space-y-10">
                
                {{-- 1. Profile Information --}}
                <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- 2. Alamat Pengiriman --}}
                <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Alamat Pengiriman</h2>
                                <p class="text-sm text-gray-500 mt-1">Daftar alamat yang Anda gunakan untuk tujuan pengiriman barang.</p>
                            </div>
                            <a href="{{ route('address.create') }}" class="inline-flex items-center px-4 py-2 bg-[#3b5d50] border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-black transition no-underline">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Tambah Alamat
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($user->addresses as $address)
                                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-5 border {{ $address->is_default ? 'border-[#3b5d50] bg-[#f9fdfc]' : 'border-gray-100 bg-white' }} rounded-lg gap-6">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="font-bold text-gray-900 text-lg">{{ $address->recipient_name }}</span>
                                            @if($address->is_default)
                                                <span class="bg-[#3b5d50] text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">Utama</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500 font-medium mb-2">{{ $address->phone_number }}</p>
                                        <p class="text-sm text-gray-600 leading-relaxed max-w-2xl font-medium">
                                            {{ $address->full_address }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('address.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest hover:border-[#3b5d50] hover:text-[#3b5d50] transition no-underline shadow-sm">
                                            Ubah Alamat
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                    <p class="text-sm font-medium text-gray-500">Belum ada alamat pengiriman yang ditambahkan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- 3. Update Password --}}
                <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- 4. Delete Account --}}
                <div class="bg-white shadow-sm border border-red-100 rounded-xl overflow-hidden">
                    <div class="bg-red-50 px-6 py-3 border-b border-red-50">
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">⚠️ Area Berbahaya</p>
                    </div>
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
