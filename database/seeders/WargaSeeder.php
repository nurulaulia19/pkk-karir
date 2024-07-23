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
        $abdul = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009008',
            'no_ktp' => '3212011401970001',
            'nama' => 'Abdul Ghani',
            'jabatan' => 'ketua',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2000-07-17',
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
            'warga_id' => $abdul->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);


        $nurul = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009002',
            'no_ktp' => '3212022203950002',
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
            'is_keluarga' => true,
            'is_valid' => '2023-02-01',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $nurul->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);

        DataKegiatanWarga::create([
            'warga_id' => $nurul->id,
            'data_kegiatan_id' => 2,
            'periode' => 2023,
            'is_valid' => now()
        ]);


        $asykur = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009003',
            'no_ktp' => '3212031504010003',
            'nama' => 'Asykur Thoriq',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2003-09-19',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'pendidikan' => 'SMP/Sederajat',
            'alamat' => 'anjatan',
            'pekerjaan' => 'Lainnya',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'berkebutuhan_khusus' => 'Cacat Mental',
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 0,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => true,
            'is_valid' => '2023-02-01',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $asykur->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);

        $septiani = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009004',
            'no_ktp' => '3212043105020004',
            'nama' => 'Septiani',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '2003-09-19',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'SMA/Sederajat',
            'pekerjaan' => 'Lainnya',
            'aktivitas_kesehatan_lingkungan' => 1,
            'aktivitas_UP2K' => 1,
            'akseptor_kb' => 1,
            'aktif_posyandu' => 1,
            'berkebutuhan_khusus' => 'Cacat Mental',
            'ikut_bkb' => 1,
            'ikut_kelompok_belajar' => 'Ya',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 0,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => true,
            'is_valid' => '2023-02-01',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $septiani->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);

        $lina = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009005',
            'no_ktp' => '3212160704050005',
            'nama' => 'Lina Sukmawati',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'perempuan',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '1991-08-15',
            'status_perkawinan' => 'menikah',
            'agama' => 'islam',
            'alamat' => 'anjatan',
            'pendidikan' => 'SMA/Sederajat',
            'pekerjaan' => 'Lainnya',
            'akseptor_kb' => 1,
            'aktif_posyandu' => 0,
            'berkebutuhan_khusus' => 'Tidak',
            'ikut_bkb' => 0,
            'ikut_kelompok_belajar' => 'Tidak',
            'ikut_paud_sejenis' => 0,
            'ikut_koperasi' => 1,
            'memiliki_tabungan' => 1,
            'periode' => 2023,
            'is_keluarga' => true,
            'is_valid' => '2023-01-05',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $lina->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);


        $budi = DataWarga::create([
            'id_desa' => 1,
            'id_kecamatan' => 1,
            'id_dasawisma' => 1,
            'no_registrasi' => '020103042009006',
            'no_ktp' => '3212062008060006',
            'nama' => 'Budi Mustaqim',
            'jabatan' => 'anggota',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Indramayu',
            'tgl_lahir' => '1979-04-17',
            'status_perkawinan' => 'menikah',
            'agama' => 'budha',
            'alamat' => 'anjatan',
            'pendidikan' => 'SMA/Sederajat',
            'pekerjaan' => 'Lainnya',
            'aktivitas_kesehatan_lingkungan' => 1,
            'aktivitas_UP2K' => 1,
            'akseptor_kb' => 0,
            'aktif_posyandu' => 1,
            'berkebutuhan_khusus' => 'Tidak',
            'ikut_bkb' => 0,
            'ikut_kelompok_belajar' => 'Tidak',
            'ikut_paud_sejenis' => 1,
            'ikut_koperasi' => 1,
            'memiliki_tabungan' => 0,
            'periode' => 2023,
            'is_keluarga' => true,
            'is_valid' => '2023-03-15',
            'is_kegiatan' => true,
        ]);
        DataKegiatanWarga::create([
            'warga_id' => $budi->id,
            'data_kegiatan_id' => 1,
            'periode' => 2023,
            'is_valid' => now()
        ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009007',
        //     'no_ktp' => '3212070101940007',
        //     'nama' => 'Citra Dewi',
        //     'jabatan' => 'sekretaris',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1990-05-22',
        //     'status_perkawinan' => 'menikah',
        //     'aktivitas_kesehatan_lingkungan' => 1,
        //     'aktivitas_UP2K' => 1,
        //     'agama' => 'kristen',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMA/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 0,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 0,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 0,
        //     'ikut_koperasi' => 1,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-01-10'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009008',
        //     'no_ktp' => '3212081705990008',
        //     'nama' => 'Dewi Lestari',
        //     'jabatan' => 'bendahara',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1985-03-10',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMP/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Cacat Fisik',
        //     'ikut_bkb' => 0,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 0,
        //     'ikut_koperasi' => 1,
        //     'memiliki_tabungan' => 1,
        //     'aktivitas_kesehatan_lingkungan' => 1,
        //     'aktivitas_UP2K' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-04-20'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009009',
        //     'no_ktp' => '3212092902050009',
        //     'nama' => 'Eko Prasetyo',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'laki-laki',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1995-07-25',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'hindu',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMA/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 0,
        //     'aktif_posyandu' => 0,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 1,
        //     'aktivitas_kesehatan_lingkungan' => 1,
        //     'aktivitas_UP2K' => 1,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 1,
        //     'ikut_koperasi' => 0,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-05-05'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009010',
        //     'no_ktp' => '3212102504040010',
        //     'nama' => 'Fajar Nugraha',
        //     'jabatan' => 'ketua',
        //     'jenis_kelamin' => 'laki-laki',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1978-12-12',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMA/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 0,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 1,
        //     'aktivitas_kesehatan_lingkungan' => 1,
        //     'aktivitas_UP2K' => 1,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 1,
        //     'ikut_koperasi' => 1,
        //     'memiliki_tabungan' => 0,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-06-08'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009011',
        //     'no_ktp' => '3212110908910011',
        //     'nama' => 'Gita Anggraeni',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1998-01-20',
        //     'status_perkawinan' => 'menikah',
        //     'aktivitas_kesehatan_lingkungan' => 1,
        //     'aktivitas_UP2K' => 1,
        //     'agama' => 'kristen',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMA/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 0,
        //     'berkebutuhan_khusus' => 'Cacat Fisik',
        //     'ikut_bkb' => 1,
        //     'ikut_kelompok_belajar' => 'Ya',
        //     'ikut_paud_sejenis' => 0,
        //     'ikut_koperasi' => 0,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-02-10'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009012',
        //     'no_ktp' => '3212121507050012',
        //     'nama' => 'Hendra Setiawan',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'laki-laki',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1982-11-11',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMA/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 0,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 0,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 1,
        //     'ikut_koperasi' => 1,
        //     'memiliki_tabungan' => 0,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-03-01'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009013',
        //     'no_ktp' => '3212132306000013',
        //     'nama' => 'Ika Marlina',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1996-04-30',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMP/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 1,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 1,
        //     'ikut_koperasi' => 0,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-01-25'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009014',
        //     'no_ktp' => '3212141805030014',
        //     'nama' => 'Joko Susanto',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'laki-laki',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1979-09-09',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'SMP/Sederajat',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 0,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 0,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 0,
        //     'ikut_koperasi' => 1,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-04-12'
        // ]);

        // DataWarga::create([
        //     'id_desa' => 1,
        //     'id_kecamatan' => 1,
        //     'id_dasawisma' => 1,
        //     'no_registrasi' => '020103042009015',
        //     'no_ktp' => '3212152709980015',
        //     'nama' => 'Kartini Aulia',
        //     'jabatan' => 'anggota',
        //     'jenis_kelamin' => 'perempuan',
        //     'tempat_lahir' => 'Indramayu',
        //     'tgl_lahir' => '1986-11-23',
        //     'status_perkawinan' => 'menikah',
        //     'agama' => 'islam',
        //     'alamat' => 'anjatan',
        //     'pendidikan' => 'D4/S1',
        //     'pekerjaan' => 'Lainnya',
        //     'akseptor_kb' => 1,
        //     'aktif_posyandu' => 1,
        //     'berkebutuhan_khusus' => 'Tidak',
        //     'ikut_bkb' => 0,
        //     'ikut_kelompok_belajar' => 'Tidak',
        //     'ikut_paud_sejenis' => 1,
        //     'ikut_koperasi' => 0,
        //     'memiliki_tabungan' => 1,
        //     'periode' => 2023,
        //     'is_keluarga' => true,
        //     'is_valid' => '2023-02-21'
        // ]);



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
