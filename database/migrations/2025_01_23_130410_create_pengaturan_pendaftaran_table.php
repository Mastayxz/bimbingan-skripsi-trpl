<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengaturan_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_pendaftaran')->default(true); // true = buka, false = tutup
            $table->unsignedBigInteger('periode_id'); // Relasi ke tabel periode
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periode_pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_pendaftaran');
    }
};
