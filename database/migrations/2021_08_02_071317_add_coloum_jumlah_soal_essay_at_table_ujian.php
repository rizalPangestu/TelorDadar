<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumJumlahSoalEssayAtTableUjian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ujians', function (Blueprint $table) {
            //
            $table->renameColumn("jlm_soal", "jumlah_soal_PG");
            $table->integer("jumlah_soal_essay")->after("nama_ujian");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
