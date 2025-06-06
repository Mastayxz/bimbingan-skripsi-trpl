<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Skripsi;
use App\Models\Proposal;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\ProposalSkripsi;
use App\Models\PenilaianBimbingan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redis;

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

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    // Controller: MahasiswaController.php
    public function searchMahasiswa(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mencari mahasiswa berdasarkan nama atau NIM
        $mahasiswa = Mahasiswa::where('nama', 'like', "%{$keyword}%")
            ->orWhere('nim', 'like', "%{$keyword}%")
            ->paginate(25);

        // dd($mahasiswa); // Periksa hasil query
        return view('admin.mahasiswa.index', compact('mahasiswa', 'keyword'));
    }

    public function searchDosen(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mencari dosen berdasarkan nama atau NIP
        $dosen = Dosen::where('nama', 'like', "%{$keyword}%")
            ->orWhere('nip', 'like', "%{$keyword}%")
            ->paginate(25);

        return view('admin.dosen.index', compact('dosen', 'keyword'));
    }

    public function searchSkripsi(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mencari skripsi berdasarkan NIM mahasiswa atau NIP dosen pembimbing 1 atau 2
        $skripsi = Skripsi::whereHas('mahasiswaSkripsi', function ($query) use ($keyword) {
            $query->where('nim', 'like', "%{$keyword}%");
        })->orWhereHas('dosenPembimbing1', function ($query) use ($keyword) {
            $query->where('nip', 'like', "%{$keyword}%");
        })->orWhereHas('dosenPembimbing2', function ($query) use ($keyword) {
            $query->where('nip', 'like', "%{$keyword}%");
        })->paginate(25);

        return view('admin.skripsi.index', compact('skripsi', 'keyword'));
    }

    public function searchProposal(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mencari proposal berdasarkan NIM mahasiswa atau NIP dosen pembimbing 1
        $proposal = ProposalSkripsi::whereHas('mahasiswaProposal', function ($query) use ($keyword) {
            $query->where('nim', 'like', "%{$keyword}%");
        })->orWhereHas('dosenPembimbing1Proposal', function ($query) use ($keyword) {
            $query->where('nip', 'like', "%{$keyword}%");
        })->paginate(25);

        return view('admin.proposal.index', compact('proposal', 'keyword'));
    }

    // Menampilkan daftar dosen
    public function listDosen()
    {
        $dosen = Dosen::paginate(10); // Mengambil semua data dosen
        return view('admin.dosen.index', compact('dosen'));
    }


    public function listSkripsi()
    {
        // Mengambil data skripsi beserta relasi mahasiswa dan dosen pembimbing 1 dan 2
        $skripsi = Skripsi::with(['mahasiswaSkripsi', 'dosenPembimbing1', 'dosenPembimbing2'])->latest('created_at')->paginate(10);

        // Mengirim data ke view
        return view('admin.skripsi.index', compact('skripsi'));
    }


    public function listProposal()
    {
        // Mengambil data proposal dengan pagination
        $proposal = ProposalSkripsi::with(['mahasiswaProposal', 'dosenPembimbing1Proposal'])->latest('created_at')->paginate(10);

        return view('admin.proposal.index', compact('proposal'));
    }


    public function listBimbingan()
    {
        // Mengambil data bimbingan beserta relasi skripsi, mahasiswa, dan dosen pembimbing 1 dan 2
        $bimbingan = Bimbingan::with(['skripsi', 'mahasiswaBimbingan', 'dosenPembimbing1', 'dosenPembimbing2'])->latest('created_at')->paginate(10);

        // Mengirim data ke view
        return view('admin.bimbingan.index', compact('bimbingan'));
    }
    public function listPenilaian()
    {
        // Mengambil data penilaian beserta relasi mahasiswa dan dosen
        $penilaian = PenilaianBimbingan::with(['bimbingan', 'dosen', 'bimbingan.skripsi'])->get();


        // Mengirim data ke view
        return view('admin.penilaian.index', compact('penilaian'));
    }
    public function listDetailNilai()
    {
        // Mengambil data penilaian beserta relasi mahasiswa dan dosen
        $penilaian = PenilaianBimbingan::with(['bimbingan', 'dosen', 'bimbingan.skripsi'])->get();


        // Mengirim data ke view
        return view('admin.penilaian.detail', compact('penilaian'));
    }
    public function lockNilai(Request $request, $id)
    {
        $penilaian = PenilaianBimbingan::findOrFail($id);
        $penilaian->status = 'Terkunci';
        $penilaian->save();

        return redirect()->route('admin.penilaian.detail')->with('success', 'Nilai berhasil dikunci.');
    }
    public function lockSelected(Request $request)
    {
        $selectedIds = $request->input('selected_ids');

        if ($selectedIds) {
            // Perbarui status ke 'Terkunci' untuk data yang dipilih
            PenilaianBimbingan::whereIn('id', $selectedIds)->update(['status' => 'Terkunci']);

            return redirect()->route('admin.penilaian.index')->with('success', 'Nilai berhasil dikunci.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }

    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->input('selected_ids');

        if ($selectedIds) {
            ProposalSkripsi::whereIn('id_proposal', $selectedIds)->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }

    public function approveSkripsi($id_skripsi)
    {
        // 1. Temukan skripsi berdasarkan ID
        $skripsi = Skripsi::findOrFail($id_skripsi);

        // 2. Perbarui status skripsi menjadi 'disetujui'
        $skripsi->status = 'berjalan';
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

    public function updateMahasiswa(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Validasi data yang diterima dari request
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_masuk' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
        ]);

        // Update data mahasiswa$mahasiswa
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->jurusan = $request->input('jurusan');
        $mahasiswa->tahun_masuk = $request->input('tahun_masuk');
        $mahasiswa->telepon = $request->input('telepon');
        $mahasiswa->email = $request->input('email');
        $mahasiswa->prodi = $request->input('prodi');
        $mahasiswa->save();

        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
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
