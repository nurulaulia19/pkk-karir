<?php

namespace Database\Seeders;

use App\Models\Rw;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RWSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desa Anjatan
        // RW 01 - Dusun ID 1
        Rw::create([
            'name' => '01',
            'dusun_id' => 1,
            'desa_id' => 1,
        ]);

        // RW 02 - Dusun ID 2
        Rw::create([
            'name' => '02',
            'dusun_id' => 2,
            'desa_id' => 1,
        ]);

        // Desa Cantigi Kulon
        // RW 01 - Dusun ID 5
        Rw::create([
            'name' => '01',
            'dusun_id' => 5,
            'desa_id' => 49,
        ]);

        // RW 02 - Dusun ID 6
        Rw::create([
            'name' => '02',
            'dusun_id' => 6,
            'desa_id' => 49,
        ]);

        // RW 03 - Dusun ID 7
        Rw::create([
            'name' => '03',
            'dusun_id' => 7,
            'desa_id' => 49,
        ]);

        // RW 04 - Dusun ID 8
        Rw::create([
            'name' => '04',
            'dusun_id' => 8,
            'desa_id' => 49,
        ]);

        // RW 05 - Dusun ID 9
        Rw::create([
            'name' => '05',
            'dusun_id' => 9,
            'desa_id' => 49,
        ]);

    }
}
