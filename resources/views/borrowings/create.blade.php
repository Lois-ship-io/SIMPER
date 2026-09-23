<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('borrowings.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Transaksi Peminjaman Baru') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Catat peminjaman buku oleh anggota perpustakaan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="borrowingForm()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('borrowings.store') }}">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left: Detail Pinjaman -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden sticky top-8">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Data Peminjam
                                </h3>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label for="member_id" class="block text-sm font-semibold text-gray-700 mb-2">Anggota</label>
                                        <select id="member_id" name="member_id" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required>
                                            <option value="">-- Cari atau Pilih Anggota --</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->member_code }} - {{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label for="borrow_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <input id="borrow_date" type="date" name="borrow_date" value="{{ date('Y-m-d') }}" class="pl-10 block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required />
                                        </div>
                                        <x-input-error :messages="$errors->get('borrow_date')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">Batas Tanggal Kembali</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <input id="due_date" type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="pl-10 block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required />
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 italic">Secara default 7 hari dari tanggal pinjam.</p>
                                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                                    </div>
                                    
                                    <div>
                                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                        <textarea id="notes" name="notes" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Pilihan Buku -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 border-b border-gray-100 pb-6">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Daftar Buku yang Dipinjam
                                    </h3>
                                    <button type="button" @click="addBookRow()" class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-bold rounded-xl shadow-sm transition-colors border border-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Buku
                                    </button>
                                </div>
                                
                                <x-input-error :messages="$errors->get('books')" class="mt-2 mb-4" />

                                <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="pb-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-[65%]">Pilih Buku</th>
                                                <th scope="col" class="pb-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider w-[20%]">Jumlah (Qty)</th>
                                                <th scope="col" class="pb-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider w-[15%]">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            <template x-for="(item, index) in booksList" :key="index">
                                                <tr class="hover:bg-gray-50/50 transition-colors">
                                                    <td class="py-4 pr-4">
                                                        <select x-model="item.id" :name="'books['+index+'][id]'" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" required>
                                                            <option value="">-- Pilih Buku --</option>
                                                            @foreach($books as $book)
                                                                <option value="{{ $book->id }}">{{ $book->book_code }} - {{ $book->title }} (Stok: {{ $book->available_qty }})</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="py-4 px-2 text-center">
                                                        <input type="number" x-model="item.qty" :name="'books['+index+'][qty]'" min="1" class="w-full text-center border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" required>
                                                    </td>
                                                    <td class="py-4 pl-4 text-right">
                                                        <button type="button" @click="removeBookRow(index)" x-show="booksList.length > 1" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-xl transition-colors inline-flex items-center justify-center" title="Hapus baris">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                                    <a href="{{ route('borrowings.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                                        Batal
                                    </a>
                                    <button type="submit" class="inline-flex justify-center items-center px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Simpan Transaksi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('borrowingForm', () => ({
                booksList: [
                    { id: '', qty: 1 }
                ],
                addBookRow() {
                    this.booksList.push({ id: '', qty: 1 });
                },
                removeBookRow(index) {
                    if (this.booksList.length > 1) {
                        this.booksList.splice(index, 1);
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
