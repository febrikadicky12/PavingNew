<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\MesinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\ProduksiController;
use App\Http\Controllers\Admin\TotalProduksiController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\SuplierController;
use App\Http\Controllers\Admin\RekapAbsenController;
use App\Http\Controllers\Karyawan\AbsenController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\NilaiProdukController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Models\Produk;



// Halaman utama
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    // Route::get('/profile/change-password', [UserProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    // Route::put('/profile/update-password', [UserProfileController::class, 'changePassword'])->name('profile.update-password');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard routes based on user role
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/karyawan/borongan/dashboard', function () {
        return view('karyawan.borongan.dashboard');
    })->name('karyawan.borongan.dashboard');

    Route::get('/karyawan/bulanan/dashboard', function () {
        return view('karyawan.bulanan.dashboard');
    })->name('karyawan.bulanan.dashboard');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Admin routes - accessible only by admin role
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        });
        
        // User management routes
        Route::resource('admin/users', UserController::class)->names([
            'index'   => 'admin.users.index',
            'create'  => 'admin.users.create',
            'store'   => 'admin.users.store',
            'show'    => 'admin.users.show',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        
        // Legacy resource route
        Route::resource('users', UserController::class);
        
        // Karyawan management routes
        Route::resource('admin/karyawan', KaryawanController::class)->names([
            'index'   => 'admin.karyawan.index',
            'create'  => 'admin.karyawan.create',
            'store'   => 'admin.karyawan.store',
            'show'    => 'admin.karyawan.show',
            'edit'    => 'admin.karyawan.edit',
            'update'  => 'admin.karyawan.update',
            'destroy' => 'admin.karyawan.destroy',
        ]);
    });

    // Karyawan routes - accessible by both types of employees
    Route::middleware(['role:karyawan_borongan,karyawan_bulanan'])->group(function () {
        Route::resource('karyawan/users', UserController::class)->names([
            'index'   => 'karyawan.users.index',
            'create'  => 'karyawan.users.create',
            'store'   => 'karyawan.users.store',
            'show'    => 'karyawan.users.show',
            'edit'    => 'karyawan.users.edit',
            'update'  => 'karyawan.users.update',
            'destroy' => 'karyawan.users.destroy',
        ]);
    });
    
    // Admin data mesin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/datamesin', [MesinController::class, 'index'])->name('datamesin.index');
        Route::get('/datamesin/create', [MesinController::class, 'create'])->name('datamesin.create');
        Route::post('/datamesin', [MesinController::class, 'store'])->name('datamesin.store');
        Route::get('/datamesin/{mesin}', [MesinController::class, 'show'])->name('datamesin.show');
        Route::get('/datamesin/{mesin}/edit', [MesinController::class, 'edit'])->name('datamesin.edit');
        Route::put('/datamesin/{mesin}', [MesinController::class, 'update'])->name('datamesin.update');
        Route::delete('/datamesin/{mesin}', [MesinController::class, 'destroy'])->name('datamesin.destroy');
    });

    // NilaiProduk routes - Add this to the existing admin routes prefix
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
// To this:
Route::resource('nilaiproduk', \App\Http\Controllers\Admin\NilaiProdukController::class);
});

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
        Route::get('/produksi/create', [ProduksiController::class, 'create'])->name('produksi.create');
        Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
        Route::get('/produksi/{id}/edit', [ProduksiController::class, 'edit'])->name('produksi.edit');
        Route::put('/produksi/{id}', [ProduksiController::class, 'update'])->name('produksi.update');
        Route::delete('/produksi/{id}', [ProduksiController::class, 'destroy'])->name('produksi.destroy');
        Route::get('/produksi/{id}', [ProduksiController::class, 'show'])->name('produksi.show'); // Tambahkan ini
    });

   // TotalProduksi routes with report, export, and print functionality
   Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/totalproduksi', [TotalProduksiController::class, 'index'])->name('totalproduksi.index');
    Route::get('/totalproduksi/create', [TotalProduksiController::class, 'create'])->name('totalproduksi.create');
    Route::post('/totalproduksi', [TotalProduksiController::class, 'store'])->name('totalproduksi.store');
    Route::get('/totalproduksi/{id}/edit', [TotalProduksiController::class, 'edit'])->name('totalproduksi.edit');
    Route::put('/totalproduksi/{id}', [TotalProduksiController::class, 'update'])->name('totalproduksi.update');
    Route::delete('/totalproduksi/{id}', [TotalProduksiController::class, 'destroy'])->name('totalproduksi.destroy');
    Route::get('/totalproduksi/{id}', [TotalProduksiController::class, 'show'])->name('totalproduksi.show');
   
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/gaji', [App\Http\Controllers\Admin\GajiController::class, 'index'])->name('gaji.index');
    Route::get('/gaji/create', [App\Http\Controllers\Admin\GajiController::class, 'create'])->name('gaji.create');
    Route::post('/gaji', [App\Http\Controllers\Admin\GajiController::class, 'store'])->name('gaji.store');
    Route::get('/gaji/{id}/edit', [App\Http\Controllers\Admin\GajiController::class, 'edit'])->name('gaji.edit');
    Route::put('/gaji/{id}', [App\Http\Controllers\Admin\GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/{id}', [App\Http\Controllers\Admin\GajiController::class, 'destroy'])->name('gaji.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Make sure this route is defined before the resource route
    Route::get('/pembelian/get-bahan-by-suplier/{id_suplier}', [PembelianController::class, 'getBahanBySuplier'])
        ->name('pembelian.get-bahan-by-suplier');
    
    // Regular resource routes
    Route::resource('pembelian', PembelianController::class);
    
    // Other admin routes...
});

    
    Route::prefix('admin')->name('admin.')->group(function () {
         // Supplier routes
    Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
    Route::get('/suplier/create', [SuplierController::class, 'create'])->name('suplier.create');
    Route::post('/suplier', [SuplierController::class, 'store'])->name('suplier.store');
    Route::get('/suplier/{suplier}', [SuplierController::class, 'show'])->name('suplier.show');
    Route::get('/suplier/{suplier}/edit', [SuplierController::class, 'edit'])->name('suplier.edit');
    Route::put('/suplier/{suplier}', [SuplierController::class, 'update'])->name('suplier.update');
    Route::delete('/suplier/{suplier}', [SuplierController::class, 'destroy'])->name('suplier.destroy');
    });

    
    

    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/bahan', [BahanController::class, 'index'])->name('bahan.index');
    Route::get('admin/bahan/create', [BahanController::class, 'create'])->name('bahan.create');
    Route::post('admin/bahan', [BahanController::class, 'store'])->name('bahan.store');
    Route::get('/bahan/{bahan}/edit', [BahanController::class, 'edit'])->name('bahan.edit');
    Route::put('/bahan/{bahan}', [BahanController::class, 'update'])->name('bahan.update');
    Route::delete('/bahan/{bahan}', [BahanController::class, 'destroy'])->name('bahan.destroy');
    
    });

    // Add this inside the existing admin prefix group in web.php
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Existing routes...
    
    // Penjualan routes
    Route::get('/penjualan', [App\Http\Controllers\Admin\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [App\Http\Controllers\Admin\PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [App\Http\Controllers\Admin\PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{id}', [App\Http\Controllers\Admin\PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/penjualan/{id}/edit', [App\Http\Controllers\Admin\PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/penjualan/{id}', [App\Http\Controllers\Admin\PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/penjualan/{id}', [App\Http\Controllers\Admin\PenjualanController::class, 'destroy'])->name('penjualan.destroy');
});


// Routes for Penggajian Karyawan Bulanan
Route::group(['prefix' => 'admin/penggajian/bulanan', 'as' => 'admin.penggajian.bulanan.'], function () {
    Route::get('/', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'store'])->name('store');
    Route::get('/{id}', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'destroy'])->name('destroy');
    
    // Batch operations
    Route::post('/generate-batch', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'generateBatch'])->name('generate-batch');
    
    // Reports
    Route::get('/{id}/slip', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'downloadSlip'])->name('slip');
    Route::get('/report', [App\Http\Controllers\Admin\PenggajianBulananController::class, 'downloadReport'])->name('report');
});

