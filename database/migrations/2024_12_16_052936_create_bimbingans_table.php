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
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id('id_bimbingan'); // Primary Key
            $table->unsignedBigInteger('skripsi_id'); // ID skripsi yang dibimbing
            $table->unsignedBigInteger('dosen_id'); // ID dosen pembimbing
            $table->unsignedBigInteger('mahasiswa_id'); // ID mahasiswa yang dibimbing

            $table->date('tanggal_bimbingan'); // Tanggal awal bimbingan
            $table->enum('status_bimbingan', ['sedang berjalan', 'selesai'])->default('sedang berjalan'); // Status bimbingan

            $table->timestamps(); // Waktu created_at dan updated_at

            // Foreign Key Constraints
            $table->foreign('skripsi_id')->references('id_skripsi')->on('skripsis')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
