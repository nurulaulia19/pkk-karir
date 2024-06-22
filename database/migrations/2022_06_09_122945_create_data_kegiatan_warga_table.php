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
        Schema::create('data_kegiatan_warga', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('warga_id')->unsigned();
            $table->foreign('warga_id')->references('id')->on('data_warga')->onDelete('cascade');
            $table->bigInteger('data_kegiatan_id')->unsigned();
            $table->foreign('data_kegiatan_id')->references('id')->on('data_kegiatan')->onDelete('cascade');
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
        Schema::dropIfExists('data_kegiatan_warga');
    }
};
