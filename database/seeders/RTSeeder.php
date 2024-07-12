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
        // RW 1
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

        // Rt::create([
        //     'name' => "04",
        //     'rw_id' => 1,
        //     'dusun_id' => 1,
        // ]);

        // Rt::create([
        //     'name' => "05",
        //     'rw_id' => 1,
        //     'dusun_id' => 1,
        // ]);

        // RW 2
        Rt::create([
            'name' => "01",
            'rw_id' => 2,
            'dusun_id' => 2,
        ]);

        Rt::create([
            'name' => "02",
            'rw_id' => 2,
            'dusun_id' => 2,
        ]);

        // // RW 3
        // Rt::create([
        //     'name' => "01",
        //     'rw_id' => 3,
        //     'dusun_id' => 3,
        // ]);

        // Rt::create([
        //     'name' => "02",
        //     'rw_id' => 3,
        //     'dusun_id' => 3,
        // ]);

        // // RW 4
        // Rt::create([
        //     'name' => "01",
        //     'rw_id' => 4,
        //     'dusun_id' => 4,
        // ]);

        // Rt::create([
        //     'name' => "02",
        //     'rw_id' => 4,
        //     'dusun_id' => 4,
        // ]);

        // // RW 5
        // Rt::create([
        //     'name' => "01",
        //     'rw_id' => 5,
        //     'dusun_id' => 5,
        // ]);

        // Rt::create([
        //     'name' => "02",
        //     'rw_id' => 5,
        //     'dusun_id' => 5,
        // ]);

        // // RW 6
        // Rt::create([
        //     'name' => "01",
        //     'rw_id' => 6,
        //     'dusun_id' => 0, // Dusun ID 0
        // ]);

        // Rt::create([
        //     'name' => "02",
        //     'rw_id' => 6,
        //     'dusun_id' => 0, // Dusun ID 0
        // ]);

    }
}
