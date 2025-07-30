<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Buat Tugas Baru untuk Proyek:') }} <span class="text-indigo-600">{{ $project->name }}</span>
        </h2>
        <p class="mt-2 text-md text-gray-600">Isi detail tugas baru yang akan ditambahkan ke proyek ini.</p>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 lg:p-8 text-gray-900">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-8 pb-3 border-b-2 border-indigo-200 text-center">
                        Formulir Tambah Tugas Baru
                    </h3>

                    {{-- FORM START --}}
                    <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Tugas')" class="mb-2" />
                            <x-text-input id="name" class="block w-full p-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                          type="text" name="name" :value="old('name')" required autofocus 
                                          placeholder="Contoh: Desain Antarmuka Pengguna" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Deskripsi')" class="mb-2" />
                            <textarea id="description" name="description" rows="4" 
                                      class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm block w-full p-3" 
                                      placeholder="Jelaskan detail tugas ini secara singkat dan jelas.">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="status" :value="__('Status')" class="mb-2" />
                                <div class="relative">
                                    <select id="status" name="status" 
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm block w-full p-3 appearance-none">
                                        <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>To Do</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="due_date" :value="__('Tenggat Waktu')" class="mb-2" />
                                <x-text-input id="due_date" class="block w-full p-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                              type="date" name="due_date" :value="old('due_date')" />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('projects.show', $project) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md flex-shrink-0">
                                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Tugas
                            </x-primary-button>
                        </div>
                    </form>
                    {{-- FORM END --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
