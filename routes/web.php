<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\Marketing\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [Authcontroller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Authcontroller::class, 'authenticate'])->name('login.submit');
});

Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'role:Admin'])->group(function () {

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

    Route::prefix('satuan')->group(function () {
        Route::get('/', [SatuanController::class, 'index'])->name('admin.satuan.index');
        Route::post('/', [SatuanController::class, 'store'])->name('admin.satuan.store');
        Route::put('/{satuan}', [SatuanController::class, 'update'])->name('admin.satuan.update');
        Route::delete('/{satuan}', [SatuanController::class, 'destroy'])->name('admin.satuan.destroy');
    });

    
    });
    Route::middleware(['auth', 'role:Marketing'])->prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // ========== PESANAN ==========
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
        Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
        Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::get('/pesanan/client/{client}', [PesananController::class, 'byClient'])->name('pesanan.by-client');
        Route::get('/pesanan/{pesanan}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
        Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
        Route::get('/get-barang-by-kategori/{kategoriId}', [PesananController::class, 'getBarangByKategori'])->name('get.barang.kategori');
        Route::get('/get-barang-by-jenis/{jenisId}', [PesananController::class, 'getBarangByJenis'])->name('get.barang.jenis');

        // ========== CLIENTS ==========
        Route::get('/clients', [\App\Http\Controllers\Marketing\ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/create', [\App\Http\Controllers\Marketing\ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [\App\Http\Controllers\Marketing\ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}', [\App\Http\Controllers\Marketing\ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{client}/edit', [\App\Http\Controllers\Marketing\ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [\App\Http\Controllers\Marketing\ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [\App\Http\Controllers\Marketing\ClientController::class, 'destroy'])->name('clients.destroy');

        // ========== KATEGORI ==========
        Route::get('/kategori', [\App\Http\Controllers\Marketing\KategoryController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [\App\Http\Controllers\Marketing\KategoryController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [\App\Http\Controllers\Marketing\KategoryController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [\App\Http\Controllers\Marketing\KategoryController::class, 'destroy'])->name('kategori.destroy');

        // ========== JENIS ==========
        Route::get('/jenis', [\App\Http\Controllers\Marketing\JenisController::class, 'index'])->name('jenis.index');
        Route::post('/jenis', [\App\Http\Controllers\Marketing\JenisController::class, 'store'])->name('jenis.store');
        Route::put('/jenis/{jeni}', [\App\Http\Controllers\Marketing\JenisController::class, 'update'])->name('jenis.update');
        Route::delete('/jenis/{jeni}', [\App\Http\Controllers\Marketing\JenisController::class, 'destroy'])->name('jenis.destroy');

        // ========== SATUAN ==========
        Route::get('/satuan', [\App\Http\Controllers\Marketing\SatuanController::class, 'index'])->name('satuan.index');
        Route::post('/satuan', [\App\Http\Controllers\Marketing\SatuanController::class, 'store'])->name('satuan.store');
        Route::put('/satuan/{satuan}', [\App\Http\Controllers\Marketing\SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/satuan/{satuan}', [\App\Http\Controllers\Marketing\SatuanController::class, 'destroy'])->name('satuan.destroy');

        // ========== BARANG ==========
        Route::get('/barang', [\App\Http\Controllers\Marketing\BarangController::class, 'index'])->name('barang.index');
        Route::post('/barang', [\App\Http\Controllers\Marketing\BarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/{barang}', [\App\Http\Controllers\Marketing\BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}', [\App\Http\Controllers\Marketing\BarangController::class, 'destroy'])->name('barang.destroy');
        Route::get('/get-jenis-by-kategori/{kategoriId}', [\App\Http\Controllers\Marketing\BarangController::class, 'getJenisByKategori'])->name('get.jenis.kategori');
        
    });
    