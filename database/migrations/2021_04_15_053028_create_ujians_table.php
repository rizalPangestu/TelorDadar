<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens');
            $table->unsignedBigInteger('id_matkul');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkuls');
            $table->string('kode_ujian',10);
            $table->string('pass_ujian',10);
            $table->string('nama_ujian',20);
            $table->integer('waktu_ujian');
            $table->datetime('mulai', $precision = 0);
            $table->datetime('selesai', $precision = 0);
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
        Schema::dropIfExists('ujians');
    }
}
