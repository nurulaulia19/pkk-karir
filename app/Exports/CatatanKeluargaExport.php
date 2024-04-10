<?php

namespace App\Exports;

use App\Models\DataKeluarga;
use App\Models\DasaWisma;
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

        // Loop untuk setiap anggota keluarga
        foreach ($this->keluarga->anggota as $index => $data_warga) {
            // Mendapatkan nilai kriteria rumah
            $kriteria_rumah = $this->keluarga->kriteria_rumah == 1 ? 'Sehat' : 'Kurang Sehat';

            // Mendapatkan nilai jamban keluarga
            $jamban_keluarga = $this->keluarga->punya_jamban ? 'Ya/' . $this->keluarga->punya_jamban . ' buah' : 'Tidak';

            // Mendapatkan nilai sumber air
            $sumber_air = '';
            switch ($this->keluarga->sumber_air) {
                case 1:
                    $sumber_air = 'PDAM';
                    break;
                case 2:
                    $sumber_air = 'Sumur';
                    break;
                case 3:
                    $sumber_air = 'Sungai';
                    break;
                case 4:
                    $sumber_air = 'Lainnya';
                    break;
                default:
                    $sumber_air = 'Tidak diketahui';
            }

            // Mendapatkan nilai tempat sampah
            $tempat_sampah = $this->keluarga->punya_tempat_sampah == 1 ? 'Ya' : 'Tidak';

            // Membuat baris data untuk setiap anggota keluarga
            $row = [
                $kriteria_rumah, // Kriteria Rumah
                $jamban_keluarga, // Jamban Keluarga
                $sumber_air, // Sumber Air
                $tempat_sampah, // Tempat Sampah
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
        $headings = [
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
