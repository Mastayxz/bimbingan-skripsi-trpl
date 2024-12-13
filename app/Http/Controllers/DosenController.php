<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    //
    public function dosenSkripsi(Dosen $dosen)
    {
        $skripsi = Skripsi::where(function ($query) use ($dosen) {
            $query->where('dosen_pembimbing_1', $dosen->id)
                ->orWhere('dosen_pembimbing_2', $dosen->id);
        })->where('status', 'disetujui')->get();

        return view('dosen.skripsi.index', compact('skripsi'));
    }
    public function index()
    {
        return view('dashboard.dosen');
    }
}
