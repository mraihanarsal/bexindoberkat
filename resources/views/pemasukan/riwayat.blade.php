<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pemasukan') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Data Riwayat Pemasukan</h3>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">Toko & Platform</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Jumlah Pendapatan</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Keterangan</th>
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <th scope="col" class="px-6 py-4 font-semibold text-center">Dibuat Oleh</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-center">Waktu Dibuat</th>
                                    @endif
                                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($pemasukans as $pemasukan)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $pemasukan->toko->nama_toko }}<br>
                                        <span class="text-xs text-gray-500">{{ $pemasukan->toko->platform->nama_platform }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pemasukan->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($pemasukan->jumlah_pendapatan, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">{{ $pemasukan->keterangan ?? '-' }}</td>
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            {{ $pemasukan->user->name ?? 'Sistem' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $pemasukan->created_at ? $pemasukan->created_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('pemasukan.destroy', $pemasukan->id) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->check() && auth()->user()->role == 1) ? '6' : '5' }}" class="px-6 py-4 text-center">Belum ada data pemasukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                text: "Anda yakin ingin menghapus data riwayat pemasukan ini?",
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