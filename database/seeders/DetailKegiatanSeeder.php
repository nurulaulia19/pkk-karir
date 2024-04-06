<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create tabel kategori_keterangan
        DB::table('detail_kegiatan')->insert([

            [
                'kegiatan_id' => 1,
                'name' => 'Keagamaan ',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'PKBN (Pembinaan Kesadaran Bela Negara)',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'Pola Asuh',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'Pencegahan KDRT',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'Pencegahan Traffocking',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'Narkoba',
            ],

            [
                'kegiatan_id' => 1,
                'name' => 'Pencegahan Kejahatan Seksual',
            ],

            [
                'kegiatan_id' => 2,
                'name' => 'Kerja Bakti',
            ],

            [
                'kegiatan_id' => 2,
                'name' => 'Jimpitan ',
            ],

            [
                'kegiatan_id' => 2,
                'name' => ' Arisan',
            ],

            [
                'kegiatan_id' => 2,
                'name' => 'Rukun Kematian',
            ],

            [
                'kegiatan_id' => 2,
                'name' => 'Bakti Sosial',
            ],

            [
                'kegiatan_id' => 3,
                'name' => 'BKB (Bina Keluarga Balita)',
            ],

            [
                'kegiatan_id' => 3,
                'name' => 'PAUD Sejenis',
            ],

            [
                'id_kegiatan' => 3,
                'name' => 'Paket A ',
            ],

            [
                'id_kegiatan' => 3,
                'name' => 'Paket B ',
            ],

            [
                'kegiatan_id' => 3,
                'name' => 'Paket C',
            ],

            [
                'kegiatan_id' => 3,
                'name' => 'KF (Keaksaraan Fungsionalitas)',
            ],

            [
                'kegiatan_id' => 4,
                'name' => 'UP2K (Usaha Peningkatan Pendapatan Koperasi)',
            ],

            [
                'kegiatan_id' => 4,
                'name' => 'Koperasi',
            ],

            [
                'kegiatan_id' => 5,
                'name' => 'Beras',
            ],
            [
                'kegiatan_id' => 5,
                'name' => 'Non Beras',
            ],
            [
                'kegiatan_id' => 5,
                'name' => 'Pemanfaatan Halaman Pekarangan',
            ],
            [
                'kegiatan_id' => 6,
                'name' => 'Penyuluhan Busana Serasi dan Pantas Pakai',
            ],
            [
                'kegiatan_id' => 6,
                'name' => 'Pelatihan Menjahit',
            ],
            [
                'kegiatan_id' => 6,
                'name' => 'Lomba Busana Tradisional Pada Hari Kartini',
            ],
            [
                'kegiatan_id' => 7,
                'name' => 'Posyandu Balita/Lansia',
            ],
            [
                'kegiatan_id' => 7,
                'name' => 'PHBS (Perilaku Hidup Bersih dan Sehat)',
            ],
            [
                'kegiatan_id' => 8,
                'name' => 'Program KB',
            ],
            [
                'kegiatan_id' => 8,
                'name' => 'Peserta BPJS Kesehatan',
            ],
            [
                'kegiatan_id' => 8,
                'name' => 'Menabung untuk Masa Depan Keluarga',
            ],
         ]);

    }
}
