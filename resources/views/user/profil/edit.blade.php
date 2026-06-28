@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')

<div class="mb-8">
    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-1">Akun</p>
    <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan data kehamilan kamu.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    {{-- Sidebar Info --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
            <div class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-white text-2xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <p class="font-semibold text-gray-900 text-sm">{{ $user->name }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $user->email }}</p>

            @if($user->usia_kehamilan)
            <div class="mt-4 pt-4 border-t border-gray-100">
                @php $trimester = $user->usia_kehamilan <= 12 ? 1 : ($user->usia_kehamilan <= 27 ? 2 : 3); @endphp
                <p class="text-xs text-gray-500 mb-1">Usia Kehamilan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $user->usia_kehamilan }}<span class="text-sm font-normal text-gray-400 ml-1">minggu</span></p>
                <p class="text-xs text-blue-600 font-medium mt-1">Trimester {{ $trimester }}</p>
            </div>
            @endif

            @if($user->no_hp)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">{{ $user->no_hp }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Form --}}
    <div class="lg:col-span-3 space-y-5">

        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Data Diri</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('user.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Nama lengkap"
                                class="w-full px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }}">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">Nomor HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">
                            Usia Kehamilan (Minggu)
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="usia_kehamilan" value="{{ old('usia_kehamilan', $user->usia_kehamilan) }}"
                                min="1" max="42" placeholder="Contoh: 12"
                                class="w-36 px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                {{ $errors->has('usia_kehamilan') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                            <p class="text-xs text-gray-400">Minggu ke-1 sampai ke-42</p>
                        </div>
                        @error('usia_kehamilan')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-100 pt-6 mb-6">
                        <h3 class="text-xs font-semibold text-gray-700 uppercase tracking-wider mb-4">
                            Ganti Password
                            <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(kosongkan jika tidak ingin ubah)</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">Password Baru</label>
                                <input type="password" name="password"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full px-3.5 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                    {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                                @error('password')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('user.dashboard') }}"
                           class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Email Info --}}
        <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-xl">
            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <p class="text-xs text-gray-500">Email <span class="font-semibold text-gray-700">{{ $user->email }}</span> tidak dapat diubah.</p>
        </div>
    </div>
</div>

@endsection