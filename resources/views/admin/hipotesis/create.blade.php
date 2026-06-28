@extends('layouts.admin')

@section('title', 'Tambah Hipotesis')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.hipotesis.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Hipotesis
    </a>
</div>

<form action="{{ route('admin.hipotesis.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kolom Kiri: Info Hipotesis --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-5">Informasi Hipotesis</h3>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Kode <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kode" value="{{ old('kode') }}"
                    placeholder="Contoh: K01"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    {{ $errors->has('kode') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('kode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Hipotesis <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    placeholder="Contoh: Gizi Kurang"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    placeholder="Penjelasan singkat mengenai hipotesis ini..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Rekomendasi Gizi</label>
                <textarea name="rekomendasi" rows="4"
                    placeholder="Rekomendasi kebutuhan gizi untuk kondisi ini..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('rekomendasi') }}</textarea>
            </div>
        </div>

        {{-- Kolom Kanan: Relasi Gejala --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-1">Gejala & Nilai Pakar</h3>
            <p class="text-xs text-gray-400 mb-5">Centang gejala yang berkaitan dan isi nilai pakar (0.1 - 1.0)</p>

            <div class="space-y-3 max-h-[480px] overflow-y-auto pr-1">
                @foreach($semuaGejala as $gejala)
                <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:border-blue-300 transition" id="row-{{ $gejala->id }}">
                    <input type="checkbox" name="gejala_ids[]" value="{{ $gejala->id }}"
                        id="gejala-{{ $gejala->id }}"
                        onchange="toggleNilai({{ $gejala->id }})"
                        class="w-4 h-4 text-blue-600 rounded">
                    <label for="gejala-{{ $gejala->id }}" class="flex-1 cursor-pointer">
                        <span class="text-xs font-bold text-blue-600">{{ $gejala->kode }}</span>
                        <p class="text-sm text-gray-700">{{ $gejala->nama_gejala }}</p>
                    </label>
                    <input type="number" name="nilai_{{ $gejala->id }}"
                        step="0.1" min="0.1" max="1.0"
                        placeholder="0.0"
                        disabled
                        id="nilai-{{ $gejala->id }}"
                        class="w-20 px-2 py-1.5 border border-gray-200 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50 disabled:text-gray-300">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mt-6">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2.5 rounded-xl transition">
            Simpan Hipotesis
        </button>
        <a href="{{ route('admin.hipotesis.index') }}"
            class="text-gray-500 hover:text-gray-700 text-sm font-medium px-6 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-50 transition">
            Batal
        </a>
    </div>
</form>

<script>
function toggleNilai(id) {
    const checkbox = document.getElementById('gejala-' + id);
    const input = document.getElementById('nilai-' + id);
    const row = document.getElementById('row-' + id);
    if (checkbox.checked) {
        input.disabled = false;
        input.focus();
        row.classList.add('border-blue-400', 'bg-blue-50');
    } else {
        input.disabled = true;
        input.value = '';
        row.classList.remove('border-blue-400', 'bg-blue-50');
    }
}
</script>
@endsection