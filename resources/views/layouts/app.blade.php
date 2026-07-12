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
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100"
          data-session-success="{{ session('success') }}"
          data-session-error="{{ session('error') }}"
          data-has-errors="{{ $errors->any() ? 'true' : 'false' }}">
        <div class="flex h-screen bg-[#f5f7fb] dark:bg-gray-900 overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                @include('layouts.navigation')

                <!-- Scrollable Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f5f7fb] dark:bg-gray-900 flex flex-col">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-transparent z-10 flex-shrink-0">
                            <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <div class="flex-1 p-4 sm:p-6 lg:p-8">
                        {{ $slot }}
                    </div>

                    <!-- Main Footer -->
                    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 h-16 px-4 sm:px-6 lg:px-8 flex-shrink-0 flex items-center justify-between transition-all duration-300 w-full mt-auto">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            &copy; PT BEX INDO BERKAT {{ date('Y') }}
                        </div>
                        <div class="flex space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy Policy</a>
                            <span>&middot;</span>
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms &amp; Conditions</a>
                        </div>
                    </footer>
                </main>
            </div>
        </div>
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sessionSuccess = document.body.dataset.sessionSuccess;
                const sessionError = document.body.dataset.sessionError;
                const hasErrors = document.body.dataset.hasErrors === 'true';

                if (sessionSuccess || sessionError || hasErrors) {
                    // Konfigurasi SweetAlert2 agar menyesuaikan dengan Dark Mode Tailwind
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    if (sessionSuccess) {
                        Toast.fire({
                            icon: 'success',
                            title: sessionSuccess
                        });
                    }

                    if (sessionError) {
                        Toast.fire({
                            icon: 'error',
                            title: sessionError
                        });
                    }
                    
                    if (hasErrors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terdapat kesalahan pada input Anda!',
                            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                            color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#111827',
                        });
                    }
                }
            });
        </script>
    </body>
</html>
