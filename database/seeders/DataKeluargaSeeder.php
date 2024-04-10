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
            'nama_kepala_keluarga' => $kepala->nama,
            'periode' => 2024
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

            $kelapa = DataWarga::find(3);
            $keluaryu = DataKeluarga::create([
                'nama_kepala_keluarga' => $kelapa->nama,
                'periode' => 2024
            ]);
            Keluargahaswarga::create([
                'keluarga_id' =>  $keluaryu->id,
                'warga_id' => $kelapa->id,
                'status' =>  'ibu',
            ]);
    }
}
