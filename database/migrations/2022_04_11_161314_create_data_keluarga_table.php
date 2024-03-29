<?php

use App\Models\DataWarga;
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
        Schema::create('data_keluarga', function (Blueprint $table) {
            $table->id();
            $table->integer('rt');
            $table->integer('rw');
            $table->string('dusun');
            $table->string('provinsi');
            $table->string('nama_kepala_rumah_tangga');
            $table->integer('punya_jamban');
            $table->boolean('is_rumah_tangga')->default(false);
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
        Schema::dropIfExists('data_keluarga');
    }
};
