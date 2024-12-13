<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Skripsi;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        $mahasiswaCount = \App\Models\Mahasiswa::count();
        $dosenCount = \App\Models\Dosen::count();
        $skripsiCount = Skripsi::count();

        // Ambil 8 skripsi terbaru dengan relasi mahasiswa dan dosen_pembimbing_1
        $recentSkripsi = Skripsi::with(['mahasiswaSkripsi', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('dashboard.admin', compact(
            'mahasiswaCount',
            'dosenCount',
            'skripsiCount',
            'recentSkripsi'
        ));
    }

    // Menampilkan daftar mahasiswa
    public function listMahasiswa()
    {

        // Mengambil data mahasiswa dengan pagination, 10 mahasiswa per halaman
        $mahasiswa = Mahasiswa::paginate(10);

        return view('admin.mahasiswa', compact('mahasiswa'));
    }

    // Menampilkan daftar dosen
    public function listDosen()
    {
        $dosen = Dosen::all(); // Mengambil semua data dosen
        return view('admin.dosen.index', compact('dosen'));
    }


    public function listSkripsi()
    {

        // Mengambil data skripsi beserta relasi mahasiswa dan dosen pembimbing 1
        // $skripsi = Skripsi::with(['mahasiswa', 'dosenPembimbing1'])->get();
        $skripsi = DB::table('skripsis')
            ->join('mahasiswas', 'skripsis.mahasiswa', '=', 'mahasiswas.id')
            ->join('dosens', 'skripsis.dosen_pembimbing_1', '=', 'dosens.id')
            ->select('skripsis.*', 'mahasiswas.nama as mahasiswa_nama', 'dosens.nama as dosen_nama')
            ->get();

        // dd($skripsi);

        // Mengirim data ke view
        return view('admin.skripsi.index', compact('skripsi'));
    }

    public function approveSkripsi($id_skripsi)
    {
        $skripsi = Skripsi::findOrFail($id_skripsi);
        $skripsi->status = 'disetujui';
        $skripsi->save();

        return redirect()->route('admin.skripsi.index')->with('success', 'Skripsi berhasil disetujui.');
    }

    public function rejectSkripsi($id_skripsi)
    {
        $skripsi = Skripsi::findOrFail($id_skripsi);
        $skripsi->status = 'ditolak';
        $skripsi->save();

        return redirect()->route('admin.skripsi.index')->with('success', 'Skripsi berhasil ditolak.');
    }

    public function editMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function deleteMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
