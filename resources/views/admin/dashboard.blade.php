@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Cards Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Gejala</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalGejala }}</h3>
                <p class="text-xs text-gray-400 mt-1">Basis pengetahuan</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Konsultasi</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalKonsultasi }}</h3>
                <p class="text-xs text-gray-400 mt-1">Semua sesi</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Menunggu Validasi</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $menungguValidasi }}</h3>
                <p class="text-xs text-gray-400 mt-1">Self diagnostik pending</p>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Konsultasi Terbaru --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold text-gray-800">Konsultasi Terbaru</h3>
        <a href="{{ route('admin.konsultasi.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <th class="px-4 py-3 rounded-tl-xl">Nama Ibu</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Hasil Diagnosa</th>
                    <th class="px-4 py-3">Nilai</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 rounded-tr-xl">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($konsultasiTerbaru as $k)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $k->user->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $k->tipe === 'self' ? 'bg-blue-100 text-blue-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $k->tipe === 'self' ? 'Self Diagnostik' : 'Pakar' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-700">{{ $k->hipotesis->nama ?? '-' }}</td>
                    <td class="px-4 py-3 font-semibold text-blue-600">{{ $k->nilai_bayes ? $k->nilai_bayes . '%' : '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $k->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $k->status === 'pending' ? '⏳ Pending' : '✅ Selesai' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $k->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Belum ada konsultasi
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection