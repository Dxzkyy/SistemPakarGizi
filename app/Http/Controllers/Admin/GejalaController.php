<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index()
    {
        $gejala = Gejala::latest()->paginate(10);
        return view('admin.gejala.index', compact('gejala'));
    }

    public function create()
    {
        return view('admin.gejala.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'          => 'required|string|unique:gejala,kode|max:20',
            'nama_gejala'   => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
            'tampil_ke_user'=> 'boolean',
        ], [
            'kode.required'        => 'Kode gejala wajib diisi.',
            'kode.unique'          => 'Kode gejala sudah digunakan.',
            'nama_gejala.required' => 'Nama gejala wajib diisi.',
        ]);

        Gejala::create([
            'kode'           => strtoupper($request->kode),
            'nama_gejala'    => $request->nama_gejala,
            'keterangan'     => $request->keterangan,
            'tampil_ke_user' => $request->boolean('tampil_ke_user'),
        ]);

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $gejala = Gejala::findOrFail($id);
        return view('admin.gejala.show', compact('gejala'));
    }

    public function edit(string $id)
    {
        $gejala = Gejala::findOrFail($id);
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, string $id)
    {
        $gejala = Gejala::findOrFail($id);

        $request->validate([
            'kode'          => 'required|string|unique:gejala,kode,' . $id . '|max:20',
            'nama_gejala'   => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
            'tampil_ke_user'=> 'boolean',
        ], [
            'kode.required'        => 'Kode gejala wajib diisi.',
            'kode.unique'          => 'Kode gejala sudah digunakan.',
            'nama_gejala.required' => 'Nama gejala wajib diisi.',
        ]);

        $gejala->update([
            'kode'           => strtoupper($request->kode),
            'nama_gejala'    => $request->nama_gejala,
            'keterangan'     => $request->keterangan,
            'tampil_ke_user' => $request->boolean('tampil_ke_user'),
        ]);

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}