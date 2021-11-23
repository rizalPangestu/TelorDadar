<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColoumJumlahSoalPGAndEssayAtTableUjians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //upadate Coloum jumlah soal PG dan Essay
        Schema::table('ujians', function (Blueprint $table) {
            $table->integer('jumlah_soal_PG')->nullable()->change();
            $table->integer('jumlah_soal_essay')->nullable()->change();
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
