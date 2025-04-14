<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiProduk;
use App\Models\Produk;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class NilaiProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil keyword dari input pencarian
        $keyword = $request->input('search');

        // Jika ada keyword, lakukan pencarian
        $nilaiProduks = NilaiProduk::with(['produk', 'karyawan'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('produk', function ($q) use ($keyword) {
                    $q->where('nama_produk', 'like', "%{$keyword}%");
                })
                ->orWhereHas('karyawan', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });
            })
            ->paginate(10);

        return view('admin.nilaiproduk.index', compact('nilaiProduks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produks = Produk::all();
        $karyawans = Karyawan::all();
        
        return view('admin.nilaiproduk.create', compact('produks', 'karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);

        NilaiProduk::create($request->all());

        return redirect()->route('admin.nilaiproduk.index')
            ->with('success', 'Nilai Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nilaiProduk = NilaiProduk::with(['produk', 'karyawan'])->findOrFail($id);
        
        return view('admin.nilaiproduk.show', compact('nilaiProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nilaiProduk = NilaiProduk::findOrFail($id);
        $produks = Produk::all();
        $karyawans = Karyawan::all();
        
        return view('admin.nilaiproduk.edit', compact('nilaiProduk', 'produks', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);

        $nilaiProduk = NilaiProduk::findOrFail($id);
        $nilaiProduk->update($request->all());

        return redirect()->route('admin.nilaiproduk.index')
            ->with('success', 'Nilai Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nilaiProduk = NilaiProduk::findOrFail($id);
        $nilaiProduk->delete();

        return redirect()->route('admin.nilaiproduk.index')
            ->with('success', 'Nilai Produk berhasil dihapus!');
    }
}