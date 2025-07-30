<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proyek Saya') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Daftar Proyek') }}</h3>
                        <div class="flex space-x-3 items-center w-full sm:w-auto">
                            <div class="relative w-full sm:w-auto">
                                <input type="text" id="project-search" placeholder="Cari proyek..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    onkeyup="filterProjects()">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            <div class="relative w-full sm:w-auto">
                                <select id="status-filter" onchange="filterProjects()"
                                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All states</option>
                                    <option value="in_progress">in_progress</option>
                                    <option value="completed">completed</option>
                                    <option value="cancelled">cancelled</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md flex-shrink-0">
                                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Proyek Baru
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($projects->isEmpty())
                        <div class="text-center bg-gray-50 py-10 rounded-lg border border-gray-200">
                            <p class="text-gray-500 text-lg">Belum ada proyek yang dibuat.</p>
                            <p class="text-gray-400 text-sm mt-2">Mulai buat proyek baru Anda sekarang!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200" id="projects-table"> {{-- Tambahkan ID untuk JS filter --}}
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Proyek</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Selesai</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Progress</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($projects as $project)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out" data-status="{{ $project->status }}"> {{-- Tambahkan data-status untuk filter --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">{{ $project->name }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($project->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($project->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-600">{{ $project->progress_percentage }}%</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                                <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="no-projects-found" class="text-center py-10 text-gray-500 text-lg hidden">
                                Tidak ada proyek yang ditemukan.
                            </div>
                        </div>
                        <div class="mt-6">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterProjects() {
            const searchText = document.getElementById('project-search').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value;
            const table = document.getElementById('projects-table');
            const rows = table.getElementsByTagName('tr');
            let foundProjects = 0;

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                const row = rows[i];
                const projectName = row.cells[0].textContent.toLowerCase();
                const projectStatus = row.dataset.status;

                const nameMatch = projectName.includes(searchText);
                const statusMatch = (statusFilter === '' || projectStatus === statusFilter);

                if (nameMatch && statusMatch) {
                    row.style.display = '';
                    foundProjects++;
                } else {
                    row.style.display = 'none';
                }
            }

            const noProjectsFoundDiv = document.getElementById('no-projects-found');
            if (foundProjects === 0) {
                noProjectsFoundDiv.classList.remove('hidden');
                table.classList.add('hidden'); // Sembunyikan tabel jika tidak ada hasil
            } else {
                noProjectsFoundDiv.classList.add('hidden');
                table.classList.remove('hidden'); // Tampilkan tabel jika ada hasil
            }
        }
    </script>
</x-app-layout>