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
            $table->bigInteger('id_dasawisma')->unsigned()->nullable();
            $table->integer('periode');
            $table->string('dusun')->nullable();
            $table->foreign('id_dasawisma')->references('id')->on('data_dasawisma');
            $table->string('nama_kepala_rumah_tangga');
            $table->boolean('punya_jamban')->default(false);
            $table->boolean('punya_tempat_sampah')->default(false);
            $table->boolean('kriteria_rumah_sehat')->default(false);
            $table->boolean('tempel_stiker')->default(false);
            $table->boolean('saluran_pembuangan_air_limbah')->default(false);
            $table->boolean('sumber_air_pdam')->default(false);
            $table->boolean('sumber_air_sumur')->default(false);
            $table->boolean('sumber_air_lainnya')->default(false);
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
