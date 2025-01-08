<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan data dosen untuk admin
        $dosen = Dosen::create([
            'nip' => '123456789',
            'nidn' => '123456789', // Nip unik untuk admin
            'nama' => 'Super Admin',
            'email' => 'admin@example.com',
            'jurusan' => 'Teknologi Informasi',
            'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
            'password' => bcrypt('password123'), // Pastikan password aman
        ]);

        // Tambahkan user terkait
        $user = User::create([
            'name' => $dosen->nama,
            'email' => $dosen->email,
            'password' => bcrypt('password123'),
        ]);

        // Kaitkan user dengan dosen
        $user->dosen()->associate($dosen);
        $user->save();

        // Tetapkan role admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($adminRole);

        echo "Admin berhasil dibuat dengan email: {$user->email}\n";
    }
}
