<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianBimbingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bimbingan_id', // bimbingan tempat dia nilai, diambil dari url 
        'dosen_id', // tergantung yang login ini juga url
        'motivasi',
        'kreativitas',
        'disiplin',
        'metodologi',
        'perencanaan',
        'rancangan',
        'kesesuaian_rancangan',
        'keberfungsian'
    ];

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
