<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Karyawan;
use App\Models\Mesin;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])->get();
        return view('admin.produksi.index', compact('produksi'));
    }

    public function create()
    {
        $produk = Produk::all();
        $bahan = Bahan::all();
        $karyawan = Karyawan::all();
        $mesin = Mesin::all();

        return view('admin.produksi.create', compact('produk', 'bahan', 'karyawan', 'mesin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk'        => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi'  => 'required|integer|min:1',
            'status_produksi'  => 'required|in:sudah,proses',
            'id_bahan'         => 'required|exists:bahan,id_bahan',
            'id_karyawan'      => 'required|exists:karyawan,id_karyawan',
            'id_mesin'         => 'required|exists:mesin,id',
            'id_totalproduksi' => 'required|integer',
        ]);

        $bahan = Bahan::findOrFail($request->id_bahan);
        $produk = Produk::findOrFail($request->id_produk);

        if ($bahan->stock_bahan < $request->jumlah_produksi) {
            return back()->withErrors(['id_bahan' => 'Stok bahan tidak mencukupi!']);
        }

        $bahan->decrement('stock_bahan', $request->jumlah_produksi);
        $produk->increment('stok_produk', $request->jumlah_produksi);

        Produksi::create($request->all());

        return redirect()->route('admin.produksi.index')->with('success', 'Produksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produk = Produk::all();
        $bahan = Bahan::all();
        $karyawan = Karyawan::all();
        $mesin = Mesin::all();

        return view('admin.produksi.edit', compact('produksi', 'produk', 'bahan', 'karyawan', 'mesin'));
    }

    public function update(Request $request, $id)
    {
        $produksi = Produksi::findOrFail($id);

        $request->validate([
            'id_produk'        => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi'  => 'required|integer|min:1',
            'status_produksi'  => 'required|in:sudah,proses',
            'id_bahan'         => 'required|exists:bahan,id_bahan',
            'id_karyawan'      => 'required|exists:karyawan,id_karyawan',
            'id_mesin'         => 'required|exists:mesin,id',
            'id_totalproduksi' => 'required|integer',
        ]);

        $bahan = Bahan::findOrFail($request->id_bahan);
        $produk = Produk::findOrFail($request->id_produk);

        // Kembalikan stok lama
        $bahan->increment('stock_bahan', $produksi->jumlah_produksi);
        $produk->decrement('stok_produk', $produksi->jumlah_produksi);

        // Cek stok bahan baru
        if ($bahan->stock_bahan < $request->jumlah_produksi) {
            return back()->withErrors(['id_bahan' => 'Stok bahan tidak mencukupi untuk update!']);
        }

        $bahan->decrement('stock_bahan', $request->jumlah_produksi);
        $produk->increment('stok_produk', $request->jumlah_produksi);

        $produksi->update($request->all());

        return redirect()->route('admin.produksi.index')->with('success', 'Produksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);

        $bahan = Bahan::findOrFail($produksi->id_bahan);
        $produk = Produk::findOrFail($produksi->id_produk);

        $bahan->increment('stock_bahan', $produksi->jumlah_produksi);
        $produk->decrement('stok_produk', $produksi->jumlah_produksi);

        $produksi->delete();

        return redirect()->route('admin.produksi.index')->with('success', 'Produksi berhasil dihapus!');
    }

    public function show($id)
    {
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])->findOrFail($id);
        return view('admin.produksi.show', compact('produksi'));
    }
}
