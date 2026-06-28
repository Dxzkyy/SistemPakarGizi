<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hipotesis;
use App\Models\Gejala;
use App\Models\GejalahHipotesis;
use Illuminate\Http\Request;

class HipotesisController extends Controller
{
    public function index()
    {
        $hipotesis = Hipotesis::withCount('gejala')->latest()->paginate(10);
        return view('admin.hipotesis.index', compact('hipotesis'));
    }

    public function create()
    {
        $semuaGejala = Gejala::orderBy('kode')->get();
        return view('admin.hipotesis.create', compact('semuaGejala'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'        => 'required|string|unique:hipotesis,kode|max:20',
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'rekomendasi' => 'nullable|string',
            'gejala'      => 'nullable|array',
            'gejala.*.id' => 'exists:gejala,id',
            'gejala.*.nilai_pakar' => 'required_with:gejala.*.id|numeric|min:0|max:1',
        ], [
            'kode.required' => 'Kode hipotesis wajib diisi.',
            'kode.unique'   => 'Kode hipotesis sudah digunakan.',
            'nama.required' => 'Nama hipotesis wajib diisi.',
        ]);

        $hipotesis = Hipotesis::create([
            'kode'        => strtoupper($request->kode),
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // Simpan relasi gejala-hipotesis
        if ($request->has('gejala_ids')) {
            foreach ($request->gejala_ids as $gejalaId) {
                $nilaiKey = 'nilai_' . $gejalaId;
                $nilai = $request->$nilaiKey;
                if ($nilai !== null && $nilai !== '') {
                    GejalahHipotesis::create([
                        'gejala_id'    => $gejalaId,
                        'hipotesis_id' => $hipotesis->id,
                        'nilai_pakar'  => $nilai,
                    ]);
                }
            }
        }

        return redirect()->route('admin.hipotesis.index')
            ->with('success', 'Hipotesis berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $hipotesis = Hipotesis::with(['gejala'])->findOrFail($id);
        return view('admin.hipotesis.show', compact('hipotesis'));
    }

    public function edit(string $id)
    {
        $hipotesis   = Hipotesis::with(['gejala'])->findOrFail($id);
        $semuaGejala = Gejala::orderBy('kode')->get();

        // Buat map gejala_id => nilai_pakar untuk kemudahan view
        $nilaiPakar = $hipotesis->gejala->pluck('pivot.nilai_pakar', 'id');

        return view('admin.hipotesis.edit', compact('hipotesis', 'semuaGejala', 'nilaiPakar'));
    }

    public function update(Request $request, string $id)
    {
        $hipotesis = Hipotesis::findOrFail($id);

        $request->validate([
            'kode'        => 'required|string|unique:hipotesis,kode,' . $id . '|max:20',
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ], [
            'kode.required' => 'Kode hipotesis wajib diisi.',
            'kode.unique'   => 'Kode hipotesis sudah digunakan.',
            'nama.required' => 'Nama hipotesis wajib diisi.',
        ]);

        $hipotesis->update([
            'kode'        => strtoupper($request->kode),
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // Hapus relasi lama lalu simpan yang baru
        GejalahHipotesis::where('hipotesis_id', $hipotesis->id)->delete();

        if ($request->has('gejala_ids')) {
            foreach ($request->gejala_ids as $gejalaId) {
                $nilaiKey = 'nilai_' . $gejalaId;
                $nilai = $request->$nilaiKey;
                if ($nilai !== null && $nilai !== '') {
                    GejalahHipotesis::create([
                        'gejala_id'    => $gejalaId,
                        'hipotesis_id' => $hipotesis->id,
                        'nilai_pakar'  => $nilai,
                    ]);
                }
            }
        }

        return redirect()->route('admin.hipotesis.index')
            ->with('success', 'Hipotesis berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $hipotesis = Hipotesis::findOrFail($id);
        $hipotesis->delete();

        return redirect()->route('admin.hipotesis.index')
            ->with('success', 'Hipotesis berhasil dihapus.');
    }
}