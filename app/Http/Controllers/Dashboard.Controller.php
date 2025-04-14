<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk untuk ditampilkan di dashboard
        $produk = Produk::all();
        
        return view('admin.dashboard', compact('produk'));
    }
}