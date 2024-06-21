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
        Schema::create('detail_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kegiatan_id')->unsigned();
            $table->foreign('kegiatan_id')->references('id')->on('data_kegiatan')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('keterangan_kegiatan');
    }
};
