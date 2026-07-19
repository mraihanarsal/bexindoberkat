<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pengeluaran') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Data Riwayat Pengeluaran</h3>
                        <a href="{{ route('pengeluaran.input') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors shadow-sm">+ Tambah Data</a>
                    </div>



                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">No</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Nama Pengeluaran</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Jumlah Pengeluaran</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Keterangan</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($pengeluarans as $pengeluaran)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $pengeluarans->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $pengeluaran->nama_pengeluaran }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 font-semibold text-red-600 dark:text-red-400">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">{{ $pengeluaran->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">Belum ada data pengeluaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pengeluarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda yakin ingin menghapus data riwayat pengeluaran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
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
