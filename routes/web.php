<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengajuanSuratController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuanController;
use App\Http\Controllers\Mahasiswa\ProfilController as MahasiswaProfilController;

Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'adminLogin'])->name('login.admin.submit');
Route::get('/', [AuthController::class, 'showMahasiswaLogin'])->name('login.mahasiswa');
Route::post('/login/mahasiswa', [AuthController::class, 'mahasiswaLogin'])->name('login.mahasiswa.submit');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('jenis-surats', JenisSuratController::class)->except(['show']);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('pengajuan-surats', PengajuanSuratController::class)->only(['index', 'show', 'update']);
    });

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [MahasiswaPengajuanController::class, 'index'])->name('index');
            Route::get('/create', [MahasiswaPengajuanController::class, 'create'])->name('create');
            Route::post('/', [MahasiswaPengajuanController::class, 'store'])->name('store');
            Route::get('/{pengajuan}', [MahasiswaPengajuanController::class, 'show'])->name('show');
            Route::delete('/{pengajuan}/cancel', [MahasiswaPengajuanController::class, 'cancel'])->name('cancel');
            Route::get('/{pengajuan}/download', [MahasiswaPengajuanController::class, 'download'])->name('download');
        });

        Route::get('/profil', [MahasiswaProfilController::class, 'index'])->name('profil');
        Route::put('/profil', [MahasiswaProfilController::class, 'update'])->name('profil.update');
        Route::put('/profil/password', [MahasiswaProfilController::class, 'updatePassword'])->name('profil.password');

        Route::get('/panduan', fn() => view('mahasiswa.panduan'))->name('panduan');
    });