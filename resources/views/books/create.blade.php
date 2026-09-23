<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('books.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Tambah Buku Baru') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan detail informasi buku ke dalam sistem.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" required autofocus
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <div>
                                    <label for="author" class="block text-sm font-semibold text-gray-700 mb-2">Penulis / Pengarang <span class="text-red-500">*</span></label>
                                    <input type="text" id="author" name="author" value="{{ old('author') }}" required
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                    <x-input-error class="mt-2" :messages="$errors->get('author')" />
                                </div>

                                <div>
                                    <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN</label>
                                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}"
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                    <p class="mt-1.5 text-xs text-gray-400">Biarkan kosong jika tidak memiliki ISBN.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="publish_year" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit</label>
                                        <input type="number" id="publish_year" name="publish_year" value="{{ old('publish_year') }}" min="1900" max="{{ date('Y')+1 }}"
                                            class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                        <x-input-error class="mt-2" :messages="$errors->get('publish_year')" />
                                    </div>
                                    <div>
                                        <label for="total_qty" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah (Stok) <span class="text-red-500">*</span></label>
                                        <input type="number" id="total_qty" name="total_qty" value="{{ old('total_qty', 1) }}" min="1" required
                                            class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                        <x-input-error class="mt-2" :messages="$errors->get('total_qty')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div>
                                    <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <input type="text" id="category_name" name="category_name" list="categories_list" value="{{ old('category_name') }}" required
                                        placeholder="Ketik atau pilih kategori"
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                    <datalist id="categories_list">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}"></option>
                                        @endforeach
                                    </datalist>
                                    <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
                                </div>

                                <div>
                                    <label for="publisher_name" class="block text-sm font-semibold text-gray-700 mb-2">Penerbit</label>
                                    <input type="text" id="publisher_name" name="publisher_name" list="publishers_list" value="{{ old('publisher_name') }}"
                                        placeholder="Ketik atau pilih penerbit"
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors">
                                    <datalist id="publishers_list">
                                        @foreach($publishers as $publisher)
                                            <option value="{{ $publisher->name }}"></option>
                                        @endforeach
                                    </datalist>
                                    <x-input-error class="mt-2" :messages="$errors->get('publisher_name')" />
                                </div>

                                <div>
                                    <label for="rack_id" class="block text-sm font-semibold text-gray-700 mb-2">Rak Penyimpanan</label>
                                    <select id="rack_id" name="rack_id"
                                        class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors text-gray-600">
                                        <option value="">Pilih Rak</option>
                                        @foreach($racks as $rack)
                                            <option value="{{ $rack->id }}" {{ old('rack_id') == $rack->id ? 'selected' : '' }}>{{ $rack->name }} ({{ $rack->location }})</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('rack_id')" />
                                </div>

                                <div>
                                    <label for="cover" class="block text-sm font-semibold text-gray-700 mb-2">Cover Buku</label>
                                    <input id="cover" name="cover" type="file" accept="image/jpeg, image/png, image/webp"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors border border-gray-200 rounded-xl cursor-pointer" />
                                    <p class="mt-2 text-xs text-gray-400">Maksimal 2MB. Format: JPG, PNG, WEBP.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('cover')" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi / Sinopsis</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors placeholder-gray-300" placeholder="Tuliskan sinopsis singkat buku ini...">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl shadow-sm transition-all">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
