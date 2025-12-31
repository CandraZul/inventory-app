<?php

use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Auth\RegisterDosenController;
use App\Http\Controllers\Auth\RegisterMahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\User\SuratController;
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

// ========== PERBAIKAN ROUTE BORROWING ==========
Route::middleware(['auth'])->prefix('borrowing')->name('borrowing.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [PeminjamanUserController::class, 'dashboard'])
        ->name('dashboard');
    
    // Halaman pinjam barang
    Route::get('/pinjam', [PeminjamanUserController::class, 'index'])
        ->name('pinjam');
    
    // Keranjang routes
    Route::post('/cart/add', [PeminjamanUserController::class, 'addToCart'])
        ->name('cart.add');
    
    Route::get('/cart', [PeminjamanUserController::class, 'viewCart'])
        ->name('cart');
    
    Route::post('/cart/update', [PeminjamanUserController::class, 'updateCart'])
        ->name('cart.update');
    
    Route::post('/cart/remove', [PeminjamanUserController::class, 'removeFromCart'])
        ->name('cart.remove');

    Route::get('/cart/clear', [PeminjamanUserController::class, 'clearCart'])
        ->name('cart.clear');
    
    Route::post('/submit', [PeminjamanUserController::class, 'submitPeminjaman'])
        ->name('submit');
    
    // Riwayat
    Route::get('/riwayat', [PeminjamanUserController::class, 'riwayat'])
        ->name('riwayat');
});

// ========== PERBAIKAN ROUTE SURAT ==========
Route::middleware(['auth'])->prefix('surat')->name('borrowing.surat.')->group(function () {
    Route::get('/upload', [SuratController::class, 'create'])
        ->name('upload');
    
    Route::post('/upload', [SuratController::class, 'store'])
        ->name('store');
    
    Route::get('/template', [SuratController::class, 'downloadTemplate'])
        ->name('template');
    
    // ROUTE INI UNTUK MENU SIDEBAR
    Route::get('/list', [SuratController::class, 'index'])
        ->name('list');

    // Tambah route untuk cancel surat (perbaiki prefix)
    Route::delete('/{id}/cancel', [SuratController::class, 'cancel'])
        ->name('cancel');
});


// Tambahkan route logout jika belum ada
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');