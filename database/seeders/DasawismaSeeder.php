<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rw;
use App\Models\DataKelompokDasawisma;
use App\Models\Rt;

class DasawismaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'matahari',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rt' => 1,
        //     'id_rw' => 1,
        //     'periode' => 2023,
        // ]);
        DB::table('data_dasawisma')->insert([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'nama_dasawisma' => 'Melati',
            'alamat_dasawisma' => 'anjatan',
            'status' => 1,
            'id_rt' => 1,
            'id_rw' => 1,
            'periode' => 2023,
        ]);

        // Dasawisma untuk RW 1, RT 1 - Bunga Melati 2
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'Mawar',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rw' => 2,
        //     'id_rt' => 4,
        //     'periode' => 2023,
        // ]);

        // Dasawisma untuk RW 3, RT 1 - Bunga Melati 3
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'Dahlia',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rt' => 1,
        //     'id_rw' => 3,
        //     'periode' => 2023,
        // ]);

        // // Dasawisma untuk RW 4, RT 1 - Bunga Melati 4
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'Tulip',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rt' => 1,
        //     'id_rw' => 4,
        //     'periode' => 2023,
        // ]);

        // // Dasawisma untuk RW 5, RT 1 - Bunga Melati 5
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'Lily',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rt' => 1,
        //     'id_rw' => 5,
        //     'periode' => 2023,
        // ]);

        // // Dasawisma untuk RW 6, RT 1 - Bunga Melati 6
        // DB::table('data_dasawisma')->insert([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'nama_dasawisma' => 'Anggrek',
        //     'alamat_dasawisma' => 'anjatan',
        //     'status' => 1,
        //     'id_rt' => 1,
        //     'id_rw' => 6,
        //     'periode' => 2023,
        // ]);
    }
}
