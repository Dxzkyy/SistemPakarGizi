@extends('layouts.user')

@section('title', 'Hasil Diagnostik')

@section('content')

<div class="mb-8">
    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Hasil Diagnostik</p>
    <h1 class="text-2xl font-bold text-gray-900">Analisis Selesai</h1>
    <p class="text-sm text-gray-500 mt-1">Berikut hasil berdasarkan gejala yang kamu pilih.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Hasil Utama --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Kondisi Terdeteksi --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 border-l-4
            {{ $konsultasi->hipotesis->kode === 'K01' ? 'border-l-red-500' : ($konsultasi->hipotesis->kode === 'K02' ? 'border-l-amber-500' : 'border-l-green-500') }}">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Kondisi Gizi Terdeteksi</p>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $konsultasi->hipotesis->nama }}</h2>

            <div class="flex items-center gap-3 mb-4">
                <span class="text-sm font-semibold text-blue-600">Nilai Bayes: {{ $konsultasi->nilai_bayes }}%</span>
                <span class="text-gray-300">|</span>
                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-md">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Menunggu Validasi Pakar
                </span>
            </div>

            <div class="w-full h-1.5 bg-gray-100 rounded-full">
                <div class="h-1.5 rounded-full transition-all
                    {{ $konsultasi->hipotesis->kode === 'K01' ? 'bg-red-500' : ($konsultasi->hipotesis->kode === 'K02' ? 'bg-amber-500' : 'bg-green-500') }}"
                    style="width: {{ min($konsultasi->nilai_bayes, 100) }}%">
                </div>
            </div>
        </div>

        {{-- Gejala yang Dipilih --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Gejala yang Dipilih <span class="text-gray-400 font-normal">({{ $konsultasi->gejala->count() }})</span></h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($konsultasi->gejala as $g)
                <div class="flex items-center gap-3 px-6 py-3">
                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">{{ $g->nama_gejala }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Rekomendasi --}}
    <div class="space-y-5">
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Rekomendasi Awal</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $konsultasi->hipotesis->rekomendasi ?? 'Segera konsultasikan hasil ini dengan pakar gizi.' }}
                </p>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-xs font-semibold text-amber-800 mb-1">Penting</p>
                    <p class="text-xs text-amber-700 leading-relaxed">Hasil ini bersifat sementara dan perlu divalidasi oleh pakar atau ahli gizi.</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Actions --}}
<div class="flex items-center gap-3">
    <a href="{{ route('user.dashboard') }}"
       class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('user.riwayat.index') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
        Lihat Riwayat
    </a>
    <a href="{{ route('user.diagnostik.index') }}"
       class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Diagnostik Ulang
    </a>
</div>

@endsection