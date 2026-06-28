@extends('layouts.user')

@section('title', 'Detail Riwayat')

@section('content')

<div class="mb-8">
    <a href="{{ route('user.riwayat.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Riwayat
    </a>
    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Detail</p>
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Konsultasi</h1>
    <p class="text-sm text-gray-500 mt-1">{{ $konsultasi->created_at->format('d M Y, H:i') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Hasil Self Diagnostik --}}
    <div class="space-y-5">
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Hasil Self Diagnostik</h2>
                @if($konsultasi->status === 'pending')
                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                    Menunggu Validasi
                </span>
                @else
                <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    Sudah Divalidasi
                </span>
                @endif
            </div>

            <div class="p-6">
                {{-- Kondisi --}}
                <div class="border border-gray-100 rounded-xl p-4 mb-5 border-l-4
                    {{ isset($konsultasi->hipotesis->kode) && $konsultasi->hipotesis->kode === 'K01' ? 'border-l-red-400' : (isset($konsultasi->hipotesis->kode) && $konsultasi->hipotesis->kode === 'K02' ? 'border-l-amber-400' : 'border-l-green-400') }}">
                    <p class="text-xs text-gray-500 font-medium mb-1">Kondisi Terdeteksi</p>
                    <p class="text-xl font-bold text-gray-900">{{ $konsultasi->hipotesis->nama ?? '—' }}</p>
                    @if($konsultasi->nilai_bayes)
                    <div class="flex items-center gap-3 mt-3">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full">
                            <div class="h-1.5 bg-blue-600 rounded-full" style="width: {{ min($konsultasi->nilai_bayes, 100) }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-blue-600">{{ $konsultasi->nilai_bayes }}%</span>
                    </div>
                    @endif
                </div>

                {{-- Gejala --}}
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Gejala yang Dirasakan</p>
                    <div class="space-y-1.5">
                        @forelse($konsultasi->gejala as $gejala)
                        <div class="flex items-center gap-2.5 text-sm text-gray-700 py-1">
                            <svg class="w-3.5 h-3.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                            {{ $gejala->nama_gejala }}
                        </div>
                        @empty
                        <p class="text-sm text-gray-400">Tidak ada data gejala.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Rekomendasi --}}
                @if($konsultasi->hipotesis?->rekomendasi)
                <div class="mt-5 pt-5 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rekomendasi Gizi</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $konsultasi->hipotesis->rekomendasi }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Validasi Pakar --}}
    <div>
        @if($validasiPakar)
        <div class="bg-white border border-green-200 rounded-xl">
            <div class="flex items-center gap-2 px-6 py-4 border-b border-green-100">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                </svg>
                <h2 class="text-sm font-semibold text-gray-900">Hasil Validasi Pakar</h2>
            </div>

            <div class="p-6">
                <div class="border border-green-100 rounded-xl p-4 mb-5 border-l-4 border-l-green-500">
                    <p class="text-xs text-gray-500 font-medium mb-1">Diagnosa Pakar</p>
                    <p class="text-xl font-bold text-gray-900">{{ $validasiPakar->hipotesis->nama ?? '—' }}</p>
                    @if($validasiPakar->nilai_bayes)
                    <div class="flex items-center gap-3 mt-3">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full">
                            <div class="h-1.5 bg-green-600 rounded-full" style="width: {{ min($validasiPakar->nilai_bayes, 100) }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-green-600">{{ $validasiPakar->nilai_bayes }}%</span>
                    </div>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">{{ $validasiPakar->created_at->format('d M Y, H:i') }}</p>
                </div>

                @if($validasiPakar->catatan_pakar)
                <div class="mb-5">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan Pakar</p>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $validasiPakar->catatan_pakar }}</p>
                    </div>
                </div>
                @endif

                @if($validasiPakar->hipotesis?->rekomendasi)
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rekomendasi Pakar</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $validasiPakar->hipotesis->rekomendasi }}</p>
                </div>
                @endif
            </div>
        </div>

        @else
        <div class="bg-white border border-amber-200 rounded-xl p-8 text-center">
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 mb-2">Menunggu Validasi Pakar</p>
            <p class="text-xs text-gray-500 leading-relaxed">
                Hasil diagnostik kamu sudah tersimpan. Segera temui pakar gizi untuk validasi langsung.
            </p>
        </div>
        @endif
    </div>

</div>

@endsection