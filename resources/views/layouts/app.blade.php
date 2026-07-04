<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          sidebarOpen: window.innerWidth >= 1024,
          mobileSidebarOpen: false
      }"
      @resize.window="sidebarOpen = window.innerWidth >= 1024; if(window.innerWidth >= 1024) mobileSidebarOpen = false"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BEX INDO BERKAT') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo/logobexindoberkat.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Prevent FOUC -->
        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 w-full overflow-y-auto">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-transparent z-10">
                        <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

                <!-- Main Footer -->
                <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 h-16 px-4 sm:px-6 lg:px-8 shrink-0 flex flex-col justify-center transition-all duration-300 mt-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        <div class="mb-2 md:mb-0">
                            &copy; PT BEX INDO BERKAT {{ date('Y') }}
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy Policy</a>
                            <span>&middot;</span>
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
