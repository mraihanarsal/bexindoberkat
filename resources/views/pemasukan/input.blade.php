<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemasukan') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="w-full sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col lg:flex-row gap-6">

            <!-- Form Manual -->
            <div class="w-full lg:w-1/2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Input Manual</h3>

                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('pemasukan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Toko & Platform</label>
                            <select name="toko_id" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}">{{ $toko->nama_toko }} ({{ $toko->platform->nama_platform }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemasukan</label>
                            <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4" x-data="{
                            raw: '',
                            formatInput(e) {
                                let val = e.target.value.replace(/\D/g, '');
                                if (val.length > 15) {
                                    val = '';
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Melebihi Batas',
                                        text: 'Nominal melebihi batas maksimal rupiah.',
                                        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                                        color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827'
                                    });
                                }
                                this.raw = val;
                                e.target.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';
                            }
                        }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Pendapatan (Rp)</label>
                            <input type="text"
                                @input="formatInput($event)"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Contoh: 1.500.000">
                            <input type="hidden" name="jumlah_pendapatan" :value="raw" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('pemasukan.riwayat') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2 transition-colors">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Auto Upload PDF -->
            <div class="w-full lg:w-1/2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Auto-Import dari PDF Invoice Shopee</h3>
                    <!-- Tampilan Contoh Invoice -->
                    <h3 class="text-lg font-bold mb-4">Contoh Invoice Shopee</h3>
                    <div class="mb-6 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img src="{{ asset('contohupload/contohupload.png') }}" alt="Contoh Invoice Shopee" class="w-full h-auto object-cover">
                    </div>
                    <form action="{{ route('pemasukan.upload_pdf') }}" method="POST" enctype="multipart/form-data" x-data="{ isUploading: false }" @submit="isUploading = true">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload File PDF (Maks 10MB/file)</label>
                            <input type="file" name="pdfs[]" multiple accept=".pdf" required class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                            <span class="font-medium">Catatan:</span> <strong>Hanya Untuk Invoice Shopee.</strong>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors shadow-sm flex items-center justify-center gap-2" :disabled="isUploading">
                                <span x-show="!isUploading">Buat Data</span>
                                <span x-show="isUploading">Mengekstrak Data...</span>
                                <svg x-show="isUploading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
