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
        Schema::create('data_dasawisma', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_desa')->unsigned();
            $table->foreign('id_desa')->references('id')->on('data_desa');
            $table->bigInteger('id_kecamatan')->unsigned();
            $table->foreign('id_kecamatan')->references('id')->on('data_kecamatan')->onDelete('cascade');
            $table->bigInteger('id_rt')->unsigned();
            $table->foreign('id_rt')->references('id')->on('rts')->onDelete('cascade');
            $table->bigInteger('id_rw')->unsigned();
            $table->foreign('id_rw')->references('id')->on('rws')->onDelete('cascade');
            $table->string('nama_dasawisma');
            $table->string('alamat_dasawisma');
            $table->boolean('status')->default(true);
            $table->integer('dusun')->default(0);
            // $table->integer('rt');
            // $table->integer('rw');
            $table->integer('periode');
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
        Schema::dropIfExists('data_dasawisma');
    }
};
