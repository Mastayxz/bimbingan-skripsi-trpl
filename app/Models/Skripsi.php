<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skripsi extends Model
{
    use HasFactory;
    protected $table = 'skripsis';

    // Tentukan kolom primary key jika tidak menggunakan 'id' secara default
    protected $primaryKey = 'id_skripsi'; // Ubah menjadi 'id_skripsi'

    // Jika Anda tidak menggunakan timestamps, tambahkan properti ini
    public $timestamps = true;

    protected $fillable = [
        'judul_skripsi',
        'mahasiswa',
        'tanggal_pengajuan',
        'dosen_pembimbing_1',
        'dosen_pembimbing_2',
        'status',
        'abstrak',
    ];
    public function proposal()
    {
        return $this->belongsTo(ProposalSkripsi::class, 'id_proposal');
    }
    // Relasi dengan Mahasiswa
    public function mahasiswaSkripsi()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa'); // Memastikan kolom 'mahasiswa' merujuk ke 'id' Mahasiswa
    }

    // Relasi dengan Dosen Pembimbing 1
    public function dosenPembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_1'); // Kolom 'dosen_pembimbing_1' merujuk ke ID Dosen
    }

    public function dosenPembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_2');
    }
}
