<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AkademikApiDosen
{
    protected $baseUrl;
    protected $hashKey;

    public function __construct()
    {
        $this->baseUrl = config('akademik_api.base_url');
        $this->hashKey = config('akademik_api.hash_key');
    }

    public function getDosen($tahunAkademik, $jurusan = '', $prodi = '58302', $nim = '')
    {
        $params = [
            'TahunAkademik' => $tahunAkademik,
            'Jurusan' => $jurusan,
            'Prodi' => $prodi,
            'NIM' => $nim
        ];

        // Generate HashCode
        $concatenatedParams = implode('', $params) . $this->hashKey;
        $hashCode = strtoupper(hash('sha256', $concatenatedParams));
        $params['HashCode'] = $hashCode;

        // Kirim permintaan ke API
        $response = Http::post($this->baseUrl . 'Daftardosen', $params);

        return $response->json();
    }
}
