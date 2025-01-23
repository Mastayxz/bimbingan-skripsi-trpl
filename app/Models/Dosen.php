<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Dosen extends Model

{
    use HasFactory, HasRoles;
    protected $table = "dosens";
    protected $fillable = [
        'id',
        'nama',
        'nip',
        'user_id',
        'jurusan',
        'password',
        'email',
        'prodi',
        'nidn'
    ];
    //
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->hasOne(User::class, 'dosen_id');
    }
    // Relasi dengan Skripsi
    public function skripsiPembimbing1()
    {
        return $this->hasMany(Skripsi::class, 'dosen_pembimbing_1');
    }

    public function skripsiPembimbing2()
    {
        return $this->hasMany(Skripsi::class, 'dosen_pembimbing_2');
    }
    public function ProposalPembimbing()
    {
        return $this->hasMany(ProposalSkripsi::class, 'id_dosen_pembimbing_1');
    }
    public function TasksDosen1()
    {
        return $this->hasMany(Task::class, 'dosen_pembimbing_1_id');
    }
    public function TasksDosen2()
    {
        return $this->hasMany(Task::class, 'dosen_pembimbing_2_id');
    }
}
