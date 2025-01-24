<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePendaftaran extends Model
{
    use HasFactory;

    protected $table = 'periode_pendaftaran';

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_akhir',
        'tahun_masuk_min',
        'tahun_masuk_max',
        'status'
    ];
    // Menentukan bahwa status hanya bisa 'dibuka' atau 'ditutup'
    const STATUS_DIBUKA = 'dibuka';
    const STATUS_DITUTUP = 'ditutup';

    public function pengaturan()
    {
        return $this->hasOne(PengaturanPendaftaran::class, 'periode_id');
    }
}
