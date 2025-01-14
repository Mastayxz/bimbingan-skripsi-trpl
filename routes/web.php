<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\SinkronisasiController;
use App\Models\Dosen;

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
    Route::get('/dosen/proposal', [DosenController::class, 'daftarProposal'])->name('dosen.proposal.index');
    Route::put('/dosen/proposal/approve/{id_proposal}', [DosenController::class, 'approveProposal'])->name('dosen.proposal.approve');
    Route::put('/dosen/proposal/reject/{id_proposal}', [DosenController::class, 'rejectProposal'])->name('dosen.proposal.reject');
    Route::get('/dosen/proposal/detail/{id_proposal}', [ProposalController::class, 'showDetail'])->name('dosen.proposal.detail');
    Route::get('/dosen/proposal/detail/{id_proposal}', [ProposalController::class, 'showDetail'])->name('dosen.proposal.detail');
    Route::post('/dosen/proposal/ujian/{id_proposal}', [ProposalController::class, 'ujianProposal'])->name('dosen.proposal.ujian');
    Route::post('/proposals/{id}/add-comment', [DosenController::class, 'addComment'])->name('proposals.addComment');
});



// Rute untuk Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'mahasiswa'])->name('dashboard.mahasiswa');
    Route::get('/mahasiswa/skripsi', [SkripsiController::class, 'index'])->name('skripsi.create');
    Route::post('/mahasiswa/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/proposal', [ProposalController::class, 'store'])->name('proposal.store');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/admin/mahasiswa', [AdminController::class, 'listMahasiswa'])->name('admin.mahasiswa');
    Route::get('/admin/dosen', [AdminController::class, 'listDosen'])->name('admin.dosen');
    Route::get('/admin/skripsi', [AdminController::class, 'listSkripsi'])->name('admin.skripsi.index');
    Route::get('/admin/proposal', [AdminController::class, 'listProposal'])->name('admin.Proposal.index');

    // create bimbingan dari skripsi lulus ujian
    Route::get('/admin/skripsi/approve/{id_skripsi}', [AdminController::class, 'approveSkripsi'])->name('admin.skripsi.approve');
    Route::get('/admin/skripsi/reject/{id_skripsi}', [AdminController::class, 'rejectSkripsi'])->name('admin.skripsi.reject');


    // Rute untuk manage mahasiswa
    Route::get('/admin/mahasiswa/edit/{id}', [AdminController::class, 'editMahasiswa'])->name('admin.mahasiswa.edit');
    Route::get('/admin/mahasiswa/delete/{id}', [AdminController::class, 'deleteMahasiswa'])->name('admin.mahasiswa.delete');

    // Rute untuk manage dosen
    Route::get('/admin/dosen/edit/{id}', [AdminController::class, 'editDosen'])->name('admin.dosen.edit');
    Route::post('/admin/dosen/update/{id}', [AdminController::class, 'updateDosen'])->name('admin.dosen.update');
    Route::get('/admin/dosen/delete/{id}', [AdminController::class, 'deleteDosen'])->name('admin.dosen.delete');

    // Rute untuk manage Skripsi
    Route::get('/admin/skripsi/edit/{id}', [SkripsiController::class, 'edit'])->name('admin.skripsi.edit');
    Route::post('/admin/skripsi/update/{id}', [SkripsiController::class, 'editDosenPembimbing'])->name('admin.skripsi.update');
    Route::post('/admin/dosen/{dosenId}/make-admin', [AdminController::class, 'makeAdmin'])->name('dosen.makeAdmin');

    Route::post('/sync-mahasiswa', [SinkronisasiController::class, 'syncMahasiswa'])->name('sync.mahasiswa');
    Route::post('/sync-dosen', [SinkronisasiController::class, 'syncDosen'])->name('sync.dosen');
    Route::get('mahasiswa/search', [AdminController::class, 'searchMahasiswa'])->name('mahasiswa.index');
    Route::get('dosen/search', [AdminController::class, 'searchDosen'])->name('dosen.search');
    Route::get('skripsi/search', [AdminController::class, 'searchSkripsi'])->name('skripsi.search');
    Route::get('proposal/search', [AdminController::class, 'searchProposal'])->name('proposal.search');
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
Route::prefix('api')  // Menambahkan prefix "api"
    ->middleware('api')  // Menambahkan middleware API
    ->group(function () {
        Route::get('/proposals/ujian', [ProposalController::class, 'getAllProposalUjian']);
    });

require __DIR__ . '/auth.php';
