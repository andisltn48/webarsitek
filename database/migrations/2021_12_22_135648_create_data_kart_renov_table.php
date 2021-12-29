<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKartRenovTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kart_renov', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item');
            $table->string('id_item');
            $table->string('harga_item');
            $table->string('luas_bangunan');
            $table->string('id_pemesan');
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
        Schema::dropIfExists('renov');
    }
}
