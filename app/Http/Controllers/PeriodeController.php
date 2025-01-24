<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodePendaftaran;

class PeriodeController extends Controller
{
    //
    public function index()
    {
        $periodes = PeriodePendaftaran::all();

        return view('admin.periode.index', [
            'periodes' => $periodes,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'tahun_masuk_min' => 'nullable|integer',
            'tahun_masuk_max' => 'nullable|integer',
            'status' => 'required|string|in:' . PeriodePendaftaran::STATUS_DIBUKA . ',' . PeriodePendaftaran::STATUS_DITUTUP,
        ]);

        PeriodePendaftaran::create([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tahun_masuk_min' => $request->tahun_masuk_min,
            'tahun_masuk_max' => $request->tahun_masuk_max,
            'status' => $request->status, // Status pendaftaran
        ]);

        return redirect()->route('admin.periode.index')->with('success', 'Periode pendaftaran berhasil disimpan.');
    }

    // Fungsi untuk mengubah status periode
    public function updateStatusPeriode(Request $request, $id)
    {
        $periode = PeriodePendaftaran::findOrFail($id);

        $periode->update([
            'status' => $request->status, // 'dibuka' atau 'ditutup'
        ]);

        return redirect()->route('admin.periode.index')->with('success', 'Status periode berhasil diperbarui.');
    }

    // Fungsi untuk menampilkan halaman edit periode
    public function create()
    {
        $periode = PeriodePendaftaran::all();

        return view('admin.periode.create', compact('periode'));
    }
}
