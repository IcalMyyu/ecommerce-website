<x-app-layout>

    <!-- Cart Hero Section -->
    <section class="furni-green pt-24 pb-32 px-4 md:px-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-0">
                Cart
            </h1>
        </div>
    </section>

    <!-- Cart Table Section -->
    <section x-data="{ showAddressModal: false, showEmptyModal: false }" class="py-24 px-4 md:px-20 max-w-7xl mx-auto position-relative">
        <div class="overflow-x-auto bg-white">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="border-b-2 border-gray-300">
                        <th class="pb-6 font-semibold text-gray-600 text-center">Gambar</th>
                        <th class="pb-6 font-semibold text-gray-600">Produk</th>
                        <th class="pb-6 font-semibold text-gray-600">Harga</th>
                        <th class="pb-6 font-semibold text-gray-600 text-center">Kuantitas</th>
                        <th class="pb-6 font-semibold text-gray-600">Total</th>
                        <th class="pb-6 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="item in $store.cart.items" :key="item.id">
                        <tr class="border-b border-gray-100">
                            <!-- Gambar -->
                            <td class="py-6">
                                <div class="h-32 w-32 mx-auto overflow-hidden rounded-2xl border border-gray-200 flex items-center justify-center p-3 shadow-sm">
                                    <img :src="item.img" class="max-h-full max-w-full object-contain drop-shadow-md">
                                </div>
                            </td>
                            <!-- Produk -->
                            <td class="py-6 font-bold text-[#2f2f2f] text-lg" x-text="item.name"></td>
                            <!-- Harga -->
                            <td class="py-6 font-bold text-gray-800 text-md" x-text="'Rp. ' + item.price.toLocaleString('id-ID')"></td>
                            <!-- Kuantitas -->
                            <td class="py-6 text-center">
                                <div class="inline-flex items-center space-x-3">
                                    <button @click="$store.cart.updateQuantity(item.id, -1)" class="font-black text-gray-500 hover:text-black focus:outline-none px-2">&minus;</button>
                                    <div class="bg-gray-200/80 rounded-md px-5 py-2 text-md font-bold text-[#2f2f2f]" x-text="item.quantity"></div>
                                    <button @click="$store.cart.updateQuantity(item.id, 1)" class="font-black text-gray-500 hover:text-black focus:outline-none px-2">&plus;</button>
                                </div>
                            </td>
                            <!-- Total -->
                            <td class="py-6 font-bold text-[#2f2f2f] text-md" x-text="'Rp. ' + (item.price * item.quantity).toLocaleString('id-ID')"></td>
                            <!-- Aksi -->
                            <td class="py-6">
                                <button @click="$store.cart.remove(item.id)" class="bg-[#ff4040] text-white px-6 py-2 rounded-full text-sm font-semibold hover:bg-red-600 transition shadow-md">Hapus</button>
                            </td>
                        </tr>
                    </template>
                    <!-- Empty State -->
                    <tr x-show="$store.cart.items.length === 0">
                        <td colspan="6" class="text-center py-20">
                            <p class="text-gray-500 font-medium text-lg mb-4">Keranjang masih kosong.</p>
                            <a href="{{ route('shop') }}" class="inline-block px-8 py-3 bg-[#3b5d50] text-white rounded-full font-bold hover:bg-black transition">Mulai Belanja</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Checkout Button Area -->
        <div class="mt-16 flex justify-center">
            @php
                $hasAddress = auth()->check() && auth()->user()->addresses()->exists() ? 'true' : 'false';
            @endphp
            <button @click="$store.cart.items.length === 0 ? showEmptyModal = true : (!{{ $hasAddress }} ? showAddressModal = true : window.location.href='{{ route('checkout.index') }}')" class="bg-[#2f2f2f] text-white px-16 py-4 rounded-full font-bold hover:bg-black transition shadow-xl text-lg">
                Checkout
            </button>
        </div>

        <!-- Address Warning Modal -->
        <div x-show="showAddressModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showAddressModal = false" x-transition.opacity></div>
            
            <!-- Dialog -->
            <div class="relative bg-white rounded-xl shadow-2xl p-10 max-w-md w-full mx-4 text-center z-10"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                
                <p class="text-gray-800 font-medium mb-8 leading-relaxed">
                    Kamu belum menambahkan alamat<br>masukkan alamat terlebih dahulu!
                </p>

                <a href="{{ route('address.create') }}" class="inline-block bg-[#005c4b] text-white px-8 py-3 rounded-md font-semibold hover:bg-[#004639] transition shadow text-sm">
                    Tambah Alamat
                </a>
            </div>
        </div>

        <!-- Empty Cart Warning Modal -->
        <div x-show="showEmptyModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showEmptyModal = false" x-transition.opacity></div>
            
            <!-- Dialog -->
            <div class="relative bg-white rounded-xl shadow-2xl p-10 max-w-md w-full mx-4 text-center z-10"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <p class="text-gray-800 font-bold text-lg mb-2">Ups, Keranjangmu Masih Kosong!</p>
                <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                    Kamu harus menambahkan produk terlebih dahulu sebelum melakukan checkout.
                </p>

                <div class="flex flex-col gap-3">
                    <a href="{{ route('shop') }}" class="inline-block bg-[#3b5d50] text-white px-8 py-3 rounded-md font-semibold hover:bg-[#004639] transition shadow text-sm w-full">
                        Mulai Belanja
                    </a>
                    <button @click="showEmptyModal = false" class="inline-block bg-white text-gray-500 border border-gray-300 px-8 py-3 rounded-md font-semibold hover:bg-gray-50 transition w-full text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
