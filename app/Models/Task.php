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
        'file_mahasiswa',
        'komentar_dosen',
        'revisi', // Tambahkan kolom ini
    ];

    protected $casts = [
        'revisi' => 'array', // Cast 'revisi' sebagai array
    ];

    // Relasi dengan tabel Bimbingan
    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id', 'id_bimbingan');
    }
}
