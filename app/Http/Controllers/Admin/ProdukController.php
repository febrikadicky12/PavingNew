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
            'harga_produk'  => 'required|numeric|min:500',
            'ukuran_produk' => 'required|string|max:50',
            'tipe_harga'    => 'required|string|in:reguler,diskon',
            'stok_produk'   => 'required|integer|min:0',
        ]);

        Produk::create($request->only([
            'nama_produk', 'jenis_produk', 'harga_produk', 'ukuran_produk', 'tipe_harga', 'stok_produk'
        ]));

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'jenis_produk'  => 'required|string|max:255',
            'harga_produk'  => 'required|numeric|min:500',
            'ukuran_produk' => 'required|string|max:50',
            'tipe_harga'    => 'required|string|in:reguler,diskon',
            'stok_produk'   => 'required|integer|min:0',
        ]);

        $produk->update($request->only([
            'nama_produk', 'jenis_produk', 'harga_produk', 'ukuran_produk', 'tipe_harga', 'stok_produk'
        ]));

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
