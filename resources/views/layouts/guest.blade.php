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
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen flex flex-col bg-white">
        
        <!-- Header -->
        <nav class="furni-green text-white py-6 px-4 md:px-20 flex justify-between items-center">
            <a href="/" class="text-3xl font-bold tracking-tight text-white no-underline">Furni.</a>
            
            <div class="hidden md:flex space-x-12 opacity-80 font-medium text-sm">
                <a href="#" class="hover:opacity-100 text-white transition">Home</a>
                <a href="#" class="hover:opacity-100 text-white transition">Shop</a>
                <a href="#" class="hover:opacity-100 text-white transition">About Us</a>
                <a href="#" class="hover:opacity-100 text-white transition">Contact Us</a>
            </div>
            
            <div class="flex space-x-6 opacity-80">
                <a href="{{ route('login') }}" class="hover:opacity-100 text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
                <a href="#" class="hover:opacity-100 text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col items-center justify-center py-20 px-4">
            <div class="w-full max-w-[500px]">
                {{ $slot }}
            </div>
        </main>
        
        <!-- Divider for footer -->
        <div class="max-w-6xl mx-auto w-full border-t border-gray-300"></div>

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
                    <!-- LinkedIn -->
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                    <!-- X / Twitter -->
                    <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
                <div class="mt-8 text-xs text-gray-500">
                    Copyright 2025 Group5. All Right reserved
                </div>
            </div>
            <div class="relative min-h-[250px] flex justify-end">
                <!-- Dots pattern as background -->
                <div class="absolute inset-0 z-0 flex flex-wrap opacity-60 ml-10 -mt-4 w-40 h-40">
                   <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                      <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle fill="#8bc34a" cx="4" cy="4" r="4"></circle>
                      </pattern>
                      <rect x="0" y="0" width="100%" height="100%" fill="url(#dots)"></rect>
                    </svg>
                </div>
                <!-- Abstract rectangles indicating chairs in Figma -->
                <div class="absolute right-0 top-0 w-48 h-48 bg-gray-200 z-10 rounded-md shadow flex items-center justify-center text-gray-400 overflow-hidden">
                   <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover rounded-md" alt="Chair 1">
                </div>
                <div class="absolute right-40 top-20 w-40 h-40 bg-gray-300 z-20 rounded-md shadow flex items-center justify-center text-gray-500 overflow-hidden">
                   <!-- Another chair placeholder -->
                   <img src="https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover rounded-md" alt="Chair 2">
                </div>
            </div>
        </footer>
    </body>
</html>