// Routes for Penggajian Karyawan Borongan
Route::group(['prefix' => 'admin/penggajian/borongan', 'as' => 'admin.penggajian.borongan.'], function () {
    Route::get('/', [PenggajianBoronganController::class, 'index'])->name('index');
    Route::get('/create', [PenggajianBoronganController::class, 'create'])->name('create');
    Route::post('/', [PenggajianBoronganController::class, 'store'])->name('store');
    Route::get('/{id}', [PenggajianBoronganController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PenggajianBoronganController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PenggajianBoronganController::class, 'update'])->name('update');
    Route::delete('/{id}', [PenggajianBoronganController::class, 'destroy'])->name('destroy');
    
    // Batch operations
    Route::post('/generate-batch', [PenggajianBoronganController::class, 'generateBatch'])->name('generate-batch');
    
    // Reports
    Route::get('/{id}/slip', [PenggajianBoronganController::class, 'downloadSlip'])->name('slip');
    Route::get('/report', [PenggajianBoronganController::class, 'downloadReport'])->name('report');
});

// Add these routes to your routes/web.php file
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Existing routes...
    
    // Rekap Absen routes
    Route::get('/rekap-absen', [RekapAbsenController::class, 'index'])->name('rekap_absen.index');
    Route::get('/rekap-absen/generate', [RekapAbsenController::class, 'generateReport'])->name('rekap_absen.generate');
    Route::get('/rekap-absen/download-pdf', [RekapAbsenController::class, 'downloadPdf'])->name('rekap_absen.downloadPdf');
    Route::get('/rekap-absen/{id_karyawan}', [RekapAbsenController::class, 'show'])->name('rekap_absen.show');
});

// Karyawan Bulanan Absen Routes
Route::middleware(['auth', 'role:karyawan_bulanan'])->prefix('karyawan/bulanan')->name('karyawan.bulanan.')->group(function () {
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
});




   

// Duplicate home route outside middleware - consider removing this
Route::get('/home', [HomeController::class, 'index']);

// Menggunakan controller untuk dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['web', 'auth'])
    ->name('admin.dashboard');

    // Menggunakan closure langsung tanpa controller
Route::get('/admin/dashboard', function () {
    $produk = Produk::all();
    return view('admin.dashboard', compact('produk'));
})->middleware(['web', 'auth'])->name('admin.dashboard');



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/create', [MitraController::class, 'create'])->name('mitra.create');
    Route::post('/mitra', [MitraController::class, 'store'])->name('mitra.store');
    Route::get('/mitra/{id}/edit', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::put('/mitra/{id}', [MitraController::class, 'update'])->name('mitra.update');
    Route::delete('/mitra/{id}', [MitraController::class, 'destroy'])->name('mitra.destroy');
});



Route::get('/reset-password', [ResetPasswordController::class, 'reset_password'])->name('reset.password');
Route::post('/reset-password-proses', [ResetPasswordController::class, 'reset_password_proses']);


});

