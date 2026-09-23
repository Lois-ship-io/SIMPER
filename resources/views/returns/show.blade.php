<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('returns.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight flex items-center gap-3">
                        Detail Pengembalian
                        <span class="bg-gray-100 text-gray-700 text-sm font-mono px-3 py-1 rounded-lg border border-gray-200">{{ $return->return_code }}</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Rincian data pengembalian buku dan denda.</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('borrowings.show', $return->borrowing_id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Lihat Peminjaman
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Info Anggota & Peminjaman -->
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Informasi Anggota & Peminjaman
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xl border border-indigo-100 flex-shrink-0 shadow-sm">
                                    {{ substr($return->borrowing->member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1">Peminjam</p>
                                    <p class="text-base font-bold text-gray-900">{{ $return->borrowing->member->name }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1">Kode Peminjaman</p>
                                    <a href="{{ route('borrowings.show', $return->borrowing_id) }}" class="text-sm font-mono font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                                        {{ $return->borrowing->borrowing_code }}
                                    </a>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1">Tgl Pinjam</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $return->borrowing->borrow_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Pengembalian -->
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Pengembalian
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1">Tanggal Kembali</p>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-base font-bold text-gray-900">{{ $return->return_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 mb-1">Total Denda</p>
                                    <p class="text-base font-bold {{ $return->total_fine > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                        Rp {{ number_format($return->total_fine, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-xl shadow-sm border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Diterima Oleh</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $return->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku yang Dikembalikan -->
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-50 flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Buku yang Dikembalikan</h3>
                        <p class="text-sm text-gray-500">Rincian buku, kondisi, dan denda per item.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Buku</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty Kembali</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Kondisi</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Denda (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @foreach($return->details as $detail)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-10 bg-gray-50 rounded flex-shrink-0 flex items-center justify-center border border-gray-100 shadow-sm">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $detail->borrowingDetail->book->title }}</div>
                                            <div class="text-xs font-mono text-gray-500 bg-gray-100 inline-block px-1.5 py-0.5 rounded">{{ $detail->borrowingDetail->book->book_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-sm font-bold text-gray-900">
                                        {{ $detail->qty_returned }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @if($detail->condition == 'good')
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Baik</span>
                                    @elseif($detail->condition == 'damaged')
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-orange-100 text-orange-800 border border-orange-200">Rusak</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200">Hilang</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-bold {{ $detail->fine_amount > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                    @if($detail->fine_amount > 0)
                                        <span class="bg-red-50 px-2 py-1 rounded-lg border border-red-100">
                                            Rp {{ number_format($detail->fine_amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($return->fines->count() > 0)
            <div class="bg-red-50/50 rounded-3xl border border-red-100 overflow-hidden relative">
                <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none transform translate-x-1/4 translate-y-1/4">
                    <svg class="w-48 h-48 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                </div>
                
                <div class="p-6 sm:p-8 relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-100 text-red-600 rounded-xl shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-900">Rincian Denda</h3>
                    </div>
                    
                    <ul class="space-y-3">
                        @foreach($return->fines as $fine)
                            <li class="flex justify-between items-center bg-white/60 p-4 rounded-xl border border-red-100/50 backdrop-blur-sm">
                                <div class="flex items-center gap-3">
                                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                    <span class="text-sm font-medium text-red-900">{{ $fine->notes }} <span class="text-xs text-red-500/70 ml-1 uppercase tracking-wider">({{ $fine->fine_type }})</span></span>
                                </div>
                                <span class="font-bold text-red-700">Rp {{ number_format($fine->amount, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                        
                        <li class="flex justify-between items-center p-4 border-t border-red-200 mt-4">
                            <span class="text-sm font-bold text-red-900 uppercase tracking-widest">Total Denda</span>
                            <span class="text-lg font-black text-red-700">Rp {{ number_format($return->total_fine, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
