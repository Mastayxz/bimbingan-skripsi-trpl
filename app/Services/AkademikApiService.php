<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AkademikApiService
{
    protected $baseUrl;
    protected $hashKey;

    public function __construct()
    {
        $this->baseUrl = config('akademik_api.base_url');
        $this->hashKey = config('akademik_api.hash_key');
    }

    public function getMahasiswa($tahunAkademik, $jurusan = '', $prodi = '58302')
    {
        $params = [
            'TahunAkademik' => $tahunAkademik,
            'Jurusan' => $jurusan,
            'Prodi' => $prodi,
        ];

        // Generate HashCode
        $concatenatedParams = implode('', $params) . $this->hashKey;
        $hashCode = strtoupper(hash('sha256', $concatenatedParams));
        $params['HashCode'] = $hashCode;

        // Kirim permintaan ke API
        $response = Http::post($this->baseUrl . 'Mahasiswa', $params);

        return $response->json();
    }
}
