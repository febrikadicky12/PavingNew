<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Produksi;
use Illuminate\Http\Request;

class ProduksiController extends Controller {
    public function index() {
        $produksi = Produksi::all();
        return view('admin.produksi.index', compact('produksi'));
    }
    public function create() {
        return view('admin.produksi.create');
    }
    public function store(Request $request) {
        $request->validate([
            'id_produk'        => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi'  => 'required|integer|min:1',
            'status_produksi'  => 'required|string|in:pending,selesai',
            'id_bahan'         => 'required|integer',
            'id_karyawan'      => 'required|integer',
            'id_mesin'         => 'required|integer',
            'id_totalproduksi' => 'required|integer',
        ]);
        Produksi::create($request->all());
        return redirect()->route('admin.produksi.index');
    }
    public function edit(Produksi $produksi) {
        return view('admin.produksi.edit', compact('produksi'));
    }
    public function update(Request $request, Produksi $produksi) {
        $request->validate([
            'id_produk'        => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi'  => 'required|integer|min:1',
            'status_produksi'  => 'required|string|in:pending,selesai',
            'id_bahan'         => 'required|integer',
            'id_karyawan'      => 'required|integer',
            'id_mesin'         => 'required|integer',
            'id_totalproduksi' => 'required|integer',
        ]);
        $produksi->update($request->all());
        return redirect()->route('admin.produksi.index');
    }
    public function destroy(Produksi $produksi) {
        $produksi->delete();
        return redirect()->route('admin.produksi.index');
    }
}