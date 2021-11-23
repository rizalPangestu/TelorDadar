<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumTypeSoalAtTableUjian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add coloumn type soal at table ujian
        Schema::table('ujians', function (Blueprint $table) {
            //
            $table->enum("type_soal", ["PG","Essay","PG Dan Essay"])->after("waktu_ujian");
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
