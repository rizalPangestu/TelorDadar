<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeSoalAtTableTPg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('t_pg', function (Blueprint $table) {
            //
            $table->enum('type_ujian', ["UTS", "UAS","QUIZ"]);
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
        Schema::table('t_pg', function (Blueprint $table) {
            //
           
        });
    }
}
