<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'           => 'required|string|max:255',
            'no_hp'          => 'nullable|string|max:20',
            'usia_kehamilan' => 'nullable|integer|min:1|max:42',
            'password'       => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'usia_kehamilan.min'   => 'Usia kehamilan minimal 1 minggu.',
            'usia_kehamilan.max'   => 'Usia kehamilan maksimal 42 minggu.',
            'password.min'         => 'Password minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name'           => $request->name,
            'no_hp'          => $request->no_hp,
            'usia_kehamilan' => $request->usia_kehamilan,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.profil.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}