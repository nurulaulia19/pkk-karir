<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DataKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('data_kegiatan')->insert([

            [
                'name'=>'Penghayatan dan Pengamalan Pancasila',
                'desa_id'=>1,
            ],
            [
                'name'=>'Gotong Royong',
                'desa_id'=>1,
            ],
            [
                'name'=>'Pendidikan dan Keterampilan',
                'desa_id'=>1,
            ],
            [
                'name'=>'Pengembangan Kehidupan Berkoperasi',
                'desa_id'=>1,
            ],
            [
                'name'=>'Pangan',
                'desa_id'=>1,
            ],
            [
                'name'=>'Sandang',
                'desa_id'=>1,
            ],
            [
                'name'=>'Persencanaan Sehat',
                'desa_id'=>1,
            ],
            [
                'name'=>'Kesehatan',
                'desa_id'=>1,
            ],

         ]);
    }
}
