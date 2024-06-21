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
            ],
            [
                'name'=>'Gotong Royong',
            ],
            [
                'name'=>'Pendidikan dan Keterampilan',
            ],
            [
                'name'=>'Pengembangan Kehidupan Berkoperasi',
            ],
            [
                'name'=>'Pangan',
            ],
            [
                'name'=>'Sandang',
            ],
            [
                'name'=>'Persencanaan Sehat',
            ],
            [
                'name'=>'Kesehatan',
            ],

         ]);
    }
}
