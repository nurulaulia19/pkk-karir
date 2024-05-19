<?php

namespace Database\Seeders;

use App\Models\DataKeluarga;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RumahTanggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kepala = DataKeluarga::find(1);
        $kepala->is_rumah_tangga = true;
        $kepala->save();

        $keluarga = RumahTangga::create([
            'nama_kepala_rumah_tangga' => $kepala->nama_kepala_keluarga,
            'id_dasawisma' => 1,
            // 'dusun' => 1,
            // 'punya_jamban' => $request->punya_jamban,
            // 'punya_tempat_sampah' => $request->punya_tempat_sampah,
            // // 'kriteria_rumah_sehat' => $request->kriteria_rumah_sehat,
            'punya_jamban' => 1,
            'punya_tempat_sampah' => 1,
            'saluran_pembuangan_air_limbah' => 1,
            'kriteria_rumah_sehat' => 1,
            'tempel_stiker' => 1,
            // 'saluran_pembuangan_air_limbah' => $request->saluran_pembuangan_air_limbah,
            'periode' => 1,
            'sumber_air_pdam' => 1,
            'sumber_air_sumur' => 1,
            'sumber_air_lainnya' => 0,

        ]);
        // is_rumah_tangga = true
        RumahTanggaHasKeluarga::create([
            'rumahtangga_id' => $keluarga->id,
            'keluarga_id' => 1,
            'status' => 'kepala-rumah-tangga',
        ]);
    }
}
