<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Gejala;
use App\Models\Hipotesis;
use App\Models\KonsultasiGejala;
use App\Services\BayesService;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    protected $bayesService;

    public function __construct(BayesService $bayesService)
    {
        $this->bayesService = $bayesService;
    }

    public function index(Request $request)
    {
        $query = Konsultasi::with(['user', 'hipotesis'])
            ->where('tipe', 'self') // hanya self diagnostik
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $konsultasi = $query->paginate(10)->appends($request->query());

        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    public function show(string $id)
    {
        $konsultasi = Konsultasi::with(['user', 'hipotesis', 'hipotesisPakar', 'gejala'])
            ->findOrFail($id);

        $semuaGejala = Gejala::orderBy('kode')->get();
        $semuaHipotesis = Hipotesis::all();

        return view('admin.konsultasi.show', compact(
            'konsultasi',
            'semuaGejala',
            'semuaHipotesis'
        ));
    }

    public function validasi(Request $request, string $id)
    {
        $request->validate([
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id',
            'catatan_pakar' => 'nullable|string',
        ], [
            'gejala.required' => 'Pilih minimal 1 gejala untuk validasi.',
        ]);

        $konsultasiSelf = Konsultasi::findOrFail($id);

        // Hitung Bayes berdasarkan gejala pilihan pakar
        $gejalaDipilih = $request->gejala;
        $hasil = $this->bayesService->hitung($gejalaDipilih);

        if (empty($hasil)) {
            return back()->with('error', 'Gejala yang dipilih tidak cocok dengan basis pengetahuan.');
        }

        $hasilTertinggi = $hasil[0];

        // UPDATE konsultasi self yang sudah ada (tidak buat baru)
        $konsultasiSelf->update([
            'status' => 'selesai',
            'hipotesis_pakar_id' => $hasilTertinggi['hipotesis']->id,
            'nilai_bayes_pakar' => $hasilTertinggi['nilai_bayes'],
            'catatan_pakar' => $request->catatan_pakar,
        ]);

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Validasi konsultasi berhasil disimpan.');
    }
}