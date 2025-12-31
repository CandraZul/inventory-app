<?php

use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Auth\RegisterDosenController;
use App\Http\Controllers\Auth\RegisterMahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\User\PeminjamanUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Auth::routes();

Route::redirect('/home', '/');

// tak matiin dulu ya
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
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

Route::middleware(['auth', 'role:admin|super admin'])->group(function () {
    Route::resource('/users', App\Http\Controllers\UserController::class);
});

Route::post('/toggle-sidebar', [SidebarController::class, 'toggle'])
    ->middleware(['auth'])
    ->name('toggle-sidebar');

// Inventory
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');


Route::middleware(['auth'])->prefix('borrowing')->group(function () {

    // dashboard user peminjaman
    Route::get('/dashboard', [PeminjamanUserController::class, 'dashboard'])
        ->name('borrowing.dashboard');

    // halaman pinjam barang
    Route::get('/pinjam', [PeminjamanUserController::class, 'index'])
        ->name('borrowing.pinjam');
    Route::post('/pinjam', [PeminjamanUserController::class, 'store'])
    ->name('borrowing.store');

    // riwayat peminjaman
    Route::get('/riwayat', [PeminjamanUserController::class, 'riwayat'])
        ->name('borrowing.riwayat');
});

