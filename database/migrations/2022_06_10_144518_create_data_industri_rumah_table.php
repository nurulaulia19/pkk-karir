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
        Schema::create('data_industri_rumah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_desa')->unsigned();
            $table->foreign('id_desa')->references('id')->on('data_desa')->onDelete('cascade');
            $table->bigInteger('id_kecamatan')->unsigned();
            $table->foreign('id_kecamatan')->references('id')->on('data_kecamatan')->onDelete('cascade');
            $table->bigInteger('keluarga_id')->unsigned();
            $table->foreign('keluarga_id')->references('id')->on('data_keluarga')->onDelete('cascade');
            $table->bigInteger('kategori_industri_rumah_id')->unsigned();
            $table->foreign('kategori_industri_rumah_id')->references('id')->on('kategori_industri_rumah')->onDelete('cascade');
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
        Schema::dropIfExists('data_industri_rumah');
    }
};
