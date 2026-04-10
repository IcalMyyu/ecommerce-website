<x-app-layout>

    <!-- Product Details Section -->
    <div class="bg-white min-h-screen pt-32 pb-24 px-4 md:px-20 font-sans text-[#2f2f2f]" x-data="{ quantity: 1 }">
        <div class="max-w-6xl mx-auto">
            
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('shop') }}" class="inline-flex items-center text-[#3b5d50] font-bold text-lg hover:text-[#2f2f2f] transition group">
                    <svg class="w-6 h-6 mr-2 transform group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Shop
                </a>
            </div>

            <div class="flex flex-col md:flex-row gap-12 lg:gap-20 items-stretch">
                
                <!-- Product Image (Left Side) -->
                <div class="w-full md:w-1/2 flex flex-col">
                    <div class="w-full h-full min-h-[400px] md:min-h-[500px] relative rounded-3xl overflow-hidden shadow-2xl mb-6 md:mb-0 group">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    </div>
                </div>

                <!-- Product Info (Right Side) -->
                <div class="w-full md:w-1/2 flex flex-col justify-between py-2">
                    
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-[#2f2f2f] mb-2">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex text-[#f9bf29]">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= floor($product->rating ?? 5))
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 font-medium">{{ number_format($product->rating ?? 5.0, 1) }} ({{ $product->reviews_count ?? 0 }} reviews) | {{ $product->sold_count ?? 0 }} Sold</span>
                        </div>

                        <div class="text-4xl font-extrabold text-[#3b5d50] mb-6">
                            Rp. {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <p class="text-gray-600 leading-relaxed mb-8 max-w-lg text-lg">
                            {{ $product->description ?? 'Crafted with precision and premium materials, this piece brings both elegance and unparalleled comfort to your living space. Designed to last a lifetime.' }}
                        </p>

                        <!-- Furniture Specific Specs -->
                        <div class="grid grid-cols-2 gap-4 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Material</p>
                                <p class="font-medium text-gray-800">Premium Wood & Fabric</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Dimensions</p>
                                <p class="font-medium text-gray-800">80 x 85 x 90 cm</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Stock Available</p>
                                <p class="font-medium text-[#3b5d50]">{{ $product->stock }} units</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Warranty</p>
                                <p class="font-medium text-gray-800">2 Years</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Row (Quantity + Buttons) aligned absolutely bottom with image -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 mt-auto">
                        <!-- Quantity -->
                        <div class="flex items-center border-2 border-gray-200 rounded-full h-14 w-full sm:w-1/3 justify-between px-4 bg-white shrink-0">
                            <button @click="if(quantity > 1) quantity--" class="text-gray-500 hover:text-black cursor-pointer font-bold focus:outline-none text-2xl h-full px-2">-</button>
                            <span class="font-bold text-gray-900 text-lg" x-text="quantity"></span>
                            <button @click="if(quantity < {{ $product->stock }}) quantity++" class="text-gray-500 hover:text-black cursor-pointer font-bold focus:outline-none text-2xl h-full px-2">+</button>
                        </div>

                        @auth
                            <button @click.prevent="
                                    $store.cart.add({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ (int)$product->price }}, img: '{{ $product->image_url }}' }, quantity); 
                                    $dispatch('toast');" 
                                    class="w-full sm:w-1/3 bg-[#f9bf29] text-[#2f2f2f] h-14 rounded-full font-bold text-lg shadow-sm hover:shadow-md transition hover:bg-[#f2b314] flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                            <button @click.prevent="
                                    $store.cart.add({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ (int)$product->price }}, img: '{{ $product->image_url }}' }, quantity);
                                    window.location.href='{{ route('checkout.index') }}'" 
                                    class="w-full sm:w-1/3 bg-[#3b5d50] text-white h-14 rounded-full font-bold text-lg shadow-md hover:bg-[#2c473d] transition flex justify-center items-center">
                                Buy Now
                            </button>
                        @else
                            <button @click="window.location.href='{{ route('login') }}'" class="w-full sm:w-1/3 bg-[#f9bf29] text-[#2f2f2f] h-14 rounded-full font-bold text-lg shadow-sm hover:shadow-md transition hover:bg-[#f2b314] flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                            <button @click="window.location.href='{{ route('login') }}'" class="w-full sm:w-1/3 bg-[#3b5d50] text-white h-14 rounded-full font-bold text-lg shadow-md hover:bg-[#2c473d] transition flex justify-center items-center">
                                Buy Now
                            </button>
                        @endauth
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
