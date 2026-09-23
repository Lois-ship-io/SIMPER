<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 mb-6 shadow-inner">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buku Tamu Perpustakaan</h2>
        <p class="text-gray-500 mt-3 text-sm max-w-sm mx-auto">Silakan isi data kunjungan Anda sebelum memasuki area perpustakaan.</p>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50/50 border border-emerald-100 p-4 mb-8 rounded-2xl flex items-center gap-3">
        <div class="p-2 bg-emerald-100 rounded-full">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('visitors.store') }}" class="space-y-8 bg-white p-8 rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100">
        @csrf

        <!-- Pilihan Tipe Pengunjung -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-4 uppercase tracking-widest">Status Pengunjung</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex cursor-pointer rounded-2xl border-2 border-gray-100 bg-gray-50 p-4 hover:bg-gray-100 transition-colors focus-within:ring-2 focus-within:ring-emerald-500 focus-within:ring-offset-2">
                    <input type="radio" name="type" value="member" class="peer sr-only" {{ old('type', 'member') === 'member' ? 'checked' : '' }} onchange="toggleFormType()">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-gray-900">Anggota</span>
                            <span class="mt-1 flex items-center text-xs text-gray-500 font-medium">Siswa / Guru Terdaftar</span>
                        </span>
                    </span>
                    <svg class="invisible h-6 w-6 text-emerald-600 peer-checked:visible" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-emerald-500" aria-hidden="true"></span>
                </label>
                <label class="relative flex cursor-pointer rounded-2xl border-2 border-gray-100 bg-gray-50 p-4 hover:bg-gray-100 transition-colors focus-within:ring-2 focus-within:ring-emerald-500 focus-within:ring-offset-2">
                    <input type="radio" name="type" value="non_member" class="peer sr-only" {{ old('type') === 'non_member' ? 'checked' : '' }} onchange="toggleFormType()">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-gray-900">Non-Anggota</span>
                            <span class="mt-1 flex items-center text-xs text-gray-500 font-medium">Tamu Umum</span>
                        </span>
                    </span>
                    <svg class="invisible h-6 w-6 text-emerald-600 peer-checked:visible" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-emerald-500" aria-hidden="true"></span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        <!-- Form Anggota -->
        <div id="member-fields" class="space-y-6">
            <div>
                <label for="member_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Identitas Anggota</label>
                <select id="member_id" name="member_id" class="mt-1 block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors">
                    <option value="">-- Cari atau Pilih Anggota --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->nis }} - {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
            </div>
        </div>

        <!-- Form Non-Anggota -->
        <div id="non-member-fields" class="space-y-6 hidden">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="Masukkan nama lengkap">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="visitor_gender" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                    <select id="visitor_gender" name="gender" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <div>
                    <label for="visitor_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                    <input id="visitor_phone" type="text" name="phone" value="{{ old('phone') }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="08xx...">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>
            
            <div>
                <label for="visitor_address" class="block text-sm font-semibold text-gray-700 mb-2">Instansi / Alamat</label>
                <input id="visitor_address" type="text" name="address" value="{{ old('address') }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="Alamat asal atau nama sekolah/instansi">
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
        </div>

        <!-- Tujuan Kunjungan (Selalu Muncul) -->
        <div class="pt-2">
            <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Kunjungan</label>
            <select id="purpose" name="purpose" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required>
                <option value="">-- Pilih Tujuan Kunjungan --</option>
                <option value="Membaca di tempat" {{ old('purpose') == 'Membaca di tempat' ? 'selected' : '' }}>Membaca di tempat</option>
                <option value="Meminjam/Mengembalikan Buku" {{ old('purpose') == 'Meminjam/Mengembalikan Buku' ? 'selected' : '' }}>Meminjam/Mengembalikan Buku</option>
                <option value="Mengerjakan Tugas" {{ old('purpose') == 'Mengerjakan Tugas' ? 'selected' : '' }}>Mengerjakan Tugas</option>
                <option value="Lainnya" {{ old('purpose') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
        </div>

        <div class="pt-6 border-t border-gray-100">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Check In Sekarang
            </button>
        </div>
    </form>

    <div class="mt-8 text-center">
        @auth
            <a href="{{ route('visitors.index') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-semibold inline-flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard Pengelola
            </a>
        @endauth
    </div>

    <script>
        function toggleFormType() {
            const isMember = document.querySelector('input[name="type"]:checked').value === 'member';
            const memberFields = document.getElementById('member-fields');
            const nonMemberFields = document.getElementById('non-member-fields');
            
            if (isMember) {
                memberFields.classList.remove('hidden');
                nonMemberFields.classList.add('hidden');
                document.getElementById('name').removeAttribute('required');
                document.getElementById('member_id').setAttribute('required', 'required');
            } else {
                memberFields.classList.add('hidden');
                nonMemberFields.classList.remove('hidden');
                document.getElementById('name').setAttribute('required', 'required');
                document.getElementById('member_id').removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFormType();
            
            setTimeout(() => {
                const isMember = document.querySelector('input[name="type"]:checked').value === 'member';
                if (isMember) {
                    document.getElementById('member_id').focus();
                } else {
                    document.getElementById('name').focus();
                }
            }, 100);
        });
    </script>
</x-guest-layout>
