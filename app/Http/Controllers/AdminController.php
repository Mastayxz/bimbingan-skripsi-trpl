<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Skripsi;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\ProposalSkripsi;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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
        $mahasiswa = Mahasiswa::paginate(25);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    // Menampilkan daftar dosen
    public function listDosen()
    {
        $dosen = Dosen::paginate(25); // Mengambil semua data dosen
        return view('admin.dosen.index', compact('dosen'));
    }


    public function listSkripsi()
    {
        // Mengambil data skripsi beserta relasi mahasiswa dan dosen pembimbing 1 dan 2
        $skripsi = Skripsi::with(['mahasiswaSkripsi', 'dosenPembimbing1', 'dosenPembimbing2'])->get();

        // Mengirim data ke view
        return view('admin.skripsi.index', compact('skripsi'));
    }

    public function listProposal()
    {
        // Mengambil data skripsi beserta relasi mahasiswa dan dosen pembimbing 1 dan 2
        $proposal = ProposalSkripsi::with(['mahasiswaProposal', 'dosenPembimbing1Proposal'])->get();

        // Mengirim data ke view
        return view('admin.proposal.index', compact('proposal'));
    }




    public function approveSkripsi($id_skripsi)
    {
        // 1. Temukan skripsi berdasarkan ID
        $skripsi = Skripsi::findOrFail($id_skripsi);

        // 2. Perbarui status skripsi menjadi 'disetujui'
        $skripsi->status = 'selesai';
        $skripsi->save();

        // 3. Periksa apakah sesi bimbingan sudah ada
        $existingBimbingan = Bimbingan::where('skripsi_id', $skripsi->id_skripsi)->first();

        if (!$existingBimbingan) {
            // 4. Buat sesi bimbingan otomatis dengan dua dosen pembimbing
            Bimbingan::create([
                'skripsi_id' => $skripsi->id_skripsi,
                'dosen_pembimbing_1' => $skripsi->dosen_pembimbing_1, // Asumsi ada di tabel skripsis
                'dosen_pembimbing_2' => $skripsi->dosen_pembimbing_2, // Asumsi ada di tabel skripsis
                'mahasiswa_id' => $skripsi->mahasiswa,
                'tanggal_bimbingan' => now(),
                'status_bimbingan' => 'berjalan',
            ]);
        }

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.skripsi.index')->with('success', 'Skripsi berhasil disetujui dan sesi bimbingan telah dibuat.');
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


    public function editDosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }


    public function updateDosen(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        // Validasi data yang diterima dari request
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
        ]);

        // Update data dosen
        $dosen->nama = $request->input('nama');
        $dosen->jurusan = $request->input('jurusan');
        $dosen->prodi = $request->input('prodi');
        $dosen->save();

        return redirect()->route('admin.dosen')->with('success', 'Data dosen berhasil diperbarui.');
    }


    public function deleteDosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();

        return redirect()->route('admin.dosen')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    public function makeAdmin($dosenId)
    {
        // Ambil data dosen
        $dosen = Dosen::findOrFail($dosenId);

        // Cari atau buat user terkait
        $user = $dosen->user;
        if (!$user) {
            $user = User::create([
                'name' => $dosen->nama,
                'email' => $dosen->email ?? $dosen->nip . '@example.com',
                'password' => bcrypt('password123'),
            ]);
            $user->dosen()->associate($dosen);
            $user->save();
        }

        // Tetapkan role admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($adminRole);

        // Mengembalikan response atau redirect
        return redirect()->route('admin.dosen')->with('success', 'Dosen berhasil dijadikan admin.');
    }
}
