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
        Schema::create('survei_perusahaan', function (Blueprint $table) {
            $table->id('survei_perusahaan_id');
            $table->string('nama', 10);
            $table->string('instansi', 100);
            $table->string('jabatan', 100);
            $table->string('no_telepon', 100);
            $table->string('email', 255);
            $table->string('nim', 10);
            $table->string('kerjasama', 255);
            $table->string('keahlian', 255);
            $table->string('kemampuan_basing', 255);
            $table->string('kemampuan_komunikasi', 255);
            $table->string('pengembangan_diri', 255);
            $table->string('kepemimpinan', 255);
            $table->string('etoskerja', 255);
            $table->string('kompetensi', 255);
            $table->string('saran', 255);

            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('alumni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_perusahaan');
    }
};
