<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Skripsi;
use App\Models\Bimbingan;
use App\Models\ProposalSkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    //
    // Dashboard untuk mahasiswa
    // Buat agar di dashboard tu bisa nampilin nama skrispi,prgres bimgingan dan nama pembimbing
    public function mahasiswa()
    {
        // Ambil data user yang sedang login
        $user = Auth::user()->mahasiswa;

        // Ambil skripsi yang terkait dengan mahasiswa yang sedang login
        $skripsi = Skripsi::where('mahasiswa', $user->id)->get();
        $proposals = ProposalSkripsi::where('id_mahasiswa', $user->id)->get();

        // Ambil bimbingan yang terkait dengan mahasiswa
        $bimbingans = Bimbingan::where('mahasiswa_id', $user->id)
            ->with(['skripsi', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->get();

        // Inisialisasi progres
        $progress = 0;

        // Hitung progres hanya jika ada bimbingan
        if ($bimbingans->isNotEmpty()) {
            // Ambil tugas-tugas yang terkait dengan bimbingan
            $tasks = Task::whereIn('bimbingan_id', $bimbingans->pluck('id_bimbingan'))->get();

            // Hitung jumlah tugas yang disetujui
            $approvedTasksCount = $tasks->where('status', 'disetujui')->count();

            // Hitung jumlah total tugas
            $totalTasksCount = $tasks->count();

            // Hitung progres
            $progress = ($totalTasksCount > 0) ? ($approvedTasksCount / $totalTasksCount) * 100 : 0;
        }

        // Kirim data skripsi dan progress ke view
        return view('dashboard.mahasiswa', compact('skripsi', 'progress', 'proposals'));
    }
}
