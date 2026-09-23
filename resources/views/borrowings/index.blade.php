<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Data Peminjaman') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data peminjaman buku oleh anggota.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('borrowings.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Peminjaman Baru
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

            @if(session('error'))
            <div class="bg-red-50/50 border border-red-100 p-4 mb-8 rounded-2xl flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-full">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    
                    <form method="GET" action="{{ route('borrowings.index') }}" class="mb-8 flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 w-full relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode peminjaman atau nama anggota..." class="pl-11 w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" />
                        </div>
                        <div class="w-full md:w-48">
                            <select name="status" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="partial_returned" {{ request('status') === 'partial_returned' ? 'selected' : '' }}>Kembali Sebagian</option>
                                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">Filter</button>
                            @if(request('search') || request('status'))
                                <a href="{{ route('borrowings.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                            @endif
                        </div>
                    </form>

                    <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Kode & Anggota</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Tgl Pinjam & Kembali</th>
                                    <th scope="col" class="pb-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="pb-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($borrowings as $borrowing)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-lg shadow-sm">
                                                    {{ substr($borrowing->member->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $borrowing->member->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                                    <span class="bg-gray-100/80 px-2 py-0.5 rounded font-mono">{{ $borrowing->borrowing_code }}</span>
                                                    <span class="text-gray-400">ID: {{ $borrowing->member->member_code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 flex items-center gap-2 mb-1">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $borrowing->borrow_date->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm flex items-center gap-2 {{ $borrowing->isOverdue() && $borrowing->status != 'returned' ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                            <svg class="w-4 h-4 {{ $borrowing->isOverdue() && $borrowing->status != 'returned' ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $borrowing->due_date->format('d/m/Y') }}
                                            @if($borrowing->isOverdue() && $borrowing->status != 'returned')
                                                <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded uppercase tracking-wider">Terlambat</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-center">
                                        @if($borrowing->status == 'borrowed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/50">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span>
                                                Dipinjam
                                            </span>
                                        @elseif($borrowing->status == 'partial_returned')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                                Sebagian
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($borrowing->status !== 'returned')
                                            <a href="{{ route('returns.create', ['borrowing_id' => $borrowing->id]) }}" class="text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm" title="Proses Pengembalian">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                Kembalikan
                                            </a>
                                            @endif
                                            
                                            <div class="flex opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity gap-1 ml-2">
                                                <a href="{{ route('borrowings.show', $borrowing) }}" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-xl transition-colors" title="Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                                
                                                @can('borrowings.delete')
                                                <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini? Semua detail pinjaman akan ikut terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-xl transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">Belum ada peminjaman</h3>
                                        <p class="mt-1 text-sm text-gray-500">Mulai catat peminjaman buku oleh anggota.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($borrowings->hasPages())
                    <div class="mt-8 border-t border-gray-50 pt-6">
                        {{ $borrowings->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
