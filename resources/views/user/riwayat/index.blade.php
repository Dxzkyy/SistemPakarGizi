@extends('layouts.user')

@section('title', 'Riwayat Konsultasi')

@section('content')

<div class="mb-8">
    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Riwayat</p>
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Konsultasi</h1>
    <p class="text-sm text-gray-500 mt-1">Semua sesi self diagnostik dan validasi pakar kamu.</p>
</div>

@if($konsultasi->isEmpty())
<div class="bg-white border border-dashed border-gray-300 rounded-xl p-16 text-center">
    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
    </div>
    <p class="text-sm font-semibold text-gray-700 mb-1">Belum ada riwayat konsultasi</p>
    <p class="text-xs text-gray-400 mb-5">Mulai self diagnostik untuk melihat riwayat di sini.</p>
    <a href="{{ route('user.diagnostik.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
        Mulai Sekarang
    </a>
</div>

@else
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    {{-- Table Header --}}
    <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-200">
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</div>
        <div class="col-span-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</div>
        <div class="col-span-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hasil</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</div>
        <div class="col-span-1"></div>
    </div>

    {{-- Table Rows --}}
    <div class="divide-y divide-gray-100">
        @foreach($konsultasi as $index => $item)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 transition">
            <div class="col-span-1 text-xs text-gray-400 font-mono">{{ $konsultasi->firstItem() + $index }}</div>
            <div class="col-span-3">
                <p class="text-sm font-medium text-gray-800">{{ $item->created_at->format('d M Y') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $item->created_at->format('H:i') }}</p>
            </div>
            <div class="col-span-3">
                <p class="text-sm font-medium text-gray-800">{{ $item->hipotesis->nama ?? '—' }}</p>
                <span class="text-xs text-gray-400">
                    {{ $item->tipe === 'self' ? 'Self Diagnostik' : 'Validasi Pakar' }}
                </span>
            </div>
            <div class="col-span-2">
                @if($item->nilai_bayes)
                <p class="text-sm font-bold text-gray-900">{{ $item->nilai_bayes }}%</p>
                <p class="text-xs text-gray-400">Bayes</p>
                @else
                <span class="text-sm text-gray-400">—</span>
                @endif
            </div>
            <div class="col-span-2">
                @if($item->status === 'pending')
                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                    Pending
                </span>
                @else
                <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    Selesai
                </span>
                @endif
            </div>
            <div class="col-span-1 text-right">
                <a href="{{ route('user.riwayat.show', $item->id) }}"
                   class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                    Detail &rarr;
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@if($konsultasi->hasPages())
<div class="mt-5">
    {{ $konsultasi->links() }}
</div>
@endif
@endif

@endsection