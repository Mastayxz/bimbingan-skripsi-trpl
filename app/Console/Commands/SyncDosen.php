<?php

namespace App\Console\Commands;

use App\Models\Dosen;
use App\Services\AkademikApiDosen;
use Illuminate\Console\Command;

class SyncDosen extends Command
{
    protected $signature = 'sync:dosen {tahunAkademik}';
    protected $description = 'Sinkronisasi data dosen dari API Akademik ke database lokal';

    protected $akademikApiService;

    public function __construct(AkademikApiDosen $akademikApiService)
    {
        parent::__construct();
        $this->akademikApiService = $akademikApiService;
    }

    public function handle()
    {
        $tahunAkademik = $this->argument('tahunAkademik');
        $response = $this->akademikApiService->getDosen($tahunAkademik);

        if ($response['responseCode'] !== '00') {
            $this->error('Gagal sinkronisasi: ' . $response['responseDescription']);
            return;
        }

        $dataDosen = $response['daftar'];

        $this->info('Mulai sinkronisasi data Dosen...'); // Menambahkan info sebelum memulai sinkronisasi

        foreach ($dataDosen as $dosen) {
            // Hanya sinkronkan jika jurusan adalah "Teknologi Informasi" atau "TI"
            if (in_array($dosen['jurusan'], ['Teknologi Informasi'])) {
                Dosen::updateOrCreate(
                    ['nip' => $dosen['nip']],
                    [
                        'nama' => $dosen['nama'],
                        'nidn' => $dosen['nidn'],
                        'jurusan' => $dosen['jurusan'],
                        'prodi' => $dosen['prodi'],
                        'password' => bcrypt($dosen['nip']), // Set password yang diinginkan
                        // 'email' => $dosen['email'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $this->info("Sinkronisasi berhasil untuk dosen dengan NIP: {$dosen['nip']}"); // Memberikan feedback di terminal setelah setiap mahasiswa disinkronkan
            }
        }

        $this->info('Sinkronisasi selesai.'); // Menambahkan info setelah selesai
    }
}
