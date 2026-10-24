<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Inventory Management System (Pertemuan 5)
|--------------------------------------------------------------------------
*/

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// Authenticated Routes (Route Grouping, Slide 16)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Controller Products (Slide 18)
    Route::resource('products', ProductController::class);

    // Resource Controller Categories & Suppliers
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('suppliers', SupplierController::class)->except(['show']);

    // Stock Movement Routes (Barang Masuk, Barang Keluar, Riwayat Mutasi)
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/in', [StockController::class, 'createIn'])->name('in');
        Route::post('/in', [StockController::class, 'storeIn'])->name('in.store');
        Route::get('/out', [StockController::class, 'createOut'])->name('out');
        Route::post('/out', [StockController::class, 'storeOut'])->name('out.store');
        Route::get('/history', [StockController::class, 'history'])->name('history');
    });

    // Reports (Laporan Agregasi SQL)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // User Management (Admin Only, Slide 24)
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
});
