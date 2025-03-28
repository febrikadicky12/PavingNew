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
use App\Http\Controllers\Admin\SuplierController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPasswordController;



// Halaman utama
Route::get('/reset-password', [ResetPasswordController::class, 'reset_password'])->name('reset.password');
Route::post('/reset-password-proses', [ResetPasswordController::class, 'reset_password_proses']);


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

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
        Route::get('/suplier/create', [SuplierController::class, 'create'])->name('suplier.create');
        Route::post('/suplier', [SuplierController::class, 'store'])->name('suplier.store');
        Route::get('/suplier/{suplier}/edit', [SuplierController::class, 'edit'])->name('suplier.edit');
        Route::put('/suplier/{suplier}', [SuplierController::class, 'update'])->name('suplier.update');
        Route::delete('/suplier/{suplier}', [SuplierController::class, 'destroy'])->name('suplier.destroy');
        Route::get('/suplier/{suplier}', [SuplierController::class, 'show'])->name('suplier.show');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/bahan', [BahanController::class, 'index'])->name('bahan.index');
    Route::get('admin/bahan/create', [BahanController::class, 'create'])->name('bahan.create');
    Route::post('admin/bahan', [BahanController::class, 'store'])->name('bahan.store');
    Route::get('/bahan/{bahan}/edit', [BahanController::class, 'edit'])->name('bahan.edit');
    Route::put('/bahan/{bahan}', [BahanController::class, 'update'])->name('bahan.update');
    Route::delete('/bahan/{bahan}', [BahanController::class, 'destroy'])->name('bahan.destroy');
    
    });
    
    

// Duplicate home route outside middleware - consider removing this
Route::get('/home', [HomeController::class, 'index']);


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/create', [MitraController::class, 'create'])->name('mitra.create');
    Route::post('/mitra', [MitraController::class, 'store'])->name('mitra.store');
    Route::get('/mitra/{id}/edit', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::put('/mitra/{id}', [MitraController::class, 'update'])->name('mitra.update');
    Route::delete('/mitra/{id}', [MitraController::class, 'destroy'])->name('mitra.destroy');
});





});

