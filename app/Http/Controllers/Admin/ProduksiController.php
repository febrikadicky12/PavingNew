<?php


namespace App\Http\Controllers\Admin;

<<<<<<< HEAD
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Karyawan;
use App\Models\Mesin;
use App\Models\TotalProduksi;
use Illuminate\Support\Facades\DB; 
=======
>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Karyawan;
use App\Models\Mesin;

class ProduksiController extends Controller
{
<<<<<<< HEAD
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('produk', function($q) use ($search) {
                    $q->where('nama_produk', 'like', "%{$search}%");
                })
                ->orWhereHas('karyawan', function($q) use ($search) {
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produks = Produk::all();
        $bahans = Bahan::all();
        $karyawans = Karyawan::all();
        $mesins = Mesin::all();
        $totalProduksis = TotalProduksi::all();
        
        return view('admin.produksi.create', compact('produks', 'bahans', 'karyawans', 'mesins', 'totalProduksis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
=======
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

>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
<<<<<<< HEAD
            'jumlah_produksi' => 'required|integer|min:1',
            'status_produksi' => 'required|in:sudah,proses',
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_mesin' => 'required|exists:mesin,id',
            'id_totalproduksi' => 'required|exists:total_produksi,id_totalproduksi'
        ]);

        // Cek ketersediaan bahan
        $bahan = Bahan::find($request->id_bahan);
        if ($bahan->stock_bahan < $request->jumlah_produksi) {
            return redirect()->back()->with('error', 'Stok bahan tidak mencukupi untuk produksi ini!')->withInput();
        }

        $produksi = Produksi::create([
            'id_produk' => $request->id_produk,
            'tanggal_produksi' => $request->tanggal_produksi,
            'jumlah_produksi' => $request->jumlah_produksi,
            'status_produksi' => $request->status_produksi,
            'id_bahan' => $request->id_bahan,
            'id_karyawan' => $request->id_karyawan,
            'id_mesin' => $request->id_mesin,
            'id_totalproduksi' => $request->id_totalproduksi
        ]);

        // Kurangi stok bahan
        $bahan->stock_bahan -= $request->jumlah_produksi;
        $bahan->save();

        // Tambah stok produk
        $produk = Produk::find($request->id_produk);
        $produk->stok_produk += $request->jumlah_produksi;
        $produk->save();

        return redirect()->route('admin.produksi.index')
                         ->with('success', 'Data produksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin', 'totalProduksi'])->findOrFail($id);
        return view('admin.produksi.show', compact('produksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produks = Produk::all();
        $bahans = Bahan::all();
        $karyawans = Karyawan::all();
        $mesins = Mesin::all();
        $totalProduksis = TotalProduksi::all();
        
        return view('admin.produksi.edit', compact('produksi', 'produks', 'bahans', 'karyawans', 'mesins', 'totalProduksis'));
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
=======
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

>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal_produksi' => 'required|date',
<<<<<<< HEAD
            'jumlah_produksi' => 'required|integer|min:1',
            'status_produksi' => 'required|in:sudah,proses',
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_mesin' => 'required|exists:mesin,id',
            'id_totalproduksi' => 'required|exists:total_produksi,id_totalproduksi'
        ]);

        $produksi = Produksi::findOrFail($id);
        
        // Kembalikan stok bahan dan produk dari data lama
        $bahanLama = Bahan::find($produksi->id_bahan);
        $bahanLama->stock_bahan += $produksi->jumlah_produksi;
        $bahanLama->save();
        
        $produkLama = Produk::find($produksi->id_produk);
        $produkLama->stok_produk -= $produksi->jumlah_produksi;
        $produkLama->save();
        
        // Cek ketersediaan bahan untuk data baru
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

        // Kurangi stok bahan baru
        $bahanBaru->stock_bahan -= $request->jumlah_produksi;
        $bahanBaru->save();
        
        // Tambah stok produk baru
        $produkBaru = Produk::find($request->id_produk);
        $produkBaru->stok_produk += $request->jumlah_produksi;
        $produkBaru->save();

        return redirect()->route('admin.produksi.index')
                         ->with('success', 'Data produksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);
        
        // Kembalikan stok bahan dan produk sebelum menghapus
        $bahan = Bahan::find($produksi->id_bahan);
        $bahan->stock_bahan += $produksi->jumlah_produksi;
        $bahan->save();
        
        $produk = Produk::find($produksi->id_produk);
        $produk->stok_produk -= $produksi->jumlah_produksi;
        $produk->save();
        
        $produksi->delete();
        
        return redirect()->route('admin.produksi.index')
                         ->with('success', 'Data produksi berhasil dihapus!');
=======
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
>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
    }

    public function show($id)
    {
        $produksi = Produksi::with(['produk', 'bahan', 'karyawan', 'mesin'])->findOrFail($id);
        return view('admin.produksi.show', compact('produksi'));
    }
}
