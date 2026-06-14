<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================
// AUTH ROUTES
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Siswa
    Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('siswa.index');
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('siswa.create');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [AdminController::class, 'editSiswa'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [AdminController::class, 'destroySiswa'])->name('siswa.destroy');

    // Guru
    Route::get('/guru', [AdminController::class, 'indexGuru'])->name('guru.index');
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('guru.create');
    Route::post('/guru', [AdminController::class, 'storeGuru'])->name('guru.store');
    Route::get('/guru/{guru}/edit', [AdminController::class, 'editGuru'])->name('guru.edit');
    Route::put('/guru/{guru}', [AdminController::class, 'updateGuru'])->name('guru.update');
    Route::delete('/guru/{guru}', [AdminController::class, 'destroyGuru'])->name('guru.destroy');

    // Nilai
    Route::get('/nilai', [AdminController::class, 'indexNilai'])->name('nilai.index');
    Route::get('/nilai/create', [AdminController::class, 'createNilai'])->name('nilai.create');
    Route::post('/nilai', [AdminController::class, 'storeNilai'])->name('nilai.store');
    Route::get('/nilai/{nilai}/edit', [AdminController::class, 'editNilai'])->name('nilai.edit');
    Route::put('/nilai/{nilai}', [AdminController::class, 'updateNilai'])->name('nilai.update');
    Route::delete('/nilai/{nilai}', [AdminController::class, 'destroyNilai'])->name('nilai.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{siswa}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan-print', [LaporanController::class, 'print'])->name('laporan.print');
});

// ============================================================
// GURU ROUTES
// ============================================================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/rekap', [GuruController::class, 'rekapNilai'])->name('rekap');
    Route::get('/input-nilai', [GuruController::class, 'formInputNilai'])->name('input-nilai');
    Route::post('/input-nilai', [GuruController::class, 'storeNilai'])->name('store-nilai');
});

// ============================================================
// SISWA ROUTES
// ============================================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
});

// ============================================================
// ROOT
// ============================================================
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});
