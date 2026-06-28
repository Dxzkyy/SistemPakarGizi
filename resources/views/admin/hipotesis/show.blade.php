@extends('layouts.admin')

@section('title', 'Detail Hipotesis')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.hipotesis.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
    <a href="{{ route('admin.hipotesis.edit', $hipotesis->id) }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        Edit Hipotesis
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-purple-100 text-purple-700 text-sm font-bold px-3 py-1.5 rounded-xl">{{ $hipotesis->kode }}</span>
            <h2 class="text-xl font-bold text-gray-800">{{ $hipotesis->nama }}</h2>
        </div>

        @if($hipotesis->deskripsi)
        <div class="mb-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</p>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $hipotesis->deskripsi }}</p>
        </div>
        @endif

        @if($hipotesis->rekomendasi)
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Rekomendasi Gizi</p>
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <p class="text-sm text-green-800 leading-relaxed">{{ $hipotesis->rekomendasi }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">
            Gejala Terkait
            <span class="ml-2 text-sm font-normal text-gray-400">({{ $hipotesis->gejala->count() }} gejala)</span>
        </h3>

        @forelse($hipotesis->gejala as $gejala)
        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ $gejala->kode }}</span>
                <p class="text-sm text-gray-700">{{ $gejala->nama_gejala }}</p>
            </div>
            <span class="text-sm font-semibold text-gray-800 bg-gray-100 px-3 py-1 rounded-lg">
                {{ $gejala->pivot->nilai_pakar }}
            </span>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-8">Belum ada gejala yang terkait</p>
        @endforelse
    </div>
</div>
@endsection