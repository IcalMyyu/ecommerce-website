<x-app-layout>

    <div class="bg-white min-h-screen pt-32 pb-24 px-4 md:px-20" x-data="{}">
        <div class="max-w-4xl mx-auto">
            
            <h1 class="text-4xl md:text-5xl font-semibold text-center mb-16 text-black tracking-tight">
                Ubah Alamat
            </h1>

            <div class="mb-12">
                @forelse($addresses as $addr)
                    <div class="border-b border-gray-200 py-8 flex justify-between items-center group transition">
                        
                        <!-- Left Block -->
                        <div>
                            <div class="flex items-center mb-3">
                                <span class="text-2xl font-bold text-black mr-2">{{ $addr->recipient_name }}</span>
                                <span class="text-2xl text-gray-500 mr-4">| {{ $addr->phone_number }}</span>
                                <form action="{{ route('address.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#ff4d4f] text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">Hapus</button>
                                </form>
                            </div>
                            <!-- Address Block -->
                            <p class="text-gray-600 text-lg leading-relaxed max-w-2xl whitespace-pre-wrap">{{ $addr->full_address }}</p>
                        </div>

                        <!-- Right Radio Circle -->
                        <div class="flex-shrink-0 ml-4 pl-4 cursor-pointer" onclick="document.getElementById('set-default-{{ $addr->id }}').submit()">
                            @if(!$addr->is_default)
                                <div class="w-8 h-8 rounded-full border-2 border-gray-400 group-hover:border-gray-500 transition"></div>
                            @else
                                <div class="w-8 h-8 rounded-full border-[3px] border-[#ff4d4f] flex items-center justify-center transition">
                                    <div class="w-4 h-4 bg-[#ff4d4f] rounded-full"></div>
                                </div>
                            @endif

                            <form id="set-default-{{ $addr->id }}" action="{{ route('address.setDefault', $addr->id) }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 text-gray-500 border border-dashed border-gray-300 rounded-lg">
                        <p class="mb-4">No addresses currently saved. Please add one.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('cart') }}" class="bg-[#3b5d50] opacity-90 text-white text-xl px-12 py-3 rounded-lg font-medium hover:opacity-100 hover:shadow-lg transition cursor-pointer">
                    Kembali
                </a>
                <a href="{{ route('address.create') }}" class="bg-[#3b5d50] opacity-90 text-white text-xl px-12 py-3 rounded-lg font-medium hover:opacity-100 hover:shadow-lg transition cursor-pointer">
                    Tambah Alamat
                </a>
            </div>

        </div>
    </div>

</x-app-layout>
