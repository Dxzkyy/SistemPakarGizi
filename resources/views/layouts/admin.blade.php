<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    {{-- Sidebar --}}
    <div class="flex h-screen">
        <aside class="w-64 bg-emerald-800 text-white flex flex-col">
            <div class="p-6 border-b border-emerald-700">
                <h1 class="text-xl font-bold">🩺 Sistem Pakar</h1>
                <p class="text-emerald-300 text-sm">Panel Pakar</p>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-emerald-700 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.gejala.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-emerald-700 {{ request()->routeIs('admin.gejala.*') ? 'bg-emerald-700' : '' }}">
                    🔬 Manajemen Gejala
                </a>
                <a href="{{ route('admin.hipotesis.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-emerald-700 {{ request()->routeIs('admin.hipotesis.*') ? 'bg-emerald-700' : '' }}">
                    📋 Manajemen Hipotesis
                </a>
                <a href="{{ route('admin.konsultasi.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-emerald-700 {{ request()->routeIs('admin.konsultasi.*') ? 'bg-emerald-700' : '' }}">
                    👩‍⚕️ Konsultasi Pakar
                </a>
            </nav>

            <div class="p-4 border-t border-emerald-700">
                <p class="text-sm text-emerald-300 mb-2">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-emerald-700 text-sm">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Header --}}
            <div class="bg-white shadow px-8 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
                <span class="text-sm text-gray-500">{{ now()->format('d F Y') }}</span>
            </div>

            {{-- Content --}}
            <div class="p-8">
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
            </div>
        </main>
    </div>

</body>
</html>