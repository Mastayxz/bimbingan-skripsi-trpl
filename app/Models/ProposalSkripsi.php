<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalSkripsi extends Model
{
    use HasFactory;
    protected $table = 'proposal_skripsi';

    protected $primaryKey = 'id_proposal';

    protected $fillable = [
        'id_mahasiswa',
        'judul',
        'deskripsi',
        'file_proposal',
        'tanggal_pengajuan',
        'id_dosen_pembimbing_1',
        'status',
        'komentar',
        'tipe_proposal'
    ];
    //
    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'id_proposal');
    }
    public function mahasiswaProposal()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa'); // Memastikan kolom 'mahasiswa' merujuk ke 'id' Mahasiswa
    }

    // Relasi dengan Dosen Pembimbing 1
    public function dosenPembimbing1Proposal()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_pembimbing_1'); // Kolom 'dosen_pembimbing_1' merujuk ke ID Dosen
    }
}
