<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    // Menampilkan halaman untuk menambahkan bimbingan
    /**
     * Menampilkan daftar bimbingan untuk mahasiswa berdasarkan id_skripsi.
     */
    public function index($id_skripsi)
    {
        // Mendapatkan semua bimbingan berdasarkan skripsi
        $bimbingans = Bimbingan::where('id_skripsi', $id_skripsi)->get();

        return view('bimbingan.index', compact('bimbingans'));
    }

    /**
     * Menampilkan form untuk mengupdate status bimbingan atau task.
     */
    public function show($id_bimbingan)
    {
        // Mendapatkan bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($id_bimbingan);

        return view('bimbingan.show', compact('bimbingan'));
    }

    /**
     * Mengupdate status bimbingan atau task.
     */
    public function update(Request $request, $id_bimbingan)
    {
        // Validasi input
        $request->validate([
            'status_bimbingan' => 'required|in:sedang berjalan,selesai', // Status bimbingan
            'status_task' => 'required|in:belum_dikerjakan,sedang_dikerjakan,selesai', // Status task
        ]);

        // Menemukan bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($id_bimbingan);

        // Mengupdate status bimbingan dan status task
        $bimbingan->update([
            'status_bimbingan' => $request->status_bimbingan, // Mengupdate status bimbingan
            'status_task' => $request->status_task, // Mengupdate status task
        ]);

        // Memperbarui status bimbingan berdasarkan status task
        $bimbingan->updateStatusBimbingan();

        return redirect()->route('bimbingan.index', ['id_skripsi' => $bimbingan->id_skripsi])
            ->with('success', 'Status bimbingan dan task berhasil diperbarui');
    }

    /**
     * Menangani upload link file dan tugas yang sedang dikerjakan
     */
    public function uploadLink(Request $request, $id_bimbingan)
    {
        // Validasi input link file dan task name
        $request->validate([
            'link_file' => 'required|url', // Validasi link file
            'task_name' => 'required|string', // Nama task/bab skripsi
        ]);

        // Menemukan bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($id_bimbingan);

        // Mengupdate link file, task name, dan status task
        $bimbingan->update([
            'link_file' => $request->link_file, // Link file yang di-upload mahasiswa
            'task_name' => $request->task_name, // Nama task yang dikerjakan
            'status_task' => 'sedang_dikerjakan', // Mengupdate status task menjadi sedang dikerjakan
        ]);

        // Memperbarui status bimbingan berdasarkan status task
        $bimbingan->updateStatusBimbingan();

        return redirect()->route('bimbingan.show', ['id_bimbingan' => $bimbingan->id_bimbingan])
            ->with('success', 'Link file dan task berhasil di-upload');
    }
}
