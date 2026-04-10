<x-guest-layout>
    <div class="text-center mb-10">
        <h1 class="text-4xl font-semibold text-[#1a1a1a]">Register</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Nama" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('name') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <input id="username" type="text" name="username" :value="old('username')" required placeholder="Username" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('username') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('password') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <input id="email" type="email" name="email" :value="old('email')" required placeholder="Email" class="w-full px-5 py-4 border border-gray-400 rounded-md focus:border-[#3b5d50] focus:ring focus:ring-[#3b5d50] focus:ring-opacity-20 placeholder-gray-400 font-medium @error('email') border-red-500 @enderror">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full py-4 bg-[#3b5d50] text-white rounded-md text-lg font-medium hover:bg-[#2c473c] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3b5d50]">
                Register
            </button>
        </div>
        
        <div class="mt-6 text-center text-gray-700">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a>
        </div>
    </form>
</x-guest-layout>
