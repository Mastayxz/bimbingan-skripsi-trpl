<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Mahasiswa extends Model
{
    use HasFactory, HasRoles;
    protected $table = "mahasiswas";
    protected $fillable = [
        'id',
        'nim',
        'nama',
        'user_id',
        'jurusan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa');
    }
}
