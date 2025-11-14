<?php

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

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('/dashboard', 'dashboard');
});

