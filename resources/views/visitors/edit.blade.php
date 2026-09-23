<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('visitors.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Edit Data Pengunjung') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi kunjungan: {{ $visitor->visitor_code }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <form method="POST" action="{{ route('visitors.update', $visitor) }}" class="p-8 sm:p-10 space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Pilihan Tipe Pengunjung -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-4 uppercase tracking-widest">Status Pengunjung</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer rounded-2xl border-2 border-gray-100 bg-gray-50 p-4 hover:bg-gray-100 transition-colors focus-within:ring-2 focus-within:ring-emerald-500 focus-within:ring-offset-2">
                                <input type="radio" name="type" value="member" class="peer sr-only" {{ old('type', $visitor->member_id ? 'member' : 'non_member') === 'member' ? 'checked' : '' }} onchange="toggleFormType()">
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
                                <input type="radio" name="type" value="non_member" class="peer sr-only" {{ old('type', $visitor->member_id ? 'member' : 'non_member') === 'non_member' ? 'checked' : '' }} onchange="toggleFormType()">
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
                                    <option value="{{ $member->id }}" {{ old('member_id', $visitor->member_id) == $member->id ? 'selected' : '' }}>
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
                            <input id="name" type="text" name="name" value="{{ old('name', $visitor->member_id ? '' : $visitor->name) }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="Masukkan nama lengkap">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="visitor_gender" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                                <select id="visitor_gender" name="gender" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('gender', $visitor->member_id ? '' : $visitor->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $visitor->member_id ? '' : $visitor->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div>
                                <label for="visitor_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input id="visitor_phone" type="text" name="phone" value="{{ old('phone', $visitor->member_id ? '' : $visitor->phone) }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="08xx...">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div>
                            <label for="visitor_address" class="block text-sm font-semibold text-gray-700 mb-2">Instansi / Alamat</label>
                            <input id="visitor_address" type="text" name="address" value="{{ old('address', $visitor->member_id ? '' : $visitor->address) }}" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" placeholder="Alamat asal atau nama sekolah/instansi">
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Tujuan Kunjungan (Selalu Muncul) -->
                    <div class="pt-2">
                        <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Kunjungan</label>
                        <select id="purpose" name="purpose" class="block w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm py-3 transition-colors" required>
                            <option value="">-- Pilih Tujuan Kunjungan --</option>
                            <option value="Membaca di tempat" {{ old('purpose', $visitor->purpose) == 'Membaca di tempat' ? 'selected' : '' }}>Membaca di tempat</option>
                            <option value="Meminjam/Mengembalikan Buku" {{ old('purpose', $visitor->purpose) == 'Meminjam/Mengembalikan Buku' ? 'selected' : '' }}>Meminjam/Mengembalikan Buku</option>
                            <option value="Mengerjakan Tugas" {{ old('purpose', $visitor->purpose) == 'Mengerjakan Tugas' ? 'selected' : '' }}>Mengerjakan Tugas</option>
                            <option value="Lainnya" {{ old('purpose', $visitor->purpose) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('visitors.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center items-center px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
        });
    </script>
</x-app-layout>
