<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Dosen;
use App\Models\Bimbingan;
use App\Mail\TugasDikirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
    public function create($bimbinganId)
    {

        // Ambil data bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($bimbinganId);
        // Hitung jumlah tugas yang sudah ada
        $existingTasksCount = $bimbingan->tasks->count();

        // Cek apakah sudah ada 10 tugas
        if ($existingTasksCount >= 10) {
            return redirect()->back()->with('error', 'Jumlah tugas untuk bimbingan ini sudah mencapai batas maksimal 10 tugas.');
        }

        // Tampilkan form create task dengan data bimbingan
        return view('tasks.create', compact('bimbingan'));
    }
    public function edit($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Pastikan hanya mahasiswa yang memiliki akses


        return view('tasks.edit', compact('task'));
        // Redirect jika bukan mahasiswa terkait
        // return redirect()->route('tasks.show', ['taskId' => $taskId])->with('error', 'Anda tidak memiliki izin untuk mengedit tugas ini.');
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
        // Validasi input dari form
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_document' => 'url|max:255',
        ]);

        // Ambil data bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($bimbinganId);

        // Simpan task baru
        $task = new Task();
        $task->nama_tugas = $request->input('nama_tugas');
        $task->deskripsi = $request->input('deskripsi');
        $task->link_dokumen = $request->input('link_document');
        $task->bimbingan_id = $bimbingan->id_bimbingan;
        $task->dosen_pembimbing_1_id = $bimbingan->dosen_pembimbing_1;
        $task->dosen_pembimbing_2_id = $bimbingan->dosen_pembimbing_2;
        $task->bimbingan_id = $bimbingan->id_bimbingan;
        $task->status = 'dikerjakan';  // Status awal tugas, bisa disesuaikan
        $task->save();

        // Mengirimkan email ke dosen pembimbing 1
        $dosenPembimbing1 = $task->dospem1; // Ambil dosen pembimbing 1
        if ($dosenPembimbing1) {
            Mail::to($dosenPembimbing1->email)->send(new TugasDikirim($task));
        }

        // Mengirimkan email ke dosen pembimbing 2 jika ada
        $dosenPembimbing2 = $task->dosPem2; // Ambil dosen pembimbing 2
        if ($dosenPembimbing2) {
            Mail::to($dosenPembimbing2->email)->send(new TugasDikirim($task));
        }
        // Redirect ke halaman detail bimbingan dengan pesan sukses
        return redirect()->route('tasks.show', $task->id_task)
            ->with('success', 'Task berhasil ditambahkan.');
    }



    // Mengedit tugas (baik oleh mahasiswa maupun dosen)
    public function update(Request $request, $taskId)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string',
            // 'proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi file (opsional)
            'link_dokumen' => 'nullable|url', // Validasi URL (opsional)
        ]);

        // Ambil data tugas
        $task = Task::findOrFail($taskId);

        // Proses file upload jika ada
        // if ($request->hasFile('proposal')) {
        //     // Simpan file ke folder 'public/proposals'
        //     $path = $request->file('proposal')->store('proposals', 'public');
        //     // Simpan URL file ke kolom 'link_dokumen'
        //     $task->link_dokumen = asset('storage/' . $path);
        // }

        // Jika user hanya memasukkan link dokumen
        if ($request->filled('link_dokumen')) {
            $task->deskripsi = $request->input('deskripsi');
            $task->link_dokumen = $request->input('link_dokumen');
        }

        // Simpan perubahan ke database
        $task->save();

        $dosenPembimbing1 = $task->dospem1; // Ambil dosen pembimbing 1
        if ($dosenPembimbing1) {
            Mail::to($dosenPembimbing1->email)->send(new TugasDikirim($task));
        }

        // Mengirimkan email ke dosen pembimbing 2 jika ada
        $dosenPembimbing2 = $task->dosPem2; // Ambil dosen pembimbing 2
        if ($dosenPembimbing2) {
            Mail::to($dosenPembimbing2->email)->send(new TugasDikirim($task));
        }
        // Redirect ke halaman detail bimbingan dengan pesan sukses


        // Redirect dengan pesan sukses
        return redirect()->route('tasks.show', ['taskId' => $taskId])->with('success', 'Proposal berhasil diperbarui.');
    }


    public function accTask(Request $request, $taskId, $dosenId)
    {
        $task = Task::findOrFail($taskId);

        // Periksa apakah dosen sudah meng-ACC sebelumnya
        if (($dosenId == $task->dosen_pembimbing_1_id && $task->status_dospem_1 == 'disetujui') ||
            ($dosenId == $task->dosen_pembimbing_2_id && $task->status_dospem_2 == 'disetujui')
        ) {
            return redirect()->route('tasks.show', ['taskId' => $taskId])
                ->with('error', 'Anda sudah meng-ACC tugas ini sebelumnya.');
        }

        // Tentukan status yang akan diperbarui sesuai dosen
        if ($dosenId == $task->dosen_pembimbing_1_id) {
            $task->status_dospem_1 = 'disetujui';  // Tandai dospem 1 sebagai disetujui
        } elseif ($dosenId == $task->dosen_pembimbing_2_id) {
            $task->status_dospem_2 = 'disetujui';  // Tandai dospem 2 sebagai disetujui
        }

        // Periksa apakah kedua dosen sudah menyetujui
        if ($task->status_dospem_1 == 'disetujui' && $task->status_dospem_2 == 'disetujui') {
            $task->status = 'selesai';  // Jika kedua dosen setuju, ubah status tugas menjadi selesai
        }

        $task->save();

        // Kirim pesan sukses dengan nama dosen yang meng-ACC
        $dosenName = ($dosenId == $task->dosen_pembimbing_1_id) ? 'Dosen Pembimbing 1' : 'Dosen Pembimbing 2';
        return redirect()->route('tasks.show', ['taskId' => $taskId])
            ->with('success', "Tugas berhasil di-ACC oleh {$dosenName}.");
    }

    public function revisiTask(Request $request, $taskId, $dosenId)
    {
        $task = Task::findOrFail($taskId);

        // Ambil nama dosen dari model User atau model lain
        $dosen = Dosen::findOrFail($dosenId);

        $revisiBaru = [
            'komentar' => $request->komentar,
            'waktu' => now(),
            'link_dokumen' => $request->link_dokumen,
            'dosen' => [
                'id' => $dosenId,
                'nama' => $dosen->nama, // Misalnya 'name' adalah kolom nama dosen
                'peran' => $dosenId == $task->dosen_pembimbing_1_id ? 'Dosen Pembimbing 1' : 'Dosen Pembimbing 2',
            ],
        ];

        // Tambahkan revisi baru ke array revisi yang sudah ada
        $task->revisi = array_merge($task->revisi ?? [], [$revisiBaru]);

        if ($dosenId == $task->dosen_pembimbing_1_id) {
            $task->status_dospem_1 = 'revisi';
        } elseif ($dosenId == $task->dosen_pembimbing_2_id) {
            $task->status_dospem_2 = 'revisi';
        }

        $task->save();

        return redirect()->route('tasks.show', ['taskId' => $taskId])->with('error', 'Tugas memerlukan revisi');
    }
}
