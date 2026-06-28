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
        $query = Konsultasi::with(['user', 'hipotesis'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $konsultasi = $query->paginate(10)->appends($request->query());

        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    public function show(string $id)
    {
        $konsultasi = Konsultasi::with(['user', 'hipotesis', 'gejala'])
            ->findOrFail($id);

        // Jika tipe self, cek apakah ada konsultasi pakar yang terhubung user ini
        $konsultasiPakar = null;
        if ($konsultasi->tipe === 'self') {
            $konsultasiPakar = Konsultasi::where('user_id', $konsultasi->user_id)
                ->where('tipe', 'pakar')
                ->latest()
                ->first();
        }

        $semuaGejala = Gejala::orderBy('kode')->get();
        $semuaHipotesis = Hipotesis::all();

        return view('admin.konsultasi.show', compact(
            'konsultasi',
            'konsultasiPakar',
            'semuaGejala',
            'semuaHipotesis'
        ));
    }

    public function validasi(Request $request, string $id)
    {
        $request->validate([
            'gejala'        => 'required|array|min:1',
            'gejala.*'      => 'exists:gejala,id',
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

        // Buat konsultasi baru tipe pakar
        $konsultasiPakar = Konsultasi::create([
            'user_id'       => $konsultasiSelf->user_id,
            'tipe'          => 'pakar',
            'status'        => 'selesai',
            'hipotesis_id'  => $hasilTertinggi['hipotesis']->id,
            'nilai_bayes'   => $hasilTertinggi['nilai_bayes'],
            'catatan_pakar' => $request->catatan_pakar,
        ]);

        // Simpan gejala pilihan pakar
        foreach ($gejalaDipilih as $gejalaId) {
            KonsultasiGejala::create([
                'konsultasi_id' => $konsultasiPakar->id,
                'gejala_id'     => $gejalaId,
            ]);
        }

        // Update status self diagnostik menjadi selesai
        $konsultasiSelf->update(['status' => 'selesai']);

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Validasi konsultasi berhasil disimpan.');
    }
}