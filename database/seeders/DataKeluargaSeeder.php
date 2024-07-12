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
            'is_rumah_tangga' => true,
            'industri_id' => 1,
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
                'status' =>  'isteri',
            ]);

            $kelapa = DataWarga::find(3);
            $keluarga2 = DataKeluarga::create([
                'nama_kepala_keluarga' => $kelapa->nama,
                'nik_kepala_keluarga' => $kepala->no_ktp,
                'id_dasawisma' => 1,
                'periode' => 2023,
                'is_valid' => '2023-02-02',
                'industri_id' => 1,
                'is_valid_industri' => '2023-02-02',
                'is_rumah_tangga' => true,
                //tambahan seeder dari rumah tangga
                'is_rumah_tangga' => 1
            ]);
            Keluargahaswarga::create([
                'keluarga_id' =>  $keluarga2->id,
                'warga_id' => $kelapa->id,
                'status' =>  'kepala-keluarga',
            ]);
            Keluargahaswarga::create([
                'keluarga_id' =>  $keluarga2->id,
                'warga_id' =>  4,
                'status' =>  'isteri',
            ]);

            $kelapa = DataWarga::find(6);

            // Membuat entri DataKeluarga baru
            $keluarga3 = DataKeluarga::create([
                'nama_kepala_keluarga' => $kelapa->nama,
                'nik_kepala_keluarga' => $kelapa->no_ktp,
                'id_dasawisma' => 1,
                'periode' => 2023,
                'is_valid' => '2023-02-02',
                'industri_id' => 2,
                'is_valid_industri' => '2023-02-02',
                'is_rumah_tangga' => true,
                //tambahan seeder dari rumah tangga
                'is_rumah_tangga' => 1
            ]);

            // Menambahkan kepala keluarga ke tabel Keluargahaswarga
            Keluargahaswarga::create([
                'keluarga_id' => $keluarga3->id,
                'warga_id' => $kelapa->id,
                'status' => 'kepala-keluarga',
            ]);

            // Menambahkan Lina ke tabel Keluargahaswarga dengan status istri
            Keluargahaswarga::create([
                'keluarga_id' => $keluarga3->id,
                'warga_id' => 5,
                'status' => 'isteri',
            ]);


            // Temukan DataWarga dengan ID 5 (sebagai kepala keluarga)
            // $kelapa = DataWarga::find(9);

            // // Membuat entri DataKeluarga baru
            // $keluarga4 = DataKeluarga::create([
            //     'nama_kepala_keluarga' => $kelapa->nama,
            //     'nik_kepala_keluarga' => $kelapa->no_ktp,
            //     'id_dasawisma' => 1,
            //     'periode' => 2023,
            //     'is_valid' => '2023-02-02',
            //     'industri_id' => 3,
            //     'is_valid_industri' => '2023-02-02',
            //     'is_rumah_tangga' => true,
            //     //tambahan seeder dari rumah tangga
            //     'is_rumah_tangga' => 1
            // ]);

            // // Menambahkan kepala keluarga ke tabel Keluargahaswarga
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga4->id,
            //     'warga_id' => $kelapa->id,
            //     'status' => 'kepala-keluarga',
            // ]);

            // // Menambahkan Lina ke tabel Keluargahaswarga dengan status istri
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga4->id,
            //     'warga_id' => 7, // ID 4 adalah ID Lina
            //     'status' => 'isteri',
            // ]);

            // // Temukan DataWarga dengan ID 5 (sebagai kepala keluarga)
            // $kelapa = DataWarga::find(10);

            // // Membuat entri DataKeluarga baru
            // $keluarga5 = DataKeluarga::create([
            //     'nama_kepala_keluarga' => $kelapa->nama,
            //     'nik_kepala_keluarga' => $kelapa->no_ktp,
            //     'id_dasawisma' => 1,
            //     'periode' => 2023,
            //     'is_valid' => '2023-02-02',
            //     'industri_id' => 3,
            //     'is_valid_industri' => '2023-02-02',
            //     'is_rumah_tangga' => true,
            //     //tambahan seeder dari rumah tangga
            //     // 'is_rumah_tangga' => 1
            // ]);

            // // Menambahkan kepala keluarga ke tabel Keluargahaswarga
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga5->id,
            //     'warga_id' => $kelapa->id,
            //     'status' => 'kepala-keluarga',
            // ]);

            // // Menambahkan Lina ke tabel Keluargahaswarga dengan status istri
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga5->id,
            //     'warga_id' => 8, // ID 4 adalah ID Lina
            //     'status' => 'isteri',
            // ]);

            // $kelapa = DataWarga::find(12);

            // // Membuat entri DataKeluarga baru
            // $keluarga6 = DataKeluarga::create([
            //     'nama_kepala_keluarga' => $kelapa->nama,
            //     'nik_kepala_keluarga' => $kelapa->no_ktp,
            //     'id_dasawisma' => 1,
            //     'periode' => 2023,
            //     'is_valid' => '2023-02-02',
            //     'is_rumah_tangga' => true,
            //     //tambahan seeder dari rumah tangga
            //     'is_rumah_tangga' => 1
            // ]);

            // // Menambahkan kepala keluarga ke tabel Keluargahaswarga
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga6->id,
            //     'warga_id' => $kelapa->id,
            //     'status' => 'kepala-keluarga',
            // ]);

            // // Menambahkan Lina ke tabel Keluargahaswarga dengan status istri
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga6->id,
            //     'warga_id' => 11, // ID 4 adalah ID Lina
            //     'status' => 'isteri',
            // ]);

            // $kelapa = DataWarga::find(14);

            // // Membuat entri DataKeluarga baru
            // $keluarga7 = DataKeluarga::create([
            //     'nama_kepala_keluarga' => $kelapa->nama,
            //     'nik_kepala_keluarga' => $kelapa->no_ktp,
            //     'id_dasawisma' => 1,
            //     'periode' => 2023,
            //     'is_valid' => '2023-02-02'
            // ]);

            // // Menambahkan kepala keluarga ke tabel Keluargahaswarga
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga7->id,
            //     'warga_id' => $kelapa->id,
            //     'status' => 'kepala-keluarga',
            // ]);

            // // Menambahkan Lina ke tabel Keluargahaswarga dengan status istri
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga7->id,
            //     'warga_id' => 15, // ID 4 adalah ID Lina
            //     'status' => 'isteri',
            // ]);
            // Keluargahaswarga::create([
            //     'keluarga_id' => $keluarga7->id,
            //     'warga_id' => 13, // ID 4 adalah ID Lina
            //     'status' => 'isteri',
            // ]);


    }
}
