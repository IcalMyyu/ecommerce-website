<x-app-layout>

    <!-- Hero Section -->
    <section class="furni-green pt-10 pb-20 px-4 md:px-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="z-10 relative">
                <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                    Modern Interior <br> Design Studio
                </h1>
                <p class="text-white opacity-80 mb-10 max-w-md text-lg leading-relaxed">
                    Wujudkan hunian impian Anda dengan kurasi furnitur modern terbaik yang menggabungkan estetika fungsional dan kenyamanan maksimal.
                </p>
                <div>
                    <a href="{{ route('shop') }}" class="inline-block px-8 py-4 furni-btn-yellow text-[#2f2f2f] font-semibold rounded-full hover:bg-yellow-500 transition shadow-lg">
                        Shop Now
                    </a>
                </div>
            </div>

            <div class="relative z-10 flex justify-end">
                <div class="absolute right-0 -top-10 w-full h-full">
                    <!-- Dotted pattern background for Hero -->
                    <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" class="absolute right-10 top-0 opacity-40">
                        <pattern id="hero-dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                            <circle fill="#fff" cx="4" cy="4" r="3"></circle>
                        </pattern>
                        <rect x="0" y="0" width="100%" height="100%" fill="url(#hero-dots)"></rect>
                    </svg>
                </div>
                <!-- Couch Image placeholder -->
                <div class="relative w-full max-w-lg mt-10 md:mt-0">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop" class="w-full object-cover rounded-xl shadow-2xl" alt="Modern Couch">
                </div>
            </div>

        </div>
    </section>

    <!-- Product Showcase -->
    <section class="py-24 px-4 md:px-20 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-end">
            <!-- Text Column -->
            <div class="md:col-span-1 mb-10 md:mb-0">
                <h2 class="text-3xl font-bold text-[#2f2f2f] mb-6 leading-tight">
                    Crafted with <br> excellent <br> material.
                </h2>
                <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                    Setiap detail dikerjakan oleh pengrajin ahli menggunakan material pilihan untuk memastikan kekuatan dan keindahan yang bertahan lama.
                </p>
                <a href="#" class="inline-block px-8 py-3 bg-[#2f2f2f] text-white rounded-full font-medium hover:bg-black transition">
                    Explore
                </a>
            </div>

            @foreach($products as $product)
            <div class="text-center group cursor-pointer relative">
                <a href="{{ route('products.show', $product->id) }}" class="block no-underline">
                    <div class="w-full aspect-square bg-[#f3f4f6] rounded-2xl group-hover:-translate-y-4 transition duration-500 relative overflow-hidden shadow-sm group-hover:shadow-xl border border-gray-100">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover z-10 group-hover:scale-110 transition-transform duration-700 ease-in-out" alt="{{ $product->name }}">
                    </div>
                    <h3 class="mt-6 font-bold text-[#2f2f2f]">{{ $product->name }}</h3>
                    <p class="font-bold text-lg mt-1 opacity-0 group-hover:opacity-100 transition text-[#2f2f2f]">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                </a>
                <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition translate-y-4 group-hover:-translate-y-0 z-20">
                    @auth
                        <button @click.prevent="$store.cart.add({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ (int)$product->price }}, img: '{{ $product->image_url }}' }); showNotification = true; setTimeout(() => showNotification = false, 3000)" class="w-10 h-10 bg-[#2f2f2f] rounded-full text-white flex items-center justify-center shadow-lg hover:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    @else
                        <button @click.prevent="window.location.href='{{ route('login') }}'" class="w-10 h-10 bg-[#2f2f2f] rounded-full text-white flex items-center justify-center shadow-lg hover:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    @endauth
                </div>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 px-4 md:px-20 max-w-7xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <!-- Text & Grid -->
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-bold text-[#2f2f2f] mb-4">Why Choose Us</h2>
            <p class="text-gray-500 mb-10 leading-relaxed text-sm">
                Kami memberikan lebih dari sekadar furnitur; kami memberikan pengalaman belanja yang unik dan layanan purna jual yang terpercaya.
            </p>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                         <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Fast & Free Shipping</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Layanan pengiriman tepat waktu dengan proteksi ekstra untuk setiap barang Anda.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                        <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Easy to Shop</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Proses checkout praktis yang memudahkan Anda berbelanja dari mana saja.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                        <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">24/7 Support</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Tim ahli kami selalu siaga membantu menjawab setiap kebutuhan furnitur Anda.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                         <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Hassle Free Returns</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Kebijakan pengembalian yang mudah demi kenyamanan dan ketenangan belanja Anda.</p>
                </div>
            </div>
        </div>
        <!-- Image -->
        <div class="w-full md:w-1/2 relative">
             <div class="absolute -top-10 -left-10 w-40 h-40 z-0">
                   <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" class="opacity-80">
                      <pattern id="choose-dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                        <circle fill="#f9bf29" cx="4" cy="4" r="3"></circle>
                      </pattern>
                      <rect x="0" y="0" width="100%" height="100%" fill="url(#choose-dots)"></rect>
                    </svg>
             </div>
             <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=800&auto=format&fit=crop" class="rounded-xl shadow-xl relative z-10 object-cover w-full h-[500px]" alt="Interior living room">
        </div>
    </section>

    <!-- We Help You Make Modern Interior Design -->
    <section class="py-24 px-4 md:px-20 max-w-7xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <!-- Collage section -->
        <div class="w-full md:w-1/2 relative">
             <div class="grid grid-cols-5 grid-rows-5 gap-4 h-[500px]">
                 <!-- Large left img -->
                <div class="col-span-3 row-span-5 relative z-10">
                     <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=500&auto=format&fit=crop" alt="Interior Details" class="w-full h-full object-cover rounded-xl shadow-lg">
                </div>
                <!-- Top right small -->
                <div class="col-span-2 row-span-2 relative z-10">
                     <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=300&auto=format&fit=crop" alt="Interior Details" class="w-full h-full object-cover rounded-xl shadow-lg">
                </div>
                <!-- Bottom right small -->
                <div class="col-span-2 row-span-3 relative z-10 pt-2 pb-4 pr-4">
                     <img src="https://images.unsplash.com/photo-1598300056393-4aac492f4344?q=80&w=300&auto=format&fit=crop" alt="Interior Details" class="w-full h-full object-cover rounded-xl shadow-lg">
                </div>
             </div>
             <div class="absolute -top-10 -left-10 w-40 h-40 z-0">
                   <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" class="opacity-80">
                      <pattern id="collage-dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                        <circle fill="#f9bf29" cx="4" cy="4" r="3"></circle>
                      </pattern>
                      <rect x="0" y="0" width="100%" height="100%" fill="url(#collage-dots)"></rect>
                    </svg>
             </div>
        </div>

        <!-- Text List -->
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-bold text-[#2f2f2f] mb-6 leading-tight">
                We Help You Make Modern Interior Design
            </h2>
            <p class="text-gray-500 text-sm mb-10 leading-relaxed">
                Estetika fungsional adalah kunci. Kami hadir untuk membantu mewujudkan visi ruang impian Anda melalui kurasi furnitur modern yang lekang oleh waktu, dirancang khusus untuk kenyamanan setiap anggota keluarga.
            </p>
            <ul class="grid grid-cols-2 gap-4">
                <li class="flex items-start text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-3 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Kualitas kayu jati dan kain premium pilihan
                </li>
                <li class="flex items-start text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-3 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Custom desain sesuai ukuran ruang Anda
                </li>
                <li class="flex items-start text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-3 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Pengerjaan presisi oleh pengrajin berpengalaman
                </li>
                <li class="flex items-start text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-3 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Garansi resmi untuk kepuasan jangka panjang
                </li>
            </ul>
        </div>
    </section>

</x-app-layout>
