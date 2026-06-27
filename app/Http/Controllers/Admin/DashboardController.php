<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Konsultasi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGejala = Gejala::count();
        $totalKonsultasi = Konsultasi::count();
        $menungguValidasi = Konsultasi::where('tipe', 'self')
                            ->where('status', 'pending')
                            ->count();
        $konsultasiTerbaru = Konsultasi::with(['user', 'hipotesis'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalGejala',
            'totalKonsultasi',
            'menungguValidasi',
            'konsultasiTerbaru'
        ));
    }
}