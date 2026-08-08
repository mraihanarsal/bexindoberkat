<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 w-full">

        <!-- Welcome Banner -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    Selamat Datang, {{ auth()->user()->name }}!
                    <span class="text-2xl inline-block origin-bottom-right hover:animate-bounce cursor-default">👋</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Anda sedang login dengan email <span class="font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->email }}</span>
                </p>
            </div>
            <div class="text-left sm:text-right bg-gray-50 dark:bg-gray-700/50 px-4 py-2 rounded-lg border border-gray-100 dark:border-gray-600">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">Waktu Akses</p>
                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                <p class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
            </div>
        </div>

        <!-- Top Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Stat Card 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pemasukan</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                <div class="flex items-center justify-between text-xs">
                    <a href="{{ route('pemasukan.riwayat') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Lihat detail &rarr;</a>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengeluaran</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                <div class="flex items-center justify-between text-xs">
                    <a href="{{ route('pengeluaran.riwayat') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Lihat detail &rarr;</a>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendapatan</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Rp {{ number_format($labaBersih, 0, ',', '.') }}</div>
                <div class="flex items-center justify-between text-xs">
                    <a href="{{ route('laporan.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Lihat detail &rarr;</a>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Platform</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ number_format($totalPlatform, 0, ',', '.') }}</div>
                <div class="flex items-center justify-between text-xs">
                    <a href="{{ url('dashboard/kelola_platform') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Kelola platform &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Middle Section: Tables & Active Users -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Transactions Area (2/3 width) -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Pemasukan Terbaru -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pemasukan Terbaru</h3>
                        <a href="{{ route('pemasukan.riwayat') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-900 dark:text-gray-300 font-semibold bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">ID</th>
                                    <th scope="col" class="px-4 py-3">Toko</th>
                                    <th scope="col" class="px-4 py-3 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($recentPemasukans as $trx)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">#PM-{{ $trx->id }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($trx->toko->nama_toko, 15) }} <br><span class="text-[10px] text-gray-400">({{ $trx->toko->platform->nama_platform }})</span></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right text-green-600 dark:text-green-400 font-semibold">Rp {{ number_format($trx->jumlah_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pengeluaran Terbaru -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengeluaran Terbaru</h3>
                        <a href="{{ route('pengeluaran.riwayat') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-900 dark:text-gray-300 font-semibold bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Keterangan</th>
                                    <th scope="col" class="px-4 py-3">Kategori</th>
                                    <th scope="col" class="px-4 py-3 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($recentPengeluarans as $pengeluaran)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ \Illuminate\Support\Str::limit($pengeluaran->keterangan ?? '-', 15) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $pengeluaran->nama_pengeluaran ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-red-600 dark:text-red-400 font-semibold">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Active Users (1/3 width) -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        Pengguna Aktif
                    </h3>
                    <span class="text-xs bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-2 py-1 rounded-full font-medium">{{ $activeUsers->count() }} Online</span>
                </div>
                <div class="p-4 flex-1">
                    <ul class="space-y-4">
                        @forelse($activeUsers as $user)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=FFFFFF&background=3B82F6" class="w-10 h-10 rounded-full shadow-sm">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::createFromTimestamp($user->last_activity)->diffForHumans() }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="text-center text-sm text-gray-500 py-4">Tidak ada pengguna aktif.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
