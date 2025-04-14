<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $supliers = Suplier::when($search, function ($query) use ($search) {
            $query->where('nama_suplier', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('no_telp', 'like', "%$search%");
        })->get();
        
        return view('admin.suplier.index', compact('supliers'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('admin.suplier.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_suplier' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'no_telp' => 'required|string|max:13',
        ]);

        Suplier::create($request->all());

        return redirect()->route('admin.suplier.index')
                        ->with('success', 'Suplier berhasil ditambahkan!');
    }

    /**
     * Display the specified supplier.
     */
    public function show($id)
    {
        $suplier = Suplier::findOrFail($id);
        // Get related materials and purchases for this supplier
        $bahans = $suplier->bahans;
        $pembelians = $suplier->pembelians;
        
        return view('admin.suplier.show', compact('suplier', 'bahans', 'pembelians'));
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit($id)
    {
        $suplier = Suplier::findOrFail($id);
        return view('admin.suplier.edit', compact('suplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_suplier' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'no_telp' => 'required|string|max:13',
        ]);

        $suplier = Suplier::findOrFail($id);
        $suplier->update($request->all());

        return redirect()->route('admin.suplier.index')
                        ->with('success', 'Suplier berhasil diperbarui!');
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy($id)
    {
        $suplier = Suplier::findOrFail($id);
        
        // Check if this supplier has related materials or purchases
        if ($suplier->bahans()->count() > 0 || $suplier->pembelians()->count() > 0) {
            return redirect()->route('admin.suplier.index')
                            ->with('error', 'Suplier tidak dapat dihapus karena masih memiliki bahan atau pembelian terkait!');
        }
        
        $suplier->delete();

        return redirect()->route('admin.suplier.index')
                        ->with('success', 'Suplier berhasil dihapus!');
    }
}