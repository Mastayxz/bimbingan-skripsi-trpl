<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_task';
    protected $fillable = [
        'bimbingan_id',
        'nama_tugas',
        'deskripsi',
        'status',
        'link_document',
        'komentar_dosen',
        'revisi',
        // Tambahkan kolom ini
    ];

    protected $casts = [
        'revisi' => 'array', // Cast 'revisi' sebagai array
    ];

    // Relasi dengan tabel Bimbingan
    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id', 'id_bimbingan');
    }

    public function dospem1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_1_id');
    }

    public function dospem2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_2_id');
    }
}
