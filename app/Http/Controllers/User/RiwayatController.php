<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;

class RiwayatController extends Controller
{
    public function index()
    {
        $konsultasi = Konsultasi::with(['hipotesis', 'hipotesisPakar'])
            ->where('user_id', auth()->id())
            ->where('tipe', 'self')
            ->latest()
            ->paginate(10);

        return view('user.riwayat.index', compact('konsultasi'));
    }

    public function show(string $id)
    {
        $konsultasi = Konsultasi::with(['hipotesis', 'hipotesisPakar', 'gejala'])
            ->where('user_id', auth()->id())
            ->where('tipe', 'self')
            ->findOrFail($id);

        $validasiPakar = null;
        if ($konsultasi->status === 'selesai' && $konsultasi->hipotesisPakar) {
            $validasiPakar = $konsultasi;
        }

        return view('user.riwayat.show', compact('konsultasi', 'validasiPakar'));
    }
}