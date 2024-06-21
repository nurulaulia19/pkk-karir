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
            // $table->integer('rt');
            // $table->integer('rw');
            $table->integer('periode');
            $table->bigInteger('id_dasawisma')->unsigned()->nullable();
            $table->foreign('id_dasawisma')->references('id')->on('data_dasawisma')->onDelete('cascade');
            // $table->string('dusun')->nullable();
            // $table->string('provinsi');
            $table->string('nama_kepala_keluarga');
            $table->string('nik_kepala_keluarga');
            // $table->boolean('punya_jamban');
            $table->boolean('is_rumah_tangga')->default(false);
            $table->bigInteger('industri_id')->default(0);
            $table->date('is_valid')->nullable();
            $table->date('is_valid_industri')->nullable();
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
