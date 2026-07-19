<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Keuangan & Laba Bersih') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col md:flex-row justify-between items-center">
                    <h3 class="text-lg font-bold mb-4 md:mb-0">Filter Tahun Laporan</h3>
                    <form action="{{ url('laporan') }}" method="GET" class="flex gap-4 w-full md:w-auto">
                        <select name="year" onchange="this.form.submit()" class="w-full md:w-48 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm cursor-pointer">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Pemasukan -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Pemasukan ({{ $year }})</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                    </div>
                </div>
                <!-- Pengeluaran -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Pengeluaran ({{ $year }})</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                    </div>
                </div>
                <!-- Laba Bersih -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Laba Bersih ({{ $year }})</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">Grafik Pemasukan, Pengeluaran & Laba Bersih ({{ $year }})</h3>
                    <div class="relative h-96 w-full">
                        <canvas id="laporanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('laporanChart').getContext('2d');

            const rupiahFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#e5e7eb' : '#374151';
            const gridColor = isDarkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: JSON.parse('{!! addslashes(json_encode($labels)) !!}'),
                    datasets: [
                        {
                            label: 'Laba Bersih',
                            data: JSON.parse('{!! addslashes(json_encode($labaBersih)) !!}'),
                            type: 'line',
                            backgroundColor: 'rgba(34, 197, 94, 1)', // green-500
                            borderColor: 'rgb(34, 197, 94)',
                            borderWidth: 3,
                            tension: 0.3,
                            fill: false,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Pemasukan',
                            data: JSON.parse('{!! addslashes(json_encode($pemasukan)) !!}'),
                            backgroundColor: 'rgba(59, 130, 246, 0.8)', // blue-500
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1,
                            borderRadius: 4,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Pengeluaran',
                            data: JSON.parse('{!! addslashes(json_encode($pengeluaran)) !!}'),
                            backgroundColor: 'rgba(239, 68, 68, 0.8)', // red-500
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 1,
                            borderRadius: 4,
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
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
                                    if (value >= 1000000000000 || value <= -1000000000000) return 'Rp ' + (value / 1000000000000) + ' T';
                                    if (value >= 1000000000 || value <= -1000000000) return 'Rp ' + (value / 1000000000) + ' M';
                                    if (value >= 1000000 || value <= -1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                    if (value >= 1000 || value <= -1000) return 'Rp ' + (value / 1000) + 'k';
                                    return 'Rp ' + value;
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
