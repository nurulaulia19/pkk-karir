<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilePembinaKetuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama_lengkap' => 'Hj. Hajjah Nina Agustina, S.H., M.H., C.R.A.',
                'foto' => 'foto/20240622123845.jpg',
                'tempat_lahir' => 'Purwodadi',
                'tanggal_lahir' => '1973-08-17',
                'masa_jabatan_mulai' => 2021,
                'masa_jabatan_akhir' => 2026,
                'jabatan' => 'Pembina',
                'riwayat_pendidikan' => 'SD Kemala Bhayangkari (1981-1986), SMP Negeri 1 Blora (1986-1989), SMA Negeri 1 Klaten (1989-1992), S1 UPN Veteran Jakarta (1992-2012), S2 UPN Veteran Jakarta (2012-2015)',
                'riwayat_pekerjaan' => 'Ketua Yayasan Dai An Nur, Losarang, Indramayu (2017-sekarang), Direktur CV Dinda Abadi (2009-sekarang), Komisaris PT Dinda Abadi (2009-sekarang), Direktur Utama PT Delta Buana Pratama (2013-sekarang), Managing Partner di NDB Law Firm & Partners (2018-sekarang)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dr. Runisah, M.Pd.',
                'foto' => 'foto/20240622135116.png',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1969-07-28',
                'masa_jabatan_mulai' => 2021,
                'masa_jabatan_akhir' => 2026,
                'jabatan' => 'Ketua',
                'riwayat_pendidikan' => 'SD N Raya Barat VI Bandung tahun 1982, SMP N 24 Bandung tahun 1985, SMA N 4 Bandung tahun 1988, S-1 Pendidikan Matematika IKIP Bandung tahun 1993, S-2 Pendidikan Matematika UPI Bandung tahun 2006, S-3 Pendidikan Matematika UPI Bandung tahun 2016',
                'riwayat_pekerjaan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke dalam database
        DB::table('profiles')->insert($data);
    }
}
