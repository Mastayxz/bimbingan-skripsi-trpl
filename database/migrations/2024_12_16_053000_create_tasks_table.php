<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('id_task'); // Primary Key
            $table->unsignedBigInteger('bimbingan_id'); // Foreign Key ke tabel bimbingans

            $table->string('nama_tugas'); // Nama tugas, misal: Bab 1, Bab 2
            $table->text('deskripsi')->nullable(); // Deskripsi tugas
            $table->enum('status', ['belum dikerjakan', 'sedang direvisi', 'disetujui'])->default('belum dikerjakan');

            $table->string('file_mahasiswa')->nullable(); // Path file yang diunggah mahasiswa
            $table->string('file_feedback_dosen')->nullable(); // Path file feedback dosen
            $table->text('komentar_dosen')->nullable(); // Komentar dari dosen

            $table->timestamps(); // Waktu created_at dan updated_at

            // Foreign Key Constraints
            $table->foreign('bimbingan_id')->references('id_bimbingan')->on('bimbingans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
