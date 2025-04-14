<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers\Admin;

use App\Models\TotalProduksi;
use App\Models\Karyawan;
use App\Models\Gaji;
use App\Http\Controllers\Controller;
use App\Models\Produksi;
use Illuminate\Support\Facades\DB; 

use Illuminate\Http\Request;

use Carbon\Carbon;

class TotalProduksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $totalProduksi = TotalProduksi::with(['karyawan', 'gaji'])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('karyawan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('periode_produksi', 'like', "%{$search}%");
            })
            ->orderBy('periode_produksi', 'desc')
            ->paginate(10);
        
        return view('admin.totalproduksi.index', compact('totalProduksi', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        $gajis = Gaji::all();
    
        return view('admin.totalproduksi.create', compact('karyawans', 'gajis'));
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
        // Ubah 'karyawans' menjadi 'karyawan' (atau nama tabel karyawan yang benar)
        'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        'periode_produksi' => 'required|date',
        // Ubah 'gajis' menjadi 'gaji' (atau nama tabel gaji yang benar)
        'id_gaji' => 'required|exists:gaji,id_gaji',
    ]);

    TotalProduksi::create([
        'id_karyawan' => $request->id_karyawan,
        'periode_produksi' => $request->periode_produksi,
        'id_gaji' => $request->id_gaji,
    ]);

    return redirect()->route('admin.totalproduksi.index')->with('success', 'Data berhasil disimpan.');
}
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $totalProduksi = TotalProduksi::with(['karyawan', 'gaji'])->findOrFail($id);
        
        // Hitung jumlah produksi untuk total produksi ini
        $produksiItems = Produksi::where('id_totalproduksi', $id)->get();
        $totalJumlahProduksi = $produksiItems->sum('jumlah_produksi');
        
        return view('admin.totalproduksi.show', compact('totalProduksi', 'produksiItems', 'totalJumlahProduksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $totalProduksi = TotalProduksi::findOrFail($id);
        $karyawans = Karyawan::all();
        $gajis = Gaji::all();
        
        return view('admin.totalproduksi.edit', compact('totalProduksi', 'karyawans', 'gajis'));
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
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'periode_produksi' => 'required|date',
            'id_gaji' => 'required|exists:gaji,id_gaji'
        ]);

        // Cek apakah data untuk periode dan karyawan tersebut sudah ada (kecuali record ini sendiri)
        $existingRecord = TotalProduksi::where('id_karyawan', $request->id_karyawan)
            ->whereDate('periode_produksi', Carbon::parse($request->periode_produksi)->format('Y-m-d'))
            ->where('id_totalproduksi', '!=', $id)
            ->first();
            
        if ($existingRecord) {
            return redirect()->back()->with('error', 'Data total produksi untuk karyawan dan periode ini sudah ada!')->withInput();
        }

        $totalProduksi = TotalProduksi::findOrFail($id);
        $totalProduksi->update([
            'id_karyawan' => $request->id_karyawan,
            'periode_produksi' => $request->periode_produksi,
            'id_gaji' => $request->id_gaji
        ]);

        return redirect()->route('admin.totalproduksi.index')
                         ->with('success', 'Data total produksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cek apakah ada data produksi yang terkait
        $produksiCount = Produksi::where('id_totalproduksi', $id)->count();
        if ($produksiCount > 0) {
            return redirect()->route('admin.totalproduksi.index')
                            ->with('error', 'Tidak dapat menghapus data karena masih digunakan dalam data produksi!');
        }
        
        $totalProduksi = TotalProduksi::findOrFail($id);
        $totalProduksi->delete();
        
        return redirect()->route('admin.totalproduksi.index')
                         ->with('success', 'Data total produksi berhasil dihapus!');
    }
    
    
}