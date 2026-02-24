<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [Authcontroller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Authcontroller::class, 'authenticate'])->name('login.submit');
});

Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::prefix('user')->group(function () {;
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientsController::class, 'index'])->name('admin.clients.index');
        Route::get('/create', [ClientsController::class, 'create'])->name('admin.clients.create');
        Route::post('/', [ClientsController::class, 'store'])->name('admin.clients.store');
        Route::get('/{client}', [ClientsController::class, 'show'])->name('admin.clients.show');
        Route::get('/{client}/edit', [ClientsController::class, 'edit'])->name('admin.clients.edit');
        Route::put('/{client}', [ClientsController::class, 'update'])->name('admin.clients.update');
        Route::delete('/{client}', [ClientsController::class, 'destroy'])->name('admin.clients.destroy');
    });

    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoryController::class, 'index'])->name('admin.kategori.index');
        Route::post('/', [KategoryController::class, 'store'])->name('admin.kategori.store');
        Route::put('/{kategori}', [KategoryController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/{kategori}', [KategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    Route::prefix('jenis')->group(function () {
        Route::get('/', [JenisController::class, 'index'])->name('admin.jenis.index');
        Route::post('/', [JenisController::class, 'store'])->name('admin.jenis.store');
        Route::put('/{jeni}', [JenisController::class, 'update'])->name('admin.jenis.update');
        Route::delete('/{jeni}', [JenisController::class, 'destroy'])->name('admin.jenis.destroy');
    });

    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('admin.barang.index');
        Route::post('/', [BarangController::class, 'store'])->name('admin.barang.store');
        Route::put('/{barang}', [BarangController::class, 'update'])->name('admin.barang.update');
        Route::delete('/{barang}', [BarangController::class, 'destroy'])->name('admin.barang.destroy');
        Route::get('/get-jenis/{kategoriId}', [BarangController::class, 'getJenisByKategori'])->name('get.jenis');
    });

    Route::prefix('ekspedisi')->group(function () {
        Route::get('/', [EkspedisiController::class, 'index'])->name('admin.ekspedisi.index');
        Route::get('/create', [EkspedisiController::class, 'create'])->name('admin.ekspedisi.create');
        Route::post('/', [EkspedisiController::class, 'store'])->name('admin.ekspedisi.store');
        Route::get('/{ekspedisi}', [EkspedisiController::class, 'show'])->name('admin.ekspedisi.show');
        Route::get('/{ekspedisi}/edit', [EkspedisiController::class, 'edit'])->name('admin.ekspedisi.edit');
        Route::put('/{ekspedisi}', [EkspedisiController::class, 'update'])->name('admin.ekspedisi.update');
        Route::delete('/{ekspedisi}', [EkspedisiController::class, 'destroy'])->name('admin.ekspedisi.destroy');
    });

});
















// ALTERNATIVE ROUTE DEFINITIONS USING RESOURCE CONTROLLERS (BELUM DI UJI COBA, TAPI SEHARUSNYA BERFUNGSI SAMA)
// Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('users', UserController::class);
//     Route::resource('clients', ClientsController::class);
//     Route::resource('kategori', KategoryController::class);
//     Route::resource('jenis', JenisController::class);
//     Route::resource('barang', BarangController::class);
//     Route::resource('ekspedisi', EkspedisiController::class); 
// });