<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Skripsi;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    // Tampilkan daftar sesi bimbingan
    public function index()
    {
        $user = Auth::user();

        if ($user->mahasiswa) { // Jika user adalah mahasiswa
            $bimbingans = Bimbingan::where('mahasiswa_id', $user->mahasiswa->id)
                ->with(['skripsi', 'dosenPembimbing1', 'dosenPembimbing2'])
                ->get();
        } elseif ($user->dosen) { // Jika user adalah dosen
            $bimbingans = Bimbingan::with(['skripsi', 'mahasiswaBimbingan'])
                ->where('dosen_pembimbing_1', $user->dosen->id)
                ->orWhere('dosen_pembimbing_2', $user->dosen->id)
                ->get();
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('bimbingan.index', compact('bimbingans'));
    }


    public function show($bimbingan_id)
    {
        $user = Auth::user();
        $tasks = Task::where('bimbingan_id', $bimbingan_id)->get();

        // Query bimbingan dengan relasi yang diperlukan
        $bimbingan = Bimbingan::with(['tasks', 'skripsi', 'mahasiswaBimbingan', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->findOrFail($bimbingan_id);

        // Validasi akses untuk mahasiswa
        if ($user->mahasiswa && $bimbingan->mahasiswa_id === $user->mahasiswa->id) {
            $tasks = $bimbingan->tasks;
        }
        // Validasi akses untuk dosen
        elseif ($user->dosen && ($bimbingan->dosen_pembimbing_1 === $user->dosen->id || $bimbingan->dosen_pembimbing_2 === $user->dosen->id)) {
            $tasks = $bimbingan->tasks;
        } else {
            // Jika bukan mahasiswa atau dosen terkait, tolak akses
            abort(403, 'Unauthorized access.');
        }

        // Hitung progress berdasarkan task yang selesai
        $completedTasks = $tasks->where('status', 'disetujui')->count();
        $totalTasks = $tasks->count();
        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        return view('bimbingan.show', compact('bimbingan', 'tasks', 'progress'));
    }
}
