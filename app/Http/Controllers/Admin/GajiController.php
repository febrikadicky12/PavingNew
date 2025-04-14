<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
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
    public function index()
    {
        $gajis = Gaji::orderBy('jenis_karyawan')->get();
        return view('admin.gaji.index', compact('gajis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gaji.create');
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
            'jenis_karyawan' => 'required|in:bulanan,borongan',
            'tarif_produksi' => 'required|numeric|min:0',
            'gaji_pokok' => 'nullable|numeric|min:0',
            'potongan_izin' => 'nullable|numeric|min:0',
            'potongan_alpa' => 'nullable|numeric|min:0',
        ]);

        // Validate gaji_pokok is required for bulanan employees
        if ($request->jenis_karyawan === 'bulanan' && empty($request->gaji_pokok)) {
            return redirect()->back()->withErrors(['gaji_pokok' => 'Gaji pokok harus diisi untuk karyawan bulanan.'])->withInput();
        }

        Gaji::create([
            'jenis_karyawan' => $request->jenis_karyawan,
            'gaji_pokok' => $request->gaji_pokok,
            'tarif_produksi' => $request->tarif_produksi,
            'potongan_izin' => $request->potongan_izin,
            'potongan_alpa' => $request->potongan_alpa,
        ]);

        return redirect()->route('admin.gaji.index')
                         ->with('success', 'Data gaji berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gaji = Gaji::findOrFail($id);
        return view('admin.gaji.edit', compact('gaji'));
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
            'jenis_karyawan' => 'required|in:bulanan,borongan',
            'tarif_produksi' => 'required|numeric|min:0',
            'gaji_pokok' => 'nullable|numeric|min:0',
            'potongan_izin' => 'nullable|numeric|min:0',
            'potongan_alpa' => 'nullable|numeric|min:0',
        ]);

        // Validate gaji_pokok is required for bulanan employees
        if ($request->jenis_karyawan === 'bulanan' && empty($request->gaji_pokok)) {
            return redirect()->back()->withErrors(['gaji_pokok' => 'Gaji pokok harus diisi untuk karyawan bulanan.'])->withInput();
        }

        $gaji = Gaji::findOrFail($id);
        $gaji->update([
            'jenis_karyawan' => $request->jenis_karyawan,
            'gaji_pokok' => $request->gaji_pokok,
            'tarif_produksi' => $request->tarif_produksi,
            'potongan_izin' => $request->potongan_izin,
            'potongan_alpa' => $request->potongan_alpa,
        ]);

        return redirect()->route('admin.gaji.index')
                         ->with('success', 'Data gaji berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if this salary is being used in totalproduksi
        $isUsed = \App\Models\TotalProduksi::where('id_gaji', $id)->exists();
        
        if ($isUsed) {
            return redirect()->route('admin.gaji.index')
                            ->with('error', 'Data gaji tidak dapat dihapus karena sedang digunakan!');
        }
        
        $gaji = Gaji::findOrFail($id);
        $gaji->delete();
        
        return redirect()->route('admin.gaji.index')
                         ->with('success', 'Data gaji berhasil dihapus!');
    }
}