<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skripsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa',
        'judul_skripsi',
        'dosen_pembimbing_1',
        'dosen_pembimbing_2',
        'tanggal_pengajuan',
        'abstrak',
        'status',
    ];
    //
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa');
    }

    public function dosenPembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_1');
    }

    public function dosenPembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_2');
    }
}
