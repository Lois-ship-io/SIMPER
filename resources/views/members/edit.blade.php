<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('members.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Anggota: ') }} <span class="text-indigo-600">{{ $member->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('members.update', $member) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="nis" :value="__('Nomor Induk Siswa (NIS/NISN)')" />
                                    <x-text-input id="nis" name="nis" type="text" class="mt-1 block w-full" :value="old('nis', $member->nis)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('nis')" />
                                </div>

                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $member->name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="L" {{ old('gender', $member->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $member->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="class" :value="__('Kelas')" />
                                        <x-text-input id="class" name="class" type="text" class="mt-1 block w-full" :value="old('class', $member->class)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('class')" />
                                    </div>
                                    <div>
                                        <x-input-label for="major" :value="__('Jurusan (Opsional)')" />
                                        <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $member->major)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('major')" />
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Nomor Telepon/HP')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $member->phone)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>

                                <div>
                                    <x-input-label for="status" :value="__('Status Keanggotaan')" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif (Bisa meminjam)</option>
                                        <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Non-Aktif (Diblokir)</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Alamat Lengkap')" />
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address', $member->address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-4">
                            <a href="{{ route('members.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
