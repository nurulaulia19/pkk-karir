<?php

namespace Database\Seeders;

use App\Models\DataKeluarga;
use App\Models\DataPemanfaatanPekarangan;
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
            'nik_kepala_rumah_tangga' => $kepala->nik_kepala_keluarga,
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
            'periode' => 2023,
            'sumber_air_pdam' => 1,
            'sumber_air_sumur' => 1,
            'sumber_air_lainnya' => 0,

            //optional
            'is_pemanfaatan_lahan' => true,
            'is_valid_pemanfaatan_lahan' => '2023-02-02'

        ]);
        // is_rumah_tangga = true
        RumahTanggaHasKeluarga::create([
            'rumahtangga_id' => $keluarga->id,
            'keluarga_id' => 1,
            'status' => 'kepala-rumah-tangga',
        ]);
        DataPemanfaatanPekarangan::create([
            'id_desa' =>1,
            'id_kecamatan' =>1 ,
            'rumah_tangga_id' => $keluarga->id,
            'kategori_id' => 1,
            'periode' => 2023,
            'is_valid' => '2023-02-02'
        ]);
    }
}
