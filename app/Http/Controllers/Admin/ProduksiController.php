<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Karyawan;
use App\Models\Mesin;
use App\Models\TotalProduksi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('produk', function ($q) use ($search) {
                    $q->where('nama_produk', 'like', "%{$search}%");
                })
                ->orWhereHas('karyawan', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('status_produksi', 'like', "%{$search}%")
                ->orWhere('tanggal_produksi', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_produksi', 'desc')
            ->paginate(10);

        return view('admin.produksi.index', compact('produksi', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        $bahan = Bahan::all();
        $karyawan = Karyawan::all();
        $mesin = Mesin::all();
        $totalProduksis = TotalProduksi::all();

        return view('admin.produksi.create', compact('produk', 'bahan', 'karyawan', 'mesin', 'totalProduksis'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produk = Produk::all();
        $bahan = Bahan::all();
        $karyawan = Karyawan::all();
        $mesin = Mesin::all();

        return view('admin.produksi.edit', compact('produksi', 'produk', 'bahan', 'karyawan', 'mesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produksi = Produksi::findOrFail($id);

        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi' => 'required|integer|min:1',
            'status_produksi' => 'required|in:sudah,proses',
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_mesin' => 'required|exists:mesin,id',
            'id_totalproduksi' => 'required|exists:total_produksi,id_totalproduksi'
        ]);

        // Kembalikan stok bahan & produk dari data lama
        $bahanLama = Bahan::find($produksi->id_bahan);
        $bahanLama->increment('stock_bahan', $produksi->jumlah_produksi);

        $produkLama = Produk::find($produksi->id_produk);
        $produkLama->decrement('stok_produk', $produksi->jumlah_produksi);

        // Cek stok bahan baru
        $bahanBaru = Bahan::find($request->id_bahan);
        if ($bahanBaru->stock_bahan < $request->jumlah_produksi) {
            return redirect()->back()->with('error', 'Stok bahan tidak mencukupi untuk produksi ini!')->withInput();
        }

        $produksi->update([
            'id_produk' => $request->id_produk,
            'tanggal_produksi' => $request->tanggal_produksi,
            'jumlah_produksi' => $request->jumlah_produksi,
            'status_produksi' => $request->status_produksi,
            'id_bahan' => $request->id_bahan,
            'id_karyawan' => $request->id_karyawan,
            'id_mesin' => $request->id_mesin,
            'id_totalproduksi' => $request->id_totalproduksi
        ]);

        $bahanBaru->decrement('stock_bahan', $request->jumlah_produksi);

        $produkBaru = Produk::find($request->id_produk);
        $produkBaru->increment('stok_produk', $request->jumlah_produksi);

        return redirect()->route('admin.produksi.index')->with('success', 'Data produksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])->findOrFail($id);
        return view('admin.produksi.show', compact('produksi'));
    }
}
