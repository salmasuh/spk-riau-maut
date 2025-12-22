<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/reset-password', [ResetPasswordController::class, 'showForm'])->name('password.reset.form');
Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.reset.update');
Route::get('/check-username', [ResetPasswordController::class, 'checkUsername'])->name('password.check-username');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔹 Administrator – akses penuh
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('kriteria', KriteriaController::class)
            ->parameters(['kriteria' => 'kriteria']);
        Route::resource('subkriteria', SubKriteriaController::class)
            ->parameters(['subkriteria' => 'subkriteria']);
        Route::resource('penilaian', PenilaianController::class)->except(['show']);
        Route::get('penilaian/manage/{jalan}', [PenilaianController::class, 'manageByJalan'])
            ->name('penilaian.manage');

        Route::get('jalan', [JalanController::class, 'index'])
            ->name('jalan.index');

        Route::get('jalan/create', [JalanController::class, 'create'])
            ->name('jalan.create');
        Route::post('jalan', [JalanController::class, 'store'])
            ->name('jalan.store');

        Route::get('jalan/{jalan}/edit', [JalanController::class, 'edit'])
            ->name('jalan.edit');
        Route::put('jalan/{jalan}', [JalanController::class, 'update'])
            ->name('jalan.update');
        Route::delete('jalan/{jalan}', [JalanController::class, 'destroy'])
            ->name('jalan.destroy');

        Route::get('jalan/import', [JalanController::class, 'importForm'])
            ->name('jalan.import.form');

        Route::post('jalan/import', [JalanController::class, 'import'])
            ->name('jalan.import');

    });

    // 🔹 Staf Lapangan – kelola jalan, input penilaian, lihat hasil
    Route::middleware([RoleMiddleware::class . ':staf'])->group(function () {
        Route::get('jalan', [JalanController::class, 'index'])
            ->name('jalan.index');

        Route::get('jalan/create', [JalanController::class, 'create'])
            ->name('jalan.create');
        Route::post('jalan', [JalanController::class, 'store'])
            ->name('jalan.store');

        Route::get('jalan/{jalan}/edit', [JalanController::class, 'edit'])
            ->name('jalan.edit');
        Route::put('jalan/{jalan}', [JalanController::class, 'update'])
            ->name('jalan.update');
        Route::delete('jalan/{jalan}', [JalanController::class, 'destroy'])
            ->name('jalan.destroy');

        Route::get('jalan/import', [JalanController::class, 'importForm'])
            ->name('jalan.import.form');

        Route::post('jalan/import', [JalanController::class, 'import'])
            ->name('jalan.import');

        Route::resource('penilaian', PenilaianController::class)->except(['show']);
        Route::get('penilaian/manage/{jalan}', [PenilaianController::class, 'manageByJalan'])
            ->name('penilaian.manage');

    });

    // 🔹 Pimpinan – hanya dashboard & hasil
    Route::middleware([RoleMiddleware::class . ':admin,staf,pimpinan'])->group(function () {
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/export', [HasilController::class, 'exportPdf'])->name('hasil.export');
});

    // 🔹 Logout (bisa semua role karena sudah login)
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
});