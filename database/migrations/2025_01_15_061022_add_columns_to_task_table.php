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
        Schema::table('tasks', function (Blueprint $table) {
            $table->bigInteger('dosen_pembimbing_1_id')->unsigned()->nullable();
            $table->bigInteger('dosen_pembimbing_2_id')->unsigned()->nullable();
            $table->enum('status_dospem_1', ['menunggu', 'disetujui', 'revisi'])->default('menunggu');
            $table->enum('status_dospem_2', ['menunggu', 'disetujui', 'revisi'])->default('menunggu');
            // $table->json('revisi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['dosen_pembimbing_1_id', 'dosen_pembimbing_2_id', 'status_dospem_1', 'status_dospem_2']);
        });
    }
};
