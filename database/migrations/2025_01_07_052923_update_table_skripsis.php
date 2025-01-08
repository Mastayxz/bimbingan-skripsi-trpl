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
        Schema::table('skripsis', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id_proposal')->on('proposal_skripsi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skripsis', function (Blueprint $table) {
            //
        });
    }
};
