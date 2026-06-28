@extends('layouts.admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.konsultasi.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Konsultasi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kolom Kiri: Info Ibu Hamil + Hasil Self Diagnostik --}}
        <div class="space-y-5">

            {{-- Info Pasien --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Data Ibu Hamil</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <span
                            class="text-blue-600 text-xl font-bold">{{ strtoupper(substr($konsultasi->user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $konsultasi->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $konsultasi->user->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-1">No. HP</p>
                        <p class="text-sm font-medium text-gray-700">{{ $konsultasi->user->no_hp ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-1">Usia Kehamilan</p>
                        <p class="text-sm font-medium text-gray-700">
                            {{ $konsultasi->user->usia_kehamilan ? $konsultasi->user->usia_kehamilan . ' Minggu' : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Hasil Self Diagnostik --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-800">Hasil Self Diagnostik</h3>
                    <span
                        class="text-xs font-medium px-2.5 py-1 rounded-full
                    {{ $konsultasi->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                        {{ $konsultasi->status === 'pending' ? 'Menunggu Validasi' : 'Sudah Divalidasi' }}
                    </span>
                </div>

                {{-- Hasil diagnosa self --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <p class="text-xs text-blue-500 font-semibold uppercase tracking-wider mb-1">Diagnosa Awal</p>
                    <p class="text-lg font-bold text-blue-800">{{ $konsultasi->hipotesis->nama ?? '-' }}</p>
                    @if ($konsultasi->nilai_bayes)
                        <p class="text-sm text-blue-600 mt-1">Nilai Bayes: <span
                                class="font-bold">{{ $konsultasi->nilai_bayes }}%</span></p>
                    @endif
                    <p class="text-xs text-blue-400 mt-2">{{ $konsultasi->created_at->format('d M Y, H:i') }}</p>
                </div>

                {{-- Gejala yang dipilih user --}}
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Gejala yang Dirasakan</p>
                <div class="space-y-2">
                    @forelse($konsultasi->gejala as $gejala)
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $gejala->nama_gejala }}</span>
                            <span class="text-xs text-gray-400">({{ $gejala->kode }})</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Tidak ada gejala tercatat</p>
                    @endforelse
                </div>
            </div>

            {{-- Hasil Validasi Pakar (jika sudah) --}}
            @if ($konsultasi->status === 'selesai' && $konsultasi->hipotesisPakar)
                <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Hasil Validasi Pakar</h3>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                        <p class="text-xs text-green-500 font-semibold uppercase tracking-wider mb-1">Diagnosa Pakar</p>
                        <p class="text-lg font-bold text-green-800">{{ $konsultasi->hipotesisPakar->nama ?? '-' }}</p>
                        @if ($konsultasi->nilai_bayes_pakar)
                            <p class="text-sm text-green-600 mt-1">Nilai Bayes: <span
                                    class="font-bold">{{ $konsultasi->nilai_bayes_pakar }}%</span></p>
                        @endif
                    </div>
                    @if ($konsultasi->catatan_pakar)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan Pakar</p>
                            <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3">{{ $konsultasi->catatan_pakar }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Kolom Kanan: Form Validasi Pakar --}}
        @if ($konsultasi->tipe === 'self' && $konsultasi->status === 'pending')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-1">Validasi oleh Pakar</h3>
                <p class="text-xs text-gray-400 mb-5">Pilih gejala berdasarkan pemeriksaan langsung, kemudian simpan
                    validasi</p>

                <form action="{{ route('admin.konsultasi.validasi', $konsultasi->id) }}" method="POST">
                    @csrf

                    {{-- Pilih Gejala --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Gejala (Pemeriksaan Pakar)</label>
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-1">
                            @foreach ($semuaGejala as $gejala)
                                @php
                                    $sudahDipilihUser = $konsultasi->gejala->contains('id', $gejala->id);
                                @endphp
                                <label
                                    class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition
                        hover:border-blue-300 hover:bg-blue-50
                        {{ $sudahDipilihUser ? 'border-blue-200 bg-blue-50' : 'border-gray-200' }}">
                                    <input type="checkbox" name="gejala[]" value="{{ $gejala->id }}"
                                        {{ $sudahDipilihUser ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-blue-600">{{ $gejala->kode }}</span>
                                            @if (!$gejala->tampil_ke_user)
                                                <span
                                                    class="text-xs bg-purple-100 text-purple-600 px-1.5 py-0.5 rounded">Pakar</span>
                                            @endif
                                            @if ($sudahDipilihUser)
                                                <span
                                                    class="text-xs bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded">User</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $gejala->nama_gejala }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('gejala')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan Pakar --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan Pakar</label>
                        <textarea name="catatan_pakar" rows="3" placeholder="Tambahkan catatan atau saran khusus untuk ibu hamil ini..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan_pakar') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-3 rounded-xl transition">
                        Simpan Validasi
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-6 flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium">Konsultasi ini sudah selesai</p>
                    <p class="text-sm mt-1">Validasi pakar telah dilakukan</p>
                </div>
            </div>
        @endif
    </div>
@endsection
