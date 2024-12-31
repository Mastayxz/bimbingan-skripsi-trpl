<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    //
    public function dosenSkripsi(Dosen $dosen)
    {
        $skripsi = Skripsi::where(function ($query) use ($dosen) {
            $query->where('dosen_pembimbing_1', $dosen->id)
                ->orWhere('dosen_pembimbing_2', $dosen->id);
        })->where('status', 'disetujui')->get();

        return view('dosen.skripsi.index', compact('skripsi'));
    }
    public function index()
    {
        // Ambil dosen yang sedang login
        $dosen = Auth::user();
        dd(Auth::user()->id);

        // Ambil skripsi yang sudah disetujui dan terkait dengan dosen yang sedang login
        $skripsi = Skripsi::where('status', 'disetujui')
            ->where(function ($query) use ($dosen) {
                // Periksa apakah dosen adalah pembimbing 1 atau pembimbing 2
                $query->where('dosen_pembimbing_1', $dosen->id)
                    ->orWhere('dosen_pembimbing_2', $dosen->id);
            })
            ->latest()  // Mengambil yang terbaru berdasarkan waktu dibuat
            ->take(5)   // Ambil 5 skripsi terbaru
            ->get();


        return view('dashboard.dosen', compact('skripsi'));
    }
    public function daftarSKripsi()
    {
        $dosen = Auth::user()->dosen;
        // / Mengambil user yang sedang login

        // Debug ID dosen untuk memastikan
        // dd(Auth::user(), $dosen);


        // Query untuk mendapatkan daftar skripsi
        $skripsi = Skripsi::where('status', 'disetujui')
            ->where(function ($query) use ($dosen) {
                $query->where('dosen_pembimbing_1', $dosen->id)
                    ->orWhere('dosen_pembimbing_2', $dosen->id);
            }) // Ambil 5 skripsi terbaru
            ->get();


        // Debug hasil query untuk memastikan ada data
        // dd($skripsi);

        return view('dosen.skripsi.index', compact('skripsi'));
    }
}
