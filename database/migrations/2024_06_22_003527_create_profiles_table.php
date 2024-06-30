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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('foto')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('masa_jabatan_mulai');
            $table->integer('masa_jabatan_akhir');
            $table->enum('jabatan', ['Ketua', 'Pembina'])->default('Ketua');
            $table->text('riwayat_pendidikan');
            $table->text('riwayat_pekerjaan')->nullable();
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
        Schema::dropIfExists('profiles');
    }
};
