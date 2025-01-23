<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Skripsi;
use App\Models\PenilaianBimbingan;
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
                ->paginate(6);
        } elseif ($user->dosen) { // Jika user adalah dosen
            $bimbingans = Bimbingan::with(['skripsi', 'mahasiswaBimbingan'])
                ->where('dosen_pembimbing_1', $user->dosen->id)
                ->orWhere('dosen_pembimbing_2', $user->dosen->id)
                ->paginate(6);
        } else {
            abort(403, 'Unauthorized access.');
        }
        // $query = Bimbingan::query();
        // Pagination 6 item per halaman
        // $query = Bimbingan::query();
        // Pagination 6 item per halaman
        return view('bimbingan.index', compact('bimbingans'));
    }


    public function show($bimbingan_id)
    {
        $user = Auth::user();
        $tasks = Task::where('bimbingan_id', $bimbingan_id)->get();
        $penilaian = PenilaianBimbingan::where('bimbingan_id', $bimbingan_id)
            ->where('dosen_id', optional($user->dosen)->id)
            ->first();
        // Query bimbingan dengan relasi yang diperlukan
        $bimbingan = Bimbingan::with(['tasks', 'skripsi', 'mahasiswaBimbingan', 'dosenPembimbing1', 'dosenPembimbing2', 'penilaian'])
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

        $tasksInProgress = $bimbingan->tasks->where('status', 'dikerjakan')->count();

        // Hitung jumlah tugas yang selesai
        $completedTasks = $tasks->where('status', 'selesai')->count();

        // Hitung total tugas
        $totalTasks = $tasks->count();

        // Tentukan progress
        if ($completedTasks >= 10) {
            // Jika minimal 10 tugas selesai, progress 100%
            $progress = 100;
        } else {
            // Jika kurang dari 10 tugas selesai, hitung progres secara proporsional
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        }


        return view('bimbingan.show', compact('bimbingan', 'tasks', 'progress', 'penilaian', 'tasksInProgress'));
    }

    public function indexForDosen()
    {
        $dosenId = Auth::user()->dosen;
        // Query untuk memuat bimbingan yang terkait dengan dosen
        $bimbingans = Bimbingan::with(['skripsi', 'mahasiswa'])
            ->where('dosen_pembimbing_1', $dosenId->id)
            ->orWhere('dosen_pembimbing_2', $dosenId->id)
            ->get();

        // Debugging: Periksa apakah query mengembalikan data
        // dd($bimbingans);

        return view('bimbingan.index', compact('bimbingans'));
    }

    public function setStatusSelesaiPembimbing($id_bimbingan, $pembimbing)
    {
        $bimbingan = Bimbingan::findOrFail($id_bimbingan);

        // Cek pembimbing mana yang mengubah status
        if ($pembimbing == 1) {
            if (Auth::user()->dosen->id == $bimbingan->dosen_pembimbing_1) {
                $bimbingan->status_pembimbing_1 = 'selesai';
            } else {
                abort(403, 'Unauthorized');
            }
        } elseif ($pembimbing == 2) {
            if (Auth::user()->dosen->id == $bimbingan->dosen_pembimbing_2) {
                $bimbingan->status_pembimbing_2 = 'selesai';
            } else {
                abort(403, 'Unauthorized');
            }
        }

        // Cek jika kedua pembimbing sudah selesai, ubah status bimbingan menjadi selesai
        if ($bimbingan->status_pembimbing_1 === 'selesai' && $bimbingan->status_pembimbing_2 === 'selesai') {
            $bimbingan->status_bimbingan = 'selesai';

            // Ubah status skripsi menjadi selesai
            $skripsi = $bimbingan->skripsi; // Relasi ke skripsi
            if ($skripsi) {
                $skripsi->status = 'selesai';
                $skripsi->save();
            }
        }

        $bimbingan->save();

        return redirect()->route('bimbingans.show', $id_bimbingan)->with('success', 'Status bimbingan diperbarui.');
    }
    public function searchBimbingan(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mencari bimbingan berdasarkan keyword di NIM mahasiswa
        $bimbingans = Bimbingan::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('mahasiswaBimbingan', function ($subQuery) use ($keyword) {
                    $subQuery->where('nim', 'like', "%{$keyword}%");
                });
            })
            ->paginate(6);

        return view('bimbingan.index', compact('bimbingans'));
    }
}
