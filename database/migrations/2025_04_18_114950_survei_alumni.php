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
            $table->string('nim', 10)->unique();
            $table->string('no_telepon', 100);
            $table->string('email', 100);
            $table->integer('tahun_lulus');
            $table->dateTime('tanggal_pertama_kerja')->nullable();
            $table->integer('masa_tunggu')->nullable();
            $table->dateTime('tanggal_pertama_kerja_instansi_saat_ini')->nullable();
            $table->string('jenis_instansi', 100)->nullable();
            $table->string('nama_instansi', 100)->nullable();
            $table->string('skala', 100)->nullable();
            $table->string('lokasi_instansi', 255)->nullable();

            $table->unsignedBigInteger('profesi_id')->nullable();
            $table->foreign('profesi_id')->references('profesi_id')->on('profesi');

            $table->integer('pendapatan');
            $table->string('alamat_kantor', 255);
            $table->string('kabupaten', 255);

            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->foreign('kategori_id')->references('kategori_id')->on('kategori_profesi');

            $table->string('nama_atasan', 100)->nullable();
            $table->string('jabatan_atasan', 100)->nullable();
            $table->string('no_telepon_atasan', 100)->nullable();
            $table->string('email_atasan', 100)->nullable();

            $table->string('kode_otp_alumni', 4)->nullable(); // dipindah ke bagian bawah agar tidak error
            $table->string('kode_otp_perusahaan', 4)->nullable(); // dipindah ke bagian bawah agar tidak error

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
