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
        Schema::create('profesi', function (Blueprint $table) {
            $table->id('profesi_id');
            $table->unsignedBigInteger('kategori_id')->index();
            $table->string('nama_profesi', 100);
            $table->string('deskripsi', 100);
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('kategori_profesi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesi');
    }
};
