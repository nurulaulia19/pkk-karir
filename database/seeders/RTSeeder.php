<?php

namespace Database\Seeders;

use App\Models\Rt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desa Anjatan
        // RW 01
        Rt::create([
            'name' => "01",
            'rw_id' => 1,
            'dusun_id' => 1,
        ]);

        Rt::create([
            'name' => "02",
            'rw_id' => 1,
            'dusun_id' => 1,
        ]);
         Rt::create([
            'name' => "03",
            'rw_id' => 1,
            'dusun_id' => 1,
        ]);


        // RW 02
        Rt::create([
            'name' => "04",
            'rw_id' => 2,
            'dusun_id' => 2,
        ]);

        Rt::create([
            'name' => "05",
            'rw_id' => 2,
            'dusun_id' => 2,
        ]);

        // Desa Cantigi Kulon
         // RW 01
         Rt::create([
            'name' => "01",
            'rw_id' => 3,
            'dusun_id' => 5,
        ]);

        Rt::create([
            'name' => "02",
            'rw_id' => 3,
            'dusun_id' => 5,
        ]);

        // RW 02
        Rt::create([
            'name' => "03",
            'rw_id' => 4,
            'dusun_id' => 6,
        ]);

        Rt::create([
            'name' => "04",
            'rw_id' => 4,
            'dusun_id' => 6,
        ]);

         // RW 03
         Rt::create([
            'name' => "05",
            'rw_id' => 5,
            'dusun_id' => 7,
        ]);

        Rt::create([
            'name' => "06",
            'rw_id' => 5,
            'dusun_id' => 7,
        ]);

         // RW 04
         Rt::create([
            'name' => "07",
            'rw_id' => 6,
            'dusun_id' => 8,
        ]);

        Rt::create([
            'name' => "08",
            'rw_id' => 6,
            'dusun_id' => 8,
        ]);

        // RW 05
        Rt::create([
            'name' => "09",
            'rw_id' => 7,
            'dusun_id' => 9,
        ]);

        Rt::create([
            'name' => "10",
            'rw_id' => 7,
            'dusun_id' => 9,
        ]);
    }
}
