<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColoumPointAtTableHasils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('hasils', function (Blueprint $table) {
            $table->integer("point")->nullable()->change();
            $table->integer("nilai_pg")->after('point')->nullable()->change();
            $table->integer("nilai_essay")->after('jawaban_essay')->nullable()->change();
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
