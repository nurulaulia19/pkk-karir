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
            'nama_kategori' => "peternakan"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "perikanan"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "warung hidup"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "lumbung hidup"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "toga"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "tanaman keras"
        ]);

        KategoriPemanfaatanLahan::create([
            'nama_kategori' => "tanaman lainnya"
        ]);
    }
}
