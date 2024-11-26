<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MahasiswaFactory extends Factory
{
    protected $model = \App\Models\Mahasiswa::class;

    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numberBetween(1000, 9999), // NIM unik
            // 'email' => $this->faker->unique()->safeEmail(), // Email unik
            'nama' => $this->faker->name(), // Nama mahasiswa
            'jurusan' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi']), // Jurusan
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
