<?php

namespace App\Exports;

use App\Models\DataKeluarga;
use App\Models\DasaWisma;
use App\Models\RumahTangga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class CatatanKeluargaExport implements FromCollection, WithHeadings
{
    protected $keluarga;
    protected $dasawisma;
    protected $dataKegiatan;

    public function __construct(DataKeluarga $keluarga, DasaWisma $dasawisma, $dataKegiatan)
    {
        $this->keluarga = $keluarga;
        $this->dasawisma = $dasawisma;
        $this->dataKegiatan = $dataKegiatan;
    }

    public function collection()
    {
        $data = [];
        $keluargaFirst = $this->keluarga->rumah_tangga->first();
        // dd($keluargaFirst);
        $rumahTangga = RumahTangga::find($keluargaFirst->rumahtangga_id);
        // dd($rumahTangga);

        $pdam = $rumahTangga->sumber_air_pdam ? 'PDAM':'';
        $sumur = $rumahTangga->sumber_air_sumur ? 'SUMUR':'';
        $lainnya = $rumahTangga->sumber_air_lainnya ? 'SUMUR':'';
        $air = $pdam . ' ' . $sumur . ' ' . $lainnya;


        // Loop untuk setiap anggota keluarga
        foreach ($this->keluarga->anggota as $index => $data_warga) {


            // Membuat baris data untuk setiap anggota keluarga
            $row = [
                $this->keluarga->nama_kepala_keluarga,
                $this->dasawisma->nama_dasawisma,
                $this->keluarga->periode,
                $rumahTangga->kriteria_rumah_sehat ? 'LAYAK HUNI' : 'TIDAK LAYAK HUNI', // Kriteria Rumah
                $rumahTangga->punya_jamban ? 'ADA 1 BUAH' : 'TIDAK ADA',
                $air,
                $rumahTangga->	punya_tempat_sampah ? 'ADA' : 'TIDAK ADA',
                // $sumber_air, // Sumber Air
                // $tempat_sampah, // Tempat Sampah
                $index + 1, // Nomor urut
                $data_warga->warga->nama,
                $data_warga->warga->status_perkawinan,
                $data_warga->warga->jenis_kelamin,
                $data_warga->warga->tempat_lahir,
                $data_warga->warga->tgl_lahir ? Carbon::parse($data_warga->warga->tgl_lahir)->format('d/m/Y') . ' / ' . Carbon::parse($data_warga->warga->tgl_lahir)->age . ' Tahun' : '-', // Tanggal lahir dan umur
                $data_warga->warga->agama,
                $data_warga->warga->pendidikan,
                $data_warga->warga->pekerjaan,
                $data_warga->warga->berkebutuhan_khusus,
            ];

            // Loop untuk setiap kegiatan
            foreach ($this->dataKegiatan as $item) {
                $ada = false;
                foreach ($data_warga->warga->kegiatan as $kegiatan) {
                    if ($kegiatan->data_kegiatan_id == $item->id) {
                        $ada = true;
                        break;
                    }
                }
                $row[] = $ada ? '1' : ''; // Tambahkan status kegiatan
            }

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        // 'CATATAN KELUARGA DARI' = 'Agat' ,
        // 'ANGGOTA KELOMPOK DASAWISMA' = ' mas ',
        // 'TAHUN' = 2023,
        $firstRow = [
            'NAMA, AGAT', // Nama dan Agat (pojok kiri)
            '', // Kolom kosong
            'KAMPUS, POLINDRA', // Kampus Polindra (pojok kanan)
            '', // Kolom kosong
            'KELAS, RPL31', // Kelas RPL31 (pojok kanan)
            '', // Kolom kosong
            'ALAMAT, CELENG', // Alamat Celeng (pojok kanan)
            '', // Kolom kosong
            '', // Kolom kosong
            '', // Kolom kosong
            '', // Kolom kosong
            '', // Kolom kosong
            '', // Kolom kosong
            '', // Kolom kosong
        ];

        // newline
        $headings = [
            'CATATAN KELUARGA DARI',
            'ANGGOTA KELOMPOK DASAWISMA',
            'TAHUN',
            'Kriteria Rumah', // Judul kolom untuk kriteria rumah
            'Jamban Keluarga', // Judul kolom untuk jamban keluarga
            'Sumber Air', // Judul kolom untuk sumber air
            'Tempat Sampah', // Judul kolom untuk tempat sampah
            'No',
            'Nama Anggota Keluarga',
            'Status Perkawinan',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir/Umur',
            'Agama',
            'Pendidikan',
            'Pekerjaan',
            'Berkebutuhan Khusus',
        ];

        // Tambahkan judul kolom untuk setiap kegiatan
        foreach ($this->dataKegiatan as $item) {
            $headings[] = $item->name;
        }

        return $headings;
    }
}
