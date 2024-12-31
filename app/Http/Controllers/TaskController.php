<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Menampilkan daftar tugas untuk bimbingan tertentu
    public function index($bimbingan_id)
    {
        $bimbingan = Bimbingan::findOrFail($bimbingan_id);
        $tasks = $bimbingan->tasks;

        return view('tasks.index', compact('bimbingan', 'tasks'));
    }

    // Menampilkan detail tugas
    public function show($taskId)
    {
        $task = Task::findOrFail($taskId);

        return view('tasks.show', compact('task'));
    }

    // Menambahkan tugas baru oleh mahasiswa
    public function store(Request $request, $bimbinganId)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_mahasiswa' => 'required|file|mimes:pdf,doc,docx,zip|max:2048',
        ]);

        $filePath = $request->file('file_mahasiswa')->store('tasks');

        Task::create([
            'bimbingan_id' => $bimbinganId,
            'nama_tugas' => $request->nama_tugas,
            'deskripsi' => $request->deskripsi,
            'file_mahasiswa' => $filePath,
            // 'status' => 'menunggu persetujuan',
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Mengedit tugas (baik oleh mahasiswa maupun dosen)
    public function update(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        // Simpan riwayat revisi sebelum memperbarui
        $revisiData = [
            'status' => $task->status,
            'komentar_dosen' => $task->komentar_dosen,
            'updated_at' => now(),
        ];

        $task->revisi = array_merge($task->revisi ?? [], [$revisiData]);

        // Perbarui tugas berdasarkan role pengguna
        if ($request->has('file_mahasiswa')) {
            $request->validate([
                'file_mahasiswa' => 'file|mimes:pdf,doc,docx,zip|max:2048',
            ]);

            // Hapus file lama
            if ($task->file_mahasiswa && Storage::exists($task->file_mahasiswa)) {
                Storage::delete($task->file_mahasiswa);
            }

            $filePath = $request->file('file_mahasiswa')->store('tasks');
            $task->file_mahasiswa = $filePath;
        }

        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:disetujui,sedang direvisi,menunggu persetujuan',
                'komentar_dosen' => 'nullable|string',
            ]);

            $task->status = $request->status;
            $task->komentar_dosen = $request->komentar_dosen;
        }

        if ($request->has('nama_tugas')) {
            $task->nama_tugas = $request->nama_tugas;
        }

        if ($request->has('deskripsi')) {
            $task->deskripsi = $request->deskripsi;
        }

        $task->save();

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui!');
    }
}
