<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Tugas:') }} <span class="text-indigo-600">{{ $task->name }}</span>
            <span class="text-gray-500">untuk Proyek:</span> <span class="text-indigo-600">{{ $project->name }}</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded p-6">
                <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
                    @csrf
                    @method('PUT')

                    @can('update', $task)
                        <!-- Nama -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Tugas')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $task->name) }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="block w-full border-gray-300 rounded">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    @endcan

                    @canany(['update', 'updateStatus'], $task)
                        <!-- Status -->
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block w-full border-gray-300 rounded">
                                <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    @endcanany

                    @can('update', $task)
                        <!-- Due Date -->
                        <div class="mb-4">
                            <x-input-label for="due_date" :value="__('Tenggat Waktu')" />
                            <x-text-input id="due_date" type="date" name="due_date" class="block mt-1 w-full" value="{{ old('due_date', $task->due_date) }}" />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>
                    @endcan

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 mr-2">Batal</a>
                        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
