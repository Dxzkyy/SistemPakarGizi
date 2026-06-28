@extends('layouts.admin')

@section('title', 'Tambah Hipotesis')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.hipotesis.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Hipotesis
    </a>
</div>

<form action="{{ route('admin.hipotesis.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kolom Kiri: Info --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Informasi Hipotesis</h2>
            </div>
            <div class="p-6 space-y-5">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            Kode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                            placeholder="K01"
                            class="w-full px-3.5 py-2.5 border rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                            {{ $errors->has('kode') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                        @error('kode')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            Nama Hipotesis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Gizi Kurang"
                            class="w-full px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                            {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                        @error('nama')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        placeholder="Penjelasan singkat mengenai hipotesis ini..."
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Rekomendasi Gizi</label>
                    <textarea name="rekomendasi" rows="5"
                        placeholder="Rekomendasi kebutuhan gizi untuk kondisi ini..."
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition">{{ old('rekomendasi') }}</textarea>
                </div>

            </div>
        </div>

        {{-- Kolom Kanan: Gejala --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Gejala & Nilai Pakar</h2>
                <p class="text-xs text-gray-400 mt-0.5">Centang gejala yang berkaitan dan isi nilai pakar (0.1–1.0)</p>
            </div>
            <div class="p-4 overflow-y-auto max-h-[520px]">
                <div class="space-y-1.5">
                    @foreach($semuaGejala as $gejala)
                    <div class="flex items-center gap-3 px-3 py-3 border border-gray-100 rounded-lg hover:border-gray-200 transition" id="row-{{ $gejala->id }}">
                        <input type="checkbox" name="gejala_ids[]" value="{{ $gejala->id }}"
                            id="gejala-{{ $gejala->id }}"
                            onchange="toggleNilai({{ $gejala->id }})"
                            class="w-4 h-4 text-blue-600 rounded border-gray-300 flex-shrink-0">
                        <label for="gejala-{{ $gejala->id }}" class="flex-1 cursor-pointer min-w-0">
                            <span class="text-xs font-mono font-semibold text-blue-600">{{ $gejala->kode }}</span>
                            <p class="text-sm text-gray-700 truncate">{{ $gejala->nama_gejala }}</p>
                        </label>
                        <input type="number" name="nilai_{{ $gejala->id }}"
                            step="0.1" min="0.1" max="1.0"
                            placeholder="0.0"
                            disabled
                            id="nilai-{{ $gejala->id }}"
                            class="w-16 px-2 py-1.5 border border-gray-200 rounded-md text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50 disabled:text-gray-300 flex-shrink-0 transition">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mt-5">
        <button type="submit"
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
            Simpan Hipotesis
        </button>
        <a href="{{ route('admin.hipotesis.index') }}"
            class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
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
        row.classList.add('border-blue-200', 'bg-blue-50');
        row.classList.remove('border-gray-100');
    } else {
        input.disabled = true;
        input.value = '';
        row.classList.remove('border-blue-200', 'bg-blue-50');
        row.classList.add('border-gray-100');
    }
}
</script>

@endsection