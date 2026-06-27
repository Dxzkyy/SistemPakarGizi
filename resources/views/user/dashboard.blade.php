@extends('layouts.user')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h2>
    <p class="text-gray-500 mt-1">
        Usia kehamilan: 
        <span class="font-semibold text-emerald-700">
            {{ auth()->user()->usia_kehamilan ? auth()->user()->usia_kehamilan . ' minggu' : 'Belum diisi' }}
        </span>
    </p>
</div>

{{-- Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-emerald-500">
        <p class="text-sm text-gray-500">Total Self Diagnostik</p>
        <h3 class="text-3xl font-bold text-emerald-700">{{ $totalSelf }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Sudah Divalidasi</p>
        <h3 class="text-3xl font-bold text-blue-700">{{ $sudahValidasi }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Validasi</p>
        <h3 class="text-3xl font-bold text-yellow-700">{{ $menungguValidasi }}</h3>
    </div>
</div>

{{-- Hasil Terakhir --}}
@if($konsultasiTerakhir)
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Hasil Self Diagnostik Terakhir</h3>
    <div class="flex items-center gap-4">
        <div class="bg-emerald-100 rounded-full p-4">
            <span class="text-3xl">🩺</span>
        </div>
        <div>
            <p class="text-xl font-bold text-emerald-700">{{ $konsultasiTerakhir->hipotesis->nama ?? '-' }}</p>
            <p class="text-gray-500 text-sm">Nilai Bayes: {{ $konsultasiTerakhir->nilai_bayes }}%</p>
            <p class="text-gray-400 text-xs">{{ $konsultasiTerakhir->created_at->format('d M Y') }}</p>
            @if($konsultasiTerakhir->status === 'pending')
                <span class="mt-1 inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">
                    ⏳ Menunggu validasi pakar
                </span>
            @else
                <span class="mt-1 inline-block px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                    ✅ Sudah divalidasi pakar
                </span>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Tombol Aksi --}}
<div class="flex gap-4">
    <a href="{{ route('user.diagnostik.index') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold">
        🩺 Mulai Self Diagnostik
    </a>
    <a href="{{ route('user.riwayat.index') }}"
       class="bg-white hover:bg-gray-50 text-gray-700 border px-6 py-3 rounded-lg font-semibold">
        📋 Lihat Riwayat
    </a>
</div>
@endsection