<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Data Pengunjung') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data pengunjung perpustakaan.</p>
            </div>
        </div>
    </x-slot>

    <div x-data="visitorPage()">
        <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-emerald-50/50 border border-emerald-100 p-4 mb-6 rounded-2xl flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="p-2 bg-emerald-100 rounded-full">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50/50 border border-red-100 p-4 mb-6 rounded-2xl flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-full">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    
                    <!-- Search & Tambah Button -->
                    <div class="mb-8 flex flex-col md:flex-row gap-4 items-end justify-between">
                        <form method="GET" action="{{ route('visitors.index') }}" class="flex-1 flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-1 w-full relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengunjung, pekerjaan, atau keperluan..." class="pl-11 w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" />
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('visitors.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">Reset</a>
                                @endif
                            </div>
                        </form>

                        @can('visitors.create')
                        <button @click="openCreate()" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 flex-shrink-0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Pengunjung
                        </button>
                        @endcan
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider pl-1">No</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengunjung</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Pekerjaan</th>
                                    <th scope="col" class="pb-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Keperluan</th>
                                    <th scope="col" class="pb-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="pb-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($visitors as $visitor)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 whitespace-nowrap pl-1">
                                        <span class="text-sm text-gray-400 font-medium">{{ $visitors->firstItem() + $loop->index }}</span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9">
                                                <div class="h-9 w-9 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold text-sm shadow-sm">
                                                    {{ strtoupper(substr($visitor->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-semibold text-gray-900">{{ $visitor->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">{{ $visitor->pekerjaan }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-sm text-gray-600">{{ $visitor->purpose }}</span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center text-sm font-medium text-gray-700 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100">
                                            {{ $visitor->visit_date->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1">
                                            @can('visitors.edit')
                                            <button @click="openEdit(@js($visitor))" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-xl transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            @endcan
                                            
                                            @can('visitors.delete')
                                            <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengunjung ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-xl transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">Belum ada data pengunjung</h3>
                                        <p class="mt-1 text-sm text-gray-500">Klik tombol "Tambah Pengunjung" untuk menambah data baru.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($visitors->hasPages())
                    <div class="mt-8 border-t border-gray-50 pt-6">
                        {{ $visitors->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MODAL: Tambah / Edit Pengunjung --}}
        {{-- ============================================================ --}}
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Overlay --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal panel --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    {{-- Close --}}
                    <div class="absolute top-0 right-0 pt-5 pr-5 z-10">
                        <button type="button" @click="showModal = false" class="bg-white rounded-full p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="px-6 pt-7 pb-6 sm:px-8">
                        {{-- Header --}}
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-emerald-100">
                                <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900" x-text="isEditing ? 'Edit Pengunjung' : 'Tambah Pengunjung'"></h3>
                                <p class="text-xs text-gray-500" x-text="isEditing ? 'Perbarui data pengunjung.' : 'Isi data pengunjung baru.'"></p>
                            </div>
                        </div>

                        {{-- Validation errors --}}
                        @if($errors->any())
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-5">
                            <ul class="text-xs text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form :action="formAction" method="POST" class="space-y-5">
                            @csrf
                            <template x-if="isEditing">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            {{-- Pengunjung --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Pengunjung <span class="text-red-500">*</span></label>
                                <input id="name" type="text" name="name" x-model="formName" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" placeholder="Nama pengunjung" required>
                            </div>

                            {{-- Pekerjaan --}}
                            <div>
                                <label for="pekerjaan" class="block text-sm font-semibold text-gray-700 mb-1.5">Pekerjaan <span class="text-red-500">*</span></label>
                                <input id="pekerjaan" type="text" name="pekerjaan" x-model="formPekerjaan" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" placeholder="Pekerjaan pengunjung" required>
                            </div>

                            {{-- Keperluan --}}
                            <div>
                                <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-1.5">Keperluan <span class="text-red-500">*</span></label>
                                <input id="purpose" type="text" name="purpose" x-model="formPurpose" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" placeholder="Keperluan kunjungan" required>
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label for="visit_date" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                                <input id="visit_date" type="date" name="visit_date" x-model="formDate" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-2.5 transition-colors" required>
                            </div>

                            {{-- Actions --}}
                            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                                <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors">
                                    Batal
                                </button>
                                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span x-text="isEditing ? 'Simpan Perubahan' : 'Simpan'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function visitorPage() {
            return {
                showModal: {{ $errors->any() ? 'true' : 'false' }},
                isEditing: false,
                formAction: '{{ route("visitors.store") }}',
                formName: '{{ old("name", "") }}',
                formPekerjaan: '{{ old("pekerjaan", "") }}',
                formPurpose: '{{ old("purpose", "") }}',
                formDate: '{{ old("visit_date", now()->toDateString()) }}',

                openCreate() {
                    this.isEditing = false;
                    this.formAction = '{{ route("visitors.store") }}';
                    this.formName = '';
                    this.formPekerjaan = '';
                    this.formPurpose = '';
                    this.formDate = new Date().toISOString().split('T')[0];
                    this.showModal = true;
                },

                openEdit(visitor) {
                    this.isEditing = true;
                    this.formAction = `/visitors/${visitor.id}`;
                    this.formName = visitor.name || '';
                    this.formPekerjaan = visitor.pekerjaan || '';
                    this.formPurpose = visitor.purpose || '';
                    this.formDate = visitor.visit_date ? visitor.visit_date.split('T')[0] : '';
                    this.showModal = true;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
