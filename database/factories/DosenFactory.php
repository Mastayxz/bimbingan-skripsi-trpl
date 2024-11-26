<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DosenFactory extends Factory
{
    protected $model = \App\Models\Dosen::class;

    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numberBetween(1000, 9999), // NIP unik
            // 'email' => $this->faker->unique()->safeEmail(), // Email unik
            'nama' => $this->faker->name(), // Nama dosen
            'jurusan' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi']), // Jurusan
            'user_id' => \App\Models\User::factory(), // default password
        ];
    }
}
