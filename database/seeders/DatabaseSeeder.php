<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::factory(10)->create(); // Membuat 10 data mahasiswa
        Dosen::factory(5)->create();      // Membuat 5 data dosen
    }
}
