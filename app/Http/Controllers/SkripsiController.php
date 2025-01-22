<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\ProposalSkripsi;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkripsiController extends Controller
{
    //
    public function index()
    {
        $dosens = Dosen::all();

        return view('mahasiswa.skripsi.create', compact('dosens'));
    }

    public function edit(Skripsi $skripsi, $id)
    {
        $skripsi = Skripsi::findOrFail($id);
        $dosens = Dosen::all();

        return view('admin.skripsi.edit', compact('skripsi', 'dosens'));
    }

    public function editDosenPembimbing(Request $request, Skripsi $skripsi, $id)
    {
        $skripsi = Skripsi::findOrFail($id);
        // Validasi input
        $request->validate([
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
            'dosen_pembimbing_2' => 'required|exists:dosens,id|different:dosen_pembimbing_1',
        ]);

        // Update dosen pembimbing skripsi
        $skripsi->update([
            'dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'dosen_pembimbing_2' => $request->dosen_pembimbing_2,
        ]);

        return redirect()->route('admin.skripsi.index', $skripsi)->with('success', 'Dosen pembimbing berhasil diperbarui.');
    }
    


    public function store(Request $request)
    {
        // Periksa apakah mahasiswa sudah memiliki skripsi yang disetujui
        $mahasiswa = Auth::user()->mahasiswa;
        $existingSkripsi = Skripsi::where('mahasiswa', $mahasiswa->id)
            ->where('status', 'disetujui') // Cek hanya skripsi yang disetujui
            ->first();


        if ($existingSkripsi) {
            return redirect()->route('skripsi.create')->with('error', 'Anda sudah memiliki skripsi yang disetujui dan tidak dapat mendaftar lagi.');
        }
        // dd($existingSkripsi);

        // Validasi input
        $request->validate([
            'judul_skripsi' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
            'dosen_pembimbing_2' => 'required|exists:dosens,id|different:dosen_pembimbing_1',
            'abstrak' => 'nullable|string|max:1000',
        ]);

        // Buat data skripsi baru
        Skripsi::create([
            'mahasiswa' => $mahasiswa->id,
            'judul_skripsi' => $request->judul_skripsi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'dosen_pembimbing_2' => $request->dosen_pembimbing_2,
            'abstrak' => $request->abstrak,
            // 'status' => 'pending', // Set status default sebagai pending
        ]);

        return redirect()->route('skripsi.create')->with('success', 'Judul skripsi berhasil diajukan.');
    }
}
