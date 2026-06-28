@extends('layouts.admin')

@section('title', 'Manajemen Gejala')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Daftar semua gejala dalam basis pengetahuan sistem.</p>
    <a href="{{ route('admin.gejala.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Gejala
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    {{-- Table Header --}}
    <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-200">
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</div>
        <div class="col-span-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Gejala</div>
        <div class="col-span-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</div>
        <div class="col-span-2 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tampil ke User</div>
        <div class="col-span-1 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</div>
    </div>

    {{-- Rows --}}
    <div class="divide-y divide-gray-100">
        @forelse($gejala as $item)
        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 transition">
            <div class="col-span-1">
                <span class="text-xs font-mono font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded">{{ $item->kode }}</span>
            </div>
            <div class="col-span-4">
                <p class="text-sm font-medium text-gray-800">{{ $item->nama_gejala }}</p>
            </div>
            <div class="col-span-4">
                <p class="text-sm text-gray-500 truncate">{{ $item->keterangan ?? '—' }}</p>
            </div>
            <div class="col-span-2 flex justify-center">
                @if($item->tampil_ke_user)
                <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    Tampil
                </span>
                @else
                <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                    Pakar saja
                </span>
                @endif
            </div>
            <div class="col-span-1 flex items-center justify-end gap-2">
                <a href="{{ route('admin.gejala.edit', $item->id) }}"
                   class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                    Edit
                </a>
                <span class="text-gray-300">|</span>
                <form action="{{ route('admin.gejala.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus gejala ini?')">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-700">Belum ada data gejala</p>
            <p class="text-xs text-gray-400 mt-1">Klik "Tambah Gejala" untuk memulai.</p>
        </div>
        @endforelse
    </div>

    @if($gejala->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $gejala->links() }}
    </div>
    @endif
</div>

@endsection