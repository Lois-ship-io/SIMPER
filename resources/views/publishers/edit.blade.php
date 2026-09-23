<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('publishers.update', $publisher) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="name" :value="__('Nama Penerbit')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $publisher->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $publisher->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $publisher->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="address" :value="__('Alamat')" />
                                <textarea id="address" name="address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('address', $publisher->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('publishers.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
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
