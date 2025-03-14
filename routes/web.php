<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\MesinController;

// Halaman utama
Route::get('/', function () {
    return view('auth.login');
});

// Routing dengan middleware role
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/karyawan/borongan/dashboard', function () {
        return view('karyawan.borongan.dashboard');
    })->name('karyawan.borongan.dashboard');

    Route::get('/karyawan/bulanan/dashboard', function () {
        return view('karyawan.bulanan.dashboard');
    })->name('karyawan.bulanan.dashboard');
});


Route::get('/home', [HomeController::class, 'index']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/datamesin', [MesinController::class, 'index'])->name('datamesin.index');
    Route::get('/datamesin/create', [MesinController::class, 'create'])->name('datamesin.create');
    Route::post('/datamesin', [MesinController::class, 'store'])->name('datamesin.store');
    Route::get('/datamesin/{mesin}', [MesinController::class, 'show'])->name('datamesin.show');
    Route::get('/datamesin/{mesin}/edit', [MesinController::class, 'edit'])->name('datamesin.edit');
    Route::put('/datamesin/{mesin}', [MesinController::class, 'update'])->name('datamesin.update');
    Route::delete('/datamesin/{mesin}', [MesinController::class, 'destroy'])->name('datamesin.destroy');
});
