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
        $dosens = Auth::user()->dosen->id; // Mengasumsikan dosen login
        if ($bimbingan->dosenPembimbing1->id !== $dosens && $bimbingan->dosenPembimbing2->id !== $dosens) {
            abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
        }

        return view('bimbingan.penilaianbimbingan', compact('bimbingan', 'dosens'));
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

        $dosens = Auth::user()->dosen->id; // Mengambil dosen yang login
        $bimbingan = Bimbingan::findOrFail($id);

        // Pastikan dosen adalah pembimbing bimbingan ini
        if ($bimbingan->dosenPembimbing1->id !== $dosens && $bimbingan->dosenPembimbing2->id !== $dosens) {
            abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
        }

        PenilaianBimbingan::updateOrCreate(
            ['bimbingan_id' => $id, 'dosen_id' => $dosens],
            [
                'motivasi' => $request->motivasi,
                'kreativitas' => $request->kreativitas,
                'disiplin' => $request->disiplin,
                'metodologi' => $request->metodologi,
                'perencanaan' => $request->perencanaan,
                'rancangan' => $request->rancangan,
                'kesesuaian_rancangan' => $request->kesesuaian_rancangan,
                'keberfungsian' => $request->keberfungsian,
                'status' => 'Terbuka',
            ]
        );

        return redirect()->route('bimbingans.show', $id)->with('success', 'Penilaian berhasil disimpan.');
    }
    public function editFromBimbingan($id_bimbingan, $id)
    {
        $bimbingan = Bimbingan::findOrFail($id_bimbingan);
        $penilaian = PenilaianBimbingan::where('bimbingan_id', $id_bimbingan)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $dosens = Auth::user()->dosen->id; // Mengasumsikan dosen login
        // if ($bimbingan->dosenPembimbing1->id !== $dosens && $bimbingan->dosenPembimbing2->id !== $dosens) {
        //     abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
        // }

        return view('bimbingan.edit', compact('bimbingan', 'dosens', 'penilaian'));
    }
    
        public function updateFromBimbingan(Request $request, $id_bimbingan, $id)
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

            $dosens = Auth::user()->dosen->id; // Mengambil dosen yang login
            $bimbingan = Bimbingan::findOrFail($id_bimbingan);

            // Pastikan dosen adalah pembimbing bimbingan ini
            if ($bimbingan->dosenPembimbing1->id !== $dosens && $bimbingan->dosenPembimbing2->id !== $dosens) {
                abort(403, 'Anda tidak memiliki akses untuk menilai bimbingan ini.');
            }

            $penilaian = PenilaianBimbingan::where('bimbingan_id', $id_bimbingan)->where('dosen_id', $dosens)->firstOrFail();

            $penilaian->update([
                'motivasi' => $request->motivasi,
                'kreativitas' => $request->kreativitas,
                'disiplin' => $request->disiplin,
                'metodologi' => $request->metodologi,
                'perencanaan' => $request->perencanaan,
                'rancangan' => $request->rancangan,
                'kesesuaian_rancangan' => $request->kesesuaian_rancangan,
                'keberfungsian' => $request->keberfungsian,
            ]);

            return redirect()->route('bimbingans.show', $id_bimbingan)->with('success', 'Penilaian berhasil diperbarui.');
        }
    }

