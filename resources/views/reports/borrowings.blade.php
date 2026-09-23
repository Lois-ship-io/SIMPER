<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Laporan Peminjaman') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Laporan rekapitulasi data peminjaman buku.</p>
            </div>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter Section (Hidden on Print) -->
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden print:hidden">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.borrowings') }}" class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" required>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" required>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm">
                                <option value="">Semua Status</option>
                                <option value="borrowed" {{ $status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="returned" {{ $status == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all">Filter</button>
                            <a href="{{ route('reports.borrowings') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Report Content -->
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden print:shadow-none print:border-none">
                <div class="p-8">
                    <!-- Report Header -->
                    <div class="text-center mb-8 border-b pb-6">
                        <h2 class="text-2xl font-bold text-gray-900 uppercase">Laporan Peminjaman Buku</h2>
                        <p class="text-sm text-gray-500 mt-2">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>

                    <!-- Summary Cards (Visible on print too) -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-indigo-50 rounded-2xl p-4 border border-indigo-100 text-center">
                            <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">Total Transaksi</p>
                            <p class="text-2xl font-bold text-indigo-900">{{ $borrowings->count() }}</p>
                        </div>
                        <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100 text-center">
                            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider mb-1">Dikembalikan</p>
                            <p class="text-2xl font-bold text-emerald-900">{{ $borrowings->where('status', 'returned')->count() }}</p>
                        </div>
                        <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100 text-center">
                            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider mb-1">Belum Kembali</p>
                            <p class="text-2xl font-bold text-amber-900">{{ $borrowings->where('status', 'borrowed')->count() }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 text-center">
                            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">Total Buku</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $borrowings->sum(function($borrowing) { return $borrowing->details->sum('qty'); }) }}</p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode / Tgl</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jml Buku</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($borrowings as $index => $borrowing)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $borrowing->borrowing_code }}</div>
                                        <div class="text-xs text-gray-500">{{ $borrowing->borrow_date->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $borrowing->member->name }}</div>
                                        <div class="text-xs text-gray-500">Oleh: {{ $borrowing->user->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-700">
                                        {{ $borrowing->details->sum('qty') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($borrowing->status == 'returned')
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                                        @else
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                        Tidak ada data peminjaman pada periode ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
