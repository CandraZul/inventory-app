<?php

use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Auth\RegisterDosenController;
use App\Http\Controllers\Auth\RegisterMahasiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin');
});

Route::middleware(['auth', 'role:dosen|mahasiswa'])->group(function () {
    Route::view('/dashboard', 'dashboard');
});

// Admin
Route::get('/register/admin', [RegisterAdminController::class, 'create']);
Route::post('/register/admin', [RegisterAdminController::class, 'store']);

// Dosen
Route::get('/register/dosen', [RegisterDosenController::class, 'create']);
Route::post('/register/dosen', [RegisterDosenController::class, 'store']);

// Mahasiswa
Route::get('/register/mahasiswa', [RegisterMahasiswaController::class, 'create']);
Route::post('/register/mahasiswa', [RegisterMahasiswaController::class, 'store']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/users', App\Http\Controllers\UserController::class);
});

