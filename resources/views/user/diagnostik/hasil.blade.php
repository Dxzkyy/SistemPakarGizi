@extends('layouts.user')

@section('title', 'Hasil Diagnostik')

@section('content')
<div class="mb-6 mt-4">
    <h2 class="text-2xl font-bold text-gray-800">Hasil Self Diagnostik 📋</h2>
    <p class="text-gray-500 mt-1">Berikut hasil analisis berdasarkan gejala yang kamu pilih</p>
</div>

{{-- Hasil Utama --}}
<div class="bg-gradient-to-r
    {{ $konsultasi->hipotesis->kode === 'K01' ? 'from-red-500 to-orange-400' : ($konsultasi->hipotesis->kode === 'K02' ? 'from-yellow-500 to-amber-400' : 'from-blue-500 to-teal-400') }}
    rounded-2xl p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-white/80 text-sm font-medium mb-1">Hasil Diagnosa Sementara</p>
            <h3 class="text-3xl font-bold">{{ $konsultasi->hipotesis->nama }}</h3>
            <div class="flex items-center gap-3 mt-3">
                <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                    Nilai Bayes: {{ $konsultasi->nilai_bayes }}%
                </span>
                <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                    ⏳ Menunggu Validasi Pakar
                </span>
            </div>
        </div>
        <div class="text-6xl">
            {{ $konsultasi->hipotesis->kode === 'K01' ? '⚠️' : ($konsultasi->hipotesis->kode === 'K02' ? '🔶' : '✅') }}
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    {{-- Gejala yang dipilih --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Gejala yang Dipilih ({{ $konsultasi->gejala->count() }})</h3>
        <div class="space-y-2">
            @foreach($konsultasi->gejala as $g)
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                </svg>
                {{ $g->nama_gejala }}
            </div>
            @endforeach
        </div>
    </div>

    {{-- Rekomendasi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Rekomendasi Awal</h3>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $konsultasi->hipotesis->rekomendasi ?? 'Segera konsultasikan hasil ini dengan pakar gizi.' }}
        </p>

        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
            <p class="text-xs text-yellow-700 font-medium">⚠️ Penting!</p>
            <p class="text-xs text-yellow-600 mt-1">Hasil ini bersifat sementara. Segera temui pakar/ahli gizi untuk mendapatkan diagnosa yang lebih akurat.</p>
        </div>
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="flex items-center gap-3">
    <a href="{{ route('user.dashboard') }}"
       class="px-5 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
        ← Kembali ke Dashboard
    </a>
    <a href="{{ route('user.riwayat.index') }}"
       class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition">
        📋 Lihat Riwayat
    </a>
    <a href="{{ route('user.diagnostik.index') }}"
       class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
        🔄 Diagnostik Ulang
    </a>
</div>
@endsection