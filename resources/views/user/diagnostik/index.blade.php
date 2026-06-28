@extends('layouts.user')

@section('title', 'Self Diagnostik')

@section('content')

<div class="mb-8">
    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Self Diagnostik</p>
    <h1 class="text-2xl font-bold text-gray-900">Pilih Gejala yang Dirasakan</h1>
    <p class="text-sm text-gray-500 mt-1">Centang semua gejala yang benar-benar kamu alami saat ini.</p>
</div>

{{-- Notice --}}
<div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
    </svg>
    <p class="text-sm text-blue-700">Hasil diagnostik bersifat <strong>sementara</strong>. Temui pakar gizi untuk validasi lebih lanjut.</p>
</div>

<form action="{{ route('user.diagnostik.proses') }}" method="POST">
    @csrf

    @error('gejala')
    <div class="flex items-center gap-2 bg-red-50 border border-red-200 border-l-4 border-l-red-500 px-4 py-3 rounded-lg mb-6 text-sm text-red-700">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
        </svg>
        {{ $message }}
    </div>
    @enderror

    <div class="bg-white border border-gray-200 rounded-xl mb-6">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Daftar Gejala</h2>
            <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium" id="counter">0 dipilih</span>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($gejala as $g)
            <label class="flex items-start gap-4 px-6 py-4 cursor-pointer hover:bg-gray-50 transition has-[:checked]:bg-blue-50 group">
                <div class="relative flex-shrink-0 mt-0.5">
                    <input type="checkbox"
                        name="gejala[]"
                        value="{{ $g->id }}"
                        class="gejala-check peer w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ in_array($g->id, old('gejala', [])) ? 'checked' : '' }}>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800 group-hover:text-gray-900 peer-checked:text-blue-700">{{ $g->nama_gejala }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $g->kode }}</p>
                </div>
                <div class="flex-shrink-0 opacity-0 group-has-[:checked]:opacity-100 transition">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <button type="submit"
            class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
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
    function updateCounter() {
        const total = document.querySelectorAll('.gejala-check:checked').length;
        counter.textContent = total + ' dipilih';
        counter.className = total > 0
            ? 'text-xs text-blue-700 bg-blue-100 px-2.5 py-1 rounded-full font-medium'
            : 'text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium';
    }
    checks.forEach(c => c.addEventListener('change', updateCounter));
</script>

@endsection