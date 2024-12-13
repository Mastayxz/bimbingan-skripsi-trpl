<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bimbingan extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_skripsi',
        'tanggal_bimbingan',
        'catatan',
        'status_bimbingan',
        'file_lampiran',
        'link_file',
        'tanggapan_dosen',
        'task_name',
        'status_task'
    ];

    // Relasi ke Skripsi (Asumsi ada model Skripsi)
    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'id_skripsi');
    }

    /**
     * Cek apakah semua task sudah selesai, jika sudah, update status bimbingan.
     */
    public function updateStatusBimbingan()
    {
        // Menghitung jumlah task dengan status 'selesai'
        $completedTasks = $this->where('id_skripsi', $this->id_skripsi)
            ->where('status_task', 'selesai')
            ->count();

        // Cek apakah semua task telah selesai
        $totalTasks = $this->where('id_skripsi', $this->id_skripsi)->count();

        if ($completedTasks == $totalTasks) {
            // Jika semua task selesai, set status bimbingan ke 'selesai'
            $this->status_bimbingan = 'selesai';
            $this->save();
        } else {
            // Jika ada task yang belum selesai, status tetap 'sedang berjalan'
            $this->status_bimbingan = 'sedang berjalan';
            $this->save();
        }
    }
}
