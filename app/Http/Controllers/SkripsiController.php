<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
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

    public function store(Request $request)
    {
        $request->validate([
            'judul_skripsi' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'dosen_pembimbing_1' => 'required|exists:dosens,id',
            'dosen_pembimbing_2' => 'required|exists:dosens,id|different:dosen_pembimbing_1',
            'abstrak' => 'nullable|string|max:1000',
        ]);


        $mahasiswa = Auth::user()->mahasiswa;
        Skripsi::create([
            'mahasiswa' => $mahasiswa->id,
            'judul_skripsi' => $request->judul_skripsi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'dosen_pembimbing_2' => $request->dosen_pembimbing_2,
            'abstrak' => $request->abstrak,
        ]);

        return redirect()->route('skripsi.create')->with('success', 'Judul skripsi berhasil diajukan.');
    }
}
