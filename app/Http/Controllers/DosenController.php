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


    //
    public function index()
    {
        // Ambil dosen yang sedang login
        $dosen = Auth::user()->dosen;
        // dd(Auth::user()->id);

        // Ambil skripsi yang sudah disetujui dan terkait dengan dosen yang sedang login
        $proposals = ProposalSkripsi::whereIn('status', ['disetujui', 'ikut ujian', 'lulus ujian'])
            ->where(function ($query) use ($dosen) {
                $query->where('id_dosen_pembimbing_1', $dosen->id);
            }) // Ambil 5 skripsi terbaru
            ->get();



        return view('dashboard.dosen', compact('proposals'));
    }
    public function daftarSKripsi()
    {
        $dosen = Auth::user()->dosen;
        // / Mengambil user yang sedang login

        // Debug ID dosen untuk memastikan
        // dd(Auth::user(), $dosen);


        // Query untuk mendapatkan daftar skripsi
        $skripsi = Skripsi::where('status', 'berjalan')
            ->where(function ($query) use ($dosen) {
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
