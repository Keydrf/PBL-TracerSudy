<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniDataTable extends Migration
{
    public function up()
    {
        Schema::create('alumni_data', function (Blueprint $table) {
            $table->id();
            $table->string('prodi');
            $table->string('kategori_profesi');
            $table->string('profesi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni_data');
    }
}
