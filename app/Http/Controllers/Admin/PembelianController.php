<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Bahan;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class PembelianController extends Controller
{
    /**
     * Display a listing of purchases
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $pembelian = Pembelian::with(['suplier', 'bahan'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('suplier', function ($q) use ($search) {
                $q->where('nama_suplier', 'like', "%$search%");
            })
            ->orWhereHas('bahan', function ($q) use ($search) {
                $q->where('nama_bahan', 'like', "%$search%");
            })
            ->orWhere('tgl_pembelian', 'like', "%$search%");
        })
        ->orderBy('tgl_pembelian', 'desc') // ✅ perbaiki di sini
        ->get();
    
        return view('admin.pembelian.index', compact('pembelian'));
    }

    /**
     * Show the form for creating a new purchase
     */
    public function create()
    {
        // Load all suppliers for the first dropdown
        $supliers = Suplier::all();
        
        // Load all ingredients/materials for reference
        $bahans = Bahan::all();
        
        return view('admin.pembelian.create', compact('supliers', 'bahans'));
    }
    
    public function getBahanBySuplier($id)
    {
        $bahan = Bahan::where('id_suplier', $id)->get();
    
        return response()->json($bahan);
    }

    /**
     * Store a newly created purchase
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_suplier' => 'required',
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'jumlah' => 'required|numeric|min:1',
            'harga_total' => 'required|numeric|min:0',
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            Pembelian::create([
                'id_suplier' => $request->id_suplier,
                'id_bahan' => $request->id_bahan,
                'jumlah' => $request->jumlah,
                'harga_total' => $request->harga_total,
                'tanggal_pembelian' => now(), // ✅ BENAR
            ]);
            
            
            // Update stock
            $bahan = Bahan::find($request->id_bahan);
            $bahan->stock_bahan + $request->jumlah;
            $bahan->save();
            
            DB::commit();
            
            return redirect()->route('admin.pembelian.index')
                ->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan! ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified purchase
     */
    public function show($id)
    {
        $pembelian = Pembelian::with(['suplier', 'bahan'])->findOrFail($id);
        return view('admin.pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing a purchase
     */
    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $supliers = Suplier::orderBy('nama_suplier')->get();
        $bahans = Bahan::all();
        
        return view('admin.pembelian.edit', compact('pembelian', 'supliers', 'bahans'));
    }

    /**
     * Update the specified purchase
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_suplier' => 'required|integer|exists:suplier,id_suplier',
            'id_bahan' => 'required|integer|exists:bahan,id_bahan',
            'jumlah' => 'required|numeric|min:1',
            'harga_total' => 'required|numeric|min:0',
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $pembelian = Pembelian::findOrFail($id);
            $oldJumlah = $pembelian->jumlah;
            $oldBahanId = $pembelian->id_bahan;
            
           
            
            // If bahan is the same, just update the stock difference
            if ($oldBahanId == $request->id_bahan) {
                $bahan = Bahan::findOrFail($request->id_bahan);
                $bahan->stock_bahan = $bahan->stock_bahan - $oldJumlah + $request->jumlah;
                $bahan->save();
            } else {
                // If bahan changed, update both old and new bahan stock
                $oldBahan = Bahan::findOrFail($oldBahanId);
                $oldBahan->stock_bahan -= $oldJumlah;
                $oldBahan->save();
                
                $newBahan = Bahan::findOrFail($request->id_bahan);
                $newBahan->stock_bahan += $request->jumlah;
                $newBahan->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.pembelian.index')
                ->with('success', 'Pembelian berhasil diperbarui dan stok bahan disesuaikan!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan! ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified purchase
     */
    public function destroy($id)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $pembelian = Pembelian::findOrFail($id);
            
            // Adjust material stock first
            $bahan = Bahan::findOrFail($pembelian->id_bahan);
            $bahan->stock_bahan -= $pembelian->jumlah;
            
            // Check if stock would be negative after deletion
            if ($bahan->stock_bahan < 0) {
                throw new \Exception('Tidak bisa menghapus pembelian karena akan menyebabkan stok bahan menjadi negatif!');
            }
            
            $bahan->save();
            
            // Then delete the purchase
            $pembelian->delete();
            
            DB::commit();
            
            return redirect()->route('admin.pembelian.index')
                ->with('success', 'Pembelian berhasil dihapus dan stok bahan dikurangi!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.pembelian.index')
                ->with('error', $e->getMessage());
        }
    }
}