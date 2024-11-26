<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //
    // Dashboard untuk mahasiswa
    public function mahasiswa()
    {
        return view('dashboard.mahasiswa');
    }

    // Dashboard untuk dosen
    public function dosen()
    {
        return view('dashboard.dosen');
    }
}
