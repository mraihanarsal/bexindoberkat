<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Toko') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        showModal: false, 
        isEdit: false,
        tokoId: '',
        platformId: '',
        namaToko: '',
        
        openAddModal() {
            this.isEdit = false;
            this.tokoId = '';
            this.platformId = '';
            this.namaToko = '';
            this.showModal = true;
        },
        
        openEditModal(id, p_id, nama) {
            this.isEdit = true;
            this.tokoId = id;
            this.platformId = p_id;
            this.namaToko = nama;
            this.showModal = true;
        }
    }">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Data Toko</h3>
                        <button @click="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors shadow-sm">
                            + Tambah Data
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold w-20">No.</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Platform</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Nama Toko</th>
                                    <th scope="col" class="px-6 py-4 font-semibold w-32">Status</th>
                                    <th scope="col" class="px-6 py-4 font-semibold w-48 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($tokos as $toko)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $toko->id }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $toko->platform->nama_platform ?? 'Platform Dihapus' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $toko->nama_toko }}</td>
                                    <td class="px-6 py-4">
                                        @if($toko->aktif)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button @click="openEditModal({{ $toko->id }}, '{{ $toko->platform_id }}', '{{ addslashes($toko->nama_toko) }}')" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Edit</button>

                                        <span class="text-gray-300 dark:text-gray-600">|</span>

                                        @if($toko->aktif)
                                        <form action="{{ url('dashboard/kelola_toko/'.$toko->id) }}" method="POST" class="inline-block" onsubmit="confirmToggle(event, this, 'menonaktifkan')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Nonaktifkan</button>
                                        </form>
                                        @else
                                        <form action="{{ url('dashboard/kelola_toko/'.$toko->id.'/activate') }}" method="POST" class="inline-block" onsubmit="confirmToggle(event, this, 'mengaktifkan kembali')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium">Aktifkan</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data toko.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">

                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
                    @click="showModal = false" aria-hidden="true"></div>

                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">

                    <form :action="isEdit ? '{{ url('dashboard/kelola_toko') }}/' + tokoId : '{{ url('dashboard/kelola_toko') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title" x-text="isEdit ? 'Edit Toko' : 'Tambah Toko Baru'">
                                    </h3>
                                    
                                    <div class="mt-4 space-y-4">
                                        <!-- Select Platform -->
                                        <div>
                                            <label for="platform_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Platform</label>
                                            <select name="platform_id" id="platform_id" x-model="platformId" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                                <option value="" disabled>-- Pilih Platform --</option>
                                                @foreach($platforms as $platform)
                                                    <option value="{{ $platform->id }}">{{ $platform->nama_platform }}</option>
                                                @endforeach
                                            </select>
                                            @if($platforms->isEmpty())
                                                <p class="mt-1 text-xs text-red-500">Anda belum memiliki platform aktif. Silakan tambahkan platform terlebih dahulu.</p>
                                            @endif
                                        </div>

                                        <!-- Input Nama Toko -->
                                        <div>
                                            <label for="nama_toko" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Toko</label>
                                            <input type="text" name="nama_toko" id="nama_toko" x-model="namaToko" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: BEX Official Store" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm" :disabled="{{ $platforms->isEmpty() ? 'true' : 'false' }}" :class="{ 'opacity-50 cursor-not-allowed': {{ $platforms->isEmpty() ? 'true' : 'false' }} }">
                                Simpan
                            </button>
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmToggle(event, form, actionText) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan " + actionText + " toko ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    </script>
</x-app-layout>
