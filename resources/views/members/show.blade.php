<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('members.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Anggota: ') }} <span class="text-indigo-600">{{ $member->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
                    
                    <!-- Left: Profile Info -->
                    <div class="w-full md:w-1/3 lg:w-1/4 flex flex-col items-center space-y-6">
                        <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-5xl border-4 border-indigo-200 shadow-sm">
                            {{ substr($member->name, 0, 1) }}
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg w-full text-center border border-gray-100">
                            <p class="text-sm font-semibold text-gray-500 mb-1">Kode Anggota</p>
                            <p class="text-lg font-mono font-bold text-gray-900 bg-gray-200 px-3 py-1 rounded inline-block">{{ $member->member_code }}</p>
                            
                            <div class="mt-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $member->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $member->status == 'active' ? 'Status: Aktif' : 'Status: Non-Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 leading-tight mb-2">{{ $member->name }}</h1>
                                <p class="text-lg text-gray-600">NIS: <span class="font-semibold">{{ $member->nis }}</span></p>
                            </div>
                            <div class="flex flex-col items-end">
                                @can('members.edit')
                                <a href="{{ route('members.edit', $member) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit Anggota</a>
                                @endcan
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 mb-8 border-t border-b py-6 border-gray-100">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Kelas & Jurusan</h3>
                                <p class="text-base text-gray-900">{{ $member->class }} {{ $member->major ? '- ' . $member->major : '' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Nomor Telepon/HP</h3>
                                <p class="text-base text-gray-900">{{ $member->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Terdaftar</h3>
                                <p class="text-base text-gray-900">{{ $member->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</h3>
                                <p class="text-base text-gray-900">{{ $member->address ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Riwayat Peminjaman (Placeholder) -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3 flex justify-between items-center">
                                Riwayat Peminjaman
                                <span class="text-sm text-gray-500 font-normal">Menampilkan 5 terakhir</span>
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-6 text-center border border-gray-100">
                                <p class="text-gray-500">Fitur riwayat peminjaman akan tersedia setelah modul peminjaman diaktifkan.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
