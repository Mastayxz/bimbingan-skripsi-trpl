<?php

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;
use Database\Factories\MahasiswaFactory;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['role:mahasiswa'])->group(function () {
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'index'])->name('dashboard.mahasiswa');
});

// // Untuk dosen
// Route::middleware(['role:dosen'])->group(function () {
//     Route::get('/dashboard/dosen', [DashboardDosenController::class, 'index'])->name('dashboard.dosen');
// });

Route::middleware(['auth'])->group(function () {
    // Dashboard untuk mahasiswa
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'mahasiswa'])->name('dashboard.mahasiswa');

    // Dashboard untuk dosen
    Route::get('/dashboard/dosen', [MahasiswaController::class, 'dosen'])->name('dashboard.dosen');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboardadmin', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/mahasiswa', [AdminController::class, 'listMahasiswa'])->name('admin.mahasiswa');
    Route::get('/dosen', [AdminController::class, 'listDosen'])->name('admin.dosen');
    Route::get('/skripsi', [AdminController::class, 'listSkripsi'])->name('admin.skripsi');
})->name('dashboard.admin');



Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    Route::get('/skripsi', [SkripsiController::class, 'create'])->name('skripsi.create');
    Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
});
