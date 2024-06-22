<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pemanfaatan_pekarangan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_desa')->unsigned();
            $table->foreign('id_desa')->references('id')->on('data_desa')->onUpdate('cascade');
            $table->bigInteger('id_kecamatan')->unsigned();
            $table->foreign('id_kecamatan')->references('id')->on('data_kecamatan')->onUpdate('cascade');
            $table->bigInteger('rumah_tangga_id')->unsigned();
            $table->foreign('rumah_tangga_id')->references('id')->on('rumah_tanggas')->onDelete('cascade');
            $table->bigInteger('kategori_id')->unsigned();
            $table->foreign('kategori_id')->references('id')->on('kategori_pemanfaatan_lahan')->onDelete('cascade');
            $table->integer('periode');
            $table->date('is_valid')->nullable();
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
        Schema::dropIfExists('data_pemanfaatan_pekarangan');
    }
};
