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
        // Desa Anjatan
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

        // Desa Cantigi Kulon
        Dusun::create([
            'name' => 'Blok karang balong',
            'desa_id' => 49
        ]);
        Dusun::create([
            'name' => 'Blok karang poman',
            'desa_id' => 49
        ]);
        Dusun::create([
            'name' => 'Blok balai desa',
            'desa_id' => 49
        ]);
        Dusun::create([
            'name' => 'Blok tengah',
            'desa_id' => 49
        ]);
        Dusun::create([
            'name' => 'Blok pulo',
            'desa_id' => 49
        ]);


    }
}
