<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Produk; // Jika produk ada dalam sistem

class MitraController extends Controller
{
    public function index()
    {
        $mitra = Mitra::all(); // Mengambil semua data mitra
        return view('admin.mitra.index', compact('mitra'));
    }

    public function create()
    {
        $produk = Produk::all(); // Jika produk ada dalam sistem
        return view('admin.mitra.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telpon' => 'required|numeric',
            'id_produk' => 'nullable|exists:produk,id_produk',
        ]);

        Mitra::create([
            'nama_mitra' => $request->nama_mitra,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'id_produk' => $request->id_produk,
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        $produk = Produk::all();
        return view('admin.mitra.edit', compact('mitra', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telpon' => 'required|numeric',
            'id_produk' => 'nullable|exists:produk,id_produk',
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'nama_mitra' => $request->nama_mitra,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'id_produk' => $request->id_produk,
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil dihapus!');
    }
}
