@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

{{-- Header Greeting --}}
<div class="bg-gradient-to-r from-blue-600 to-teal-500 rounded-2xl p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-blue-100 mt-1">Selamat datang di Sistem Pakar Gizi Ibu Hamil</p>
            <div class="flex items-center gap-2 mt-3">
                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-sm font-medium">
                    🤰 Usia Kehamilan: {{ auth()->user()->usia_kehamilan ? auth()->user()->usia_kehamilan . ' Minggu' : 'Belum diisi' }}
                </span>
                @if(auth()->user()->usia_kehamilan)
                    @php
                        $minggu = auth()->user()->usia_kehamilan;
                        $trimester = $minggu <= 12 ? 'Trimester 1' : ($minggu <= 27 ? 'Trimester 2' : 'Trimester 3');
                    @endphp
                    <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-sm font-medium">
                        📅 {{ $trimester }}
                    </span>
                @endif
            </div>
        </div>
        <div class="hidden md:block">
            <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center">
                <span class="text-5xl">🤰</span>
            </div>
        </div>
    </div>
</div>

{{-- Cards Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total Self Diagnostik</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSelf }}</h3>
                <p class="text-xs text-gray-400 mt-1">Sesi konsultasi mandiri</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Sudah Divalidasi</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $sudahValidasi }}</h3>
                <p class="text-xs text-gray-400 mt-1">Dikonfirmasi pakar</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Menunggu Validasi</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $menungguValidasi }}</h3>
                <p class="text-xs text-gray-400 mt-1">Segera temui pakar</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    {{-- Hasil Terakhir --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Hasil Terakhir</h3>
        @if($konsultasiTerakhir)
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0
                    {{ $konsultasiTerakhir->hipotesis->kode === 'K01' ? 'bg-red-100' : ($konsultasiTerakhir->hipotesis->kode === 'K02' ? 'bg-yellow-100' : 'bg-blue-100') }}">
                    <span class="text-2xl">
                        {{ $konsultasiTerakhir->hipotesis->kode === 'K01' ? '⚠️' : ($konsultasiTerakhir->hipotesis->kode === 'K02' ? '🔶' : '✅') }}
                    </span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-lg">{{ $konsultasiTerakhir->hipotesis->nama }}</p>
                    <p class="text-blue-600 font-semibold text-sm">Nilai Bayes: {{ $konsultasiTerakhir->nilai_bayes }}%</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $konsultasiTerakhir->created_at->format('d M Y, H:i') }}</p>
                    <div class="mt-2">
                        @if($konsultasiTerakhir->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                ⏳ Menunggu validasi pakar
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                ✅ Sudah divalidasi pakar
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <a href="{{ route('user.riwayat.show', $konsultasiTerakhir->id) }}"
               class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 border border-blue-200 text-blue-600 text-sm font-medium rounded-xl hover:bg-blue-50 transition">
                Lihat Detail
            </a>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <span class="text-5xl mb-3">🩺</span>
                <p class="text-gray-500 text-sm">Belum ada hasil diagnostik</p>
                <p class="text-gray-400 text-xs mt-1">Mulai self diagnostik sekarang</p>
            </div>
        @endif
    </div>

    {{-- Tips Gizi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Tips Gizi Hari Ini 💡</h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl">
                <span class="text-xl">🥦</span>
                <div>
                    <p class="text-sm font-medium text-gray-700">Konsumsi Sayuran Hijau</p>
                    <p class="text-xs text-gray-500">Bayam dan brokoli kaya asam folat untuk perkembangan janin</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl">
                <span class="text-xl">🥛</span>
                <div>
                    <p class="text-sm font-medium text-gray-700">Cukupi Kalsium</p>
                    <p class="text-xs text-gray-500">Minum susu atau konsumsi produk susu 2-3 porsi per hari</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-xl">
                <span class="text-xl">💧</span>
                <div>
                    <p class="text-sm font-medium text-gray-700">Minum Air Putih</p>
                    <p class="text-xs text-gray-500">Minimal 8-10 gelas per hari untuk mencegah dehidrasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <a href="{{ route('user.diagnostik.index') }}"
           class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 rounded-xl font-medium transition">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Mulai Self Diagnostik</p>
                <p class="text-blue-100 text-xs">Periksa kondisi gizi kamu sekarang</p>
            </div>
        </a>
        <a href="{{ route('user.riwayat.index') }}"
           class="flex items-center gap-3 bg-gray-50 hover:bg-gray-100 text-gray-700 px-5 py-4 rounded-xl font-medium transition border border-gray-200">
            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Lihat Riwayat</p>
                <p class="text-gray-400 text-xs">Cek hasil diagnostik sebelumnya</p>
            </div>
        </a>
    </div>
</div>

@endsection