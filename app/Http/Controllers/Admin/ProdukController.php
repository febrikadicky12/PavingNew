<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk.
     */
    public function index()
    {
        $produk = Produk::all();
        return view('admin.produk.index', compact('produk'));
    }

    /**
     * Tampilkan form tambah produk.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'jenis_produk'  => 'required|string|max:255',
            'harga_produk'  => 'required|numeric',
            'ukuran_produk' => 'required|string|max:50',
            'tipe_harga'    => 'required|string|in:reguler,diskon',
            'stok_produk'   => 'required|integer|min:0',
        ]);

        Produk::create($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail produk.
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update produk di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'jenis_produk'  => 'required|string|max:255',
            'harga_produk'  => 'required|numeric',
            'ukuran_produk' => 'required|string|max:50',
            'tipe_harga'    => 'required|string|in:reguler,diskon',
            'stok_produk'   => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
