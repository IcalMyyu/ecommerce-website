<x-app-layout>

    <div class="bg-white min-h-screen pt-32 pb-24 px-4 md:px-20">
        <div class="max-w-4xl mx-auto">
            
            <h1 class="text-4xl md:text-5xl font-semibold text-center mb-16 text-black tracking-tight">
                Tambah Alamat
            </h1>

            <form action="{{ route('address.store') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label class="block text-lg font-medium text-black mb-3">Nama</label>
                    <input type="text" name="recipient_name" required class="w-full border border-gray-400 rounded-lg py-4 px-4 outline-none focus:border-[#3b5d50] focus:ring-1 focus:ring-[#3b5d50] transition shadow-sm">
                </div>

                <div class="mb-8">
                    <label class="block text-lg font-medium text-black mb-3">Nomor Telepon</label>
                    <input type="text" name="phone_number" required class="w-full border border-gray-400 rounded-lg py-4 px-4 outline-none focus:border-[#3b5d50] focus:ring-1 focus:ring-[#3b5d50] transition shadow-sm">
                </div>

                <div class="mb-12">
                    <label class="block text-lg font-medium text-black mb-3">Alamat Lengkap</label>
                    <textarea name="full_address" required class="w-full border border-gray-400 rounded-lg py-4 px-4 h-48 outline-none focus:border-[#3b5d50] focus:ring-1 focus:ring-[#3b5d50] transition shadow-sm resize-none"></textarea>
                </div>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('cart') }}" class="bg-[#3b5d50] opacity-90 text-white text-xl px-12 py-3 rounded-lg font-medium hover:opacity-100 hover:shadow-lg transition cursor-pointer">
                        Kembali
                    </a>
                    <button type="submit" class="bg-[#3b5d50] opacity-90 text-white text-xl px-12 py-3 rounded-lg font-medium hover:opacity-100 hover:shadow-lg transition cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>
