<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            // Tambahkan dua kolom untuk dosen pembimbing
            $table->unsignedBigInteger('dosen_pembimbing_1')->after('skripsi_id');
            $table->unsignedBigInteger('dosen_pembimbing_2')->after('dosen_pembimbing_1');

            // Foreign Key ke tabel users
            $table->foreign('dosen_pembimbing_1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosen_pembimbing_2')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropForeign(['dosen_pembimbing_1']);
            $table->dropForeign(['dosen_pembimbing_2']);
            $table->dropColumn(['dosen_pembimbing_1', 'dosen_pembimbing_2']);
        });
    }
};
