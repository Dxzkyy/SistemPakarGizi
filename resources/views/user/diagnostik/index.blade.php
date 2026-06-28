@extends('layouts.user')

@section('title', 'Self Diagnostik')

@section('content')
<div class="mb-6 mt-4">
    <h2 class="text-2xl font-bold text-gray-800">Self Diagnostik 🩺</h2>
    <p class="text-gray-500 mt-1">Pilih gejala yang kamu rasakan saat ini</p>
</div>

{{-- Info Box --}}
<div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6">
    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
    </svg>
    <div>
        <p class="text-sm font-medium text-blue-800">Perhatian</p>
        <p class="text-xs text-blue-600 mt-0.5">Hasil self diagnostik ini bersifat <strong>sementara</strong>. Segera temui pakar/ahli gizi untuk validasi lebih lanjut. Pilih semua gejala yang benar-benar kamu rasakan.</p>
    </div>
</div>

<form action="{{ route('user.diagnostik.proses') }}" method="POST">
    @csrf

    @error('gejala')
        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </div>
    @enderror

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Daftar Gejala</h3>
            <span class="text-xs text-gray-400" id="counter">0 gejala dipilih</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($gejala as $g)
            <label class="flex items-start gap-3 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                <input type="checkbox"
                    name="gejala[]"
                    value="{{ $g->id }}"
                    class="gejala-check mt-0.5 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    {{ in_array($g->id, old('gejala', [])) ? 'checked' : '' }}>
                <div>
                    <p class="text-sm font-medium text-gray-700">{{ $g->nama_gejala }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $g->kode }}</p>
                </div>
            </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('user.dashboard') }}"
           class="px-5 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
            ← Kembali
        </a>
        <button type="submit"
            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Proses Diagnostik
        </button>
    </div>
</form>

<script>
    const checks = document.querySelectorAll('.gejala-check');
    const counter = document.getElementById('counter');
    checks.forEach(c => c.addEventListener('change', () => {
        const total = document.querySelectorAll('.gejala-check:checked').length;
        counter.textContent = total + ' gejala dipilih';
    }));
</script>
@endsection