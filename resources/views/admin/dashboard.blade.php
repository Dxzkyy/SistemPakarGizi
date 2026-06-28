@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Gejala</p>
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalGejala }}</p>
        <p class="text-xs text-gray-400 mt-1">Basis pengetahuan</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Konsultasi</p>
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalKonsultasi }}</p>
        <p class="text-xs text-gray-400 mt-1">Semua sesi</p>
    </div>

    <div class="bg-white border border-amber-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Menunggu Validasi</p>
            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $menungguValidasi }}</p>
        <p class="text-xs text-amber-500 mt-1 font-medium">Perlu tindakan</p>
    </div>

</div>

{{-- Konsultasi Terbaru --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="text-sm font-semibold text-gray-900">Konsultasi Terbaru</h2>
        <a href="{{ route('admin.konsultasi.index') }}" class="text-xs text-blue-600 hover:underline font-medium">Lihat semua &rarr;</a>
    </div>

    {{-- Table Header --}}
    <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-100">
        <div class="col-span-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Ibu</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</div>
        <div class="col-span-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hasil Diagnosa</div>
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</div>
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</div>
    </div>

    {{-- Table Rows --}}
    <div class="divide-y divide-gray-100">
        @forelse($konsultasiTerbaru as $k)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 transition">
            <div class="col-span-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-semibold text-gray-600">{{ strtoupper(substr($k->user->name, 0, 1)) }}</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800 truncate">{{ $k->user->name }}</span>
                </div>
            </div>
            <div class="col-span-2">
                <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-md
                    {{ $k->tipe === 'self' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                    {{ $k->tipe === 'self' ? 'Self' : 'Pakar' }}
                </span>
            </div>
            <div class="col-span-3">
                <p class="text-sm text-gray-700 truncate">{{ $k->hipotesis->nama ?? '—' }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-sm font-bold text-gray-900">{{ $k->nilai_bayes ? $k->nilai_bayes . '%' : '—' }}</p>
            </div>
            <div class="col-span-2">
                @if($k->status === 'pending')
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
            <div class="col-span-1">
                <p class="text-xs text-gray-400">{{ $k->created_at->format('d M') }}</p>
            </div>
        </div>
        @empty
        <div class="px-6 py-14 text-center">
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-600">Belum ada konsultasi</p>
            <p class="text-xs text-gray-400 mt-1">Data konsultasi akan muncul di sini</p>
        </div>
        @endforelse
    </div>
</div>

@endsection