<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableTPg extends Migration
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
            $table->text('soal_gambar')->after("soal_pg")->nullable();
            $table->text('gambar_pil_a')->after('pil_a')->nullable();
            $table->text('gambar_pil_b')->after('pil_b')->nullable();
            $table->text('gambar_pil_c')->after('pil_c')->nullable();
            $table->text('gambar_pil_d')->after('pil_d')->nullable();
            $table->text('gambar_pil_e')->after('pil_e')->nullable();
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
        Schema::dropIfExists('essays');
    }
}

