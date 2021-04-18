<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPgTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pg', function (Blueprint $table) {
            $table->bigIncrements('id_soalPG');
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens');
            $table->unsignedBigInteger('id_matkul');
            $table->foreign('id_matkul')->references('id_matkul')->on('matkuls');
            $table->text('soal_pg');
            $table->text('pil_a');
            $table->text('pil_b');
            $table->text('pil_c');
            $table->text('pil_d');
            $table->text('pil_e');
            $table->text('kunci_pg');
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
        Schema::dropIfExists('t_pg_tables');
    }
}
