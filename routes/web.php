<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\MahasiswaController;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (default)
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute Profile (Semua user yang login bisa mengakses)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// AUTHENTICATION AND ROLE BASED ROUTES

// Rute untuk Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dashboard/dosen', [DosenController::class, 'index'])->name('dashboard.dosen');
    Route::get('/dosen/{dosen}/skripsi', [DosenController::class, 'dosenSkripsi'])->name('dosen.skripsi');
});

// Rute untuk Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'mahasiswa'])->name('dashboard.mahasiswa');
    Route::get('/mahasiswa/skripsi', [SkripsiController::class, 'index'])->name('skripsi.create');
    Route::post('/mahasiswa/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/admin/mahasiswa', [AdminController::class, 'listMahasiswa'])->name('admin.mahasiswa');
    Route::get('/admin/dosen', [AdminController::class, 'listDosen'])->name('admin.dosen');
    Route::get('/admin/skripsi', [AdminController::class, 'listSkripsi'])->name('admin.skripsi.index');
    Route::get('/admin/skripsi/approve/{id_skripsi}', [AdminController::class, 'approveSkripsi'])->name('admin.skripsi.approve');
    Route::get('/admin/skripsi/reject/{id_skripsi}', [AdminController::class, 'rejectSkripsi'])->name('admin.skripsi.reject');

    // Rute untuk mengedit mahasiswa
    Route::get('/admin/mahasiswa/edit/{id}', [AdminController::class, 'editMahasiswa'])->name('admin.mahasiswa.edit');

    // Rute untuk menghapus mahasiswa
    Route::get('/admin/mahasiswa/delete/{id}', [AdminController::class, 'deleteMahasiswa'])->name('admin.mahasiswa.delete');
});

// Untuk menangani route lainnya, misalnya Skripsi yang diajukan oleh Mahasiswa ke Dosen
Route::middleware(['auth'])->group(function () {
    // Menambahkan beberapa route yang membutuhkan akses autentikasi tetapi tidak terikat dengan role
    // Jika ada route lain yang ingin diakses oleh semua role yang sudah terverifikasi
    // Route::get('/path', [Controller::class, 'method']);
});

// Route untuk menampilkan bimbingan berdasarkan id_skripsi
Route::get('bimbingan/{id_skripsi}', [BimbinganController::class, 'index'])->name('bimbingan.index');

// Route untuk melihat detail bimbingan dan status task
Route::get('bimbingan/show/{id_bimbingan}', [BimbinganController::class, 'show'])->name('bimbingan.show');

// Route untuk mengupdate status bimbingan dan task
Route::post('bimbingan/update/{id_bimbingan}', [BimbinganController::class, 'update'])->name('bimbingan.update');

// Route untuk meng-upload link file dan memilih task
Route::post('bimbingan/upload/{id_bimbingan}', [BimbinganController::class, 'uploadLink'])->name('bimbingan.uploadLink');

require __DIR__ . '/auth.php';
