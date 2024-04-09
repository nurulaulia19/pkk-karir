<?php

namespace App\Exports;

use App\Models\DataKeluarga;
use App\Models\DasaWisma;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatatanKeluargaExport implements FromView, WithHeadings
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

    public function view(): View
    {
        return view('kader.data_catatan_keluarga.export', [
            'keluarga' => $this->keluarga,
            'dasawisma' => $this->dasawisma,
            'dataKegiatan' => $this->dataKegiatan,
        ]);
    }

    public function headings(): array
    {
        // Mendefinisikan header kolom Excel
        return [
            'No',
            'Nama Anggota Keluarga',
            'Status Perkawinan',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir / Umur',
            'Agama',
            'Pendidikan',
            'Pekerjaan',
            'Berkebutuhan Khusus',
            // Tambahkan kolom kegiatan sesuai dengan dataKegiatan
            // Contoh: 'Kegiatan 1', 'Kegiatan 2', ...
        ];
    }
}

