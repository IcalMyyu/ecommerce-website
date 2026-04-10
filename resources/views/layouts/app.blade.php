<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Furni.</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.userId = '{!! Auth::check() && Auth::user() ? addslashes(Auth::user()->email) : "guest" !!}';
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .furni-green {
                background-color: #3b5d50;
            }
            .furni-text-green {
                color: #3b5d50;
            }
            .furni-btn-yellow {
                background-color: #f9bf29;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white flex flex-col min-h-screen" x-data="{ isCartOpen: false, showNotification: false }" @toast.window="showNotification = true; setTimeout(() => showNotification = false, 3000)">
        
        <!-- Header -->
        <nav class="furni-green text-white py-6 px-4 md:px-20 flex justify-between items-center w-full z-50">
            <a href="{{ route('home') }}" class="text-3xl font-bold tracking-tight text-white no-underline">Furni.</a>
            
            <div class="hidden md:flex space-x-12 opacity-80 font-medium text-sm">
                <a href="{{ route('home') }}" class="hover:opacity-100 transition {{ request()->routeIs('home') ? 'text-white opacity-100 border-b-4 border-[#f9bf29] pb-1' : 'text-white' }}">Home</a>
                <a href="{{ route('shop') }}" class="hover:opacity-100 transition {{ request()->routeIs('shop') ? 'text-white opacity-100 border-b-4 border-[#f9bf29] pb-1' : 'text-white' }}">Shop</a>
                <a href="{{ route('about') }}" class="hover:opacity-100 transition {{ request()->routeIs('about') ? 'text-white opacity-100 border-b-4 border-[#f9bf29] pb-1' : 'text-white' }}">About Us</a>
                <a href="{{ route('contact') }}" class="hover:opacity-100 transition {{ request()->routeIs('contact') ? 'text-white opacity-100 border-b-4 border-[#f9bf29] pb-1' : 'text-white' }}">Contact Us</a>
            </div>
            
            <div class="flex space-x-6 opacity-80 items-center">
                <!-- User Dropdown -->
                <div class="relative inline-block" x-data="{ isUserMenuOpen: false }">
                    <div @click="isUserMenuOpen = !isUserMenuOpen" @click.away="isUserMenuOpen = false" class="hover:opacity-100 text-white transition flex items-center cursor-pointer select-none">
                        @auth
                            <span class="mr-2 font-medium text-sm hidden md:block">{{ Auth::user()->name }}</span>
                        @endauth
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    
                    <div x-show="isUserMenuOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         style="display: none;"
                         @click="isUserMenuOpen = false"
                         class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 pt-2 pb-2">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                Profile
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                Pesanan Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-none bg-transparent cursor-pointer">
                                    Log Out
                                </button>
                            </form>
                        @endauth
                        @guest
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                Sign up
                            </a>
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 no-underline">
                                Log in
                            </a>
                        @endguest
                    </div>
                </div>
                
                <button @click="isCartOpen = true" class="hover:opacity-100 transition focus:outline-none {{ request()->routeIs('cart') ? 'text-[#f9bf29]' : 'text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ request()->routeIs('cart') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow w-full">
            {{ $slot }}
        </main>
        
        <!-- Divider for footer -->
        <div class="max-w-6xl mx-auto w-full border-t border-gray-300 mt-20"></div>

        <!-- Footer -->
        <footer class="max-w-6xl mx-auto w-full py-16 px-4 md:px-0 grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <a href="/" class="text-3xl font-bold tracking-tight text-[#2f2f2f] mb-6 block no-underline">Furni.</a>
                <p class="text-gray-500 text-sm leading-relaxed mb-6 max-w-sm">
                    Platform e-commerce furnitur terpercaya yang menghadirkan solusi interior modern untuk gaya hidup dinamis Anda. Koleksi kami dikurasi khusus untuk memberikan keindahan dan kenyamanan di setiap sudut ruangan.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
                <div class="mt-8 text-xs text-gray-500">
                    Copyright 2025 Group5. All Right reserved
                </div>
            </div>
            <div class="relative min-h-[250px] flex justify-end">
                <div class="absolute inset-0 z-0 flex flex-wrap opacity-60 ml-10 -mt-4 w-40 h-40">
                   <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                      <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle fill="#8bc34a" cx="4" cy="4" r="4"></circle>
                      </pattern>
                      <rect x="0" y="0" width="100%" height="100%" fill="url(#dots)"></rect>
                    </svg>
                </div>
                <div class="absolute right-0 top-0 w-48 h-48 bg-gray-200 z-10 rounded-md shadow flex items-center justify-center text-gray-400 overflow-hidden">
                   <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover rounded-md" alt="Chair 1">
                </div>
                <div class="absolute right-40 top-20 w-40 h-40 bg-gray-300 z-20 rounded-md shadow flex items-center justify-center text-gray-500 overflow-hidden">
                   <img src="https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover rounded-md" alt="Chair 2">
                </div>
            </div>
        </footer>
        <!-- Slide-out Cart Panel -->
        <div x-show="isCartOpen" style="display: none;" class="relative z-50">
            <!-- Overlay -->
            <div x-show="isCartOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-black bg-opacity-70" @click="isCartOpen = false"></div>
                 
            <div class="fixed inset-y-0 right-0 flex max-w-full z-50">
                <div x-show="isCartOpen" 
                     x-transition:enter="transform transition ease-in-out duration-300" 
                     x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-300" 
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                     class="w-screen max-w-sm" @click.stop>
                    <div class="flex h-full flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-6 sm:px-6 bg-[#3b5d50] text-white">
                            <h2 class="text-lg font-bold">Keranjang Belanja</h2>
                            <button type="button" class="-m-2 p-2 text-white hover:text-gray-200 outline-none" @click="isCartOpen = false">
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                <template x-for="item in $store.cart.items" :key="item.id">
                                    <li class="flex py-6">
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 p-2">
                                            <img :src="item.img" :alt="item.name" class="h-full w-full object-contain object-center drop-shadow-md">
                                        </div>
                                        <div class="ml-4 flex flex-1 flex-col justify-center">
                                            <div>
                                                <div class="flex justify-between text-base font-bold text-gray-900">
                                                    <h3 x-text="item.name"></h3>
                                                    <button type="button" @click="$store.cart.remove(item.id)" class="font-medium text-gray-700 hover:text-black focus:outline-none">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500 font-medium">Bangku Estetik</p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                                <div class="flex items-center border border-gray-400 rounded-full h-8 w-24 justify-between px-3">
                                                    <button @click="$store.cart.updateQuantity(item.id, -1)" class="text-gray-500 hover:text-black cursor-pointer font-bold focus:outline-none">-</button>
                                                    <span class="font-bold text-gray-900" x-text="item.quantity"></span>
                                                    <button @click="$store.cart.updateQuantity(item.id, 1)" class="text-gray-500 hover:text-black cursor-pointer font-bold focus:outline-none">+</button>
                                                </div>
                                                <p class="font-bold text-gray-900" x-text="'Rp. ' + (item.price * item.quantity).toLocaleString('id-ID')"></p>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                                
                                <li x-show="$store.cart.items.length === 0" class="flex py-6 justify-center">
                                    <p class="text-gray-500">Keranjang masih kosong.</p>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Footer -->
                        <div class="border-t border-gray-200 px-4 py-8 sm:px-6 mb-4">
                            <div class="flex justify-between text-base font-bold text-gray-900 mb-6">
                                <p>Subtotal</p>
                                <p x-text="'Rp. ' + $store.cart.total.toLocaleString('id-ID')"></p>
                            </div>
                            <div class="mt-0">
                                <a href="{{ route('cart') }}" class="flex w-full items-center justify-center rounded-full border border-transparent bg-[#3b5d50] px-6 py-4 text-base font-bold text-white shadow-sm hover:bg-black transition cursor-pointer">Lihat Keranjang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="showNotification" style="display: none;"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-10 right-10 max-w-[300px] w-full bg-[#f9bf29] text-[#2f2f2f] rounded-lg shadow-2xl pointer-events-auto z-[60] overflow-hidden">
            <div class="p-4 flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-[#2f2f2f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-bold">Success</p>
                    <p class="mt-1 text-sm font-medium">Added to your cart!</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="showNotification = false" class="rounded-md inline-flex text-[#2f2f2f] hover:text-black focus:outline-none bg-transparent">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
    </body>
</html>
