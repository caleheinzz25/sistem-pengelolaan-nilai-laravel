<?php

use App\Http\Controllers\Api\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Api\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Api\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ============================================================
// AUTH
// ============================================================
Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');

    // ============================================================
    // ADMIN
    // ============================================================
    Route::middleware('role:admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::apiResource('siswa', AdminSiswaController::class);
        Route::apiResource('guru', AdminGuruController::class);
        Route::apiResource('nilai', AdminNilaiController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{siswa}', [LaporanController::class, 'show'])->name('laporan.show');
    });

    // ============================================================
    // GURU
    // ============================================================
    Route::middleware('role:guru')->prefix('guru')->name('api.guru.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
        Route::get('/rekap', [GuruController::class, 'rekap'])->name('rekap');
        Route::post('/input-nilai', [GuruController::class, 'storeNilai'])->name('input-nilai');
    });

    // ============================================================
    // SISWA
    // ============================================================
    Route::middleware('role:siswa')->prefix('siswa')->name('api.siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    });
});
