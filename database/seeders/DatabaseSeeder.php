<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            // Seeder lainnya jika ada
        ]);   // Membuat 5 data dosen
    }
}
