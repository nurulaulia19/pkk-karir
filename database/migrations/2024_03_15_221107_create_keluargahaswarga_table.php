<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluargaHasWargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluarga_has_warga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('keluarga_id');
            $table->unsignedBigInteger('warga_id');
            $table->enum('status',['kepala-keluarga','ibu','anak']);
            $table->timestamps();

            $table->foreign('keluarga_id')->references('id')->on('data_keluarga');
            $table->foreign('warga_id')->references('id')->on('data_warga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluarga_has_warga');
    }
}
