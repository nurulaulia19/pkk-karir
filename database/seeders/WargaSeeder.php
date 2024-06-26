<?php

namespace Database\Seeders;

use App\Models\DataKegiatanWarga;
use App\Models\DataWarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abdulghani = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => 1,
            'no_ktp' => 1234567890987654,
            'nama' => 'Abdul Ghani Asykur Thoriq',
            'jabatan' => 'ketua',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2023-07-17',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'Tidak Tamat SD',
            'pekerjaan' => 'Petani',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'ikut_paud_sejenis' => 1,
            'ikut_koperasi' => 1,
            'berkebutuhan_khusus' => 'Cacat Mental',
            'pekerjaan' => 'Petani',
            'pendidikan' => 'Tidak Tamat SD',
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => true,
            'is_valid' => '2023-02-01',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $abdulghani->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);


        DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => 2,
            'no_ktp' => 1234567890987653,
            'nama' => 'Nurul Aulia',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2003-09-19',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'Tidak Tamat SD',
            'pekerjaan' => 'Petani',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'berkebutuhan_khusus' => 'Cacat Mental',
            'pekerjaan' => 'Petani',
            'pendidikan' => 'Tidak Tamat SD',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 0,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => false,
            'is_valid' => '2023-02-01'
        ]);
        DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => 9,
            'no_ktp' => 1234567890987659,
            'nama' => 'Toko buka Y',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2003-09-19',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'Tidak Tamat SD',
            'pekerjaan' => 'Petani',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'berkebutuhan_khusus' => 'Cacat Mental',
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 0,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => false,
            'is_valid' => '2023-02-01'
        ]);

        DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => 9,
            'no_ktp' => 1234567890987676,
            'nama' => 'Awap',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2003-09-19',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'Tidak Tamat SD',
            'pekerjaan' => 'Petani',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'berkebutuhan_khusus' => 'Cacat Mental',
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 0,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => false,
            'is_valid' => '2023-02-01'
        ]);


        // DataWarga::create([
        //     'id_desa' => 1,

        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => 2,
        //     'no_ktp' => 1234567890987658,
        //     'nama' => 'Ipim',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '2003-09-19',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'sma',
        //     'pekerjaan' => 'pengusaha',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 1,
        //     'ikut_bkb' => 1,
        //     'ikut_kelompok_belajar' => 0,
        //     'ikut_paud_sejenis' => 0,
        //     'ikut_koperasi' => 0,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        // ]);
        // $table->string('');
        // $table->string('');
        // $table->string('');
        // $table->boolean('pasangan_usia_subur')->default(false);
        // $table->boolean('tiga_buta')->default(false);
        // $table->boolean('ibu_hamil')->default(false);
        // $table->boolean('ibu_menyusui')->default(false);
        // $table->integer('');
        //
    }
}
