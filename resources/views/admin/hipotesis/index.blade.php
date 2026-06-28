@extends('layouts.admin')

@section('title', 'Manajemen Hipotesis')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar kondisi gizi yang menjadi hipotesis sistem</h2>
    <a href="{{ route('admin.hipotesis.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Hipotesis
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4">Kode</th>
                <th class="px-6 py-4">Nama Hipotesis</th>
                <th class="px-6 py-4">Jumlah Gejala</th>
                <th class="px-6 py-4">Rekomendasi</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($hipotesis as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2.5 py-1 rounded-lg">{{ $item->kode }}</span>
                </td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $item->nama }}</p>
                    @if($item->deskripsi)
                        <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $item->deskripsi }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="text-gray-700 font-semibold">{{ $item->gejala_count }}</span>
                    <span class="text-gray-400 text-xs"> gejala</span>
                </td>
                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $item->rekomendasi ? Str::limit($item->rekomendasi, 60) : '-' }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.hipotesis.show', $item->id) }}"
                           class="text-gray-600 hover:text-gray-800 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            Detail
                        </a>
                        <a href="{{ route('admin.hipotesis.edit', $item->id) }}"
                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.hipotesis.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus hipotesis ini? Semua relasi gejala akan ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <p class="font-medium">Belum ada data hipotesis</p>
                    <p class="text-sm mt-1">Klik tombol "Tambah Hipotesis" untuk memulai</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($hipotesis->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $hipotesis->links() }}
    </div>
    @endif
</div>
@endsection