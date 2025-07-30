<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">
    <div class="flex flex-1 bg-gray-100">
        {{-- Sidebar --}}
        <aside class="w-64 bg-indigo-900 border-r border-indigo-950 flex flex-col shadow-lg">
            <div class="p-4 flex flex-col items-center justify-center border-b border-indigo-800">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-12 w-auto fill-current text-indigo-100" />
                </a>
                <span class="text-sm font-semibold text-indigo-300 mt-2 text-center">
                    Sistem Manajemen Tugas Proyek
                </span>
            </div>

            <div class="flex-grow p-4">
                <p class="text-xs font-semibold text-indigo-300 uppercase tracking-wider mb-3">Platform</p>
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-2 rounded-md text-indigo-100 hover:bg-indigo-700 {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7m7-7v10a1 1 0 01-1 1h-3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('projects.index') }}"
                           class="flex items-center px-4 py-2 rounded-md text-indigo-100 hover:bg-indigo-700 {{ request()->routeIs('projects.*') ? 'bg-indigo-700' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Project
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('team.index') }}"
                           class="flex items-center px-4 py-2 rounded-md text-indigo-100 hover:bg-indigo-700 {{ request()->routeIs('team.*') ? 'bg-indigo-700' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h2a2 2 0 002-2V7.414a2 2 0 00-.586-1.414L15.586 3.414A2 2 0 0014.172 3H5a2 2 0 00-2 2v12a2 2 0 002 2h2m0 0l-2 2v-2m2 0h10v-2m-8 2h8m-8 0v2m8-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2h8z" />
                            </svg>
                            Team
                        </a>
                    </li>
                </ul>
            </div>

            {{-- User Profile Dropdown --}}
            <div class="p-4 border-t border-indigo-800">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = ! open"
                            class="w-full flex items-center justify-between text-left cursor-pointer p-2 rounded-md text-indigo-100 hover:bg-indigo-700">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-indigo-50 flex items-center justify-center text-sm font-semibold mr-3">
                                {{ substr(Auth::user()->name ?? '?', 0, 1) }}
                            </div>
                            <div class="text-sm font-medium">{{ Auth::user()->name ?? 'Guest' }}</div>
                        </div>
                        <svg class="w-4 h-4 text-indigo-300 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" class="absolute bottom-full left-0 right-0 mb-2 bg-indigo-700 border border-indigo-600 rounded-md shadow-lg z-10"
                         @click.outside="open = false">
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-indigo-50 hover:bg-indigo-600">
                                    Profile
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-indigo-50 hover:bg-indigo-600">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Page Content --}}
        <main class="flex-grow p-4">
            @isset($header)
                <header class="bg-white shadow mb-4 rounded-lg border border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{ $slot }}
        </main>
    </div>
</body>
</html>