<?php


namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Jobs\SyncDosenJob;
use Illuminate\Http\Request;
use App\Jobs\SyncMahasiswaJob;
use App\Services\AkademikApiService;

class SinkronisasiController extends Controller
{
    protected $akademikApiService;

    public function __construct(AkademikApiService $akademikApiService)
    {
        $this->akademikApiService = $akademikApiService;
    }

    // public function syncMahasiswa(Request $request)
    // {
    //     $tahunAkademik = $request->input('tahunAkademik');

    //     // Memanggil layanan API untuk mendapatkan data mahasiswa
    //     $response = $this->akademikApiService->getMahasiswa($tahunAkademik);

    //     if ($response['responseCode'] !== '00') {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal sinkronisasi: ' . $response['responseDescription'],
    //         ], 500);
    //     }

    //     $dataMahasiswa = $response['daftar'];

    //     foreach ($dataMahasiswa as $mahasiswa) {
    //         if (in_array($mahasiswa['jurusan'], ['Teknologi Informasi'])) {
    //             $existingMahasiswa = Mahasiswa::where('nim', $mahasiswa['nim'])->first();
    //             Mahasiswa::updateOrCreate(
    //                 ['nim' => $mahasiswa['nim']],
    //                 [
    //                     'tahunAkademik' => $mahasiswa['tahunAkademik'],
    //                     'nama' => $mahasiswa['nama'],
    //                     'jurusan' => $mahasiswa['jurusan'],
    //                     'prodi' => $mahasiswa['prodi'],
    //                     'password' => $existingMahasiswa && !password_verify('password', $existingMahasiswa->password)
    //                         ? $existingMahasiswa->password
    //                         : bcrypt('password'),
    //                     'email' => $mahasiswa['email'],
    //                     'telepon' => $mahasiswa['telepon'],
    //                     'jenjang' => $mahasiswa['jenjang'],
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]
    //             );
    //         }
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Sinkronisasi data mahasiswa berhasil dilakukan.',
    //     ]);
    // }

    public function syncDosen(Request $request)
    {
        $request->validate([
            'tahunAkademik' => 'required|string',
        ]);

        // Ambil tahun akademik dari form
        $tahunAkademik = $request->input('tahunAkademik');

        // Dispatch job ke queue
        SyncDosenJob::dispatch($tahunAkademik);

        // Berikan respons ke pengguna
        return back()->with('success', 'Sinkronisasi sedang berjalan di latar belakang.');
    }

    public function syncMahasiswa(Request $request)
    {
        $request->validate([
            'tahunAkademik' => 'required|string',
        ]);

        // Ambil tahun akademik dari form
        $tahunAkademik = $request->input('tahunAkademik');

        // Dispatch job ke queue
        SyncMahasiswaJob::dispatch($tahunAkademik);

        // Berikan respons ke pengguna
        return back()->with('success', 'Sinkronisasi sedang berjalan di latar belakang.');
    }
}
