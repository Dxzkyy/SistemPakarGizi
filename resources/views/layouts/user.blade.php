<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pakar Gizi') — MBG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', system-ui, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">

    {{-- Navbar --}}
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="max-w-screen-xl mx-auto px-6">
            <div class="flex items-center justify-between h-14">

                {{-- Logo --}}
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-bgn-Photoroom.png') }}" alt="Logo" class="h-16 w-auto">
                    <div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Sistem Pakar Gizi</p>
                        <p class="text-xs text-blue-600 font-medium">Program Untuk Ibu Hamil</p>
                    </div>
                </div>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm font-medium transition
                   {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.diagnostik.index') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm font-medium transition
                   {{ request()->routeIs('user.diagnostik.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Diagnostik
                    </a>
                    <a href="{{ route('user.riwayat.index') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm font-medium transition
                   {{ request()->routeIs('user.riwayat.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Riwayat
                    </a>
                    <a href="{{ route('user.profil.edit') }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm font-medium transition
                   {{ request()->routeIs('user.profil.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2">
                        <div class="w-7 h-7 bg-gray-900 rounded-full flex items-center justify-center">
                            <span
                                class="text-white text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="w-px h-5 bg-gray-200 hidden md:block"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-14 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-6 py-8">

            @if (session('success'))
                <div
                    class="flex items-center gap-3 p-4 mb-6 bg-white border border-green-200 border-l-4 border-l-green-500 rounded-lg">
                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="flex items-center gap-3 p-4 mb-6 bg-white border border-red-200 border-l-4 border-l-red-500 rounded-lg">
                    <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>

</html>
