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
        'jurusan'
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
