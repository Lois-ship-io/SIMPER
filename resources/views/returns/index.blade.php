<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Data Pengembalian') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data pengembalian buku dan denda keterlambatan.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('returns.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    Proses Pengembalian
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-emerald-50/50 border border-emerald-100 p-4 mb-8 rounded-2xl flex items-center gap-3">
                <div class="p-2 bg-emerald-100 rounded-full">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    
                    <form method="GET" action="{{ route('returns.index') }}" class="mb-8 flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 w-full relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode pengembalian atau nama anggota..." class="pl-11 w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" />
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">Filter</button>
                            @if(request('search'))
                                <a href="{{ route('returns.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                            @endif
                        </div>
                    </form>

                    <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Kode & Anggota</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Tgl Kembali</th>
                                    <th scope="col" class="pb-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Denda</th>
                                    <th scope="col" class="pb-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($returns as $return)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold text-lg shadow-sm">
                                                    {{ substr($return->borrowing->member->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $return->borrowing->member->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                                    <span class="bg-gray-100/80 px-2 py-0.5 rounded font-mono">{{ $return->return_code }}</span>
                                                    <span class="text-gray-400">Ref: {{ $return->borrowing->borrowing_code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $return->return_date->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-right">
                                        <div class="text-sm font-medium {{ $return->total_fine > 0 ? 'text-red-600 bg-red-50 inline-block px-2 py-1 rounded-lg border border-red-100' : 'text-gray-500' }}">
                                            @if($return->total_fine > 0)
                                                Rp {{ number_format($return->total_fine, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('returns.show', $return) }}" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-xl transition-colors inline-flex items-center gap-2" title="Detail">
                                                <span class="text-xs font-semibold hidden lg:inline">Detail</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">Belum ada pengembalian</h3>
                                        <p class="mt-1 text-sm text-gray-500">Mulai proses pengembalian buku dari transaksi peminjaman.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($returns->hasPages())
                    <div class="mt-8 border-t border-gray-50 pt-6">
                        {{ $returns->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
