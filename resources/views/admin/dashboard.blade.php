@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Card Total Gejala --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-emerald-500">
        <p class="text-sm text-gray-500">Total Gejala</p>
        <h3 class="text-3xl font-bold text-emerald-700">{{ $totalGejala }}</h3>
        <p class="text-xs text-gray-400 mt-1">Basis pengetahuan</p>
    </div>

    {{-- Card Total Konsultasi --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Konsultasi</p>
        <h3 class="text-3xl font-bold text-blue-700">{{ $totalKonsultasi }}</h3>
        <p class="text-xs text-gray-400 mt-1">Semua sesi</p>
    </div>

    {{-- Card Menunggu Validasi --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Validasi</p>
        <h3 class="text-3xl font-bold text-yellow-700">{{ $menungguValidasi }}</h3>
        <p class="text-xs text-gray-400 mt-1">Self diagnostik pending</p>
    </div>
</div>

{{-- Tabel Konsultasi Terbaru --}}
<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Konsultasi Terbaru</h3>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="px-4 py-3 rounded-tl-lg">Nama Ibu</th>
                <th class="px-4 py-3">Tipe</th>
                <th class="px-4 py-3">Hasil</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 rounded-tr-lg">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($konsultasiTerbaru as $k)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-3">{{ $k->user->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $k->tipe === 'self' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $k->tipe === 'self' ? 'Self Diagnostik' : 'Pakar' }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $k->hipotesis->nama ?? '-' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $k->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                        {{ $k->status === 'pending' ? 'Pending' : 'Selesai' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $k->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada konsultasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection