<?php

namespace Database\Seeders;

use App\Models\Dusun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DusunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dusun::create([
            'name' => 'sawah indah',
            'desa_id' => 1
        ]);
        Dusun::create([
            'name' => 'lapang bola',
            'desa_id' => 1
        ]);
        Dusun::create([
            'name' => 'karang sambung',
            'desa_id' => 1
        ]);
        Dusun::create([
            'name' => 'karang mulya',
            'desa_id' => 1
        ]);
        // Dusun::create([
        //     'name' => 'karang mulya',
        //     'desa_id' => 1
        // ]);
    }
}
