<x-app-layout>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Dashboard
            </h2>
            <p class="mt-1 text-gray-500 font-medium text-sm">Selamat datang kembali, {{ Auth::user()->name }}! Berikut ringkasan hari ini.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="bg-white px-5 py-2.5 rounded-full border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-sm font-semibold text-gray-700">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Minimalist Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Buku -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['total_books'] ?? 0) }}</p>
            <h3 class="text-gray-500 text-sm font-medium">Total Buku Tersedia</h3>
        </div>

        @role('admin')
        <!-- Anggota -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['total_members'] ?? 0) }}</p>
            <h3 class="text-gray-500 text-sm font-medium">Anggota Aktif</h3>
        </div>
        @else
        <!-- Pengunjung Hari Ini -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['visitors_today'] ?? 0) }}</p>
            <h3 class="text-gray-500 text-sm font-medium">Pengunjung Hari Ini</h3>
        </div>
        @endrole

        <!-- Peminjaman Hari ini -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['borrowings_today'] ?? 0) }}</p>
            <h3 class="text-gray-500 text-sm font-medium">Peminjaman Hari Ini</h3>
        </div>

        <!-- Pengembalian -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['returns_today'] ?? 0) }}</p>
            <h3 class="text-gray-500 text-sm font-medium">Pengembalian Hari Ini</h3>
        </div>
    </div>

    <!-- Two columns: Chart & Popular Books -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 sm:p-8">
            <h3 class="text-lg font-extrabold text-gray-900 mb-1">Statistik Peminjaman</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Tren sirkulasi 6 bulan terakhir</p>
            <div class="w-full relative" style="height: 320px;">
                <canvas id="circulationChart"></canvas>
            </div>
        </div>

        <!-- Popular Books -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-1">Buku Terpopuler</h3>
                    <p class="text-sm text-gray-500 font-medium">Sering dipinjam</p>
                </div>
            </div>
            
            <div class="space-y-4">
                @forelse($popularBooks as $book)
                    <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-2xl transition-all duration-200 border border-transparent hover:border-gray-100 cursor-default">
                        <div class="w-12 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                            @if($book->cover)
                                <img src="{{ asset('storage/covers/' . $book->cover) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 line-clamp-1">{{ $book->title }}</h4>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Dipinjam {{ $book->total_borrowed }}x</p>
                        </div>
                        <div class="w-8 h-8 rounded-full {{ $loop->first ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-600' }} flex items-center justify-center text-sm font-bold">
                            {{ $loop->iteration }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-sm text-gray-500">
                        Belum ada data buku populer.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartCanvas = document.getElementById('circulationChart');
            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const chartData = @json($chartData);
                
                // Gradient for the line chart fill
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); // Emerald 500 at 20%
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                
                new Chart(ctx, {
                    type: 'line', 
                    data: {
                        labels: chartData.labels,
                        datasets: [
                            {
                                label: 'Peminjaman',
                                data: chartData.borrowings,
                                borderColor: '#10b981', // emerald-500
                                backgroundColor: gradient,
                                tension: 0.4,
                                fill: true,
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#10b981',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleFont: { family: 'Inter', weight: 'bold' },
                                bodyFont: { family: 'Inter' },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: { color: '#f3f4f6', drawBorder: false },
                                ticks: { stepSize: 1, color: '#9ca3af', font: { family: 'Inter' }, padding: 10 }
                            },
                            x: {
                                border: { display: false },
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#9ca3af', font: { family: 'Inter' }, padding: 10 }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
