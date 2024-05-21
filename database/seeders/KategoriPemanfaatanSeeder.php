<?php

namespace Database\Seeders;

use App\Models\KategoriPemanfaatanLahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriPemanfaatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Peternakan"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Perikanan"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Warung hidup"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Lumbung hidup"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Toga"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Tanaman keras"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "Tanaman lainnya"
        ]);
    }
}
