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
        Schema::create('rumah_tangga_has_keluargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rumahtangga_id');
            $table->unsignedBigInteger('keluarga_id');
            $table->enum('status',['kepala-rumah-tangga','kepala-keluarga']);
            $table->timestamps();

            $table->foreign('keluarga_id')->references('id')->on('data_keluarga');
            $table->foreign('rumahtangga_id')->references('id')->on('rumah_tanggas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rumah_tangga_has_wargas');
    }
};
