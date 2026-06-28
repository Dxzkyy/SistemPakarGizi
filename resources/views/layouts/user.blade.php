<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pakar Gizi') - MBG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

{{-- Navbar --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="w-full px-6">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-sm">GZ</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Sistem Pakar Gizi</p>
                    <p class="text-xs text-blue-600">Program MBG</p>
                </div>
            </div>

            {{-- Menu --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition
                   {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('user.diagnostik.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition
                   {{ request()->routeIs('user.diagnostik.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Self Diagnostik
                </a>
                <a href="{{ route('user.riwayat.index') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition
                   {{ request()->routeIs('user.riwayat.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Riwayat
                </a>
                <a href="{{ route('user.profil.edit') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition
                   {{ request()->routeIs('user.profil.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil
                </a>
            </div>

            {{-- User Info + Logout --}}
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 bg-blue-50 px-3 py-2 rounded-xl">
                    <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-600">
                            {{ auth()->user()->usia_kehamilan ? auth()->user()->usia_kehamilan . ' minggu' : 'Ibu Hamil' }}
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-1 text-sm text-gray-500 hover:text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- Content --}}
<main class="pt-20 pb-10">
    <div class="w-full px-6">

        @if(session('success'))
            <div class="flex items-center p-4 mb-4 mt-4 text-green-800 rounded-xl bg-green-50 border border-green-200">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center p-4 mb-4 mt-4 text-red-800 rounded-xl bg-red-50 border border-red-200">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</main>

</body>
</html>