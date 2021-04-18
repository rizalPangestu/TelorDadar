<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('essays', function (Blueprint $table) {
            $table->bigIncrements('id_essay');
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens');
            $table->unsignedBigInteger('id_matkul');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkuls');
            $table->text('soal_essay');
            $table->text('gambar');
            $table->text('kunci_essay');
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
        Schema::dropIfExists('essays');
    }
}
