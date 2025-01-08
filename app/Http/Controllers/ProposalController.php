<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use App\Models\ProposalSkripsi;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function create()
    {
        $dosens = Dosen::all();

        return view('mahasiswa.proposal.create', compact('dosens'));
    }
    //
    public function store(Request $request)
    {
        // Periksa apakah mahasiswa sudah memiliki proposal yang disetujui
        $mahasiswa = Auth::user()->mahasiswa;
        $existingProposal = ProposalSkripsi::where('id_mahasiswa', $mahasiswa->id)
            ->where('status', 'diajukan') // Cek hanya proposal yang disetujui
            ->first();

        if ($existingProposal) {
            return redirect()->route('proposal.create')->with('error', 'Anda sudah memiliki proposal yang disetujui dan tidak dapat mendaftar lagi.');
        }

        // Validasi input
        $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'deskripsi' => 'required|string|max:1000',
            'file_proposal' => 'required|mimes:pdf|max:2048', // Hanya menerima file PDF maksimal 2MB
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
        ]);

        // Upload file proposal
        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        // Buat data proposal baru
        ProposalSkripsi::create([
            'id_mahasiswa' => $mahasiswa->id,
            'judul' => $request->judul_proposal,
            'deskripsi' => $request->deskripsi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'file_proposal' => $filePath,
            'id_dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'status' => 'diajukan', // Set status default sebagai menunggu
        ]);

        return redirect()->route('proposal.create')->with('success', 'Proposal skripsi berhasil diajukan.');
    }

    public function showDetail($id_proposal)
    {
        $proposal = ProposalSkripsi::with('mahasiswaProposal', 'dosenPembimbing1Proposal')->findOrFail($id_proposal);

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
        $skripsi->status = 'berjalan'; // Status default untuk skripsi
        $skripsi->link_document = $proposal->file_proposal; // Mengambil file proposal sebagai file skripsi (jika diperlukan)
        $skripsi->save();

        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal berhasil disetujui dan skripsi telah dibuat.');
    }
}
