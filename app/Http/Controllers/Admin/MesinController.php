<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesin;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = $request->input('search');

    if ($query) {
        $mesins = Mesin::where('nama_mesin', 'like', "%$query%")->get();
    } else {
        $mesins = Mesin::all(); // Jika input kosong, ambil semua data
    }

    return view('admin.datamesin', compact('mesins'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form_mesin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'status' => 'required'
        ]);

        Mesin::create($request->all());

        return redirect()->route('admin.datamesin.index')->with('success', 'Mesin berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $mesin = Mesin::findOrFail($id);
    return view('admin.detailmesin', compact('mesin'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesin $mesin)
    {
        return view('admin.form_mesin', compact('mesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesin $mesin)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'status' => 'required'
        ]);

        $mesin->update($request->all());

        return redirect()->route('admin.datamesin.index')->with('success', 'Mesin berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesin $mesin)
    {
        $mesin->delete();
        return redirect()->route('admin.datamesin.index');
    }
}
