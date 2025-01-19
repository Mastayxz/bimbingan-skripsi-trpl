<?php

namespace App\Jobs;

use App\Models\Dosen;
use Illuminate\Bus\Queueable;
use App\Services\AkademikApiDosen;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Bus\Dispatchable;

class SyncDosenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tahunAkademik;

    public function __construct($tahunAkademik)
    {
        $this->tahunAkademik = $tahunAkademik;
    }

    public function handle(AkademikApiDosen $akademikApiService)
    {
        $response = $akademikApiService->getDosen($this->tahunAkademik);
        if ($response['responseCode'] !== '00') {
            Log::error('Gagal sinkronisasi: ' . $response['responseDescription']);
            return;
        }

        foreach ($response['daftar'] as $dosen) {
            Dosen::updateOrCreate(
                ['nip' => $dosen['nip']],
                [
                    'nama' => $dosen['nama'],
                    'email' => strtolower(str_replace(' ', '.', $dosen['nama'])) . '@gmail.com',
                    'nidn' => $dosen['nidn'],
                    'jurusan' => $dosen['jurusan'],
                    'prodi' => $dosen['prodi'],
                    'password' => bcrypt($dosen['nip']),
                ]
            );
        }
    }
}
