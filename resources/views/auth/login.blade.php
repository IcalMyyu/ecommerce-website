<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-10">
        <h1 class="text-4xl font-semibold text-[#1a1a1a]">Login</h1>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Username -->
        <div>
            <input id="username" type="text" name="username" :value="old('username')" required autofocus placeholder="Username" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('username') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('password') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me (Hidden in Figma, but good to have functional if needed, we'll hide it or default it, let's keep it hidden via default false) -->

        <div class="mt-8">
            <button type="submit" class="w-full py-4 bg-[#3b5d50] text-white rounded-md text-lg font-medium hover:bg-[#2c473c] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3b5d50]">
                Login
            </button>
        </div>
        
        <div class="mt-6 text-center text-gray-700">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
        </div>
    </form>
</x-guest-layout>
