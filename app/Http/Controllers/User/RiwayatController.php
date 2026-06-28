<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;

class RiwayatController extends Controller
{
    public function index()
    {
        $konsultasi = Konsultasi::with('hipotesis')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.riwayat.index', compact('konsultasi'));
    }

    public function show(string $id)
    {
        $konsultasi = Konsultasi::with(['hipotesis', 'gejala'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Cek apakah ada hasil validasi pakar untuk user ini (yang terkait)
        $validasiPakar = null;
        if ($konsultasi->tipe === 'self') {
            $validasiPakar = Konsultasi::with(['hipotesis', 'gejala'])
                ->where('user_id', auth()->id())
                ->where('tipe', 'pakar')
                ->where('created_at', '>=', $konsultasi->created_at)
                ->latest()
                ->first();
        }

        return view('user.riwayat.show', compact('konsultasi', 'validasiPakar'));
    }
}