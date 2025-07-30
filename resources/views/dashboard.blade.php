<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Sistem Manajemen Tugas Proyek') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 bg-gray-50"> {{-- Added subtle background to the main content area --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8 lg:p-10 text-gray-900">
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-8 pb-4 text-center relative after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-24 after:h-1 after:bg-indigo-500 after:rounded-full">
                        Selamat datang, <span class="text-indigo-600">{{ Auth::user()->name }}</span>!
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                        {{-- Total Projects Card --}}
                        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white p-6 rounded-xl shadow-md transform hover:scale-105 transition duration-300 ease-in-out flex flex-col items-center text-center relative overflow-hidden border-b-4 border-indigo-900">
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 bg-white/20 rounded-full w-24 h-24 blur-xl opacity-50"></div>
                            <svg class="w-16 h-16 mb-3 text-indigo-200" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <h4 class="text-5xl font-extrabold mb-2">{{ $totalProjects }}</h4>
                            <p class="text-lg font-semibold">Total Projects</p>
                        </div>
                        {{-- Completed Projects Card --}}
                        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-6 rounded-xl shadow-md transform hover:scale-105 transition duration-300 ease-in-out flex flex-col items-center text-center relative overflow-hidden border-b-4 border-green-800">
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 bg-white/20 rounded-full w-24 h-24 blur-xl opacity-50"></div>
                            <svg class="w-16 h-16 mb-3 text-green-200" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="text-5xl font-extrabold mb-2">{{ $completedProjects }}</h4>
                            <p class="text-lg font-semibold">Completed Projects</p>
                        </div>
                        {{-- Running Projects Card --}}
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-xl shadow-md transform hover:scale-105 transition duration-300 ease-in-out flex flex-col items-center text-center relative overflow-hidden border-b-4 border-blue-800">
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 bg-white/20 rounded-full w-24 h-24 blur-xl opacity-50"></div>
                            <svg class="w-16 h-16 mb-3 text-blue-200" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="text-5xl font-extrabold mb-2">{{ $runningProjects + $pendingProjects }}</h4>
                            <p class="text-lg font-semibold">Running Projects</p>
                        </div>
                        {{-- Cancelled Projects Card --}}
                        <div class="bg-gradient-to-br from-red-500 to-red-700 text-white p-6 rounded-xl shadow-md transform hover:scale-105 transition duration-300 ease-in-out flex flex-col items-center text-center relative overflow-hidden border-b-4 border-red-800">
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 bg-white/20 rounded-full w-24 h-24 blur-xl opacity-50"></div>
                            <svg class="w-16 h-16 mb-3 text-red-200" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="text-5xl font-extrabold mb-2">{{ $cancelledProjects }}</h4>
                            <p class="text-lg font-semibold">Cancelled Projects</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        {{-- Project Progress Monitoring --}}
                        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-5 pb-3 border-b border-gray-300">Project Progress Monitoring</h3>
                            <div class="bg-gray-50 p-6 min-h-[280px] flex flex-col rounded-xl shadow-inner overflow-hidden">
                                @if($projectsForMonitoring->isEmpty())
                                    <div class="flex-grow flex flex-col items-center justify-center text-center p-4">
                                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6 18H4a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v2M12 17v2m-4 0h8"></path></svg>
                                        <p class="text-gray-500 text-xl font-medium">No projects currently being monitored.</p>
                                        <p class="text-md text-gray-500 mt-2">Create new projects or mark them as 'In Progress' or 'Pending' to see them here.</p>
                                    </div>
                                @else
                                    <div class="space-y-4 overflow-y-auto max-h-[250px] pr-2 custom-scrollbar">
                                        @foreach($projectsForMonitoring as $project)
                                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 transition duration-150 ease-in-out hover:shadow-md">
                                                <div class="flex justify-between items-center mb-2">
                                                    <h4 class="font-bold text-lg text-gray-900">{{ $project->name }}</h4>
                                                    <span class="text-md font-semibold text-blue-700">{{ $project->progress_percentage }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-300 rounded-full h-3">
                                                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                                </div>
                                                <p class="text-sm text-gray-600 mt-1.5">Due: {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- Urgent Projects --}}
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-5 pb-3 border-b border-gray-300">Urgent Projects</h3>
                            <div class="bg-gray-50 p-6 min-h-[280px] rounded-xl shadow-inner overflow-hidden">
                                @if($urgentProjects->isEmpty())
                                    <div class="flex-grow flex flex-col items-center justify-center text-center p-4">
                                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.192 10.007a4.5 4.5 0 113.623 3.623L16.21 17.5l-1.636 1.636L12 14.364l-2.007 2.007L8 15.192l-1.636 1.636L3 12l.754-.754M12 4v.01"></path></svg>
                                        <p class="text-gray-500 text-xl font-medium">No urgent projects at this time.</p>
                                    </div>
                                @else
                                    <ul class="list-none space-y-3 overflow-y-auto max-h-[250px] pr-2 custom-scrollbar">
                                        @foreach($urgentProjects as $project)
                                            <li class="flex items-start bg-white p-4 rounded-lg shadow-sm border border-red-200 transition duration-150 ease-in-out hover:shadow-md">
                                                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                <div>
                                                    <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800 hover:underline font-semibold text-lg">
                                                        {{ $project->name }}
                                                    </a>
                                                    <p class="text-sm text-gray-700 mt-1">Due: {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
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

    /* Subtle background for the dashboard main content area */
    .dashboard-bg {
        background-color: #f7f8fc; /* A very light blue-gray */
    }
</style>