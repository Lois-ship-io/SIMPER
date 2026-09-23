<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('returns.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Proses Pengembalian Buku') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selesaikan transaksi peminjaman dan catat pengembalian buku.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="returnForm()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Step 1: Select Borrowing -->
            @if(!$borrowing)
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-10 max-w-3xl mx-auto">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Pilih Transaksi Peminjaman</h3>
                        <p class="text-sm text-gray-500 mt-2">Cari dan pilih transaksi peminjaman yang masih aktif (belum dikembalikan sepenuhnya).</p>
                    </div>

                    <form method="GET" action="{{ route('returns.create') }}">
                        <div class="relative">
                            <select id="borrowing_id" name="borrowing_id" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-base py-4 pl-4 pr-12 transition-colors cursor-pointer appearance-none bg-gray-50 hover:bg-gray-100" required>
                                <option value="">-- Pilih Transaksi Peminjaman Aktif --</option>
                                @foreach($activeBorrowings as $ab)
                                    <option value="{{ $ab->id }}">
                                        {{ $ab->borrowing_code }} - {{ $ab->member->name }} 
                                        (Batas: {{ $ab->due_date->format('d/m/Y') }} {{ $ab->isOverdue() ? '- TERLAMBAT' : '' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 w-full sm:w-auto">
                                Lanjutkan Proses
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Step 2: Return Form -->
            @if($borrowing)
            <form method="POST" action="{{ route('returns.store') }}">
                @csrf
                <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Info & Form -->
                    <div class="lg:col-span-1 space-y-8">
                        
                        <!-- Info Card -->
                        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden relative">
                            <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                                <svg class="w-20 h-20 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                            
                            <div class="p-6 sm:p-8">
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Info Peminjaman
                                </h3>
                                
                                <div class="space-y-5">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 mb-1">Peminjam</p>
                                        <p class="text-base font-bold text-gray-900 flex items-center gap-2">
                                            {{ $borrowing->member->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 mb-1">Kode Transaksi</p>
                                        <p class="text-sm font-mono font-bold text-gray-700 bg-gray-50 inline-block px-2 py-1 rounded">{{ $borrowing->borrowing_code }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 mb-1">Batas Waktu Pengembalian</p>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-semibold flex items-center gap-1.5 {{ $borrowing->isOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                                                <svg class="w-4 h-4 {{ $borrowing->isOverdue() ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $borrowing->due_date->format('d M Y') }}
                                            </p>
                                            @if($borrowing->isOverdue())
                                                <span class="inline-flex text-xs font-bold text-red-700 bg-red-100 px-2 py-0.5 rounded self-start">Terlambat {{ $borrowing->calculateLateDays() }} hari</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Card -->
                        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Detail Pengembalian
                                </h3>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label for="return_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pengembalian</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <input id="return_date" type="date" name="return_date" value="{{ date('Y-m-d') }}" class="pl-10 block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required />
                                        </div>
                                        <x-input-error :messages="$errors->get('return_date')" class="mt-2" />
                                    </div>
                                    
                                    <div>
                                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                        <textarea id="notes" name="notes" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" rows="3" placeholder="Tambahkan catatan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Books Table -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col h-full">
                            <div class="p-6 sm:p-8 border-b border-gray-50">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Status Buku yang Dikembalikan
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">Periksa jumlah dan kondisi buku yang dikembalikan.</p>
                            </div>
                            
                            <x-input-error :messages="$errors->get('books')" class="mx-6 mt-4" />

                            <div class="overflow-x-auto flex-grow">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-[40%]">Buku</th>
                                            <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty Kembali</th>
                                            <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Kondisi</th>
                                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Denda (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 bg-white">
                                        @foreach($borrowing->details as $index => $detail)
                                            @if($detail->status == 'borrowed')
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center gap-4">
                                                        <div class="h-10 w-8 bg-emerald-50 rounded flex-shrink-0 flex items-center justify-center border border-emerald-100">
                                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $detail->book->title }}</div>
                                                            <div class="text-xs font-medium text-gray-500">Dipinjam: <span class="text-gray-900 font-bold">{{ $detail->qty }} eks</span></div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="books[{{ $index }}][id]" value="{{ $detail->id }}">
                                                </td>
                                                <td class="px-4 py-5 text-center">
                                                    <input type="number" name="books[{{ $index }}][qty_returned]" min="1" max="{{ $detail->qty }}" value="{{ $detail->qty }}" class="w-20 text-center border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2 transition-colors" required>
                                                </td>
                                                <td class="px-4 py-5 text-center">
                                                    <select name="books[{{ $index }}][condition]" class="border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2 pl-3 pr-8 transition-colors" required>
                                                        <option value="good">Baik</option>
                                                        <option value="damaged">Rusak</option>
                                                        <option value="lost">Hilang</option>
                                                    </select>
                                                </td>
                                                <td class="px-6 py-5 text-right">
                                                    <div class="relative max-w-[120px] ml-auto">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm font-medium">Rp</span>
                                                        </div>
                                                        <input type="number" name="books[{{ $index }}][fine_amount]" min="0" value="0" class="pl-9 w-full text-right border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2 transition-colors">
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="p-6 sm:p-8 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <a href="{{ route('returns.create') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">
                                    Ganti Transaksi Peminjaman
                                </a>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <a href="{{ route('returns.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-white hover:bg-gray-100 border border-gray-200 text-gray-700 text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                                        Batal
                                    </a>
                                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('returnForm', () => ({
                // Add any necessary frontend logic here if needed
            }));
        });
    </script>
    @endpush
</x-app-layout>
