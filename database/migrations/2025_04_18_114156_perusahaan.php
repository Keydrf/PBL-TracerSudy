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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('perusahaan_id');
            $table->string('nama', 100);
            $table->string('instansi', 100);
            $table->string('no_telepon', 30);
            $table->string('email', 100);
            $table->string('nama_alumni', 100);
            $table->string('program_studi', 100);
            $table->dateTime('tahun_lulus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
