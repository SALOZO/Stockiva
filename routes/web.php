<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\ClientsController;
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

});
