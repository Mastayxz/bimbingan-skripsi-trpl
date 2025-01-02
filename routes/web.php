<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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
    // return view('dashboard.dashboard');
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
    Route::get('/dosen/skripsi', [DosenController::class, 'daftarSkripsi'])->name('skripsi.index');
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




Route::middleware('auth')->group(function () {
    // Mahasiswa membuat task
    Route::post('/tasks/{bimbinganId}', [TaskController::class, 'store'])->name('tasks.store');

    // Dosen memberikan feedback
    Route::put('/tasks/{taskId}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/bimbingan/{bimbingan_id}', [BimbinganController::class, 'show'])->name('bimbingans.show');
    // routes/web.php
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
});

require __DIR__ . '/auth.php';
