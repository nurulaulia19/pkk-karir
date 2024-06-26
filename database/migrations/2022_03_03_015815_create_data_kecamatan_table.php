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
        Schema::create('data_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kecamatan');
            $table->string('nama_kecamatan');
            $table->bigInteger('kabupaten_id')->unsigned();
            $table->foreign('kabupaten_id')->references('id')->on('data_kabupaten')->onDelete('cascade');
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
        Schema::dropIfExists('data_kecamatan');
    }
};
