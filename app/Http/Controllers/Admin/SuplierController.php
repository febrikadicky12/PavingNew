<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $supliers = Suplier::all();
        return view('admin.suplier.index', compact('supliers'));
    }

    public function create()
    {
        return view('admin.suplier.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|integer|max:15',
        ]);

        // Simpan data ke database
        Suplier::create([
            'nama_suplier' => $request->nama_suplier,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        // Redirect ke halaman daftar supplier dengan pesan sukses
        return redirect()->route('admin.suplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function edit(Suplier $suplier)
    {
        return view('admin.suplier.edit', compact('suplier'));
    }

    public function update(Request $request, Suplier $suplier)
    {
        $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);

        $suplier->update([
            'nama_suplier' => $request->nama_suplier,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('admin.suplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(Suplier $suplier)
    {
        $suplier->delete();
        return redirect()->route('admin.suplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
