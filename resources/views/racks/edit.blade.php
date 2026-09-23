<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('racks.update', $rack) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="code" :value="__('Kode Rak')" />
                                <x-text-input id="code" class="block mt-1 w-full bg-gray-50" type="text" name="code" :value="old('code', $rack->code)" required readonly />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Kode rak tidak dapat diubah setelah dibuat.</p>
                            </div>

                            <div>
                                <x-input-label for="name" :value="__('Nama Rak')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $rack->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="location" :value="__('Lokasi (Opsional)')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $rack->location)" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                                <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('description', $rack->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('racks.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
