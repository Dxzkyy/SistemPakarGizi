<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalSelf = Konsultasi::where('user_id', $user->id)
                    ->where('tipe', 'self')->count();

        $sudahValidasi = Konsultasi::where('user_id', $user->id)
                        ->where('status', 'selesai')->count();

        $menungguValidasi = Konsultasi::where('user_id', $user->id)
                           ->where('status', 'pending')->count();

        $konsultasiTerakhir = Konsultasi::with('hipotesis')
                             ->where('user_id', $user->id)
                             ->where('tipe', 'self')
                             ->latest()
                             ->first();

        return view('user.dashboard', compact(
            'totalSelf',
            'sudahValidasi',
            'menungguValidasi',
            'konsultasiTerakhir'
        ));
    }
}