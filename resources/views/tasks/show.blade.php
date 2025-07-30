{{-- resources/views/tasks/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tugas: {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tugas</h3>

                <dl class="divide-y divide-gray-200">
                    <div class="py-4 flex justify-between">
                        <dt class="font-medium text-gray-500">Nama</dt>
                        <dd class="text-gray-900">{{ $task->name }}</dd>
                    </div>
                    <div class="py-4 flex justify-between">
                        <dt class="font-medium text-gray-500">Deskripsi</dt>
                        <dd class="text-gray-900">{{ $task->description }}</dd>
                    </div>
                    <div class="py-4 flex justify-between">
                        <dt class="font-medium text-gray-500">Status</dt>
                        <dd class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</dd>
                    </div>
                    <div class="py-4 flex justify-between">
                        <dt class="font-medium text-gray-500">Tenggat Waktu</dt>
                        <dd class="text-gray-900">{{ $task->due_date ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('projects.tasks.index', $project) }}" class="text-indigo-600 hover:underline">← Kembali ke Daftar Tugas</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
