<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\MesinController;
use App\Http\Controllers\KaryawanController;

// Halaman utama
Route::get('/', function () {
    return view('auth.login');
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
});

// Duplicate home route outside middleware - consider removing this
Route::get('/home', [HomeController::class, 'index']);