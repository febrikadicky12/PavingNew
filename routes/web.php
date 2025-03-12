<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;


// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Routing dengan middleware role
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::middleware('role:admin')->get('/admin', function () {
        return view('admin.dashboard');
    });

    Route::middleware('role:karyawan_borongan')->get('/karyawan-borongan', function () {
        return view('karyawan.borongan');
    });

    Route::middleware('role:karyawan_bulanan')->get('/karyawan-bulanan', function () {
        return view('karyawan.bulanan');
    });
});

Route::get('/home', [HomeController::class, 'index']);
