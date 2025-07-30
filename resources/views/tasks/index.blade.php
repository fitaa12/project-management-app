<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Tugas untuk Proyek: <span class="text-indigo-600">{{ $project->name }}</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tenggat</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($tasks as $task)
                            <tr>
                                <td class="px-6 py-4">{{ $task->name }}</td>

                                {{-- Status (bisa diubah oleh tim dan owner) --}}
                                <td class="px-6 py-4">
                                    @can('updateStatus', $task)
                                        <form action="{{ route('projects.tasks.updateStatus', [$project, $task]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do</option>
                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                            </select>
                                        </form>
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    @endcan
                                </td>

                                <td class="px-6 py-4">
                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}
                                </td>

                                {{-- Aksi (edit/hapus hanya untuk owner) --}}
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="text-blue-600 hover:underline">Lihat</a>

                                    @can('update', $task)
                                        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    @endcan

                                    @can('delete', $task)
                                        <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
