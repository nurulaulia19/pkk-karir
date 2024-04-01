<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_provinsi')->insert([
            [
                'kode_provinsi' => '32',
                'name' => 'Jawa Barat',
            ]
        ]);

        DB::table('data_kabupaten')->insert([
            [
                'kode_kabupaten' => '32.12',
                'name' => 'Indramayu',
                'provinsi_id' => 1
            ]
        ]);

        //input data kecamatan
        DB::table('data_kecamatan')->insert([
        [
            'kode_kecamatan'=>'32.12.23',
            'nama_kecamatan'=>'Anjatan',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.19',
            'nama_kecamatan'=>'Arahan',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.14',
            'nama_kecamatan'=>'Balongan',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.06',
            'nama_kecamatan'=>'Bangodua',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.22',
            'nama_kecamatan'=>'Bongas',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.17',
            'nama_kecamatan'=>'Cantigi',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.04',
            'nama_kecamatan'=>'Cikedung',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.03',
            'nama_kecamatan'=>'Gabuswetan',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.25',
            'nama_kecamatan'=>'Gantar',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.01',
            'nama_kecamatan'=>'Haurgeulis',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.15',
            'nama_kecamatan'=>'Indramayu',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.13',
            'nama_kecamatan'=>'Jatibarang',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.11',
            'nama_kecamatan'=>'Juntinyuat',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.21',
            'nama_kecamatan'=>'Kandanghaur',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.10',
            'nama_kecamatan'=>'Karangampel',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.28',
            'nama_kecamatan'=>'Kedokan Bunder',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.08',
            'nama_kecamatan'=>'Kertasemaya',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.09',
            'nama_kecamatan'=>'Krangkeng',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.02',
            'nama_kecamatan'=>'Kroya',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.05',
            'nama_kecamatan'=>'Lelea',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.18',
            'nama_kecamatan'=>'Lohbener',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.20',
            'nama_kecamatan'=>'Losarang',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.29',
            'nama_kecamatan'=>'Pasekan',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.31',
            'nama_kecamatan'=>'Patrol',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.16',
            'nama_kecamatan'=>'Sindang',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.12',
            'nama_kecamatan'=>'Sliyeg',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.27',
            'nama_kecamatan'=>'Sukagumiwang',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.24',
            'nama_kecamatan'=>'Sukra',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.26',
            'nama_kecamatan'=>'Trisi',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.30',
            'nama_kecamatan'=>'Tukdana',
            'kabupaten_id'=> 1
        ],
        [
            'kode_kecamatan'=>'32.12.07',
            'nama_kecamatan'=>'Widasari',
            'kabupaten_id'=> 1
        ]
        ]);
    }
}
