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
            'name' => 'legok',
            'desa_id' => 1
        ]);
        Dusun::create([
            'name' => 'kolot',
            'desa_id' => 1
        ]);
    }
}
