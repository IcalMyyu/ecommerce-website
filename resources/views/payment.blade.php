@php
    $orderId = request()->query('order');
    $orderDb = \App\Models\Order::where('id', $orderId)->where('user_id', auth()->id())->first();
    $orderData = $orderDb ? json_encode(['id' => $orderDb->id, 'total' => (float)$orderDb->total_amount, 'shipping_cost' => (float)$orderDb->shipping_cost, 'bank' => $orderDb->payment_bank]) : 'null';
@endphp
<x-app-layout>
    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-4 md:px-20" x-data="{ 
        order: {{ $orderData }},
        showSuccessModal: false,
        get bank() { return this.order ? this.order.bank : 'bca'; },
        copied: false,
        activeTab: 'atm',
        banks: {
            'bca': { name: 'BCA', no: '8077 1234 5678 9012', logoUrl: 'text-[#005faa]', bgText: 'bg-blue-50' },
            'mandiri': { name: 'Mandiri', no: '8965 444 333 222', logoUrl: 'text-[#f4ba3e]', bgText: 'bg-yellow-50' },
            'bni': { name: 'BNI', no: '8801 2233 4455 6677', logoUrl: 'text-[#00605b]', bgText: 'bg-teal-50' },
            'bri': { name: 'BRI', no: '1012 3344 5566 7788', logoUrl: 'text-[#085a97]', bgText: 'bg-blue-50' }
        },
        copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }">
        <div class="max-w-3xl mx-auto space-y-8" x-show="order">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-[#3b5d50] mb-3">Selesaikan Pembayaran</h1>
            </div>

            <!-- Virtual Account / Bank Transfer Info -->
            <div x-show="banks[bank]" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Metode Pembayaran</p>
                        <p class="font-bold text-xl uppercase text-gray-800" x-text="'Transfer ' + banks[bank].name"></p>
                    </div>
                    <div class="h-14 px-4 rounded-xl flex items-center justify-center font-black text-2xl italic tracking-tighter shadow-sm border border-gray-100" :class="banks[bank].bgText + ' ' + banks[bank].logoUrl" x-text="banks[bank].name">
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-sm text-gray-500 mb-2">Nomor Virtual Account</p>
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <p class="font-mono text-2xl md:text-3xl font-bold tracking-wider text-black" x-text="banks[bank].no"></p>
                        <button @click="copyToClipboard(banks[bank].no)" class="text-[#3b5d50] font-semibold hover:opacity-80 transition flex items-center space-x-2 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm ml-4">
                            <span x-text="copied ? 'Tersalin!' : 'Salin'" class="hidden md:inline"></span>
                            <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <svg x-show="copied" style="display: none;" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-6 pt-6">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-gray-500 font-medium text-sm md:text-base">Subtotal Produk</p>
                        <p class="font-bold text-gray-800 text-sm md:text-base">Rp <span x-text="(order.total - order.shipping_cost).toLocaleString('id-ID')"></span></p>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-gray-500 font-medium text-sm md:text-base">Biaya Pengiriman</p>
                        <p class="font-bold text-gray-800 text-sm md:text-base">Rp <span x-text="order.shipping_cost.toLocaleString('id-ID')"></span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                        <p class="font-bold text-3xl md:text-4xl text-[#3b5d50]">
                            Rp <span x-text="order.total.toLocaleString('id-ID')"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cara Pembayaran / Instructions -->
            <div x-show="banks[bank]" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-lg mb-6">Cara Pembayaran</h3>
                
                <div class="flex space-x-6 border-b border-gray-200 mb-6 font-medium overflow-x-auto pb-1">
                    <button @click="activeTab = 'atm'" class="pb-3 border-b-2 transition whitespace-nowrap" :class="activeTab === 'atm' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">ATM <span x-text="banks[bank].name"></span></button>
                    <button @click="activeTab = 'mbanking'" class="pb-3 border-b-2 transition whitespace-nowrap" :class="activeTab === 'mbanking' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">m-Banking <span x-text="banks[bank].name"></span></button>
                    <button @click="activeTab = 'ibanking'" class="pb-3 border-b-2 transition whitespace-nowrap" :class="activeTab === 'ibanking' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Internet Banking <span x-text="banks[bank].name"></span></button>
                </div>

                <!-- ATM Instructions -->
                <div x-show="activeTab === 'atm'" class="space-y-4 text-gray-700">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Masukkan Kartu ATM dan PIN Anda</li>
                        <li>Pilih menu <b>Transaksi Lainnya</b> > <b>Transfer</b></li>
                        <li>Pilih <b>Ke Rekening Virtual Account</b></li>
                        <li>Masukkan Nomor Virtual Account <b x-text="banks[bank].no" class="font-mono"></b></li>
                        <li>Periksa informasi yang tertera di layar. Pastikan Nama dan Jumlah Total pembayaran benar. Pilih <b>Benar</b> / <b>Ya</b></li>
                        <li>Simpan struk ATM sebagai bukti pembayaran Anda</li>
                    </ol>
                </div>

                <!-- m-Banking Instructions -->
                <div x-show="activeTab === 'mbanking'" style="display: none;" class="space-y-4 text-gray-700">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Buka aplikasi m-Banking di ponsel Anda lalu login</li>
                        <li>Pilih menu <b>Transfer</b> > <b>Virtual Account</b></li>
                        <li>Masukkan Nomor Virtual Account <b x-text="banks[bank].no" class="font-mono"></b></li>
                        <li>Periksa rincian tagihan (Nama dan Total Tagihan)</li>
                        <li>Masukkan PIN m-Banking untuk konfirmasi</li>
                        <li>Simpan screenshot bukti transfer jika berhasil</li>
                    </ol>
                </div>

                <!-- Internet Banking Instructions -->
                <div x-show="activeTab === 'ibanking'" style="display: none;" class="space-y-4 text-gray-700">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Login ke website Internet Banking <span x-text="banks[bank].name"></span></li>
                        <li>Pilih menu <b>Transfer</b> / <b>Pembayaran Tagihan</b> > <b>Virtual Account</b></li>
                        <li>Masukkan Nomor Virtual Account <b x-text="banks[bank].no" class="font-mono"></b></li>
                        <li>Cek detail rincian pembayaran sebelum lanjut</li>
                        <li>Masukkan kode Token (jika diminta) / PIN untuk otentikasi</li>
                        <li>Simpan bukti transaksi elektronik yang muncul</li>
                    </ol>
                </div>

            </div>

            <!-- Action buttons -->
            <div class="flex justify-between items-center mt-10 mb-10 pt-6">
                <a href="{{ route('checkout.index') }}?step=2" class="text-[#3b5d50] border-2 border-[#3b5d50] font-bold py-3 px-10 rounded-lg hover:bg-gray-50 transition">
                    Kembali
                </a>
                <button @click="showSuccessModal = true" class="bg-[#3b5d50] text-white py-4 px-10 rounded-lg font-bold hover:shadow-lg transition text-center outline-none focus:outline-none">
                    Checkout Produk
                </button>
            </div>

        </div>
        
        <!-- Success Modal -->
        <div x-show="showSuccessModal" style="display: none;" class="relative z-50">
            <!-- Modal Overlay -->
            <div x-show="showSuccessModal" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-40" @click="showSuccessModal = false"></div>
            
            <!-- Modal Content -->
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 pointer-events-none">
                <div x-show="showSuccessModal" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 scale-90 translate-y-8" 
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                     x-transition:leave="transition ease-in duration-200" 
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                     x-transition:leave-end="opacity-0 scale-90 translate-y-8" 
                     class="bg-white rounded-[2rem] p-8 md:p-12 max-w-md w-full shadow-2xl mx-auto text-center relative pointer-events-auto"
                     @click.away="showSuccessModal = false">
                     
                    <!-- Icon -->
                    <div class="w-24 h-24 bg-green-50 border-[6px] border-white shadow-md rounded-full flex items-center justify-center mx-auto mb-6 mt-[-4rem]">
                        <svg class="w-12 h-12 text-[#3b5d50]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    
                    <h2 class="text-3xl font-black text-gray-800 mb-3 tracking-tight">Berhasil!</h2>
                    <p class="text-gray-500 mb-8 leading-relaxed font-medium">Instruksi pembayaran telah diterima. Silakan cek status pesanan atau kembali ke halaman utama.</p>
                    
                    <!-- Modal Actions -->
                    <div class="space-y-3">
                        <a href="{{ route('orders.index') }}" @click="$store.cart.items = []; $store.cart.save();" class="block w-full bg-[#3b5d50] text-white font-bold py-4 rounded-xl hover:shadow-lg hover:bg-black transition">
                            Cek Status Pesanan
                        </a>
                        <a href="{{ route('home') }}" @click="$store.cart.items = []; $store.cart.save();" class="block w-full bg-white text-gray-500 font-bold py-3.5 rounded-xl hover:bg-gray-50 hover:text-gray-800 transition">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Error State if missing order -->
        <div class="max-w-3xl mx-auto text-center" x-show="!order" style="display: none;">
            <p class="text-xl text-gray-500 mb-6">Pesanan tidak ditemukan.</p>
            <a href="{{ route('shop') }}" class="bg-[#3b5d50] text-white py-3 px-8 rounded-lg font-bold hover:shadow-lg transition">Mulai Belanja</a>
        </div>
    </div>
</x-app-layout>
