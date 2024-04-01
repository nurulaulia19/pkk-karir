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
        Schema::create('data_kabupaten', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kabupaten');
            $table->string('name');
            $table->bigInteger('provinsi_id')->unsigned();
            $table->foreign('provinsi_id')->references('id')->on('data_provinsi');
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
        Schema::dropIfExists('data_kabupaten');
    }
};
