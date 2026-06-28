@extends('layouts.admin')

@section('title', 'Tambah Gejala')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.gejala.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Gejala
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Informasi Gejala</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.gejala.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            Kode Gejala <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                            placeholder="GJL01"
                            class="w-full px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono
                            {{ $errors->has('kode') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                        @error('kode')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            Nama Gejala <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_gejala" value="{{ old('nama_gejala') }}"
                            placeholder="Mual dan Muntah Berlebihan"
                            class="w-full px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                            {{ $errors->has('nama_gejala') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                        @error('nama_gejala')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        placeholder="Deskripsi tambahan mengenai gejala ini..."
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition">{{ old('keterangan') }}</textarea>
                </div>

                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative flex-shrink-0">
                            <input type="hidden" name="tampil_ke_user" value="0">
                            <input type="checkbox" name="tampil_ke_user" value="1" id="tampil_ke_user"
                                {{ old('tampil_ke_user') ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Tampilkan ke Ibu Hamil</p>
                            <p class="text-xs text-gray-400 mt-0.5">Aktifkan jika gejala ini bisa dirasakan sendiri oleh ibu hamil</p>
                        </div>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                        Simpan Gejala
                    </button>
                    <a href="{{ route('admin.gejala.index') }}"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection