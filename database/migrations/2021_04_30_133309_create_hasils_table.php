<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasils', function (Blueprint $table) {
            $table->bigIncrements("id_hasil");
            $table->unsignedBigInteger('id_ujian');
            $table->foreign('id_ujian')->references('id_ujian')->on('ujians');
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens');
            $table->unsignedBigInteger('id_matkul');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkuls');
            $table->string('email');
            $table->integer('nim');
            $table->string('nama_mhs');
            $table->integer('point');
            $table->integer('nilai_akhir');
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
        Schema::dropIfExists('hasils');
    }
}
