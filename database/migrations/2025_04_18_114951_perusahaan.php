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
            $table->string('kode_perusahaan', 4)->unique();
            $table->unsignedBigInteger('survei_alumni_id'); // foreign key
            
            $table->string('nama_atasan', 100); 
            $table->string('instansi', 100);
            $table->string('nama_instansi', 100);
            $table->string('no_telepon', 30);
            $table->string('email', 100);
            $table->string('nama_alumni', 100);
            $table->string('program_studi', 100);
            $table->dateTime('tahun_lulus');
            $table->timestamps();
        
            // foreign key constraint
            $table->foreign('survei_alumni_id')->references('survei_alumni_id')->on('survei_alumni')->onDelete('cascade');
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
