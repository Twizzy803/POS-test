<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    //* Admin
    Route::middleware('can:access-admin')
        ->prefix('admin')
        ->name('admin.') // Menegaskan bahwa semua rute di dalam wajib diawali 'admin.'
        ->group(function () {

            // Tulis nama lengkapnya secara tegas di sini untuk menghindari bug penamaan
            Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

            // CRUD Master Kategori & Produk
            Route::resource('categories', CategoryController::class);
            Route::resource('products', ProductController::class);
        });

    //* Kasir
    Route::middleware('can:access-kasir')
        ->prefix('kasir')
        ->name('kasir.')
        ->group(function () {
            Route::get('/order', [TransactionController::class, 'create'])->name('order');
            Route::post('/order', [TransactionController::class, 'store']);
            Route::get('/history', [TransactionController::class, 'history'])->name('history');
        });
});
