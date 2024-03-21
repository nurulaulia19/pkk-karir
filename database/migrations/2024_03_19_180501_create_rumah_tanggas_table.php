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
        Schema::create('rumah_tanggas', function (Blueprint $table) {
            $table->id();
            $table->integer('rt');
            $table->integer('rw');
            $table->string('dusun');
            $table->string('provinsi');
            $table->string('name');
            $table->boolean('punya_tempat_sampah')->default(false);
            $table->boolean('kriteria_rumah_sehat')->default(false);
            $table->boolean('tempel_stiker')->default(false);
            $table->boolean('saluran_pembuangan_air_limbah')->default(false);
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
        Schema::dropIfExists('rumah_tanggas');
    }
};
