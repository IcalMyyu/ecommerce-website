<x-app-layout>
    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-4 md:px-20"
         x-data="{
             previewUrl: null,
             fileName: '',
             fileSize: '',
             dragging: false,
             uploading: false,
             handleFile(file) {
                 if (!file) return;
                 const allowed = ['image/jpeg', 'image/png', 'image/jpg'];
                 if (!allowed.includes(file.type)) {
                     alert('Format file tidak didukung. Gunakan JPG atau PNG.');
                     return;
                 }
                 if (file.size > 5 * 1024 * 1024) {
                     alert('Ukuran file terlalu besar. Maksimal 5MB.');
                     return;
                 }
                 this.fileName = file.name;
                 this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                 const reader = new FileReader();
                 reader.onload = (e) => { this.previewUrl = e.target.result; };
                 reader.readAsDataURL(file);
             },
             handleDrop(e) {
                 this.dragging = false;
                 const file = e.dataTransfer.files[0];
                 this.handleFile(file);
             },
             submitForm() {
                 if (!this.previewUrl) return;
                 this.uploading = true;
                 this.$refs.uploadForm.submit();
             }
         }">

        <div class="max-w-xl mx-auto">

            {{-- Back Button --}}
            <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-black mb-8 transition group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Pesanan Saya
            </a>

            {{-- Page Title --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#3b5d50]">Upload Bukti Transfer</h1>
                <p class="text-gray-500 mt-2 text-sm">Kirimkan bukti transfer Anda agar pesanan dapat segera diproses.</p>
            </div>

            {{-- Order ID Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4 mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nomor Pesanan</p>
                    <p class="font-bold text-gray-800 font-mono text-sm">{{ $order->id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 mb-0.5">Total Pembayaran</p>
                    <p class="font-black text-lg text-[#3b5d50]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Upload Form --}}
            <form
                action="{{ route('orders.paid') }}"
                method="POST"
                enctype="multipart/form-data"
                x-ref="uploadForm"
            >
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">
                    <h3 class="font-bold text-gray-800 mb-1">Bukti Transfer</h3>
                    <p class="text-sm text-gray-400 mb-5">Format: JPG atau PNG. Maksimal 5MB.</p>

                    {{-- Drop Zone --}}
                    <div
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="handleDrop($event)"
                        @click="$refs.fileInput.click()"
                        :class="dragging ? 'border-[#3b5d50] bg-[#3b5d50]/5 scale-[1.01]' : (previewUrl ? 'border-[#3b5d50]/40 bg-green-50/30' : 'border-gray-300 hover:border-[#3b5d50] hover:bg-gray-50')"
                        class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-all duration-200"
                    >
                        {{-- Preview --}}
                        <div x-show="previewUrl" style="display:none;" class="mb-3">
                            <img :src="previewUrl" class="max-h-56 mx-auto rounded-lg shadow-sm object-contain" alt="Preview Bukti">
                        </div>

                        {{-- Upload Icon (shown when no preview) --}}
                        <div x-show="!previewUrl" class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-700 mb-1">Klik atau drag & drop gambar di sini</p>
                            <p class="text-sm text-gray-400">JPG, PNG hingga 5MB</p>
                        </div>

                        {{-- File info when selected --}}
                        <div x-show="fileName" style="display:none;" class="mt-3">
                            <p class="text-sm font-semibold text-[#3b5d50]" x-text="'✓ ' + fileName"></p>
                            <p class="text-xs text-gray-400 mt-0.5" x-text="fileSize"></p>
                            <p class="text-xs text-[#3b5d50] mt-2 underline">Klik untuk ganti gambar</p>
                        </div>
                    </div>

                    {{-- Hidden File Input --}}
                    <input
                        type="file"
                        name="payment_proof"
                        accept="image/jpeg,image/png,image/jpg"
                        class="hidden"
                        x-ref="fileInput"
                        @change="handleFile($event.target.files[0])"
                    >
                </div>

                {{-- Submit & Cancel Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('orders.index') }}"
                       class="flex-1 text-center border-2 border-gray-200 text-gray-500 font-bold py-3.5 px-6 rounded-xl hover:bg-gray-100 hover:border-gray-300 transition text-sm">
                        Batalkan
                    </a>

                    {{-- Use @click.prevent and call submitForm() to avoid Alpine disabling button before submit --}}
                    <button
                        type="button"
                        @click="submitForm()"
                        :disabled="!previewUrl || uploading"
                        :class="previewUrl && !uploading
                            ? 'bg-[#3b5d50] text-white hover:shadow-lg hover:bg-[#2d4a3e] cursor-pointer'
                            : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                        class="flex-1 font-bold py-3.5 px-6 rounded-xl transition flex items-center justify-center space-x-2 text-sm">

                        <svg x-show="uploading" style="display:none;" class="w-4 h-4 animate-spin flex-shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <svg x-show="!uploading" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span x-text="uploading ? 'Mengunggah...' : 'Upload Bukti Transfer'"></span>
                    </button>
                </div>

                <p class="text-center text-xs text-gray-400 mt-4 leading-relaxed">
                    Setelah upload, status pesanan berubah menjadi <strong class="text-gray-500">"Menunggu Konfirmasi"</strong> dan admin akan segera memverifikasi.
                </p>
            </form>

        </div>
    </div>
</x-app-layout>
