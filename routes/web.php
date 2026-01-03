<?php

use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Auth\RegisterDosenController;
use App\Http\Controllers\Auth\RegisterMahasiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\User\SuratController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\User\PeminjamanUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeminjamanApprovalController;
use App\Http\Controllers\Admin\RiwayatPeminjamanController;


Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin|super admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard.admin');
});

Route::middleware('auth')->prefix('borrowing')->name('borrowing.')->group(function () {
    Route::get('/dashboard', [PeminjamanUserController::class, 'dashboard'])->name('dashboard');
});

Auth::routes();

Route::redirect('/home', '/');

// tak matiin dulu ya
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

//User Interface (Side Pengguna)
Route::middleware(['auth'])->prefix('borrowing')->name('borrowing.')->group(function () {

    //Dashboard
    Route::get('/dashboard', [PeminjamanUserController::class, 'dashboard'])
        ->name('dashboard');

    //Halaman pinjam
    Route::get('/pinjam', [PeminjamanUserController::class, 'index'])
        ->name('pinjam');

    //Keranjang
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

    //Riwayat
    Route::get('/riwayat', [PeminjamanUserController::class, 'riwayat'])
        ->name('riwayat');
});

Route::middleware(['auth'])->prefix('surat')->name('borrowing.surat.')->group(function () {
    Route::get('/upload', [SuratController::class, 'create'])
        ->name('upload');

    Route::post('/upload', [SuratController::class, 'store'])
        ->name('store');

    Route::get('/template', [SuratController::class, 'downloadTemplate'])
        ->name('template');

    Route::get('/list', [SuratController::class, 'index'])
        ->name('list');

    //Cancel surat
    Route::delete('/{id}/cancel', [SuratController::class, 'cancel'])
        ->name('cancel');
});


//Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth', 'role:admin|super admin'])->group(function () {
    Route::get('/approval/peminjaman', [PeminjamanApprovalController::class, 'index'])
        ->name('approval.peminjaman.index');

    Route::put('/approval/peminjaman/{id}/approve', [PeminjamanApprovalController::class, 'approve'])
        ->name('approval.peminjaman.approve');

    Route::put('/approval/peminjaman/{id}/reject', [PeminjamanApprovalController::class, 'reject'])
        ->name('approval.peminjaman.reject');

    Route::put('/approval/surat/{id}/signed-response', [PeminjamanApprovalController::class, 'uploadSignedResponse'])
        ->name('approval.surat.signed.upload');

    Route::get('/approval/surat/{id}/signed-response', [PeminjamanApprovalController::class, 'downloadSignedResponse'])
        ->name('approval.surat.signed.download');

    Route::get('/admin/riwayat', [RiwayatPeminjamanController::class, 'index'])
        ->name('admin.riwayat.index');
});

Route::middleware(['auth', 'role:admin|super admin'])
    ->prefix('approval/peminjaman')
    ->name('approval.peminjaman.')
    ->group(function () {
        Route::put('/{id}', [PeminjamanApprovalController::class, 'process'])
            ->name('process');

        Route::post('/{id}/signed-response', [PeminjamanApprovalController::class, 'uploadSignedResponse'])
            ->name('signed.upload');

        Route::get('/{id}/signed-response', [PeminjamanApprovalController::class, 'signed.download'])
            ->name('signed.download');
    });


