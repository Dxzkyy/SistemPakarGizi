@extends('layouts.admin')

@section('title', 'Konsultasi Pakar')

@section('content')
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Daftar konsultasi ibu hamil yang perlu divalidasi</h2>
    </div>

    {{-- Filter Tab --}}
    <div class="flex gap-2 mb-5">
        <a href="{{ route('admin.konsultasi.index') }}"
            class="px-4 py-2 text-sm font-medium rounded-xl transition
            {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.konsultasi.index', ['status' => 'pending']) }}"
            class="px-4 py-2 text-sm font-medium rounded-xl transition
            {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Menunggu Validasi
        </a>
        <a href="{{ route('admin.konsultasi.index', ['status' => 'selesai']) }}"
            class="px-4 py-2 text-sm font-medium rounded-xl transition
            {{ request('status') === 'selesai' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Sudah Divalidasi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Ibu</th>
                    <th class="px-6 py-4">Hasil Diagnosa</th>
                    <th class="px-6 py-4">Nilai Bayes</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($konsultasi as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 text-xs font-bold">{{ strtoupper(substr($item->user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->user->name }}</p>
                                    @if($item->user->usia_kehamilan)
                                        <p class="text-xs text-gray-400">{{ $item->user->usia_kehamilan }} minggu</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status === 'selesai' && $item->hipotesisPakar)
                                <p class="font-medium text-gray-800">{{ $item->hipotesisPakar->nama ?? '-' }}</p>
                                <p class="text-xs text-green-500">Hasil Pakar</p>
                            @else
                                <p class="font-medium text-gray-800">{{ $item->hipotesis->nama ?? '-' }}</p>
                                <p class="text-xs text-gray-400">Self Diagnostik</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status === 'selesai' && $item->nilai_bayes_pakar)
                                <p class="font-semibold text-gray-800">{{ $item->nilai_bayes_pakar }}%</p>
                                <p class="text-xs text-green-500">Validasi Pakar</p>
                            @elseif($item->nilai_bayes)
                                <p class="font-semibold text-gray-800">{{ $item->nilai_bayes }}%</p>
                                <p class="text-xs text-gray-400">Self Diagnostik</p>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $item->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ $item->status === 'pending' ? '⏳ Perlu Validasi' : '✅ Selesai' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ $item->created_at->translatedFormat('d F Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.konsultasi.show', $item->id) }}"
                                class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                {{ $item->status === 'pending' ? 'Validasi' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-medium">Belum ada konsultasi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($konsultasi->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $konsultasi->links() }}
            </div>
        @endif
    </div>
@endsection