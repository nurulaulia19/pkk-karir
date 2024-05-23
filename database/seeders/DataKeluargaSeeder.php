<?php

namespace Database\Seeders;

use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\Keluargahaswarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKeluargaSeeder extends Seeder
{

    public function run()
    {
        $kepala = DataWarga::find(1);
        $keluarga = DataKeluarga::create([
            'nama_kepala_keluarga' => $kepala->nama,
            'nik_kepala_keluarga' => $kepala->no_ktp,
            'id_dasawisma' => 1,
            'periode' => 2023,
            'is_rumah_tangga' =>   true,
            'industri_id' =>   1,
            'is_valid' => '2023-02-02',
            'is_valid_industri' => '2023-02-02',

            //tambahan seeder dari rumah tangga
            'is_rumah_tangga' => 1
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
            $keluarga2 = DataKeluarga::create([
                'nama_kepala_keluarga' => $kelapa->nama,
                'nik_kepala_keluarga' => $kepala->no_ktp,
                'id_dasawisma' => 1,
                'periode' => 2023,
                'is_valid' => '2023-02-02'
            ]);
            Keluargahaswarga::create([
                'keluarga_id' =>  $keluarga2->id,
                'warga_id' => $kelapa->id,
                'status' =>  'ibu',
            ]);
    }
}
