<x-app-layout>

    <!-- Shop Hero Section -->
    <section class="furni-green pt-24 pb-32 px-4 md:px-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-0">
                Shop
            </h1>
        </div>
    </section>

    <!-- Shop Products Grid -->
    <section class="py-24 px-4 md:px-20 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
            @foreach($products as $product)
            <div class="text-center group flex flex-col items-center relative pb-12">
                <a href="{{ route('products.show', $product->id) }}" class="flex flex-col items-center cursor-pointer w-full">
                    <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-md mb-6 relative group border border-gray-100">
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out" alt="{{ $product->name }}">
                    </div>
                    <h3 class="font-bold text-[#2f2f2f] text-lg">{{ $product->name }}</h3>
                    <p class="font-bold text-gray-800 text-lg mt-1 mb-4">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                </a>
                <div class="absolute bottom-0 w-full flex justify-center">
                    @auth
                        <button @click.prevent="$store.cart.add({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ (int)$product->price }}, img: '{{ $product->image_url }}' }); showNotification = true; setTimeout(() => showNotification = false, 3000)" class="w-8 h-8 bg-[#2f2f2f] rounded-full text-white flex items-center justify-center shadow-md hover:bg-black transition focus:outline-none cursor-pointer z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    @else
                        <button @click.prevent="window.location.href='{{ route('login') }}'" class="w-8 h-8 bg-[#2f2f2f] rounded-full text-white flex items-center justify-center shadow-md hover:bg-black transition focus:outline-none cursor-pointer z-10">
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

</x-app-layout>
