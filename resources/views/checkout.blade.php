<x-app-layout>

    <div class="bg-white min-h-screen pt-32 pb-10 px-4 md:px-20" x-data="{ step: new URLSearchParams(location.search).get('step') ? Number(new URLSearchParams(location.search).get('step')) : 1, shipping: 'jtr', bank: 'bca', shippingCosts: { jtr: 50000, jnt: 150000 } }">
        <div class="max-w-5xl mx-auto">
            
            <h1 class="text-5xl font-bold text-center mb-20 text-[#3b5d50] tracking-tight">
                Checkout
            </h1>

            <!-- Alamat Pengiriman -->
            <div class="mb-16">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3 text-[#3b5d50]">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h2 class="text-2xl font-bold">Alamat Pengiriman</h2>
                    </div>
                    <a href="{{ route('address.index') }}" class="text-sm text-gray-800 font-medium hover:underline hover:text-black transition">Ubah</a>
                </div>
                @php 
                    $defaultAddr = $addresses->where('is_default', true)->first(); 
                    if (!$defaultAddr) $defaultAddr = $addresses->first(); // fallback to any available address
                @endphp
                
                @if($defaultAddr)
                    <div class="pl-11">
                        <div class="font-bold text-xl mb-1 text-black">
                            <span>{{ $defaultAddr->recipient_name }}</span> 
                            <span class="font-normal text-black text-xl">
                                ({{ $defaultAddr->phone_number }})
                            </span>
                        </div>
                        <p class="text-black text-lg max-w-3xl whitespace-pre-wrap">{{ $defaultAddr->full_address }}</p>
                    </div>
                @else
                    <div class="pl-11 text-red-600 font-medium">Anda belum menyimpan alamat atau memilih alamat utama. Silakan <a href="{{ route('address.create') }}" class="underline font-bold">tambahkan alamat</a>.</div>
                @endif
                
                <div class="border-b border-gray-600 mt-8"></div>
            </div>

            <!-- Produk Dipesan -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-[#3b5d50] mb-8">Produk Dipesan</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[700px]">
                        <thead>
                            <tr class="bg-[#3b5d50] text-[#eeecec]">
                                <th class="py-4 px-6 font-medium text-center">Gambar</th>
                                <th class="py-4 px-6 font-medium text-center">Series</th>
                                <th class="py-4 px-6 font-medium text-center">Jumlah</th>
                                <th class="py-4 px-6 font-medium text-center">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in $store.cart.items" :key="item.id">
                                <tr>
                                    <td class="py-6 px-6">
                                        <div class="h-28 w-28 mx-auto flex items-center justify-center">
                                            <img :src="item.img" class="max-h-full object-contain mix-blend-multiply">
                                        </div>
                                    </td>
                                    <td class="py-6 px-6 font-medium text-sm text-black text-center" x-text="item.name"></td>
                                    <td class="py-6 px-6 text-center text-lg text-black" x-text="item.quantity"></td>
                                    <td class="py-6 px-6 text-lg text-black text-center" x-text="'Rp. ' + (item.price * item.quantity).toLocaleString('id-ID')"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="border-b border-gray-600 mt-2"></div>
            </div>

            <!-- Opsi Pengiriman (STEP 1) -->
            <div class="mb-20" x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                <h2 class="text-2xl font-bold text-[#3b5d50] mb-8">Opsi Pengiriman</h2>
                
                <div class="space-y-6">
                    <!-- JTR Option -->
                    <label class="flex justify-between items-center cursor-pointer p-6 border-2 rounded-2xl hover:bg-gray-50 transition" :class="shipping === 'jtr' ? 'border-[#3b5d50] bg-green-50 shadow-sm' : 'border-gray-200'" @click="shipping = 'jtr'">
                        <div class="flex items-center space-x-6">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition" :class="shipping === 'jtr' ? 'border-[#3b5d50]' : 'border-gray-400'">
                                <div class="w-4 h-4 bg-[#3b5d50] rounded-full transition" x-show="shipping === 'jtr'"></div>
                            </div>
                            <div class="select-none">
                                <div class="font-black text-2xl text-[#0b1a62] italic tracking-tighter shadow-sm border-b-2 border-red-600 pb-0.5 leading-none" :class="shipping !== 'jtr' && 'opacity-50'">JTR</div>
                                <div class="text-[10px] text-red-600 font-bold italic tracking-tighter mt-1" :class="shipping !== 'jtr' && 'opacity-50'">LOGISTICS</div>
                            </div>
                        </div>
                        <div class="font-bold text-xl text-[#3b5d50]">Rp 50.000</div>
                    </label>

                    <!-- J&T Cargo Option -->
                    <label class="flex justify-between items-center cursor-pointer p-6 border-2 rounded-2xl hover:bg-gray-50 transition" :class="shipping === 'jnt' ? 'border-[#3b5d50] bg-green-50 shadow-sm' : 'border-gray-200'" @click="shipping = 'jnt'">
                        <div class="flex items-center space-x-6">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition" :class="shipping === 'jnt' ? 'border-[#3b5d50]' : 'border-gray-400'">
                                <div class="w-4 h-4 bg-[#3b5d50] rounded-full transition" x-show="shipping === 'jnt'" style="display: none;"></div>
                            </div>
                            <div class="select-none font-bold text-2xl text-green-600 italic tracking-tighter transition" :class="shipping !== 'jnt' && 'opacity-50'">
                                J&T <span class="text-sm font-bold">CARGO</span>
                            </div>
                        </div>
                        <div class="font-bold text-xl text-[#3b5d50]">Rp 150.000</div>
                    </label>
                </div>

                <div class="flex flex-col items-end mt-16 border-t border-b border-gray-200 py-6 space-y-3">
                    <p class="text-lg font-medium text-gray-500 w-full md:w-1/2 flex justify-between">
                        <span>Subtotal Produk (<span x-text="$store.cart.count"></span> Barang):</span>
                        <span x-text="'Rp. ' + $store.cart.total.toLocaleString('id-ID')"></span>
                    </p>
                    <p class="text-lg font-medium text-gray-500 w-full md:w-1/2 flex justify-between">
                        <span>Biaya Pengiriman:</span>
                        <span x-text="'Rp. ' + shippingCosts[shipping].toLocaleString('id-ID')"></span>
                    </p>
                    <div class="w-full md:w-1/2 border-t border-gray-300 my-2"></div>
                    <p class="text-2xl font-bold text-[#3b5d50] w-full md:w-1/2 flex justify-between">
                        <span>Total Pembayaran:</span>
                        <span x-text="'Rp. ' + ($store.cart.total + shippingCosts[shipping]).toLocaleString('id-ID')"></span>
                    </p>
                </div>
            </div>

            <!-- Metode Pembayaran (STEP 2) -->
            <div class="mb-20" x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                <h2 class="text-2xl font-bold text-[#3b5d50] mb-8">Metode Pembayaran</h2>
                
                <div class="space-y-6">
                    <!-- Transfer Bank Master Option -->
                    <label class="flex items-center space-x-4 cursor-pointer pl-2 mb-4">
                        <div class="w-8 h-8 rounded-full border-2 border-[#005c4b] flex items-center justify-center transition">
                            <div class="w-4 h-4 bg-[#005c4b] rounded-full transition"></div>
                        </div>
                        <div class="font-bold text-3xl text-black">Transfer Bank</div>
                    </label>

                    <!-- Bank Options Grid inside Border Box -->
                    <div class="border border-black rounded-xl p-8 max-w-4xl mx-auto md:ml-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- BCA -->
                            <label class="cursor-pointer border-2 rounded-xl h-24 flex items-center justify-center transition" :class="bank === 'bca' ? 'border-[#3b5d50] bg-green-50 shadow-md' : 'border-gray-200 hover:border-gray-300'" @click="bank = 'bca'">
                                <span class="font-black italic text-[#005faa] text-4xl tracking-tighter shadow-sm">BCA</span>
                            </label>
                            
                            <!-- Mandiri -->
                            <label class="cursor-pointer border-2 rounded-xl h-24 flex items-center justify-center transition" :class="bank === 'mandiri' ? 'border-[#3b5d50] bg-green-50 shadow-md' : 'border-gray-200 hover:border-gray-300'" @click="bank = 'mandiri'">
                                <span class="font-bold italic text-[#f4ba3e] text-3xl tracking-tight shadow-sm"><span class="text-[#093e7a]">mandi</span>ri</span>
                            </label>
                            
                            <!-- BNI -->
                            <label class="cursor-pointer border-2 rounded-xl h-24 flex items-center justify-center transition" :class="bank === 'bni' ? 'border-[#3b5d50] bg-green-50 shadow-md' : 'border-gray-200 hover:border-gray-300'" @click="bank = 'bni'">
                                <span class="font-black italic text-[#00605b] text-4xl tracking-tight shadow-sm">BNI</span>
                            </label>
                            
                            <!-- BRI -->
                            <label class="cursor-pointer border-2 rounded-xl h-24 flex items-center justify-center transition" :class="bank === 'bri' ? 'border-[#3b5d50] bg-green-50 shadow-md' : 'border-gray-200 hover:border-gray-300'" @click="bank = 'bri'">
                                <span class="font-black italic text-[#085a97] text-4xl tracking-tighter shadow-sm">BRI</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center mb-24">
                
                <!-- Step 1 Actions -->
                <template x-if="step === 1">
                    <div class="flex justify-between items-center w-full">
                        <a href="{{ route('cart') }}" class="bg-[#3b5d50] opacity-90 text-white px-12 py-3 rounded-lg font-bold hover:opacity-100 hover:shadow-lg transition text-lg cursor-pointer">
                            Kembali
                        </a>
                        <button @click.prevent="step = 2" class="bg-[#3b5d50] opacity-90 text-white px-16 py-3 rounded-lg font-bold hover:opacity-100 hover:shadow-lg transition text-lg cursor-pointer outline-none focus:outline-none">
                            Lanjutkan
                        </button>
                    </div>
                </template>

                <!-- Step 2 Actions -->
                <template x-if="step === 2">
                    <div class="flex justify-between items-center w-full">
                        <button @click.prevent="step = 1" class="bg-[#3b5d50] opacity-90 text-white px-12 py-3 rounded-lg font-bold hover:opacity-100 hover:shadow-lg transition text-lg cursor-pointer outline-none focus:outline-none">
                            Kembali
                        </button>
                        @if($defaultAddr)
                            <a href="#" @click.prevent="document.getElementById('checkout-form').submit();" class="bg-[#3b5d50] opacity-90 text-white px-10 py-3 rounded-lg font-bold hover:opacity-100 hover:shadow-lg transition text-lg cursor-pointer">
                                Lanjutkan Pesanan
                            </a>
                        @else
                            <button disabled class="bg-gray-400 text-white px-10 py-3 rounded-lg font-bold cursor-not-allowed text-lg">
                                Lanjutkan Pesanan
                            </button>
                        @endif
                    </div>
                </template>

            </div>

            <!-- Hidden Form for Backend Submission -->
            @if($defaultAddr)
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="cart_items" :value="JSON.stringify($store.cart.items)">
                <input type="hidden" name="total_amount" :value="$store.cart.total + shippingCosts[shipping]">
                <input type="hidden" name="shipping_cost" :value="shippingCosts[shipping]">
                <input type="hidden" name="payment_bank" x-model="bank">
                <input type="hidden" name="shipping_courier" x-model="shipping">
                <input type="hidden" name="address_id" value="{{ $defaultAddr->id }}">
            </form>
            @endif

        </div>
    </div>

</x-app-layout>
