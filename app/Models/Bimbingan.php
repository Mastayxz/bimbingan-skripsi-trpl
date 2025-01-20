<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bimbingan extends Model
{
    protected $table = 'bimbingans'; // Nama tabel
    protected $primaryKey = 'id_bimbingan';

    protected $fillable = [
        'skripsi_id',
        'dosen_pembimbing_1',
        'dosen_pembimbing_2',
        'mahasiswa_id',
        'tanggal_bimbingan',
        'status_bimbingan',
    ];

    // Relasi ke Skripsi
    public function skripsi(): BelongsTo
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }

    // Relasi ke Dosen (Pembimbing 1)
    public function dosenPembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_1');
    }

    // Relasi ke Dosen (Pembimbing 2)
    public function dosenPembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_2');
    }

    public function mahasiswaBimbingan()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke Task (satu bimbingan memiliki banyak tugas)
    public function tasks()
    {
        return $this->hasMany(Task::class, 'bimbingan_id');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianBimbingan::class, 'bimbingan_id', 'id_bimbingan');
    }
}
