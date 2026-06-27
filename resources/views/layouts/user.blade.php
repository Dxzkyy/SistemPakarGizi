<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Sistem Pakar Gizi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-emerald-700 text-white shadow">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold">🤰 Sistem Pakar Gizi Ibu Hamil</h1>
                <p class="text-emerald-200 text-xs">Program MBG</p>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('user.dashboard') }}"
                   class="text-sm hover:text-emerald-200 {{ request()->routeIs('user.dashboard') ? 'font-bold underline' : '' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('user.diagnostik.index') }}"
                   class="text-sm hover:text-emerald-200 {{ request()->routeIs('user.diagnostik.*') ? 'font-bold underline' : '' }}">
                    🩺 Self Diagnostik
                </a>
                <a href="{{ route('user.riwayat.index') }}"
                   class="text-sm hover:text-emerald-200 {{ request()->routeIs('user.riwayat.*') ? 'font-bold underline' : '' }}">
                    📋 Riwayat
                </a>
                <a href="{{ route('user.profil.edit') }}"
                   class="text-sm hover:text-emerald-200 {{ request()->routeIs('user.profil.*') ? 'font-bold underline' : '' }}">
                    👤 Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm hover:text-emerald-200">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="max-w-6xl mx-auto px-6 py-8">
        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>