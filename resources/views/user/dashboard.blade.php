@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Dashboard</p>
            <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">
                @if(auth()->user()->usia_kehamilan)
                    @php
                        $minggu = auth()->user()->usia_kehamilan;
                        $trimester = $minggu <= 12 ? 'Trimester 1' : ($minggu <= 27 ? 'Trimester 2' : 'Trimester 3');
                    @endphp
                    Kehamilan {{ $minggu }} minggu &middot; {{ $trimester }}
                @else
                    Usia kehamilan belum diisi
                @endif
            </p>
        </div>
        <a href="{{ route('user.diagnostik.index') }}"
           class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Mulai Diagnostik
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Diagnostik</p>
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalSelf }}</p>
        <p class="text-xs text-gray-400 mt-1">Sesi mandiri</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sudah Divalidasi</p>
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $sudahValidasi }}</p>
        <p class="text-xs text-gray-400 mt-1">Dikonfirmasi pakar</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Validasi</p>
            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $menungguValidasi }}</p>
        <p class="text-xs text-gray-400 mt-1">Perlu konfirmasi pakar</p>
    </div>
</div>

{{-- Bottom Section --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- Hasil Terakhir --}}
    <div class="lg:col-span-3 bg-white border border-gray-200 rounded-xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Hasil Terakhir</h2>
            <a href="{{ route('user.riwayat.index') }}" class="text-xs text-blue-600 hover:underline font-medium">Lihat semua</a>
        </div>

        <div class="p-6">
            @if($konsultasiTerakhir)
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900">{{ $konsultasiTerakhir->hipotesis->nama }}</p>
                    <p class="text-sm text-blue-600 font-medium mt-0.5">Nilai Bayes: {{ $konsultasiTerakhir->nilai_bayes }}%</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $konsultasiTerakhir->created_at->format('d M Y, H:i') }}</p>
                    <div class="mt-3">
                        @if($konsultasiTerakhir->status === 'pending')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-medium rounded-md border border-amber-200">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Menunggu validasi pakar
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-md border border-green-200">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                            Sudah divalidasi pakar
                        </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('user.riwayat.show', $konsultasiTerakhir->id) }}"
                   class="flex-shrink-0 text-xs text-blue-600 hover:text-blue-800 font-medium border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-md transition">
                    Detail
                </a>
            </div>

            {{-- Progress Bar --}}
            <div class="mt-5 pt-5 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-500">Tingkat keyakinan</p>
                    <p class="text-xs font-semibold text-gray-700">{{ $konsultasiTerakhir->nilai_bayes }}%</p>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full">
                    <div class="h-1.5 bg-blue-600 rounded-full transition-all" style="width: {{ min($konsultasiTerakhir->nilai_bayes, 100) }}%"></div>
                </div>
            </div>

            @else
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-700">Belum ada hasil diagnostik</p>
                <p class="text-xs text-gray-400 mt-1">Mulai self diagnostik untuk melihat hasilnya di sini</p>
                <a href="{{ route('user.diagnostik.index') }}"
                   class="mt-4 text-xs font-medium text-blue-600 hover:underline">
                    Mulai sekarang &rarr;
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Tips & Aksi --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Aksi Cepat --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="p-4 space-y-2">
                <a href="{{ route('user.diagnostik.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 border border-transparent hover:border-blue-100 transition group">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800 group-hover:text-blue-700">Mulai Diagnostik Baru</p>
                        <p class="text-xs text-gray-400">Periksa kondisi gizi sekarang</p>
                    </div>
                </a>
                <a href="{{ route('user.riwayat.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition group">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Lihat Riwayat</p>
                        <p class="text-xs text-gray-400">Cek hasil diagnostik sebelumnya</p>
                    </div>
                </a>
                <a href="{{ route('user.profil.edit') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition group">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Update Profil</p>
                        <p class="text-xs text-gray-400">Edit data kehamilan kamu</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Tips Gizi --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Tips Gizi</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="flex items-start gap-3 px-6 py-4">
                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Sayuran Hijau</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Bayam dan brokoli kaya asam folat untuk perkembangan janin.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-6 py-4">
                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Cukupi Kalsium</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Konsumsi produk susu 2–3 porsi per hari untuk tulang janin.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-6 py-4">
                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Hidrasi Cukup</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Minum minimal 8–10 gelas air putih per hari.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection