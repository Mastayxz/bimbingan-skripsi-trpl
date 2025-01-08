<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalSkripsiTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_skripsi', function (Blueprint $table) {
            $table->id('id_proposal');
            $table->foreignId('id_mahasiswa')->constrained('mahasiswas')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file_proposal');
            $table->foreignId('id_dosen_pembimbing_1')->nullable()->constrained('dosens')->onDelete('set null');
            $table->enum('status', ['diajukan', 'ditolak', 'disetujui', 'ikut ujian', 'lulus ujian'])->default('diajukan');
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_skripsi');
    }
}
