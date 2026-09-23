<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Laporan Pengembalian') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Laporan rekapitulasi data pengembalian buku dan denda.</p>
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
                    <form method="GET" action="{{ route('reports.returns') }}" class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" required>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" required>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all">Filter</button>
                            <a href="{{ route('reports.returns') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Report Content -->
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden print:shadow-none print:border-none">
                <div class="p-8">
                    <!-- Report Header -->
                    <div class="text-center mb-8 border-b pb-6">
                        <h2 class="text-2xl font-bold text-gray-900 uppercase">Laporan Pengembalian Buku</h2>
                        <p class="text-sm text-gray-500 mt-2">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 text-center flex flex-col justify-center">
                            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider mb-2">Total Pengembalian</p>
                            <p class="text-3xl font-bold text-emerald-900">{{ $returns->count() }} <span class="text-lg font-medium text-emerald-700">transaksi</span></p>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-5 border border-red-100 text-center flex flex-col justify-center">
                            <p class="text-sm font-semibold text-red-600 uppercase tracking-wider mb-2">Total Denda</p>
                            <p class="text-3xl font-bold text-red-900">Rp {{ number_format($totalFines, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 text-center flex flex-col justify-center">
                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-2">Ada Denda</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $returns->where('total_fine', '>', 0)->count() }} <span class="text-lg font-medium text-blue-700">transaksi</span></p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode / Tgl Kembali</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Anggota</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penerima</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Denda (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($returns as $index => $return)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $return->return_code }}</div>
                                        <div class="text-xs text-gray-500">{{ $return->return_date->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $return->borrowing->member->name }}</div>
                                        <div class="text-xs text-gray-500">Ref: {{ $return->borrowing->borrowing_code }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $return->user->name }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $return->total_fine > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                        {{ number_format($return->total_fine, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                        Tidak ada data pengembalian pada periode ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold">
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-right text-sm text-gray-900 uppercase">Total Denda Keseluruhan:</td>
                                    <td class="px-4 py-4 text-right text-sm text-red-700">Rp {{ number_format($totalFines, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
