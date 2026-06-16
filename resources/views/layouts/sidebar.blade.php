<div x-data="{ openPemasukan: false, sidebarOpen: true }" 
     :class="sidebarOpen ? 'w-64' : 'w-20'"
     class="flex flex-col bg-blue-600 dark:bg-gray-800 text-white transition-all duration-300 min-h-screen">
    
    <!-- Sidebar - Brand with Modal Preview -->
    <div x-data="{ openLogoPreview: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700">
        <button @click="openLogoPreview = true" type="button" class="w-full flex items-center justify-center h-16 px-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none">
            <!-- Full Logo for Expanded Sidebar -->
            <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo PT Bex Indo Berkat" class="h-10 w-auto object-contain drop-shadow-sm transition-all duration-300" x-show="sidebarOpen" />
            
            <!-- Short Text for Collapsed Sidebar -->
            <div class="font-extrabold text-blue-600 dark:text-blue-400 text-xl tracking-wider transition-all duration-300" x-show="!sidebarOpen" style="display: none;">
                BIB
            </div>
        </button>

        <!-- Preview Modal -->
        <div x-show="openLogoPreview" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden">
            <!-- Backdrop -->
            <div x-show="openLogoPreview"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                @click="openLogoPreview = false"></div>

            <!-- Modal Panel -->
            <div x-show="openLogoPreview"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-transparent p-6 max-w-sm w-full mx-4 flex flex-col items-center justify-center transform transition-all z-10">

                <!-- Close Button -->
                <button @click="openLogoPreview = false" class="absolute top-0 right-0 mt-4 mr-4 text-white hover:text-gray-300 focus:outline-none z-20">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Image container with white background -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl mb-6 w-full flex justify-center items-center mt-8 relative border border-gray-100 dark:border-gray-700" style="min-height: 150px;">
                    <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo Preview" class="max-h-48 w-auto drop-shadow-md" />
                </div>

                <!-- Download Button -->
                <a href="{{ asset('logo/logobexindoberkat.png') }}" download="logobexindoberkat.png" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-full shadow-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Logo
                </a>
            </div>
        </div>
    </div>

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
