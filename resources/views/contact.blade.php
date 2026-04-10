<x-app-layout>

    <!-- Hero Section -->
    <section class="furni-green pt-10 pb-20 px-4 md:px-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="z-10 relative">
                <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                    Contact Us
                </h1>
                <p class="text-white opacity-80 mb-10 max-w-md text-sm leading-relaxed">
                    Ada pertanyaan tentang produk atau butuh bantuan dengan pesanan Anda? Tim kami selalu siap mendengar
                    dan memberikan solusi terbaik untuk Anda.
                </p>
                <div>
                    <a href="{{ route('shop') }}"
                        class="inline-block px-8 py-4 furni-btn-yellow text-[#2f2f2f] font-semibold rounded-full hover:bg-yellow-500 transition shadow-lg">
                        Shop Now
                    </a>
                </div>
            </div>

            <div class="relative z-10 flex justify-end">
                <div class="absolute right-0 -top-10 w-full h-full">
                    <!-- Dotted pattern background for Hero -->
                    <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg"
                        class="absolute right-10 top-0 opacity-40">
                        <pattern id="hero-dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                            <circle fill="#fff" cx="4" cy="4" r="3"></circle>
                        </pattern>
                        <rect x="0" y="0" width="100%" height="100%" fill="url(#hero-dots)"></rect>
                    </svg>
                </div>
                <!-- Couch Image placeholder -->
                <div class="relative w-full max-w-lg mt-10 md:mt-0">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop"
                        class="w-full object-cover rounded-xl shadow-2xl" alt="Modern Couch">
                </div>
            </div>

        </div>
    </section>

    <!-- Contact Details & Form Section -->
    <section class="py-24 px-4 md:px-20 max-w-5xl mx-auto">

        <!-- Contact Info Row -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-12 mb-20">
            <!-- Address -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-[#3b5d50] text-white flex items-center justify-center rounded-md shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">Tanah Baru, Depok</span>
            </div>
            <!-- Email -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-[#3b5d50] text-white flex items-center justify-center rounded-md shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">faisalmy@gmail.com</span>
            </div>
            <!-- Phone -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-[#3b5d50] text-white flex items-center justify-center rounded-md shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                        </path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">085894883677</span>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div
                class="max-w-4xl mx-auto mb-8 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Contact Form -->
        <div class="max-w-4xl mx-auto bg-white p-8 md:p-12">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">First name</label>
                        <input type="text" name="first_name" required
                            class="w-full border-2 border-gray-300 rounded-2xl py-3 px-5 outline-none focus:border-[#3b5d50] focus:ring-0 transition"
                            placeholder="">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Last name</label>
                        <input type="text" name="last_name" required
                            class="w-full border-2 border-gray-300 rounded-2xl py-3 px-5 outline-none focus:border-[#3b5d50] focus:ring-0 transition"
                            placeholder="">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Email address</label>
                    <input type="email" name="email" required
                        class="w-full border-2 border-gray-300 rounded-2xl py-3 px-5 outline-none focus:border-[#3b5d50] focus:ring-0 transition"
                        placeholder="">
                </div>
                <div class="mb-10">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Message</label>
                    <textarea name="message" required
                        class="w-full border-2 border-gray-300 rounded-2xl p-5 h-56 outline-none focus:border-[#3b5d50] focus:ring-0 transition resize-none"
                        placeholder=""></textarea>
                </div>
                <div>
                    <button type="submit"
                        class="bg-[#2f2f2f] text-white font-semibold rounded-full px-10 py-4 hover:bg-black transition shadow-lg">
                        Send Message
                    </button>
                </div>
            </form>
        </div>

    </section>

</x-app-layout>