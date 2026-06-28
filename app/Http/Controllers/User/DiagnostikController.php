<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\KonsultasiGejala;
use App\Services\BayesService;
use Illuminate\Http\Request;

class DiagnostikController extends Controller
{
    protected $bayesService;

    public function __construct(BayesService $bayesService)
    {
        $this->bayesService = $bayesService;
    }

    // Tampilkan form self diagnostik
    public function index()
    {
        $gejala = Gejala::where('tampil_ke_user', true)->get();
        return view('user.diagnostik.index', compact('gejala'));
    }

    // Proses self diagnostik
    public function proses(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id',
        ], [
            'gejala.required' => 'Pilih minimal 1 gejala yang kamu rasakan.',
            'gejala.min' => 'Pilih minimal 1 gejala yang kamu rasakan.',
        ]);

        $gejalaDipilih = $request->gejala;

        // Hitung Bayes
        $hasil = $this->bayesService->hitung($gejalaDipilih);

        if (empty($hasil)) {
            return back()->with('error', 'Gejala yang dipilih tidak cocok dengan basis pengetahuan.');
        }

        // Ambil hasil tertinggi
        $hasilTertinggi = $hasil[0];

        // Simpan konsultasi
        $konsultasi = Konsultasi::create([
            'user_id'     => auth()->id(),
            'tipe'        => 'self',
            'status'      => 'pending',
            'hipotesis_id' => $hasilTertinggi['hipotesis']->id,
            'nilai_bayes' => $hasilTertinggi['nilai_bayes'],
        ]);

        // Simpan gejala yang dipilih
        foreach ($gejalaDipilih as $gejalaId) {
            KonsultasiGejala::create([
                'konsultasi_id' => $konsultasi->id,
                'gejala_id'     => $gejalaId,
            ]);
        }

        return redirect()->route('user.diagnostik.hasil', $konsultasi->id);
    }

    // Tampilkan hasil
    public function hasil($id)
    {
        $konsultasi = Konsultasi::with(['hipotesis', 'gejala'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.diagnostik.hasil', compact('konsultasi'));
    }
}