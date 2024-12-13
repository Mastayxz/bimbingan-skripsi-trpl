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
            $table->id('id_bimbingan'); // ID bimbingan (Primary Key)
            $table->unsignedBigInteger('id_skripsi'); // Foreign key ke tabel skripsi
            $table->date('tanggal_bimbingan'); // Tanggal bimbingan
            $table->enum('status_bimbingan', ['sedang berjalan', 'selesai'])->default('sedang berjalan'); // Status bimbingan
            $table->string('link_file', 255)->nullable(); // Link file (upload link)
            $table->text('tanggapan_dosen')->nullable(); // Tanggapan dosen terhadap file yang di-upload
            $table->string('task_name')->nullable(); // Nama task (misal: Bab 1, Bab 2, dst)
            $table->enum('status_task', ['belum_dikerjakan', 'sedang_dikerjakan', 'selesai'])->default('belum_dikerjakan'); // Status task
            $table->timestamps(); // Timestamp untuk created_at dan updated_at

            // Definisi foreign key ke tabel skripsi
            $table->foreign('id_skripsi')->references('id_skripsi')->on('skripsis')->onDelete('cascade');
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
