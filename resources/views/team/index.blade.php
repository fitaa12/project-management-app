<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Manajemen Tim') }}
        </h2>
        <p class="mt-2 text-md text-gray-600">Daftar semua pengguna yang terdaftar di sistem Anda.</p>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 lg:p-8 text-gray-900">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 pb-3 border-b-2 border-indigo-200">
                        Daftar Pengguna Sistem
                    </h3>
                    <p class="mb-8 text-gray-700 leading-relaxed">
                        Di sini Anda dapat melihat ringkasan semua pengguna. Untuk mengelola peran atau detail spesifik pengguna dalam sebuah proyek, silakan kunjungi halaman detail proyek yang relevan.
                    </p>

                    @if($users->isEmpty())
                        <div class="bg-gray-100 p-8 rounded-lg shadow-inner flex flex-col items-center justify-center text-center min-h-[200px] border border-gray-200">
                            <svg class="w-24 h-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7.465m-4.993 6.368L12 21l-2.993-4.167M2 7v10a2 2 0 002 2h4.5M14 4h6m-6 0h-6m6 0v10m0-10l-2.293-2.293a1 1 0 00-1.414 0L7 4"></path></svg>
                            <p class="text-center text-gray-500 text-xl font-semibold">Belum ada pengguna lain yang terdaftar.</p>
                            <p class="text-center text-gray-500 mt-2">Undang anggota tim baru atau daftarkan pengguna untuk mulai membangun tim Anda.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-100"> {{-- Card for the table --}}
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50 border-b border-indigo-200"> {{-- Stronger header background --}}
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Nama</th> {{-- Stronger text --}}
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Email</th> {{-- Stronger text --}}
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">Aksi</th> {{-- Centered --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out"> {{-- Hover effect for rows --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        {{-- User Avatar (if you have one, otherwise use initial) --}}
                                                        @if(isset($user->profile_photo_url)) {{-- Assuming you have profile photos --}}
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                                        @else
                                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100 text-indigo-800 text-sm font-semibold">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $user->email }}</div> {{-- Email under name --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td> {{-- Duplicated, let's keep one --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"> {{-- Centered --}}
                                                <a href="{{ route('team.show', $user) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8 flex justify-center"> {{-- Centered paginasi --}}
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Custom scrollbar for better aesthetics */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e0; /* gray-300 */
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a0aec0; /* gray-400 */
    }
</style>