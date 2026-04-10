<x-app-layout>
    @php
        $statusCounts = [
            'semua' => $orders->count(),
            'belum-bayar' => $orders->where('status', 'belum-bayar')->count(),
            'menunggu-konfirmasi' => $orders->whereIn('status', ['menunggu-konfirmasi', 'dikonfirmasi'])->count(),
            'dikemas' => $orders->where('status', 'dikemas')->count(),
            'dikirim' => $orders->where('status', 'dikirim')->count(),
            'selesai' => $orders->where('status', 'selesai')->count(),
        ];
    @endphp
    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-4 md:px-20" x-data="{ activeTab: 'belum-bayar', counts: {{ json_encode($statusCounts) }} }">
        <div class="max-w-5xl mx-auto">
            
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-black mb-6 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
            
            <h1 class="text-3xl font-bold text-[#3b5d50] mb-8">Pesanan Saya</h1>

            <!-- Tabs -->
            <div class="bg-white rounded-t-xl border-b border-gray-200 overflow-x-auto shadow-sm">
                <div class="flex space-x-8 px-6 min-w-max">
                    <button @click="activeTab = 'semua'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'semua' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Semua</button>
                    <button @click="activeTab = 'belum-bayar'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'belum-bayar' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Belum Bayar</button>
                    <button @click="activeTab = 'menunggu-konfirmasi'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'menunggu-konfirmasi' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Menunggu Konfirmasi</button>
                    <button @click="activeTab = 'dikemas'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'dikemas' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Dikemas</button>
                    <button @click="activeTab = 'dikirim'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'dikirim' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Dikirim</button>
                    <button @click="activeTab = 'selesai'" class="py-4 font-medium transition border-b-2" :class="activeTab === 'selesai' ? 'border-[#3b5d50] text-[#3b5d50]' : 'border-transparent text-gray-500 hover:text-black'">Selesai</button>
                </div>
            </div>

            <div class="mt-6">

                <!-- Loop through dynamic Orders -->
                @foreach($orders as $order)
                    @php
                        $tabValue = $order->status;
                        if ($tabValue === 'dikonfirmasi') $tabValue = 'menunggu-konfirmasi';
                    @endphp
                    <div x-show="activeTab === 'semua' || activeTab === '{{ $tabValue }}'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6" style="display: none;">
                        <!-- Card Header -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-100 pb-4 mb-4 gap-2">
                            <div class="flex items-center space-x-4">
                                <span class="font-bold text-sm text-gray-800">Shopping</span>
                                <!-- Format Dynamic Date -->
                                <span class="text-sm text-gray-500 hidden md:block">{{ $order->created_at->translatedFormat('d M Y') }}</span>
                                <!-- Dynamic Status Badge -->
                                <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide
                                    @if($order->status === 'belum-bayar') bg-red-50 text-red-600
                                    @elseif($order->status === 'menunggu-konfirmasi' || $order->status === 'dikonfirmasi') bg-purple-50 text-purple-600
                                    @elseif($order->status === 'dikemas') bg-blue-50 text-blue-600
                                    @elseif($order->status === 'dikirim') bg-yellow-50 text-yellow-500
                                    @elseif($order->status === 'selesai') bg-green-50 text-green-600
                                    @endif">
                                    @if($order->status === 'menunggu-konfirmasi') Menunggu Konfirmasi
                                    @elseif($order->status === 'dikonfirmasi') Konfirmasi
                                    @else {{ str_replace('-', ' ', $order->status) }}
                                    @endif
                                </span>
                                <span class="text-sm text-gray-500 hidden md:block">{{ $order->id }}</span>
                            </div>
                        </div>

                        <!-- Render dynamic items inside the order -->
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $item->product->image_url }}" class="w-24 h-24 object-cover rounded-md border border-gray-200 p-2 mix-blend-multiply">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-800">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">Kuantitas &times; {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right hidden md:block mt-2">
                                        <p class="font-bold text-lg text-black">Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Order Total summary -->
                        <div class="text-right border-t border-gray-100 pt-4 mt-4 flex flex-col md:flex-row justify-end md:items-center space-y-2 md:space-y-0 md:space-x-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500 mb-1 inline-block md:block mr-2 md:mr-0">Total Belanja:</p>
                                <p class="font-bold text-xl text-black inline-block md:block">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Dynamic Actions based on Status -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-6 pt-4 border-t border-gray-100 gap-4">
                            <div class="flex-shrink-0">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-[#3b5d50] font-bold text-sm inline-flex items-center hover:underline group">
                                    Lihat Detail & Invoice 
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                            
                            <div class="flex-grow flex justify-end">
                                @if($order->status === 'belum-bayar')
                                    <div class="flex flex-wrap justify-end items-center gap-3">
                                        <a href="{{ route('orders.payment_proof', $order->id) }}" class="bg-[#3b5d50] text-white px-8 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg transition flex-shrink-0">
                                            Konfirmasi Pembayaran
                                        </a>
                                    </div>
                                @elseif($order->status === 'menunggu-konfirmasi')
                                    <div class="flex justify-end">
                                        <span class="text-gray-500 italic text-sm font-medium">Menunggu admin mengonfirmasi pembayaran Anda...</span>
                                    </div>
                                @elseif($order->status === 'dikonfirmasi')
                                    <div class="flex justify-end">
                                        <span class="text-[#3b5d50] italic text-sm font-bold">Pembayaran Diterima! Menunggu pesanan diproses.</span>
                                    </div>
                                @elseif($order->status === 'dikemas')
                                    <div class="flex justify-end">
                                        <span class="text-gray-500 italic text-sm font-medium">Pembayaran Diterima! Pesanan sedang dipersiapkan.</span>
                                    </div>
                                @elseif($order->status === 'dikirim')
                                    <div class="flex justify-end">
                                        <button class="bg-[#3b5d50] text-white px-8 py-2.5 rounded-lg font-bold text-sm hover:opacity-90 transition shadow-sm">Pesanan Telah Diterima</button>
                                    </div>
                                @elseif($order->status === 'selesai')
                                    <div class="flex gap-4 justify-end">
                                        <button class="border border-gray-300 text-black px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-gray-50 transition hidden sm:block">Lihat Ulasan</button>
                                        <a href="{{ route('shop') }}" class="bg-[#f9bf29] text-black px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg transition">Beli Lagi</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Dynamic Empty State -->
                <div x-show="counts[activeTab] === 0" class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center" style="display: none;" x-cloak x-transition>
                    <div class="flex justify-center mb-6">
                        <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-[#3b5d50] opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3" x-text="activeTab === 'semua' ? 'Belum Ada Pesanan' : 'Tidak Ada Pesanan'">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8 font-medium">Anda belum memiliki pesanan pada kategori ini. Yuk, mulai belanja dan temukan barang-barang menarik!</p>
                    <a href="{{ route('shop') }}" class="inline-flex bg-[#f9bf29] text-black px-8 py-3.5 rounded-full font-bold text-sm hover:shadow-lg transition-all border border-transparent">
                        Belanja Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
