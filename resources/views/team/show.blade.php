<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Pengguna:') }} <span class="text-indigo-600">{{ $user->name }}</span>
        </h2>
        <p class="mt-2 text-md text-gray-600">Lihat informasi lengkap mengenai pengguna ini.</p>
    </x-slot>

    <div class="py-8 bg-gray-50"> {{-- Tambahkan latar belakang abu-abu muda --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar maksimum yang lebih fokus untuk detail --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200"> {{-- Card yang lebih menonjol --}}
                <div class="p-6 lg:p-8 text-gray-900">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-indigo-200">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                            Informasi Pengguna
                        </h3>
                        {{-- Opsional: Tambahkan tombol edit di sini jika ada halaman edit user --}}
                        {{-- <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Pengguna
                        </a> --}}
                    </div>

                    <div class="space-y-4 mb-6"> {{-- Tambah jarak antar elemen info --}}
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Nama Lengkap:</p>
                            <p class="text-xl text-gray-900 ml-4">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Email:</p>
                            <p class="text-xl text-gray-900 ml-4">{{ $user->email }}</p>
                        </div>
                    </div>

                    <h4 class="text-xl font-bold text-gray-800 mb-4 pt-4 border-t-2 border-gray-100">Proyek yang Ditugaskan</h4>
                    @if($user->assignedProjects->isEmpty())
                        <p class="text-gray-500 italic">Pengguna ini belum ditugaskan ke proyek manapun.</p>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-inner"> {{-- Kontainer untuk daftar proyek --}}
                            <ul class="space-y-3"> {{-- Jarak antar item list --}}
                                @foreach($user->assignedProjects as $project)
                                    <li class="flex items-center text-gray-800">
                                        <svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline font-medium text-lg">
                                            {{ $project->name }}
                                        </a>
                                        <span class="ml-auto text-sm text-gray-500">({{ $project->status == 'completed' ? 'Selesai' : 'Sedang Berlangsung' }})</span> {{-- Tampilkan status proyek --}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end"> {{-- Tambah margin atas dan border --}}
                        <a href="{{ route('team.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h14"></path></svg>
                            {{ __('Kembali ke Daftar Tim') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>