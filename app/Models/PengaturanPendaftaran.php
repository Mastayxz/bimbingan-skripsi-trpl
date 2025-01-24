<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_pendaftaran';

    protected $fillable = [
        'status_pendaftaran',
        'periode_id',
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_id');
    }
}
