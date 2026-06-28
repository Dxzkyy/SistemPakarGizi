@extends('layouts.admin')

@section('title', 'Edit Gejala')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.gejala.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Gejala
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.gejala.update', $gejala->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kode --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Kode Gejala <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kode" value="{{ old('kode', $gejala->kode) }}"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    {{ $errors->has('kode') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('kode')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Gejala --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Gejala <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_gejala" value="{{ old('nama_gejala', $gejala->nama_gejala) }}"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    {{ $errors->has('nama_gejala') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('nama_gejala')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('keterangan', $gejala->keterangan) }}</textarea>
            </div>

            {{-- Tampil ke User --}}
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="hidden" name="tampil_ke_user" value="0">
                        <input type="checkbox" name="tampil_ke_user" value="1" id="tampil_ke_user"
                            {{ old('tampil_ke_user', $gejala->tampil_ke_user) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tampilkan ke Ibu Hamil</p>
                        <p class="text-xs text-gray-400">Aktifkan jika gejala ini bisa dirasakan sendiri oleh ibu hamil</p>
                    </div>
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2.5 rounded-xl transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.gejala.index') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm font-medium px-6 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection