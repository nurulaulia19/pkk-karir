<?php

namespace Database\Seeders;

use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\Keluargahaswarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kepala = DataWarga::find(1);
        $keluarga = DataKeluarga::create([
            'nama_kepala_rumah_tangga' => $kepala->nama,
            'punya_jamban' => 1
        ]);

            Keluargahaswarga::create([
                'keluarga_id' =>  $keluarga->id,
                'warga_id' =>  $kepala->id,
                'status' =>  'kepala-keluarga',
            ]);
            Keluargahaswarga::create([
                'keluarga_id' =>  $keluarga->id,
                'warga_id' =>  2,
                'status' =>  'ibu',
            ]);
    }
}
