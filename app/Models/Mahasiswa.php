<?php

namespace App\Models;

use App\Models\Skripsi;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model

{
    use HasFactory, HasRoles;
    protected $table = "mahasiswas";
    protected $fillable = [
        'id',
        'nama',
        'nim',
        'user_id',
        'jurusan',
        'email',
        'password',
        'prodi',
        'telepon',
        'jenjang'
    ];
    //
    //
    public function user()
    {
        return $this->hasOne(User::class, 'mahasiswa_id');
    }
    // Relasi dengan Skripsi
    public function skripsiMahasiswa()
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa', 'id'); // Memastikan 'mahasiswa' merujuk ke ID Mahasiswa
    }
    public function proposalMahasiswa()
    {
        return $this->hasMany(ProposalSkripsi::class, 'id_mahasiswa', 'id'); // Memastikan 'mahasiswa' merujuk ke ID Mahasiswa
    }
}
