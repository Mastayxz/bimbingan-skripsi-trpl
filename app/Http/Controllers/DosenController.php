<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\ProposalSkripsi;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function approveProposal(Request $request, $id_proposal)
    {
        $proposal = ProposalSkripsi::findOrFail($id_proposal);

        // Validasi input komentar
        $request->validate([
            'komentar' => 'required|string|max:1000', // Komentar wajib diisi dengan maksimal 1000 karakter
        ]);

        // Perbarui status dan komentar
        $proposal->status = 'disetujui';
        $proposal->komentar = $request->input('komentar');
        $proposal->save();

        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal berhasil disetujui.');
    }

    public function rejectProposal(Request $request, $id_proposal)
    {
        $proposal = ProposalSkripsi::findOrFail($id_proposal);

        // Validasi input komentar
        $request->validate([
            'komentar' => 'required|string|max:1000', // Komentar wajib diisi dengan maksimal 1000 karakter
        ]);

        // Perbarui status dan komentar
        $proposal->status = 'ditolak';
        $proposal->komentar = $request->input('komentar');
        $proposal->save();

        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal berhasil ditolak.');
    }

    public function addComment(Request $request, $id)
    {
        $proposal = ProposalSkripsi::findOrFail($id);

        // Validasi input
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Tambahkan komentar baru ke riwayat komentar
        $newComment = $request->komentar;
        $existingComments = $proposal->komentar ? $proposal->komentar . '|' : '';
        $proposal->komentar = $existingComments . $newComment;

        // Ubah status ke "Bimbingan" jika belum
        if ($proposal->status === 'Disetujui') {
            $proposal->status = 'Bimbingan';
        }

        $proposal->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    //
    public function index()
    {
        // Ambil dosen yang sedang login
        $dosen = Auth::user()->dosen;

        // Hitung total proposal yang terkait dengan dosen yang sedang login
        $totalProposals = ProposalSkripsi::where('id_dosen_pembimbing_1', $dosen->id)->count();
        $proposalsOnExam = ProposalSkripsi::where('status', 'ikut ujian')->where('id_dosen_pembimbing_1', $dosen->id)->count();
        $proposalsInProgress = Skripsi::where('status', 'berjalan')
            ->where(function ($query) use ($dosen) {
                $query->where('dosen_pembimbing_1', $dosen->id)
                    ->orWhere('dosen_pembimbing_2', $dosen->id);
            })->count();

        $completedProposals = Skripsi::where('status', 'selesai')
            ->where(function ($query) use ($dosen) {
                $query->where('dosen_pembimbing_1', $dosen->id)
                    ->orWhere('dosen_pembimbing_2', $dosen->id);
            })->count();

        // Ambil proposal yang sudah disetujui dan terkait dengan dosen yang sedang login
        $proposals = ProposalSkripsi::whereIn('status', ['disetujui', 'ikut ujian', 'lulus ujian'])
            ->where('id_dosen_pembimbing_1', $dosen->id)
            ->get();

        return view('dashboard.dosen', compact('proposals', 'totalProposals', 'proposalsOnExam', 'proposalsInProgress', 'completedProposals'));
    }
    public function daftarSKripsi()
    {
        $dosen = Auth::user()->dosen;
        // / Mengambil user yang sedang login

        // Debug ID dosen untuk memastikan
        // dd(Auth::user(), $dosen);


        // Query untuk mendapatkan daftar skripsi
        $skripsi = Skripsi::where(function ($query) use ($dosen) {
            $query->where('dosen_pembimbing_1', $dosen->id)
                ->orWhere('dosen_pembimbing_2', $dosen->id);
        }) // Ambil 5 skripsi terbaru
            ->get();


        // Debug hasil query untuk memastikan ada data
        // dd($skripsi);

        return view('dosen.skripsi.index', compact('skripsi'));
    }
    public function daftarProposal()
    {
        $dosen = Auth::user()->dosen;
        // / Mengambil user yang sedang login

        // Debug ID dosen untuk memastikan
        // dd(Auth::user(), $dosen);


        // Query untuk mendapatkan daftar skripsi
        $proposals = ProposalSkripsi::where(function ($query) use ($dosen) {
            $query->where('id_dosen_pembimbing_1', $dosen->id);
        }) // Ambil 5 skripsi terbaru
            ->get();


        // Debug hasil query untuk memastikan ada data
        // dd($skripsi);

        return view('dosen.proposal.index', compact('proposals'));
    }
}
