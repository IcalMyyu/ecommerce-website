@php
$orderData = [
    'id' => $order->id,
    'status' => $order->status,
    'date' => $order->created_at->toISOString(),
    'bank' => $order->payment_bank,
    'total' => (float) $order->total_amount,
    'shipping_cost' => (float) $order->shipping_cost,
    'address' => $order->address ? [
        'nama' => $order->address->recipient_name,
        'telp' => $order->address->phone_number,
        'alamat' => $order->address->full_address,
    ] : null,
    'items' => $order->items->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->product ? $item->product->name : 'Produk Tidak Ditemukan',
            'price' => (float) $item->price_at_purchase,
            'quantity' => $item->quantity,
            'img' => $item->product ? $item->product->image_url : '',
        ];
    })->values()->all(),
];
@endphp
<x-app-layout>
    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-4 md:px-20" x-data="{ 
        order: {{ json_encode($orderData) }},
        banks: {
            'bca': { name: 'BCA', bg: 'bg-blue-50 text-blue-800' },
            'mandiri': { name: 'Mandiri', bg: 'bg-yellow-50 text-yellow-800' },
            'bni': { name: 'BNI', bg: 'bg-teal-50 text-teal-800' },
            'bri': { name: 'BRI', bg: 'bg-blue-50 text-blue-800' }
        }
    }">
        <div class="max-w-4xl mx-auto" x-show="order">
            
            <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-black mb-6 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Pesanan
            </a>
            
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#3b5d50] to-[#2b443a] text-white p-8 md:p-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-2">
                            <h1 class="text-3xl font-bold">Detail Pesanan</h1>
                            <template x-if="order.status === 'selesai'">
                                <a :href="'/pesanan/' + order.id + '/receipt'" class="bg-[#f9bf29] text-black px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 hover:bg-yellow-400 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Download Struk
                                </a>
                            </template>
                        </div>
                        <p class="text-gray-200 font-mono tracking-wider opacity-90" x-text="order.id"></p>
                    </div>
                    <div class="bg-white text-[#3b5d50] px-6 py-3 rounded-xl font-black text-sm shadow-md tracking-wider border border-[#3b5d50]" x-text="order.status === 'menunggu-konfirmasi' ? 'KONFIRMASI' : order.status.replace('-', ' ').toUpperCase()"></div>
                </div>

                <div class="p-8 md:p-10 space-y-10">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-gray-500 font-medium text-sm mb-2 uppercase tracking-wider">Tanggal Pembelian</h3>
                            <p class="font-bold text-gray-800 text-lg" x-text="new Date(order.date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute:'2-digit'}) + ' WIB'"></p>
                        </div>
                        <div>
                            <h3 class="text-gray-500 font-medium text-sm mb-2 uppercase tracking-wider">Metode Pembayaran</h3>
                            <p class="font-bold text-gray-800 text-lg uppercase" x-text="'Transfer ' + (banks[order.bank] ? banks[order.bank].name : order.bank)"></p>
                        </div>
                    </div>

                    <hr class="border-gray-100 border-2 rounded-full">

                    <!-- Address Block -->
                    <div>
                        <h3 class="text-gray-800 font-bold text-xl mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#f9bf29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Pengiriman
                        </h3>
                        
                        <template x-if="order.address && order.address.nama">
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                <p class="font-bold text-gray-900 text-lg mb-1" x-text="order.address.nama"></p>
                                <p class="text-sm text-gray-500 font-medium mb-4" x-text="order.address.telp"></p>
                                <p class="text-base text-gray-700 leading-relaxed" x-text="order.address.alamat"></p>
                            </div>
                        </template>
                        <template x-if="!order.address || !order.address.nama">
                            <div class="bg-red-50 text-red-600 rounded-2xl p-6 border border-red-100 text-sm italic font-medium">
                                Data alamat pengiriman tidak terekam saat checkout ini dibuat.
                            </div>
                        </template>
                    </div>

                    <hr class="border-gray-100 border-2 rounded-full">

                    <!-- Item List -->
                    <div>
                        <h3 class="text-gray-800 font-bold text-xl mb-6">Daftar Produk</h3>
                        <div class="space-y-4">
                            <template x-for="item in order.items" :key="item.id">
                                <div class="flex items-center space-x-6 p-5 border border-gray-100 rounded-2xl hover:shadow-md transition bg-white group cursor-pointer">
                                    <div class="w-24 h-24 bg-gray-50 rounded-xl flex items-center justify-center p-3">
                                        <img :src="item.img" class="max-w-full max-h-full object-contain mix-blend-multiply group-hover:scale-110 transition duration-300">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 text-lg" x-text="item.name"></h4>
                                        <p class="text-sm font-medium text-gray-500 mt-2 bg-gray-100 inline-block px-3 py-1 rounded-full" x-text="item.quantity + ' Barang x Rp ' + item.price.toLocaleString('id-ID')"></p>
                                    </div>
                                    <div class="text-right pl-4">
                                        <p class="font-black text-xl text-black" x-text="'Rp ' + (item.price * item.quantity).toLocaleString('id-ID')"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Totals Breakdown -->
                    <div class="bg-[#f9fafb] p-8 rounded-3xl border border-gray-100 shadow-inner">
                        <h3 class="text-gray-800 font-bold text-xl mb-6">Rincian Pembayaran</h3>
                        <div class="space-y-4 text-base font-medium text-gray-500 mb-6 pb-6 border-b-2 border-gray-200 border-dashed">
                            <div class="flex justify-between">
                                <span>Total Harga Barang</span>
                                <span class="text-gray-800" x-text="'Rp ' + (order.total - order.shipping_cost).toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Ongkos Kirim</span>
                                <span class="text-gray-800 font-bold" x-text="'Rp ' + order.shipping_cost.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Layanan Aplikasi</span>
                                <span class="text-gray-800">Rp 0</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800 text-2xl">Total Belanja</span>
                            <span class="font-black text-4xl text-[#3b5d50] drop-shadow-sm" x-text="'Rp ' + order.total.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="mt-10 text-center text-gray-500 text-sm font-medium">
                Butuh bantuan dengan detail tagihan pesanan ini? <a href="{{ route('contact') }}" class="text-[#3b5d50] font-black hover:underline px-1">Hubungi Customer Service</a>
            </div>
        </div>
        
        <!-- Error State if missing order -->
        <div class="max-w-3xl mx-auto text-center" x-show="!order" style="display: none;">
            <div class="bg-white p-16 rounded-3xl shadow-sm border border-gray-100">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-2xl font-bold text-gray-800 mb-2">Waduh!</p>
                <p class="text-gray-500 mb-8">Detail pesanan untuk ID <span class="font-mono text-gray-700 bg-gray-100 px-2 rounded">{{ $order->id }}</span> tidak ditemukan dalam memori keranjang Anda.</p>
                <a href="{{ route('orders.index') }}" class="bg-[#3b5d50] text-white py-4 px-10 rounded-xl font-bold hover:shadow-lg transition">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
</x-app-layout>
