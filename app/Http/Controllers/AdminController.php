<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Skripsi;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('dashboard.admin'); // Tampilan utama dashboard
    }

    // Menampilkan daftar mahasiswa
    public function listMahasiswa()
    {
        $mahasiswa = Mahasiswa::all(); // Mengambil semua data mahasiswa
        return view('admin.mahasiswa', compact('mahasiswa'));
    }

    // Menampilkan daftar dosen
    public function listDosen()
    {
        $dosen = Dosen::all(); // Mengambil semua data dosen
        return view('admin.dosen.index', compact('dosen'));
    }

    // Menampilkan daftar skripsi
    public function listSkripsi()
    {
        $skripsi = Skripsi::all(); // Mengambil semua data skripsi
        return view('admin.skripsi.index', compact('skripsi'));
    }
}
