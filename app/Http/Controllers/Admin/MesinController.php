<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesin;

class MesinController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $mesins = $query
            ? Mesin::where('nama_mesin', 'like', "%$query%")->get()
            : Mesin::all();

        return view('admin.mesin.index', compact('mesins'));
    }

    public function create()
    {
        return view('admin.mesin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'status' => 'required'
        ]);

        Mesin::create($request->all());

        return redirect()->route('admin.mesin.index')->with('success', 'Mesin berhasil ditambahkan');
    }

    public function edit(Mesin $mesin)
    {
        return view('admin.mesin.edit', compact('mesin'));
    }

    public function update(Request $request, Mesin $mesin)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'status' => 'required'
        ]);

        $mesin->update($request->all());

        return redirect()->route('admin.mesin.index')->with('success', 'Mesin berhasil diperbarui');
    }

    public function destroy(Mesin $mesin)
    {
        $mesin->delete();
        return redirect()->route('admin.mesin.index')->with('success', 'Mesin berhasil dihapus');
    }

    public function show(Mesin $mesin)
    {
        return view('admin.mesin.show', compact('mesin'));
    }
}
