<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Services\AkademikApiService;
use Illuminate\Console\Command;

class SyncMahasiswa extends Command
{
    protected $signature = 'sync:mahasiswa {tahunAkademik}';
    protected $description = 'Sinkronisasi data mahasiswa dari API Akademik ke database lokal';

    protected $akademikApiService;

    public function __construct(AkademikApiService $akademikApiService)
    {
        parent::__construct();
        $this->akademikApiService = $akademikApiService;
    }

    public function handle()
    {
        $tahunAkademik = $this->argument('tahunAkademik');
        $response = $this->akademikApiService->getMahasiswa($tahunAkademik);

        if ($response['responseCode'] !== '00') {
            $this->error('Gagal sinkronisasi: ' . $response['responseDescription']);
            return;
        }

        $dataMahasiswa = $response['daftar'];

        $this->info('Mulai sinkronisasi data mahasiswa...'); // Menambahkan info sebelum memulai sinkronisasi debugging


        foreach ($dataMahasiswa as $mahasiswa) {
            // Hanya sinkronkan jika jurusan adalah "Teknologi Informasi" atau "TI"
            if (in_array($mahasiswa['jurusan'], ['Teknologi Informasi'])) {
                Mahasiswa::updateOrCreate(
                    ['nim' => $mahasiswa['nim']],
                    [
                        'tahunAkademik' => $mahasiswa['tahunAkademik'],
                        'nama' => $mahasiswa['nama'],
                        'jurusan' => $mahasiswa['jurusan'],
                        'prodi' => $mahasiswa['prodi'],
                        'password' => bcrypt('password'),
                        'email' => $mahasiswa['email'],
                        'telepon' => $mahasiswa['telepon'],
                        'jenjang' => $mahasiswa['jenjang'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $this->info("Sinkronisasi berhasil untuk mahasiswa dengan NIM: {$mahasiswa['nim']}"); // Memberikan feedback di terminal setelah setiap mahasiswa disinkronkan
            }
        }

        $this->info('Sinkronisasi selesai.'); // Menambahkan info setelah selesai
    }
}
