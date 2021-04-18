<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatkulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matkuls', function (Blueprint $table) {
            $table->bigIncrements('id_matkul');
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens');
            $table->string('nama_matkul', 50);
            $table->string('prodi',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matkuls');
    }
}
