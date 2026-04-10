<x-app-layout>

    <!-- Hero Section -->
    <section class="furni-green pt-10 pb-20 px-4 md:px-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="z-10 relative">
                <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                    About Us
                </h1>
                <p class="text-white opacity-80 mb-10 max-w-md text-sm leading-relaxed">
                    Berawal dari semangat untuk membawa keindahan ke setiap rumah, Furni hadir sebagai solusi interior modern yang mengedepankan kualitas dan detail tanpa kompromi. Kami percaya bahwa furnitur yang baik dapat meningkatkan kualitas hidup penghuninya melalui keseimbangan antara kenyamanan dan desain yang estetis.
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

    <!-- Why Choose Us -->
    <section class="py-24 px-4 md:px-20 max-w-7xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <!-- Text & Grid -->
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-bold text-[#2f2f2f] mb-4">Why Choose Us</h2>
            <p class="text-gray-500 mb-10 leading-relaxed text-sm">
                Lorem ipsum dolor sit amet consectetur adipiscing elit. Dolor sit amet consectetur adipiscing elit quisque faucibus.
            </p>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                         <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Fast & Free Shipping</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Lorem ipsum dolor sit amet consectetur adipiscing elit quisque.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                        <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Easy to Shop</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Lorem ipsum dolor sit amet consectetur adipiscing elit quisque.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                        <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">24/7 Support</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Lorem ipsum dolor sit amet consectetur adipiscing elit quisque.</p>
                </div>
                <div>
                    <div class="w-10 h-10 mb-4 rounded-full flex items-center justify-center text-[#2f2f2f] relative">
                         <div class="absolute w-6 h-6 bg-gray-200 rounded-full -ml-3 z-0"></div>
                        <svg class="w-6 h-6 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <h4 class="font-bold text-[#2f2f2f] mb-2">Hassle Free Returns</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Lorem ipsum dolor sit amet consectetur adipiscing elit quisque.</p>
                </div>
            </div>
        </div>
        <!-- Image -->
        <div class="w-full md:w-1/2 relative">
             <div class="absolute -top-10 -left-10 w-40 h-40 z-0">
                   <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" class="opacity-80">
                      <pattern id="choose-dots-about" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                        <circle fill="#f9bf29" cx="4" cy="4" r="3"></circle>
                      </pattern>
                      <rect x="0" y="0" width="100%" height="100%" fill="url(#choose-dots-about)"></rect>
                    </svg>
             </div>
             <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=800&auto=format&fit=crop" class="rounded-xl shadow-xl relative z-10 object-cover w-full h-[500px]" alt="Interior living room">
        </div>
    </section>

</x-app-layout>
