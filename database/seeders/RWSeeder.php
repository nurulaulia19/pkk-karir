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
        // RW 1 - Dusun ID 1
        Rw::create([
            'name' => '01',
            'dusun_id' => 1,
            'desa_id' => 1,
        ]);

        // RW 2 - Dusun ID 2
        Rw::create([
            'name' => '02',
            'dusun_id' => 2,
            'desa_id' => 1,
        ]);

        // RW 3 - Dusun ID 3
        // Rw::create([
        //     'name' => '03',
        //     'dusun_id' => 1,
        //     'desa_id' => 1,
        // ]);

        // // RW 4 - Dusun ID 4
        // Rw::create([
        //     'name' => '04',
        //     'dusun_id' => 1,
        //     'desa_id' => 1,
        // ]);

        // // RW 5 - Dusun ID 5
        // Rw::create([
        //     'name' => '05',
        //     'dusun_id' => 1,
        //     'desa_id' => 1,
        // ]);

        // // RW 6 - Dusun ID 0
        // Rw::create([
        //     'name' => '06',
        //     'dusun_id' => 0,
        //     'desa_id' => 1,
        // ]);
    }
}
