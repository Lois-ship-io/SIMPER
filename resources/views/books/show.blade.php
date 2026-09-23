<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('books.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                        {{ __('Detail Buku') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap tentang buku.</p>
                </div>
            </div>
            @can('books.edit')
            <a href="{{ route('books.edit', $book) }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-medium rounded-xl transition-colors border border-emerald-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Buku
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-12 flex flex-col md:flex-row gap-12">
                    
                    <!-- Left: Cover & QR -->
                    <div class="w-full md:w-1/3 lg:w-1/4 flex flex-col items-center space-y-6">
                        <div class="w-full aspect-[3/4] bg-gray-50 rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex items-center justify-center">
                            @if($book->cover)
                                <img src="{{ $book->cover_url }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="text-gray-400 flex flex-col items-center">
                                    <svg class="h-16 w-16 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-sm font-medium">Tanpa Cover</span>
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl w-full flex flex-col items-center border border-gray-100">
                            <p class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Kode Buku</p>
                            <p class="text-lg font-mono bg-white border border-emerald-200 px-4 py-2 rounded-xl text-emerald-700 font-bold shadow-sm">{{ $book->book_code }}</p>
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-2 tracking-tight">{{ $book->title }}</h1>
                                <p class="text-lg text-gray-500">Karya <span class="font-semibold text-emerald-600">{{ $book->author }}</span></p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full {{ $book->status == 'available' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-red-50 text-red-700 ring-1 ring-red-600/20' }}">
                                    {{ $book->status == 'available' ? 'Tersedia' : 'Kosong' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-y-8 gap-x-6 mb-10 py-8 border-y border-gray-100">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Kategori</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $book->category->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">ISBN</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $book->isbn ?? '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Penerbit</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $book->publisher?->name ?? '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Tahun Terbit</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $book->publish_year ?? '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Rak Penyimpanan</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $book->rack?->name ?? '-' }} <span class="text-sm text-gray-500 font-normal">({{ $book->rack?->location ?? '-' }})</span></p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Ketersediaan Stok</h3>
                                <div class="flex items-end gap-2 text-gray-900">
                                    <span class="text-2xl font-bold leading-none {{ $book->available_qty > 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $book->available_qty }}</span>
                                    <span class="text-sm text-gray-500 mb-0.5">/ {{ $book->total_qty }} buku</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                Deskripsi / Sinopsis
                            </h3>
                            <div class="prose prose-sm sm:prose text-gray-600 max-w-none bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                                @if($book->description)
                                    {!! nl2br(e($book->description)) !!}
                                @else
                                    <p class="text-gray-400 italic m-0">Tidak ada deskripsi tersedia untuk buku ini.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
