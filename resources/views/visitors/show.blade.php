<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('visitors.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                        {{ __('Detail Pengunjung') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap tentang kunjungan.</p>
                </div>
            </div>
            @can('visitors.edit')
            <a href="{{ route('visitors.edit', $visitor) }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-medium rounded-xl transition-colors border border-emerald-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-12 flex flex-col md:flex-row gap-12">
                    
                    <!-- Left: Avatar & Status -->
                    <div class="w-full md:w-1/3 lg:w-1/4 flex flex-col items-center space-y-6">
                        <div class="w-40 h-40 rounded-full {{ $visitor->member_id ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-gray-50 text-gray-600 border border-gray-100' }} flex items-center justify-center font-bold text-6xl shadow-sm">
                            {{ substr($visitor->name, 0, 1) }}
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl w-full flex flex-col items-center border border-gray-100 text-center">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Tipe Pengunjung</p>
                            @if($visitor->member_id)
                                <span class="bg-emerald-100/50 text-emerald-700 text-sm px-3 py-1 rounded-md font-bold uppercase tracking-wider mb-4 border border-emerald-200">Anggota</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-md font-bold uppercase tracking-wider mb-4 border border-gray-200">Non-Anggota</span>
                            @endif

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Kode Kunjungan</p>
                            <span class="font-mono text-lg font-bold text-gray-900 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200">{{ $visitor->visitor_code }}</span>
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-2 tracking-tight">{{ $visitor->name }}</h1>
                                <p class="text-lg text-gray-500 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($visitor->visit_date)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                @if($visitor->check_out)
                                    <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full bg-gray-50 text-gray-700 ring-1 ring-gray-200">
                                        Selesai Berkunjung
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 inline-flex text-sm font-bold rounded-full bg-amber-50 text-amber-700 ring-1 ring-amber-200/50 flex items-center">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span>
                                        Sedang Berkunjung
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-6 mb-10 py-8 border-y border-gray-100">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Check In</h3>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <p class="text-xl text-gray-900 font-bold font-mono">{{ is_string($visitor->check_in) ? substr($visitor->check_in, 0, 5) : $visitor->check_in->format('H:i') }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Check Out</h3>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <p class="text-xl {{ $visitor->check_out ? 'text-gray-900 font-bold' : 'text-gray-400 italic font-medium' }} font-mono">
                                        {{ $visitor->check_out ? (is_string($visitor->check_out) ? substr($visitor->check_out, 0, 5) : $visitor->check_out->format('H:i')) : 'Belum Keluar' }}
                                    </p>
                                </div>
                            </div>
                            
                            @if($visitor->member_id)
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-6">
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">NIS / Identitas</h3>
                                    <p class="text-base text-gray-900 font-medium">{{ $visitor->member->nis ?? '-' }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Kelas / Tingkat</h3>
                                    <p class="text-base text-gray-900 font-medium">{{ $visitor->member->kelas ?? '-' }}</p>
                                </div>
                            </div>
                            @endif

                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Jenis Kelamin</h3>
                                <p class="text-base text-gray-900 font-medium">
                                    @if($visitor->gender == 'L')
                                        Laki-laki
                                    @elseif($visitor->gender == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Nomor Telepon</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $visitor->phone ?? '-' }}</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Alamat / Instansi</h3>
                                <p class="text-base text-gray-900 font-medium">{{ $visitor->address ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Tujuan Kunjungan
                            </h3>
                            <div class="bg-emerald-50/50 p-6 rounded-2xl border border-emerald-100">
                                <p class="text-emerald-900 font-medium">{{ $visitor->purpose }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
