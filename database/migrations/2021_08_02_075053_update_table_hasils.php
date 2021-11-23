<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableHasils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //update table hasil
        Schema::table('hasils', function (Blueprint $table) {
            $table->text("nilai_pg")->after('point')->nullable();
            $table->text("jawaban_essay")->after('nilai_pg')->nullable();
            $table->text("nilai_essay")->after('jawaban_essay')->nullable();
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
