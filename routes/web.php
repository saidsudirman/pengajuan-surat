<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PengajuanSuratController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])
    ->name('login.admin');

Route::post('/login/admin', [AuthController::class, 'adminLogin'])
    ->name('login.admin.submit');

Route::get('/', [AuthController::class, 'showMahasiswaLogin'])
    ->name('login.mahasiswa');

Route::post('/login/mahasiswa', [AuthController::class, 'mahasiswaLogin'])
    ->name('login.mahasiswa.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('jenis-surats', JenisSuratController::class)
            ->except(['show']);

        Route::resource('mahasiswa', MahasiswaController::class);

        Route::resource('pengajuan-surats', PengajuanSuratController::class)
            ->only(['index', 'show', 'update']);
    });


Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.mahasiswa.dashboard');
        })->name('dashboard');

        Route::resource('pengajuan-surats', PengajuanSuratController::class)
            ->only([
                'index',
                'create',
                'store',
                'show',
            ]);
    });