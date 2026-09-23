<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Katalog Buku') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola semua data koleksi buku perpustakaan.</p>
            </div>
            
            @can('books.create')
            <a href="{{ route('books.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Buku
            </a>
            @endcan
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
                    
                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('books.index') }}" class="mb-8 flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 w-full relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, ISBN..." class="pl-11 w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" />
                        </div>
                        <div class="w-full md:w-64">
                            <select name="category" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors text-gray-600" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">Filter</button>
                            @if(request('search') || request('category'))
                                <a href="{{ route('books.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                            @endif
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-16">Cover</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Detail Buku</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori/Rak</th>
                                    <th scope="col" class="pb-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                                    <th scope="col" class="pb-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="pb-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($books as $book)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="h-20 w-14 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border border-gray-200 shadow-sm">
                                            @if($book->cover)
                                                <img src="{{ $book->cover_url }}" alt="Cover" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-6 w-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-1">{{ $book->title }}</div>
                                        <div class="text-sm text-gray-500 mt-1">{{ $book->author }}</div>
                                        <div class="text-xs text-gray-400 mt-2 flex flex-wrap gap-2">
                                            <span class="bg-gray-100/80 px-2.5 py-1 rounded-md">{{ $book->book_code }}</span>
                                            @if($book->isbn)<span class="bg-gray-100/80 px-2.5 py-1 rounded-md">ISBN: {{ $book->isbn }}</span>@endif
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ $book->category->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            {{ $book->rack?->name ?? 'Belum ada rak' }}
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-col items-center justify-center">
                                            <span class="text-base font-bold {{ $book->available_qty > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                                {{ $book->available_qty }}
                                            </span>
                                            <span class="text-xs text-gray-400 font-medium">/ {{ $book->total_qty }} total</span>
                                        </div>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $book->status == 'available' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-red-50 text-red-700 ring-1 ring-red-600/20' }}">
                                            {{ $book->status == 'available' ? 'Tersedia' : 'Kosong' }}
                                        </span>
                                    </td>
                                    <td class="py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            @can('books.view')
                                            <a href="{{ route('books.show', $book) }}" class="text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 p-2 rounded-xl transition-colors" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            @endcan
                                            
                                            @can('books.edit')
                                            <a href="{{ route('books.edit', $book) }}" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-xl transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            @endcan
                                            
                                            @can('books.delete')
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-xl transition-colors" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">Katalog Kosong</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada data buku atau pencarian tidak ditemukan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($books->hasPages())
                    <div class="mt-8 border-t border-gray-50 pt-6">
                        {{ $books->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
