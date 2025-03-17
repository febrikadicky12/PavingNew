<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bahan;
use Illuminate\Support\Facades\DB; 
use App\Models\Suplier;

class BahanController extends Controller
{
    // Menampilkan daftar bahan
    public function index()
    {
        $bahan = Bahan::with('suplier')->get(); // Menggunakan relasi eager loading
        return view('admin.bahan.index', compact('bahan'));
    }

    // Menampilkan form tambah bahan
    public function create()
{
    $supliers = DB::table('suplier')->get(); // Ambil semua data suplier dari tabel
    return view('admin.bahan.create', compact('supliers'));
}


    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stock_bahan' => 'required|integer|min:0',
            'jenis_bahan' => 'required|string|max:255',
            'id_suplier' => 'required|integer',
            'harga_satuan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        Bahan::create($request->all());

        return redirect()->route('admin.bahan.index')->with('success', 'Bahan berhasil ditambahkan!');
    }

    // Menampilkan form edit bahan
    public function edit($id_bahan)
{
    $bahan = Bahan::findOrFail($id_bahan);
    $supliers = Suplier::all(); // Ambil semua data suplier
    return view('admin.bahan.edit', compact('bahan', 'supliers'));
}


    // Menyimpan perubahan data bahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stock_bahan' => 'required|integer|min:0',
            'jenis_bahan' => 'required|string|max:255',
            'id_suplier' => 'required|integer',
            'harga_satuan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->update($request->all());

        return redirect()->route('admin.bahan.index')->with('success', 'Bahan berhasil diperbarui!');
    }

    // Menghapus bahan
    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->route('admin.bahan.index')->with('success', 'Bahan berhasil dihapus!');
    }
}

