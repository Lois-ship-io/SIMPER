<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('borrowings.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                        {{ __('Detail Peminjaman') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap transaksi peminjaman buku.</p>
                </div>
            </div>
            @if($borrowing->status !== 'returned')
            <a href="{{ route('returns.create', ['borrowing_id' => $borrowing->id]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors border border-transparent focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Proses Pengembalian
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informasi Peminjam -->
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Peminjam
                    </h3>
                    
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold text-2xl shadow-sm">
                            {{ substr($borrowing->member->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900">{{ $borrowing->member->name }}</h4>
                            <p class="text-gray-500 flex items-center gap-2 mt-1">
                                <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono text-gray-700">{{ $borrowing->member->member_code }}</span>
                                @if($borrowing->member->nis)
                                    <span class="text-sm">• NIS: {{ $borrowing->member->nis }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-6 border-t border-gray-100 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Nomor Telepon</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $borrowing->member->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Kelas/Tingkat</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $borrowing->member->kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Transaksi -->
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-24 h-24 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Detail Transaksi
                        </h3>
                        
                        <div class="flex flex-col items-end gap-2">
                            @if($borrowing->status == 'borrowed')
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/50">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span>
                                    Sedang Dipinjam
                                </span>
                            @elseif($borrowing->status == 'partial_returned')
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                    Kembali Sebagian
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                    Selesai Dikembalikan
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-xs font-medium text-gray-500 mb-1">Kode Peminjaman</p>
                        <p class="text-2xl font-mono font-bold text-gray-900 bg-gray-50 px-4 py-2 rounded-xl inline-block border border-gray-100">{{ $borrowing->borrowing_code }}</p>
                    </div>
                    
                    <div class="mt-auto pt-6 border-t border-gray-100 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Tanggal Pinjam</p>
                            <p class="text-sm font-semibold text-gray-900 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $borrowing->borrow_date->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Batas Kembali</p>
                            <div class="text-sm font-semibold flex items-center gap-1.5 {{ $borrowing->isOverdue() && $borrowing->status != 'returned' ? 'text-red-600' : 'text-gray-900' }}">
                                <svg class="w-4 h-4 {{ $borrowing->isOverdue() && $borrowing->status != 'returned' ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $borrowing->due_date->format('d M Y') }}
                            </div>
                            @if($borrowing->isOverdue() && $borrowing->status != 'returned')
                                <p class="text-xs text-red-600 mt-1 font-medium bg-red-50 inline-block px-2 py-0.5 rounded">Terlambat {{ $borrowing->calculateLateDays() }} hari</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Buku -->
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Daftar Buku yang Dipinjam
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Buku</th>
                                <th scope="col" class="px-8 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-8 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @foreach($borrowing->details as $index => $detail)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-10 bg-emerald-50 rounded flex-shrink-0 flex items-center justify-center border border-emerald-100 shadow-sm">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 mb-1">{{ $detail->book->title }}</div>
                                            <div class="text-xs font-mono text-gray-500 flex items-center gap-2">
                                                <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $detail->book->book_code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap text-center">
                                    <span class="text-sm font-bold text-gray-900">{{ $detail->qty }}</span>
                                    <span class="text-xs text-gray-500 ml-1">eks</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap text-center">
                                    @if($detail->status == 'borrowed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            Dipinjam
                                        </span>
                                    @elseif($detail->status == 'partial_returned')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Kembali Sbg.
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="bg-gray-50 p-6 flex items-center justify-between border-t border-gray-100">
                    <div class="text-sm text-gray-500 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Diproses oleh: <span class="font-semibold text-gray-700">{{ $borrowing->user->name }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
