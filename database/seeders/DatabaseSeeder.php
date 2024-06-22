<?php

namespace Database\Seeders;

use App\Models\DataKeluarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(GeneratePermissionSeeder::class);
        $this->call(PeriodeSeeder::class);
        $this->call(ProfilePembinaKetuaSeeder::class);

        $this->call(DataKecamatanSeeder::class);
        $this->call(DataDesaSeeder::class);
        $this->call(RWSeeder::class);
        $this->call(RTSeeder::class);
        $this->call(DasawismaSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(DataKegiatanSeeder::class);
        // $this->call(DetailKegiatanSeeder::class);
        $this->call(WargaSeeder::class);
        $this->call(DataKeluargaSeeder::class);
        $this->call(KategoriPemanfaatanSeeder::class );

        $this->call(RumahTanggaSeeder::class);
        // $this->call(KategoriPemanfaatanLahanSeeder::class);
        $this->call(KategoriIndustriRumahSeeder::class);
        $this->call(DusunSeeder::class);

    }
}
