@extends('layouts.admin')

@section('title', 'Manajemen Hipotesis')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Daftar kondisi gizi yang menjadi hipotesis sistem.</p>
    <a href="{{ route('admin.hipotesis.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Hipotesis
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    {{-- Table Header --}}
    <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-200">
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</div>
        <div class="col-span-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Hipotesis</div>
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Gejala</div>
        <div class="col-span-5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rekomendasi</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</div>
    </div>

    {{-- Rows --}}
    <div class="divide-y divide-gray-100">
        @forelse($hipotesis as $item)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 transition">
            <div class="col-span-1">
                <span class="text-xs font-mono font-semibold text-gray-700 bg-gray-100 border border-gray-200 px-2 py-1 rounded">{{ $item->kode }}</span>
            </div>
            <div class="col-span-3">
                <p class="text-sm font-medium text-gray-800">{{ $item->nama }}</p>
                @if($item->deskripsi)
                <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $item->deskripsi }}</p>
                @endif
            </div>
            <div class="col-span-1 text-center">
                <span class="text-sm font-bold text-gray-900">{{ $item->gejala_count }}</span>
                <p class="text-xs text-gray-400">gejala</p>
            </div>
            <div class="col-span-5">
                <p class="text-sm text-gray-500 truncate">{{ $item->rekomendasi ? Str::limit($item->rekomendasi, 70) : '—' }}</p>
            </div>
            <div class="col-span-2 flex items-center justify-end gap-3">
                <a href="{{ route('admin.hipotesis.show', $item->id) }}"
                   class="text-xs font-medium text-gray-600 hover:text-gray-900 transition">
                    Detail
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('admin.hipotesis.edit', $item->id) }}"
                   class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                    Edit
                </a>
                <span class="text-gray-300">|</span>
                <form action="{{ route('admin.hipotesis.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus hipotesis ini? Semua relasi gejala akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-14 text-center">
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-700">Belum ada data hipotesis</p>
            <p class="text-xs text-gray-400 mt-1">Klik "Tambah Hipotesis" untuk memulai.</p>
        </div>
        @endforelse
    </div>

    @if($hipotesis->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $hipotesis->links() }}
    </div>
    @endif
</div>

@endsection