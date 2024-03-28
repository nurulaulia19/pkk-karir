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
        // desa id anjatan tuh 1
        // $rw = Rw::create([
        //     'name' => "01",
        //     "desa_id" => 1
        // ]);
        // $rt = Rt::create([
        //     'name' => "01",
        //     "rw_id" => 1
        // ]);
        DB::table('data_dasawisma')->insert([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'nama_dasawisma' => 'matahari',
            'alamat_dasawisma' => 'anjatan',
            'status' => 1,
            'id_rt' => 1,
            'id_rw' => 1,
            'periode' => 2024,
            'dusun' => 'matahari',
        ]);
    }
}
