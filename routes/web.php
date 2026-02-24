<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [Authcontroller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Authcontroller::class, 'authenticate'])->name('login.submit');
});

Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');

    // TAMBAH USER
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/user', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('admin.users.show');
    // EDIT USER
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('admin.users.update');
    // HAPUS USER
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
