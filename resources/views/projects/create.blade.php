<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Buat Proyek Baru') }}
        </h2>
        <p class="mt-2 text-md text-gray-600">Isi detail proyek baru Anda di bawah ini.</p>
    </x-slot>

    <div class="py-8 bg-gray-50"> {{-- Tambahkan latar belakang abu-abu muda --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar maksimum yang lebih fokus untuk form --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200"> {{-- Card yang lebih menonjol --}}
                <div class="p-6 lg:p-8 text-gray-900">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-8 pb-3 border-b-2 border-indigo-200 text-center">
                        Formulir Proyek Baru
                    </h3>

                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <div class="mb-6"> {{-- Tambah margin bawah --}}
                            <x-input-label for="name" :value="__('Nama Proyek')" class="mb-2" /> {{-- Tambah margin bawah pada label --}}
                            <x-text-input id="name" class="block w-full p-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama proyek" /> {{-- Padding lebih besar, rounded-lg, placeholder --}}
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Deskripsi')" class="mb-2" />
                            <textarea id="description" name="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm block w-full p-3" placeholder="Jelaskan detail proyek">{{ old('description') }}</textarea> {{-- Padding lebih besar, rounded-lg, placeholder --}}
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"> {{-- Gap lebih besar --}}
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" class="mb-2" />
                                <x-text-input id="start_date" class="block w-full p-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" type="date" name="start_date" :value="old('start_date')" /> {{-- Padding lebih besar, rounded-lg --}}
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" class="mb-2" />
                                <x-text-input id="end_date" class="block w-full p-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" type="date" name="end_date" :value="old('end_date')" /> {{-- Padding lebih besar, rounded-lg --}}
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" class="mb-2" />
                            <div class="relative"> {{-- Tambahkan div relative untuk ikon dropdown --}}
                                <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm block w-full p-3 appearance-none"> {{-- Padding lebih besar, rounded-lg, appearance-none untuk kustomisasi ikon --}}
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"> {{-- Ikon dropdown kustom --}}
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8"> {{-- Tambah margin atas --}}
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 shadow-md"> {{-- Padding lebih besar, warna indigo, shadow --}}
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ __('Buat Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>