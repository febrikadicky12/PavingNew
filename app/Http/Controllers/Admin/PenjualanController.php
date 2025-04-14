<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the sales.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        
        $penjualan = Penjualan::with('produk')
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('produk', function ($q) use ($keyword) {
                    $q->where('nama_produk', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('admin.penjualan.index', compact('penjualan'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $produk = Produk::where('stok_produk', '>', 0)->get();
        return view('admin.penjualan.create', compact('produk'));
    }

    /**
     * Store a newly created sale in database and reduce product stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah_produk' => 'required|integer|min:1',
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($request->id_produk);
            
            // Check if there's enough stock
            if ($produk->stok_produk < $request->jumlah_produk) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $produk->stok_produk);
            }
            
            // Calculate total price
            $total_harga = $produk->harga_produk * $request->jumlah_produk;
            
            // Create sale record
            $penjualan = new Penjualan();
            $penjualan->id_produk = $request->id_produk;
            $penjualan->jumlah_produk = $request->jumlah_produk;
            $penjualan->total_harga = $total_harga;
            $penjualan->tanggal = now();
            $penjualan->save();
            
            // Reduce product stock
            $produk->stok_produk -= $request->jumlah_produk;
            $produk->save();
            
            DB::commit();
            
            return redirect()->route('admin.penjualan.index')
                ->with('success', 'Penjualan berhasil ditambahkan dan stok produk telah diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified sale.
     */
    public function show($id)
    {
        $penjualan = Penjualan::with('produk')->findOrFail($id);
        return view('admin.penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $produk = Produk::all();
        $selectedProduk = Produk::findOrFail($penjualan->id_produk);
        
        return view('admin.penjualan.edit', compact('penjualan', 'produk', 'selectedProduk'));
    }

    /**
     * Update the specified sale in storage and adjust product stock.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah_produk' => 'required|integer|min:1',
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $penjualan = Penjualan::findOrFail($id);
            $oldProdukId = $penjualan->id_produk;
            $oldJumlah = $penjualan->jumlah_produk;
            
            // If product is the same, calculate stock difference
            if ($oldProdukId == $request->id_produk) {
                $produk = Produk::findOrFail($request->id_produk);
                $stockChange = $request->jumlah_produk - $oldJumlah;
                
                // Check if there's enough stock for increased quantity
                if ($stockChange > 0 && $produk->stok_produk < $stockChange) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Stok produk tidak mencukupi untuk penambahan! Stok tersedia: ' . $produk->stok_produk);
                }
                
                // Update product stock
                $produk->stok_produk -= $stockChange;
                $produk->save();
                
                // Calculate new total price
                $total_harga = $produk->harga_produk * $request->jumlah_produk;
                
                // Update sale record
                $penjualan->jumlah_produk = $request->jumlah_produk;
                $penjualan->total_harga = $total_harga;
                $penjualan->save();
            } else {
                // If product is different, restore old product stock and reduce new product stock
                $oldProduk = Produk::findOrFail($oldProdukId);
                $newProduk = Produk::findOrFail($request->id_produk);
                
                // Check if there's enough stock for the new product
                if ($newProduk->stok_produk < $request->jumlah_produk) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Stok produk baru tidak mencukupi! Stok tersedia: ' . $newProduk->stok_produk);
                }
                
                // Restore old product stock
                $oldProduk->stok_produk += $oldJumlah;
                $oldProduk->save();
                
                // Reduce new product stock
                $newProduk->stok_produk -= $request->jumlah_produk;
                $newProduk->save();
                
                // Calculate new total price
                $total_harga = $newProduk->harga_produk * $request->jumlah_produk;
                
                // Update sale record
                $penjualan->id_produk = $request->id_produk;
                $penjualan->jumlah_produk = $request->jumlah_produk;
                $penjualan->total_harga = $total_harga;
                $penjualan->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.penjualan.index')
                ->with('success', 'Penjualan berhasil diperbarui dan stok produk telah disesuaikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified sale from storage and restore product stock.
     */
    public function destroy($id)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $penjualan = Penjualan::findOrFail($id);
            $produk = Produk::findOrFail($penjualan->id_produk);
            
            // Restore product stock
            $produk->stok_produk += $penjualan->jumlah_produk;
            $produk->save();
            
            // Delete sale record
            $penjualan->delete();
            
            DB::commit();
            
            return redirect()->route('admin.penjualan.index')
                ->with('success', 'Penjualan berhasil dihapus dan stok produk telah dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}