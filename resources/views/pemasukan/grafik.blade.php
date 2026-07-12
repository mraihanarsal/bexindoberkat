<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grafik Pembanding Pemasukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('pemasukan.grafik') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

                        <!-- Filter Periode Pembanding (Period 2) -->
                        <div class="flex-1 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Periode Sebelumnya</h4>
                            <input type="month" name="period2" value="{{ $period2 }}" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm cursor-pointer">
                        </div>
                        <!-- Filter Periode Utama (Period 1) -->
                        <div class="flex-1 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800">
                            <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">Periode Sekarang</h4>
                            <input type="month" name="period1" value="{{ $period1 }}" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm cursor-pointer">
                        </div>

                        <div class="w-full md:w-auto">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Card Utama -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Pemasukan ({{ date('F', mktime(0,0,0,$month1,10)) }} {{ $year1 }})</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($total1, 0, ',', '.') }}</div>
                    </div>
                </div>
                <!-- Card Pembanding -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-gray-400">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Pemasukan ({{ date('F', mktime(0,0,0,$month2,10)) }} {{ $year2 }})</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($total2, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">Perbandingan Pemasukan Berdasarkan Toko</h3>
                    <div class="relative h-96 w-full">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('comparisonChart').getContext('2d');

            // Format Rupiah untuk tooltip
            const rupiahFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Mendeteksi mode dark/light untuk warna teks
            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#e5e7eb' : '#374151';
            const gridColor = isDarkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: JSON.parse('{!! addslashes(json_encode($labels)) !!}'),
                    datasets: [{
                            label: '{{ date("F", mktime(0,0,0,$month1,10)) }} {{ $year1 }}',
                            data: JSON.parse('{!! addslashes(json_encode($chartToko1)) !!}'),
                            backgroundColor: 'rgba(59, 130, 246, 0.8)', // blue-500
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: '{{ date("F", mktime(0,0,0,$month2,10)) }} {{ $year2 }}',
                            data: JSON.parse('{!! addslashes(json_encode($chartToko2)) !!}'),
                            backgroundColor: 'rgba(156, 163, 175, 0.8)', // gray-400
                            borderColor: 'rgb(156, 163, 175)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: textColor
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += rupiahFormatter.format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                callback: function(value) {
                                    if (value >= 1000000000000) return 'Rp ' + (value / 1000000000000) + ' T';
                                    if (value >= 1000000000) return 'Rp ' + (value / 1000000000) + ' M';
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            },
                            grid: {
                                color: gridColor
                            }
                        },
                        x: {
                            ticks: {
                                color: textColor
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>