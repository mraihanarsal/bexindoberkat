<div x-data="{ openPemasukan: false, sidebarOpen: true }" 
     :class="sidebarOpen ? 'w-64' : 'w-20'"
     class="flex flex-col bg-blue-600 dark:bg-gray-800 text-white transition-all duration-300 min-h-screen">
    
    <!-- Sidebar - Brand -->
    <a href="{{ url('/') }}" class="flex items-center justify-center h-16 border-b border-blue-500 dark:border-gray-700 px-4">
        <div class="transform -rotate-15">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="mx-3 font-bold text-lg" x-show="sidebarOpen">Welcome !</div>
    </a>

    <!-- Divider -->
    <hr class="border-blue-500 dark:border-gray-700 my-0">

    <div class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-2">
            <!-- Nav Item - Dashboard -->
            <li>
                <a href="{{ url('/') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('/') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="mx-3" x-show="sidebarOpen">Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="border-blue-500 dark:border-gray-700 my-4" x-show="sidebarOpen">

            <!-- Heading -->
            <div class="px-4 text-xs font-semibold text-blue-200 dark:text-gray-400 uppercase tracking-wider mb-2" x-show="sidebarOpen">
                Kelola
            </div>

            <!-- Menu Toko (Pemasukan) -->
            <li x-data="{ isPemasukanOpen: false }">
                <button @click="isPemasukanOpen = !isPemasukanOpen" class="w-full flex items-center justify-between px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="mx-3" x-show="sidebarOpen">Pemasukan</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transform transition-transform" :class="isPemasukanOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="isPemasukanOpen && sidebarOpen" x-transition class="mt-2 py-2 bg-white dark:bg-gray-900 rounded-md shadow-inner mx-4">
                    <h6 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Platform:</h6>
                    <a href="{{ url('shopee') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <img src="{{ asset('img/shopee.png') }}" alt="Shopee" class="w-4 h-4 mr-2">
                        Shopee
                    </a>
                    <a href="{{ url('tiktok') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <img src="{{ asset('img/tiktok.png') }}" alt="TikTok" class="w-4 h-4 mr-2">
                        TikTok
                    </a>
                    <a href="{{ url('zefatex') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <img src="{{ asset('img/konveksi.png') }}" alt="Zefatex" class="w-4 h-4 mr-2">
                        Zefatex
                    </a>
                </div>
            </li>

            <!-- Nav Item - Pengeluaran -->
            <li>
                <a href="{{ url('pengeluaran') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('pengeluaran') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="mx-3" x-show="sidebarOpen">Pengeluaran</span>
                </a>
            </li>

            <!-- Nav Item - Kelola Pengguna -->
            @if (auth()->check() && (auth()->user()->is_master || auth()->user()->role === 'admin'))
            <li>
                <a href="{{ url('dashboard/kelola_pengguna') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('dashboard/kelola_pengguna') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="mx-3" x-show="sidebarOpen">Kelola Pengguna</span>
                </a>
            </li>
            @endif

            <!-- Nav Item - Rekapitulasi -->
            <li>
                <a href="{{ url('laporan') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('laporan') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="mx-3" x-show="sidebarOpen">Rekapitulasi</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Toggler -->
    <div class="hidden md:flex justify-center py-4 border-t border-blue-500 dark:border-gray-700">
        <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 rounded-full bg-blue-700 dark:bg-gray-700 flex items-center justify-center text-white hover:bg-blue-800 dark:hover:bg-gray-600 transition-colors">
            <svg class="w-5 h-5 transform transition-transform" :class="!sidebarOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>
</div>
