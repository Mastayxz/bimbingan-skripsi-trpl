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
        Schema::create('skripsis', function (Blueprint $table) {
            $table->id('id_skripsi');
            $table->unsignedBigInteger('mahasiswa'); // Foreign key
            $table->string('judul_skripsi', 255);
            $table->date('tanggal_pengajuan');
            $table->unsignedBigInteger('dosen_pembimbing_1'); // Foreign key
            $table->unsignedBigInteger('dosen_pembimbing_2'); // Foreign key
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('abstrak')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('mahasiswa')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('dosen_pembimbing_1')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('dosen_pembimbing_2')->references('id')->on('dosens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsis');
    }
};
