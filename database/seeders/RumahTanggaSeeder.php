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
            'punya_jamban' => 1,
            'punya_tempat_sampah' => 1,
            'saluran_pembuangan_air_limbah' => 1,
            'kriteria_rumah_sehat' => 1,
            'tempel_stiker' => 1,
            'periode' => 2023,
            'sumber_air_pdam' => 1,
            'sumber_air_sumur' => 1,
            'sumber_air_lainnya' => 0,
            //optional
            'is_pemanfaatan_lahan' => true,
            'is_valid_pemanfaatan_lahan' => '2023-02-02',
            'is_valid' => '2023-02-02'

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

        $kepala2 = DataKeluarga::find(2);
        $kepala2->is_rumah_tangga = true;
        $kepala2->save();

        // Buat entri RumahTangga untuk kepala keluarga kedua
        $rumahTangga2 = RumahTangga::create([
            'nama_kepala_rumah_tangga' => $kepala2->nama_kepala_keluarga,
            'nik_kepala_rumah_tangga' => $kepala2->nik_kepala_keluarga,
            'id_dasawisma' => 1,
            'punya_jamban' => 1,
            'punya_tempat_sampah' => 1,
            'saluran_pembuangan_air_limbah' => 1,
            'kriteria_rumah_sehat' => 1,
            'tempel_stiker' => 1,
            'periode' => 2023,
            'sumber_air_pdam' => 1,
            'sumber_air_sumur' => 1,
            'sumber_air_lainnya' => 0,
            'is_pemanfaatan_lahan' => true,
            'is_valid_pemanfaatan_lahan' => '2023-02-02',
            'is_valid' => '2023-02-02',
        ]);

        // Hubungkan rumah tangga dengan kepala keluarga kedua
        RumahTanggaHasKeluarga::create([
            'rumahtangga_id' => $rumahTangga2->id,
            'keluarga_id' => 2, // ID keluarga yang sesuai
            'status' => 'kepala-rumah-tangga',
        ]);

        // Tambahkan data pemanfaatan pekarangan untuk rumah tangga kedua
        DataPemanfaatanPekarangan::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'rumah_tangga_id' => $rumahTangga2->id,
            'kategori_id' => 1,
            'periode' => 2023,
            'is_valid' => '2023-02-02',
        ]);


        // DataKeluarga dengan ID 3 sebagai kepala keluarga
        $kepala3 = DataKeluarga::find(3);
        $kepala3->is_rumah_tangga = true;
        $kepala3->save();

        // Buat entri RumahTangga untuk kepala keluarga ketiga
        $rumahTangga3 = RumahTangga::create([
            'nama_kepala_rumah_tangga' => $kepala3->nama_kepala_keluarga,
            'nik_kepala_rumah_tangga' => $kepala3->nik_kepala_keluarga,
            'id_dasawisma' => 1,
            'punya_jamban' => 1,
            'punya_tempat_sampah' => 1,
            'saluran_pembuangan_air_limbah' => 1,
            'kriteria_rumah_sehat' => 1,
            'tempel_stiker' => 1,
            'periode' => 2023,
            'sumber_air_pdam' => 1,
            'sumber_air_sumur' => 1,
            'sumber_air_lainnya' => 0,
            'is_pemanfaatan_lahan' => true,
            'is_valid_pemanfaatan_lahan' => '2023-02-02',
            'is_valid' => '2023-02-02',
        ]);

        // Hubungkan rumah tangga dengan kepala keluarga ketiga
        RumahTanggaHasKeluarga::create([
            'rumahtangga_id' => $rumahTangga3->id,
            'keluarga_id' => 3, // ID keluarga yang sesuai
            'status' => 'kepala-rumah-tangga',
        ]);

        // Tambahkan data pemanfaatan pekarangan untuk rumah tangga ketiga
        DataPemanfaatanPekarangan::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'rumah_tangga_id' => $rumahTangga3->id,
            'kategori_id' => 1,
            'periode' => 2023,
            'is_valid' => '2023-02-02',
        ]);

        // DataKeluarga dengan ID 4 sebagai kepala keluarga
        // $kepala4 = DataKeluarga::find(4);
        // $kepala4->is_rumah_tangga = true;
        // $kepala4->save();

        // // Buat entri RumahTangga untuk kepala keluarga keempat
        // $rumahTangga4 = RumahTangga::create([
        //     'nama_kepala_rumah_tangga' => $kepala4->nama_kepala_keluarga,
        //     'nik_kepala_rumah_tangga' => $kepala4->nik_kepala_keluarga,
        //     'id_dasawisma' => 1,
        //     'punya_jamban' => 1,
        //     'punya_tempat_sampah' => 0,
        //     'saluran_pembuangan_air_limbah' => 1,
        //     'kriteria_rumah_sehat' => 1,
        //     'tempel_stiker' => 1,
        //     'periode' => 2023,
        //     'sumber_air_pdam' => 1,
        //     'sumber_air_sumur' => 1,
        //     'sumber_air_lainnya' => 0,
        //     'is_pemanfaatan_lahan' => true,
        //     'is_valid_pemanfaatan_lahan' => '2023-02-02',
        //     'is_valid' => '2023-02-02',
        // ]);

        // // Hubungkan rumah tangga dengan kepala keluarga keempat
        // RumahTanggaHasKeluarga::create([
        //     'rumahtangga_id' => $rumahTangga4->id,
        //     'keluarga_id' => 4, // ID keluarga yang sesuai
        //     'status' => 'kepala-rumah-tangga',
        // ]);

        // // Tambahkan data pemanfaatan pekarangan untuk rumah tangga keempat
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga4->id,
        //     'kategori_id' => 1,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);


        // // DataKeluarga dengan ID 5 sebagai kepala keluarga
        // $kepala5 = DataKeluarga::find(5);
        // $kepala5->is_rumah_tangga = true;
        // $kepala5->save();

        // // Buat entri RumahTangga untuk kepala keluarga kelima
        // $rumahTangga5 = RumahTangga::create([
        //     'nama_kepala_rumah_tangga' => $kepala5->nama_kepala_keluarga,
        //     'nik_kepala_rumah_tangga' => $kepala5->nik_kepala_keluarga,
        //     'id_dasawisma' => 1,
        //     'punya_jamban' => 1,
        //     'punya_tempat_sampah' => 1,
        //     'saluran_pembuangan_air_limbah' => 0,
        //     'kriteria_rumah_sehat' => 1,
        //     'tempel_stiker' => 1,
        //     'periode' => 2023,
        //     'sumber_air_pdam' => 1,
        //     'sumber_air_sumur' => 1,
        //     'sumber_air_lainnya' => 0,
        //     'is_pemanfaatan_lahan' => true,
        //     'is_valid_pemanfaatan_lahan' => '2023-02-02',
        //     'is_valid' => '2023-02-02',
        // ]);

        // // Hubungkan rumah tangga dengan kepala keluarga kelima
        // RumahTanggaHasKeluarga::create([
        //     'rumahtangga_id' => $rumahTangga5->id,
        //     'keluarga_id' => 5, // ID keluarga yang sesuai
        //     'status' => 'kepala-rumah-tangga',
        // ]);

        // // Tambahkan data pemanfaatan pekarangan untuk rumah tangga kelima
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga5->id,
        //     'kategori_id' => 2,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);


        // // DataKeluarga dengan ID 6 sebagai kepala keluarga
        // $kepala6 = DataKeluarga::find(6);
        // $kepala6->is_rumah_tangga = true;
        // $kepala6->save();

        // // Buat entri RumahTangga untuk kepala keluarga keenam
        // $rumahTangga6 = RumahTangga::create([
        //     'nama_kepala_rumah_tangga' => $kepala6->nama_kepala_keluarga,
        //     'nik_kepala_rumah_tangga' => $kepala6->nik_kepala_keluarga,
        //     'id_dasawisma' => 1,
        //     'punya_jamban' => 1,
        //     'punya_tempat_sampah' => 1,
        //     'saluran_pembuangan_air_limbah' => 1,
        //     'kriteria_rumah_sehat' => 1,
        //     'tempel_stiker' => 1,
        //     'periode' => 2023,
        //     'sumber_air_pdam' => 1,
        //     'sumber_air_sumur' => 1,
        //     'sumber_air_lainnya' => 0,
        //     'is_pemanfaatan_lahan' => true,
        //     'is_valid_pemanfaatan_lahan' => '2023-02-02',
        //     'is_valid' => '2023-02-02',
        // ]);

        // // Hubungkan rumah tangga dengan kepala keluarga keenam
        // RumahTanggaHasKeluarga::create([
        //     'rumahtangga_id' => $rumahTangga6->id,
        //     'keluarga_id' => 6, // ID keluarga yang sesuai
        //     'status' => 'kepala-rumah-tangga',
        // ]);

        // // Tambahkan data pemanfaatan pekarangan untuk rumah tangga keenam
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga6->id,
        //     'kategori_id' => 2,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga6->id,
        //     'kategori_id' => 3,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);


        // // DataKeluarga dengan ID 7 sebagai kepala keluarga
        // $kepala7 = DataKeluarga::find(7);
        // $kepala7->is_rumah_tangga = true;
        // $kepala7->save();

        // // Buat entri RumahTangga untuk kepala keluarga ketujuh
        // $rumahTangga7 = RumahTangga::create([
        //     'nama_kepala_rumah_tangga' => $kepala7->nama_kepala_keluarga,
        //     'nik_kepala_rumah_tangga' => $kepala7->nik_kepala_keluarga,
        //     'id_dasawisma' => 1,
        //     'punya_jamban' => 1,
        //     'punya_tempat_sampah' => 1,
        //     'saluran_pembuangan_air_limbah' => 1,
        //     'kriteria_rumah_sehat' => 1,
        //     'tempel_stiker' => 1,
        //     'periode' => 2023,
        //     'sumber_air_pdam' => 1,
        //     'sumber_air_sumur' => 1,
        //     'sumber_air_lainnya' => 0,
        //     'is_pemanfaatan_lahan' => true,
        //     'is_valid_pemanfaatan_lahan' => '2023-02-02',
        //     'is_valid' => '2023-02-02',
        // ]);

        // // Hubungkan rumah tangga dengan kepala keluarga ketujuh
        // RumahTanggaHasKeluarga::create([
        //     'rumahtangga_id' => $rumahTangga7->id,
        //     'keluarga_id' => 7, // ID keluarga yang sesuai
        //     'status' => 'kepala-rumah-tangga',
        // ]);

        // // Tambahkan data pemanfaatan pekarangan untuk rumah tangga ketujuh
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga7->id,
        //     'kategori_id' => 4,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);
        // DataPemanfaatanPekarangan::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'rumah_tangga_id' => $rumahTangga7->id,
        //     'kategori_id' => 5,
        //     'periode' => 2023,
        //     'is_valid' => '2023-02-02',
        // ]);


    }
}
