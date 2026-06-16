<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Selamat Datang - PT BEX INDO BERKAT</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/logobexindoberkat.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Menggunakan CDN agar styling langsung berjalan tanpa perlu npm run dev -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine JS via CDN untuk dark mode toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans antialiased flex flex-col min-h-screen transition-colors duration-300">

    <!-- Header -->
    <header class="w-full p-6 flex justify-between items-center z-10 max-w-7xl mx-auto">

        <div class="flex items-center gap-6">
            <!-- Theme Toggle -->
            <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600 dark:text-gray-300">
                <!-- Sun Icon -->
                <svg x-cloak x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <!-- Moon Icon -->
                <svg x-cloak x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>

            @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-md shadow-blue-500/20">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Log in
                </a>
                @endauth
            </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-10 px-6 w-full">
        <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Side (Text & CTA) -->
            <div class="flex flex-col justify-center space-y-6 text-center lg:text-left order-2 lg:order-1">
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                        <span class="block">Selamat Datang di</span>
                        <span class="block text-blue-600 dark:text-blue-400 mt-2">PT BEX INDO BERKAT</span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Sistem Manajemen Keuangan untuk mempermudah pengelolaan data, pencatatan transaksi pemasukan dan pengeluaran, serta pembuatan laporan secara efisien.
                    </p>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                        Ke Dashboard Utama
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                        Mulai Sekarang
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-xl text-gray-700 dark:text-gray-200 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Daftar Account
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side (Logo / Illustration) -->
            <div class="flex justify-center items-center order-1 lg:order-2">
                <div class="w-full max-w-sm h-48 relative transform transition-transform duration-500 hover:scale-[1.05]">
                    <img src="{{ asset('logo/logobexindoberkat.png') }}" alt="Logo PT Bex Indo Berkat" class="absolute inset-0 w-full h-full object-contain drop-shadow-2xl transition-opacity duration-300 opacity-100 dark:opacity-0">
                    <img src="{{ asset('logo/logodarkmode.png') }}" alt="Logo PT Bex Indo Berkat" class="absolute inset-0 w-full h-full object-contain drop-shadow-2xl transition-opacity duration-300 opacity-0 dark:opacity-100 transform scale-[1.8]">
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-sm text-gray-500 dark:text-gray-400 mt-auto">
        &copy; {{ date('Y') }} PT Bex Indo Berkat. All rights reserved.
    </footer>

</body>

</html>