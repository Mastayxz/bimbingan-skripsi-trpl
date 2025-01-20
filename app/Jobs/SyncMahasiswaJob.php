<?php

namespace App\Jobs;

use App\Models\Mahasiswa;
use App\Services\AkademikApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncMahasiswaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tahunAkademik;

    /**
     * Buat instansiasi job dengan tahun akademik
     *
     * @param string $tahunAkademik
     */
    public function __construct($tahunAkademik)
    {
        $this->tahunAkademik = $tahunAkademik;
    }

    /**
     * Eksekusi tugas job
     *
     * @return void
     */
    public function handle(AkademikApiService $akademikApiService)
    {
        // Memanggil layanan API untuk mendapatkan data mahasiswa
        $response = $akademikApiService->getMahasiswa($this->tahunAkademik);

        if ($response['responseCode'] !== '00') {
            Log::error('Gagal sinkronisasi: ' . $response['responseDescription']);
            return;
        }

        $dataMahasiswa = $response['daftar'];

        foreach ($dataMahasiswa as $mahasiswa) {
            if (in_array($mahasiswa['prodi'], ['Teknologi Rekayasa Perangkat Lunak'])) {
                $existingMahasiswa = Mahasiswa::where('nim', $mahasiswa['nim'])->first();
                Log::info('Tahun Masuk untuk NIM ' . $mahasiswa['nim'] . ': ' . '20' . substr($mahasiswa['nim'], 0, 2)); // Debug tahun masuk
                Mahasiswa::updateOrCreate(
                    ['nim' => $mahasiswa['nim']],
                    [
                        'tahun_masuk' => '20' . substr($mahasiswa['nim'], 0, 2),
                        'nama' => $mahasiswa['nama'],
                        'jurusan' => $mahasiswa['jurusan'],
                        'prodi' => $mahasiswa['prodi'],
                        'password' => $existingMahasiswa && !password_verify('password', $existingMahasiswa->password)
                            ? $existingMahasiswa->password
                            : bcrypt('password'),
                        'email' => $existingMahasiswa && $existingMahasiswa->email
                            ? $existingMahasiswa->email
                            : $mahasiswa['email'],
                        'telepon' => $existingMahasiswa && $existingMahasiswa->telepon
                            ? $existingMahasiswa->telepon
                            : $mahasiswa['telepon'],
                        'jenjang' => $mahasiswa['jenjang'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        Log::info('Sinkronisasi data mahasiswa berhasil dilakukan untuk tahun akademik ' . $this->tahunAkademik);
    }
}
