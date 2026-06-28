@extends('layouts.admin')

@section('title', 'Manajemen Gejala')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Daftar semua gejala dalam basis pengetahuan</h2>
    </div>
    <a href="{{ route('admin.gejala.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Gejala
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4">Kode</th>
                <th class="px-6 py-4">Nama Gejala</th>
                <th class="px-6 py-4">Keterangan</th>
                <th class="px-6 py-4 text-center">Tampil ke User</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($gejala as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-lg">{{ $item->kode }}</span>
                </td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_gejala }}</td>
                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    @if($item->tampil_ke_user)
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            Ya
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">
                            Pakar saja
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.gejala.edit', $item->id) }}"
                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.gejala.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus gejala ini?')">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="font-medium">Belum ada data gejala</p>
                    <p class="text-sm mt-1">Klik tombol "Tambah Gejala" untuk memulai</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($gejala->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $gejala->links() }}
    </div>
    @endif
</div>
@endsection