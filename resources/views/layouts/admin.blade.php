<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Sistem Pakar Gizi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

{{-- Top Navbar --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 h-14 flex items-center">
    <div class="flex items-center justify-between w-full px-4">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 w-64">
            <button data-drawer-target="sidebar-admin" data-drawer-toggle="sidebar-admin"
                class="sm:hidden p-1.5 text-gray-500 rounded-md hover:bg-gray-100">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"/>
                </svg>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-bgn-Photoroom.png') }}" alt="Logo" class="h-16 w-auto object-contain">
                <div>
                    <p class="text-sm font-bold text-gray-900 leading-tight">Sistem Pakar Gizi</p>
                    <p class="text-xs text-blue-600 font-medium">Program Untuk Ibu Hamil</p>
                </div>
            </a>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3">
            {{-- Pending Badge --}}
            @php $pendingCount = \App\Models\Konsultasi::where('tipe','self')->where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
            <a href="{{ route('admin.konsultasi.index') }}"
               class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium rounded-lg hover:bg-amber-100 transition">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                {{ $pendingCount }} menunggu validasi
            </a>
            @endif

            <div class="w-px h-5 bg-gray-200"></div>

            <div class="hidden md:flex items-center gap-2">
                <div class="w-7 h-7 bg-gray-900 rounded-full flex items-center justify-center">
                    <span class="text-white text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-600">Pakar Gizi</p>
                </div>
            </div>

            <div class="w-px h-5 bg-gray-200 hidden md:block"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Sidebar --}}
<aside id="sidebar-admin"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200"
    aria-label="Sidebar">
    <div class="h-full px-3 py-5 overflow-y-auto">

        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2 px-3">Menu Utama</p>
        <ul class="space-y-0.5 mb-6">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
        </ul>

        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2 px-3">Basis Pengetahuan</p>
        <ul class="space-y-0.5 mb-6">
            <li>
                <a href="{{ route('admin.gejala.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('admin.gejala.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Manajemen Gejala
                </a>
            </li>
            <li>
                <a href="{{ route('admin.hipotesis.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('admin.hipotesis.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    Manajemen Hipotesis
                </a>
            </li>
        </ul>

        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2 px-3">Konsultasi</p>
        <ul class="space-y-0.5">
            <li>
                <a href="{{ route('admin.konsultasi.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('admin.konsultasi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Konsultasi Pakar
                    @if($pendingCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
        </ul>

        {{-- Bottom Info --}}
        <div class="absolute bottom-5 left-3 right-3">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                <p class="text-xs text-gray-500 font-medium">{{ now()->translatedFormat('l') }}</p>
                <p class="text-xs text-gray-400">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </div>
</aside>

{{-- Main Content --}}
<div class="sm:ml-64 pt-14 min-h-screen">
    <div class="p-6">

        {{-- Page Header --}}
        <div class="mb-6">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Pakar Gizi</p>
            <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
        </div>

        @if(session('success'))
        <div class="flex items-center gap-3 p-4 mb-5 bg-white border border-green-200 border-l-4 border-l-green-500 rounded-lg">
            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="flex items-center gap-3 p-4 mb-5 bg-white border border-red-200 border-l-4 border-l-red-500 rounded-lg">
            <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
        </div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>