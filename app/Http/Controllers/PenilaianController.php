<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;
use App\Models\PenilaianBimbingan;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    //
    public function createFromBimbingan($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);

        // Pastikan dosen yang login adalah pembimbing dari bimbingan ini
        $dosen = Auth::user(); // Mengasumsikan dosen login
        if (!$bimbingan->dosen->contains($dosen)) {
            abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
        }

        return view('penilaian_bimbingan.create_from_bimbingan', compact('bimbingan', 'dosen'));
    }

    public function storeFromBimbingan(Request $request, $id)
    {
        $request->validate([
            'motivasi' => 'nullable|numeric|min:0|max:100',
            'kreativitas' => 'nullable|numeric|min:0|max:100',
            'disiplin' => 'nullable|numeric|min:0|max:100',
            'metodologi' => 'nullable|numeric|min:0|max:100',
            'perencanaan' => 'nullable|numeric|min:0|max:100',
            'rancangan' => 'nullable|numeric|min:0|max:100',
            'kesesuaian_rancangan' => 'nullable|numeric|min:0|max:100',
            'keberfungsian' => 'nullable|numeric|min:0|max:100',
        ]);

        $dosen = Auth::user(); // Mengambil dosen yang login
        $bimbingan = Bimbingan::findOrFail($id);

        // Pastikan dosen adalah pembimbing bimbingan ini
        if (!$bimbingan->dosens->contains($dosen)) {
            abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
        }

        PenilaianBimbingan::updateOrCreate(
            ['bimbingan_id' => $id, 'dosen_id' => $dosen->id],
            [
                'motivasi' => $request->motivasi,
                'kreativitas' => $request->kreativitas,
                'disiplin' => $request->disiplin,
                'metodologi' => $request->metodologi,
                'perencanaan' => $request->perencanaan,
                'rancangan' => $request->rancangan,
                'kesesuaian_rancangan' => $request->kesesuaian_rancangan,
                'keberfungsian' => $request->keberfungsian,
            ]
        );

        return redirect()->route('bimbingan.show', $id)->with('success', 'Penilaian berhasil disimpan.');
    }
}
