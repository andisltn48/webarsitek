<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->bigInteger('id_pemesan');
            $table->string('alamat_pemesan');
            $table->string('kontak_pemesan');
            $table->string('nama_pesanan');
            $table->bigInteger('id_pesanan');
            $table->string('tipe_lantai');
            $table->string('luas_bangunan');
            $table->string('harga_pesanan');
            $table->string('harga_bayar');
            $table->string('total_harga_bayar');
            $table->string('tahap');
            $table->string('pembayaran_via');
            $table->string('bukti_pembayaran');
            $table->string('status_pengerjaan');
            $table->bigInteger('no_pemesanan');
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
        Schema::dropIfExists('data_pemesanan');
    }
}
