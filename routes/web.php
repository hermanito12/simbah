<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Pengurus\NasabahController;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Pengurus\HargaSampahController;
use App\Http\Controllers\Pengurus\TransaksiController;
use App\Http\Controllers\Pengurus\PenarikanController;
use App\Http\Controllers\Pengurus\TabunganController;
use App\Http\Controllers\Nasabah\BukuSakuController;
use App\Http\Controllers\Pengurus\RekapController;
use App\Http\Controllers\Kelurahan\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect(match (auth()->user()->role) {
            'admin' => '/admin/dashboard',
            'pengurus' => '/pengurus/dashboard',
            'nasabah' => '/nasabah/dashboard',
            'kelurahan' => '/kelurahan/dashboard',
            default => '/login',
        });
    }
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('units', UnitController::class)->except(['show']);
    Route::resource('jenis-sampah', JenisSampahController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware(['auth', 'role:pengurus'])->prefix('pengurus')->name('pengurus.')->group(function () {
    Route::get('/dashboard', fn() => view('pengurus.dashboard'))->name('dashboard');
    Route::resource('nasabah', NasabahController::class)->except(['show']);
    Route::get('/harga', [HargaSampahController::class, 'index'])->name('harga.index');
    Route::get('/harga/create', [HargaSampahController::class, 'create'])->name('harga.create');
    Route::post('/harga', [HargaSampahController::class, 'store'])->name('harga.store');
    Route::get('/harga/{jenisSampah}/riwayat', [HargaSampahController::class, 'riwayat'])->name('harga.riwayat');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/nasabah/{nasabah}/tabungan', [TabunganController::class, 'index'])->name('tabungan.index');
    Route::get('/nasabah/{nasabah}/penarikan', [PenarikanController::class, 'create'])->name('penarikan.create');
    Route::post('/nasabah/{nasabah}/penarikan', [PenarikanController::class, 'store'])->name('penarikan.store');
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::post('/nasabah/{nasabah}/reset-password', [NasabahController::class, 'resetPassword'])->name('nasabah.reset-password');
});

Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/dashboard', [BukuSakuController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:kelurahan'])->prefix('kelurahan')->name('kelurahan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
