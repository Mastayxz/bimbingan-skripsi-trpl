<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\ProposalSkripsi;
use App\Models\PeriodePendaftaran;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function create()
    {
        $periode = PeriodePendaftaran::where('status', PeriodePendaftaran::STATUS_DIBUKA)->first();

        // Jika tidak ada periode yang dibuka
        if (!$periode) {
            return redirect()->route('dashboard.mahasiswa')->with('error', 'Pendaftaran sedang ditutup.');
        }

        // Validasi tanggal
        $today = now()->toDateString();
        if ($today < $periode->tanggal_mulai || $today > $periode->tanggal_akhir) {
            return redirect()->route('dashboard.mahasiswa')->with('error', 'Pendaftaran tidak tersedia pada periode ini.');
        }

        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Mahasiswa::findOrFail(Auth::user()->mahasiswa->id);

        // Validasi berdasarkan tahun masuk
        if ($periode->tahun_masuk_min && $mahasiswa->tahun_masuk < $periode->tahun_masuk_min) {
            return redirect()->route('dashboard.mahasiswa')->with('error', 'Tahun masuk Anda tidak memenuhi syarat untuk periode ini.');
        }

        if ($periode->tahun_masuk_max && $mahasiswa->tahun_masuk > $periode->tahun_masuk_max) {
            return redirect()->route('dashboard.mahasiswa')->with('error', 'Tahun masuk Anda tidak memenuhi syarat untuk periode ini.');
        }


        // Ambil data dosen untuk form pendaftaran
        $dosens = Dosen::all();
        return view('mahasiswa.proposal.create', compact('dosens'));
    }

    public function editDosen(ProposalSkripsi $proposals, $id)
    {
        $dosens = Dosen::all();
        $proposals = ProposalSkripsi::findOrFail($id);
        return view('admin.proposal.edit', compact('proposals', 'dosens'));
    }
    //
    public function editDosenPembimbing1(Request $request, ProposalSkripsi $proposal, $id)
    {
        $proposal = ProposalSkripsi::findOrFail($id);
        // Validasi input
        $request->validate([
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
        ]);

        // Update dosen pembimbing 1 skripsi
        $proposal->update([
            'id_dosen_pembimbing_1' => $request->dosen_pembimbing_1,
        ]);
        if ($proposal->status === 'ditolak') {
            $proposal->status = 'disetujui';
        }
        $proposal->save();

        return redirect()->route('admin.proposal.index', $proposal)->with('success', 'Dosen pembimbing 1 berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        // Periksa apakah mahasiswa sudah memiliki proposal yang disetujui
        $mahasiswa = Auth::user()->mahasiswa;

        // Cek tahun masuk
        if ($mahasiswa->tahun_masuk >= 2023) {
            return redirect()->route('proposal.create')
                ->with('error', 'Anda belum dapat mendaftarkan proposal.');
        }

        // Cek jika sudah ada proposal dengan status tertentu
        $existingProposal = ProposalSkripsi::where('id_mahasiswa', $mahasiswa->id)
            ->whereIn('status', ['diajukan', 'disetujui', 'ikut ujian'])
            ->exists();

        if ($existingProposal) {
            return redirect()->route('proposal.create')
                ->with('error', 'Anda sudah memiliki proposal yang terdaftar. Anda tidak dapat mendaftar proposal baru.');
        }
        // dd($existingProposal);

        // Validasi input
        $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'deskripsi' => 'required|string|max:1000',
            'file_proposal' => 'required|string|max:1000', // Hanya menerima file PDF maksimal 2MB
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
            'tipe_proposal' => 'required|string|in:analisis,produk',
        ]);

        // Upload file proposal
        // $filePath = $request->file('file_proposal')->store('proposals', 'public');

        // Buat data proposal baru
        ProposalSkripsi::create([
            'id_mahasiswa' => $mahasiswa->id,
            'judul' => $request->judul_proposal,
            'deskripsi' => $request->deskripsi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'file_proposal' => $request->file_proposal,
            'id_dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'tipe_proposal' => $request->tipe_proposal,
            'status' => 'diajukan', // Set status default sebagai menunggu
        ]);

        return redirect()->route('proposal.create')->with('success', 'Proposal skripsi berhasil diajukan.');
    }

    public function showDetail($id_proposal)
    {
        $proposal = ProposalSkripsi::with('mahasiswaProposal', 'dosenPembimbing1Proposal')->findOrFail($id_proposal);
        // Pecah komentar menjadi array
        $proposal->listKomentar = $proposal->komentar ? explode('|', $proposal->komentar) : [];
        return view('dosen.proposal.detail', compact('proposal'));
    }
    public function ujianProposal($id_proposal)
    {
        $proposal = ProposalSkripsi::findOrFail($id_proposal);

        // Validasi input komentar (jika diperlukan)

        // Perbarui status proposal
        $proposal->status = 'ikut ujian';
        $proposal->save();

        // Membuat entri di tabel skripsi
        $skripsi = new Skripsi();
        $skripsi->id_proposal = $proposal->id_proposal;
        $skripsi->judul_skripsi = $proposal->judul;
        $skripsi->tanggal_pengajuan = $proposal->tanggal_pengajuan;
        $skripsi->mahasiswa = $proposal->id_mahasiswa;
        $skripsi->dosen_pembimbing_1 = $proposal->id_dosen_pembimbing_1;
        $skripsi->dosen_pembimbing_2 = null; // Admin Kaprodi akan menetapkan dospem 2
        $skripsi->status = 'lulus ujian'; // Status default untuk skripsi
        $skripsi->link_document = $proposal->file_proposal; // Mengambil file proposal sebagai file skripsi (jika diperlukan)
        $skripsi->save();

        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal berhasil disetujui dan skripsi telah dibuat.');
    }

    public function getProposalUjian($id_proposal)
    {
        // Mencari proposal berdasarkan ID
        $proposal = ProposalSkripsi::findOrFail($id_proposal);

        // Ambil NIM mahasiswa dari proposal
        $mahasiswa = Mahasiswa::findOrFail($proposal->id_mahasiswa);
        $nim = $mahasiswa->nim; // Ambil NIM mahasiswa

        // Menyiapkan data untuk dikirim melalui API
        $data = [
            'id_proposal' => $proposal->id_proposal,
            'judul' => $proposal->judul,
            'tanggal_pengajuan' => $proposal->tanggal_pengajuan,
            'nim' => $nim,
            'dosen_pembimbing_1' => $proposal->id_dosen_pembimbing_1,
            'status' => $proposal->status,
            'file_proposal' => $proposal->file_proposal,
        ];

        // Mengembalikan response dalam format JSON
        return response()->json([
            'success' => true,
            'message' => 'Data proposal berhasil ditemukan.',
            'data' => $data,
        ]);
    }
    public function getAllProposalUjian()
    {
        // Ambil semua proposal yang memiliki status 'ikut ujian'
        $proposals = ProposalSkripsi::where('status', 'ikut ujian')->get();

        // Siapkan data untuk dikirimkan dalam format JSON
        $data = $proposals->map(function ($proposal) {
            return [
                'id_proposal' => $proposal->id_proposal,
                'judul' => $proposal->judul,
                'tanggal_pengajuan' => $proposal->tanggal_pengajuan,
                'NIM' => $proposal->mahasiswaProposal->nim, // Misalkan 'mahasiswa' relasi dari Proposal
                'nama_mahasiswa' => $proposal->mahasiswaProposal->nama, // Misalkan 'mahasiswa' relasi dari Proposal
                'NIP' => $proposal->dosenPembimbing1Proposal->nip, // Misalkan 'dosen_pembimbing_1' relasi dari Proposal
                'nama_dosen_pembimbing_1' => $proposal->dosenPembimbing1Proposal->nama, // Misalkan 'dosen_pembimbing_1' relasi dari Proposal
                'status' => $proposal->status,
                'file_proposal' => $proposal->file_proposal,
            ];
        });

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data proposal ikut ujian berhasil ditemukan.',
            'data' => $data,
        ]);
    }

    public function edit($id)
    {

        $proposal = ProposalSkripsi::findOrFail($id);
        $mahasiswa = Auth::user()->mahasiswa->id;
        if ($mahasiswa !== $proposal->id_mahasiswa) {
            abort(403, 'Unauthorized');
        }

        return view('mahasiswa.proposal.edit', compact('proposal'));
    }

    public function update(Request $request, $id)
    {
        $proposal = ProposalSkripsi::findOrFail($id);
        $mahasiswa = Auth::user()->mahasiswa->id;
        if ($mahasiswa !== $proposal->id_mahasiswa) {
            abort(403, 'Unauthorized');
        }

        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_proposal' => 'required|string|max:1000',
        ]);

        // Update data
        $proposal->judul = $request->judul;
        $proposal->deskripsi = $request->deskripsi;
        $proposal->file_proposal = $request->file_proposal;



        // Periksa status proposal
        if ($proposal->status === 'disetujui') {
            $proposal->status = 'revisi'; // Ubah ke revisi jika sudah disetujui
        } else {
            $proposal->status = 'diajukan'; // Tetap diajukan jika belum disetujui
        }
        $proposal->save();

        return redirect()->route('proposal.detail', $proposal->id_proposal)->with('success', 'Proposal berhasil direvisi.');
    }

    public function setRevisi(Request $request, $id)
    {
        $proposal = ProposalSkripsi::findOrFail($id);
        $dosen = Auth::user()->dosen->id;
        // Validasi hanya dosen yang bisa memberikan revisi
        if ($dosen !== $proposal->id_dosen_pembimbing_1) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Tambahkan komentar baru ke riwayat komentar
        $newComment = $request->komentar;
        $existingComments = $proposal->komentar ? $proposal->komentar . '|' : '';
        $proposal->komentar = $existingComments . $newComment;

        // Ubah status ke "revisi" jika belum
        if ($proposal->status === 'disetujui') {
            $proposal->status = 'revisi';
        }


        $proposal->save();

        return redirect()->back()->with('success', 'Proposal berhasil diberikan status revisi.');
    }
}
