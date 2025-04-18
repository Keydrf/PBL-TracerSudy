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
        Schema::create('survei_alumni', function (Blueprint $table) {
            $table->id('survei_alumni_id');
            $table->string('nim', 10);
            $table->string('no_telepon', 100);
            $table->string('email', 100);
            $table->integer('tahun_lulus');
            $table->dateTime('tanggal_pertama_kerja');
            $table->integer('masa_tunggu');
            $table->dateTime('tanggal_pertama_kerja_instansi_saat_ini');
            $table->string('jenis_instansi', 100);
            $table->string('nama_instansi', 100);
            $table->string('skala', 100);
            $table->string('lokasi_instansi', 255);
            $table->string('kategori_profesi', 100);
            $table->string('profesi', 100);
            $table->string('nama_atasan', 100);
            $table->string('jabatan_atasan', 100);
            $table->string('no_telepon_atasan', 100);
            $table->string('email_atasan', 100);
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('alumni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_alumni');
    }
};
