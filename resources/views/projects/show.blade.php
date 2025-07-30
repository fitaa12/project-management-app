<x-app-layout>
    {{-- Slot untuk header --}}
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Proyek:') }} <span class="text-indigo-600">{{ $project->name }}</span>
        </h2>
        <p class="mt-2 text-md text-gray-600">Lihat semua informasi, tugas, dan anggota tim untuk proyek ini.</p>
    </x-slot>


    {{-- Konten utama halaman, ini akan masuk ke $slot di layouts/app.blade.php --}}
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Informasi!</p>
                    <p>{{ session('info') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Ada Kesalahan!</p>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Bagian Detail Proyek --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6 lg:p-8 text-gray-900">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 pb-3 border-b-2 border-indigo-200">
                        Informasi Proyek
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Nama Proyek:</p>
                            <p class="text-lg text-gray-900 font-medium">{{ $project->name }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-semibold text-gray-600 mb-1">Deskripsi:</p>
                            <p class="text-gray-700 leading-relaxed">{{ $project->description }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Dibuat Oleh:</p>
                            {{-- PERBAIKAN: Menggunakan $project->owner --}}
                            <p class="text-gray-700">{{ $project->owner->name ?? 'Pengguna Tidak Ditemukan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Tanggal Mulai:</p>
                            <p class="text-gray-700">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d F Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Tanggal Selesai:</p>
                            <p class="text-gray-700">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d F Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Status:</p>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                @if($project->status === 'completed') bg-green-100 text-green-800
                                @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($project->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-semibold text-gray-600 mb-1">Progress Proyek:</p>
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full
                                        @if($project->progress_percentage == 100) bg-green-500
                                        @elseif($project->progress_percentage > 50) bg-blue-500
                                        @elseif($project->progress_percentage > 0) bg-yellow-500
                                        @else bg-gray-400 @endif"
                                        style="width: {{ $project->progress_percentage }}%">
                                    </div>
                                </div>
                                <span class="ml-3 text-gray-700 font-medium">{{ $project->progress_percentage }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3 mt-8 pt-4 border-t border-gray-200">
                        @if ($project->user_id === Auth::id())
                            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Proyek
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini? Ini akan menghapus semua tugas dan anggota tim terkait.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus Proyek
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bagian Daftar Tugas --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6 lg:p-8 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-3 border-b-2 border-indigo-200">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                            Daftar Tugas
                        </h3>
                        @if ($project->user_id === Auth::id())
                          <a href="{{ route('projects.tasks.create', $project->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                 Tambah Tugas Baru
                        </a>
                        

                        @endif
                    </div>

                    @if ($project->tasks->isEmpty())
                        <div class="bg-gray-100 p-8 rounded-lg shadow-inner flex flex-col items-center justify-center text-center min-h-[150px] border border-gray-200">
                            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p class="text-center text-gray-500 text-lg font-semibold">Belum ada tugas untuk proyek ini.</p>
                            <p class="text-center text-gray-500 mt-2">Mulai tambahkan tugas untuk melacak progress proyek.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-100">
                           <table class="min-w-full text-left text-sm">
    <thead class="bg-gray-200 text-gray-700">
        <tr>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Tenggat</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($project->tasks as $task)
            <tr class="border-b">
                <td class="px-4 py-3">{{ $task->name }}</td>
                <td class="px-4 py-3">
                    @can('updateStatus', $task)
                        <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="border-gray-300 rounded p-1">
                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </form>
                    @else
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    @endcan
                </td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</td>
                <td class="px-4 py-3 space-x-2">
                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="text-blue-500 hover:underline">Lihat</a>

                    @can('update', $task)
                        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-yellow-500 hover:underline">Edit</a>
                    @endcan

                    @can('delete', $task)
                        <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus tugas ini?')" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Anggota Team --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 lg:p-8 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-3 border-b-2 border-indigo-200">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                            Anggota Tim
                        </h3>
                    </div>

                    @if ($project->user_id === Auth::id())
                        <form action="{{ route('projects.add-member', $project) }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            @csrf
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Tambah Anggota ke Proyek:</label>
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                                <select id="user_id" name="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:flex-grow p-2.5">
                                    <option value="">Pilih Anggota Tim</option>
                                    {{-- PERBAIKAN: Gunakan $project->users di sini untuk memeriksa anggota yang sudah ada --}}
                                    @foreach ($users as $user)
                                        {{-- Jangan tampilkan user jika dia sudah menjadi anggota atau jika dia adalah pemilik proyek --}}
                                        @if (($project->members && !$project->members->contains($user)) && $user->id !== $project->user_id)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-primary-button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 shadow-md">
                                    <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14v4m-4-4h8m-4 0v4m-4-4H8"></path></svg>
                                    Tambah Anggota
                                </x-primary-button>
                            </div>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </form>
                    @endif

                    {{-- PERBAIKAN: Gunakan $project->users di sini --}}
                   @if ($project->members->isEmpty())
                        <div class="bg-gray-100 p-8 rounded-lg shadow-inner flex flex-col items-center justify-center text-center min-h-[150px] border border-gray-200">
                            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7.465m-4.993 6.368L12 21l-2.993-4.167M2 7v10a2 2 0 002 2h4.5M14 4h6m-6 0h-6m6 0v10m0-10l-2.293-2.293a1 1 0 00-1.414 0L7 4"></path></svg>
                            <p class="text-center text-gray-500 text-lg font-semibold">Belum ada anggota tim di proyek ini.</p>
                            @if ($project->user_id === Auth::id())
                                <p class="text-center text-gray-500 mt-2">Gunakan formulir di atas untuk menambahkan anggota baru.</p>
                            @else
                                <p class="text-center text-gray-500 mt-2">Hanya pemilik proyek yang dapat menambahkan anggota.</p>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50 border-b border-indigo-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Nama Anggota</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Email</th>
                                        @if ($project->user_id === Auth::id())
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- PERBAIKAN: Gunakan $project->users di sini --}}
                                    @foreach ($project->members as $member)

                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if(isset($member->profile_photo_url))
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}">
                                                        @else
                                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">
                                                                {{ substr($member->name, 0, 1) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $member->email }}</td>
                                            @if ($project->user_id === Auth::id())
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    {{-- Pastikan owner proyek tidak bisa menghapus dirinya sendiri dari daftar anggota jika dia juga terdaftar sebagai anggota --}}
                                                    @if ($member->id !== Auth::id())
                                                        <form action="{{ route('projects.remove-member', [$project, $member]) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $member->name }} dari proyek ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-md text-xs font-semibold hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 11-2 0v6a1 1 0 112 0V8z" clip-rule="evenodd"></path></svg>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Pemilik Proyek</span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<style>
    /* Custom scrollbar for better aesthetics, if needed for tables */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0; /* gray-300 */
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0; /* gray-400 */
    }
</style>