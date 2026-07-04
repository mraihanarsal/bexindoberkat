<!-- Mobile Sidebar Overlay Backdrop -->
<div x-show="mobileSidebarOpen"
    @click="mobileSidebarOpen = false"
    x-transition.opacity.duration.300ms
    class="fixed inset-0 bg-gray-900/60 z-40 lg:hidden" style="display: none;"></div>

<!-- Sidebar Container -->
<div x-data="{ openPemasukan: false }"
    :class="{
         'w-64': sidebarOpen || mobileSidebarOpen,
         'w-20': !sidebarOpen && !mobileSidebarOpen,
         'translate-x-0': mobileSidebarOpen,
         '-translate-x-full': !mobileSidebarOpen
     }"
    class="fixed lg:relative inset-y-0 left-0 z-50 flex flex-col bg-blue-600 dark:bg-gray-800 text-white transition-all duration-300 min-h-screen lg:translate-x-0">
    <!-- Sidebar - Brand with Modal Preview -->
    <div x-data="{ openLogoPreview: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700">
        <button @click="openLogoPreview = true" type="button" class="w-full flex items-center justify-center h-16 px-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none">
            <!-- Full Logo for Expanded Sidebar -->
            <div class="relative w-40 h-10" x-show="sidebarOpen || mobileSidebarOpen">
                <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo PT Bex Indo Berkat" class="absolute inset-0 w-full h-full object-contain drop-shadow-sm transition-opacity duration-300 opacity-100 dark:opacity-0 pointer-events-none" />
                <img src="{{ asset('logo/logodarkmode.png') }}" alt="Logo PT Bex Indo Berkat" class="absolute inset-0 w-full h-full object-contain drop-shadow-sm transition-opacity duration-300 opacity-0 dark:opacity-100 transform scale-150 pointer-events-none" />
            </div>

            <!-- Logo for Collapsed Sidebar -->
            <div class="relative w-10 h-10 transition-all duration-300" x-show="!sidebarOpen && !mobileSidebarOpen" style="display: none;">
                <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo Icon" class="absolute inset-0 w-full h-full object-contain drop-shadow-sm transition-opacity duration-300 opacity-100 dark:opacity-0 pointer-events-none" />
                <img src="{{ asset('logo/logodarkmode.png') }}" alt="Logo Icon" class="absolute inset-0 w-full h-full object-contain drop-shadow-sm transition-opacity duration-300 opacity-0 dark:opacity-100 transform scale-150 pointer-events-none" />
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

                <!-- Image container with dynamic background -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl mb-6 w-full flex justify-center items-center mt-8 relative border border-gray-100 dark:border-gray-700 h-64">
                    <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo Preview" class="absolute inset-0 w-full h-full p-8 object-contain drop-shadow-md transition-opacity duration-300 opacity-100 dark:opacity-0" />
                    <img src="{{ asset('logo/logodarkmode.png') }}" alt="Logo Preview" class="absolute inset-0 w-full h-full p-8 object-contain drop-shadow-md transition-opacity duration-300 opacity-0 dark:opacity-100 transform scale-150" />
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
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="border-blue-500 dark:border-gray-700 my-4" x-show="sidebarOpen || mobileSidebarOpen">

            <!-- Heading -->
            <div class="px-4 text-xs font-semibold text-blue-200 dark:text-gray-400 uppercase tracking-wider mb-2" x-show="sidebarOpen || mobileSidebarOpen">
                Master Data
            </div>
            <!-- Nav Item - Kelola Pengguna -->
            <li>
                <a href="{{ url('dashboard/kelola_pengguna') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('dashboard/kelola_pengguna') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Pengguna</span>
                </a>
            </li>
            <li>
                <a href="{{ url('dashboard/kategori') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('dashboard/kategori') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ url('dashboard/produk') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('dashboard/produk') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Produk</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="border-blue-500 dark:border-gray-700 my-4" x-show="sidebarOpen || mobileSidebarOpen">

            <div class="px-4 text-xs font-semibold text-blue-200 dark:text-gray-400 uppercase tracking-wider mb-2" x-show="sidebarOpen || mobileSidebarOpen">
                Kelola
            </div>

            <!-- Menu Toko (Pemasukan) -->
            <li x-data="{ isPemasukanOpen: false }">
                <button @click="isPemasukanOpen = !isPemasukanOpen; if(!sidebarOpen && !mobileSidebarOpen) { sidebarOpen = true; isPemasukanOpen = true; }" class="w-full flex items-center justify-between px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors" :class="{'bg-blue-700 dark:bg-gray-700': isPemasukanOpen}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Pemasukan</span>
                    </div>
                    <!-- Chevron icon for dropdown -->
                    <svg x-show="sidebarOpen || mobileSidebarOpen" :class="{ 'rotate-180': isPemasukanOpen }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Content -->
                <div x-show="isPemasukanOpen && (sidebarOpen || mobileSidebarOpen)"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="overflow-hidden mt-1">
                    <ul class="space-y-1 py-1">
                        <li>
                            <a href="#" class="block px-11 py-2 text-sm text-blue-100 hover:text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors">
                                Input Pemasukan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-11 py-2 text-sm text-blue-100 hover:text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors">
                                Riwayat Pemasukan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Nav Item - Pengeluaran -->
            <li>
                <a href="{{ url('pengeluaran') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('pengeluaran') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Pengeluaran</span>
                </a>
            </li>




            <!-- Nav Item - Rekapitulasi -->
            <li>
                <a href="{{ url('laporan') }}" class="flex items-center px-4 py-2 text-white hover:bg-blue-700 dark:hover:bg-gray-700 rounded-md transition-colors {{ request()->is('laporan') ? 'bg-blue-700 dark:bg-gray-700 font-bold' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="mx-3" x-show="sidebarOpen || mobileSidebarOpen">Rekapitulasi</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="bg-blue-700 dark:bg-gray-900 border-t border-blue-500 dark:border-gray-700 p-4 transition-all duration-300 mt-auto">
        <div class="text-xs text-blue-200 dark:text-gray-400 mb-1" x-show="sidebarOpen || mobileSidebarOpen">Logged in as:</div>
        <div class="text-sm font-semibold truncate" x-show="sidebarOpen || mobileSidebarOpen">
            {{ auth()->user()->name ?? 'Guest' }} - {{ auth()->user()->role ?? 'User' }}
        </div>

        <!-- Collapsed state icon or initials -->
        <div class="flex justify-center" x-show="!sidebarOpen && !mobileSidebarOpen" style="display: none;">
            <div class="w-10 h-10 rounded-full bg-blue-800 dark:bg-gray-700 border border-blue-500 dark:border-gray-600 flex items-center justify-center text-sm font-bold shadow-inner" title="{{ auth()->user()->name ?? 'Guest' }}">
                {{ substr(auth()->user()->name ?? 'G', 0, 1) }}
            </div>
        </div>
    </div>
</div>