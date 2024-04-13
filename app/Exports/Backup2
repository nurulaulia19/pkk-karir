<?php

namespace App\Exports;

use App\Models\DataKeluarga;
use App\Models\DasaWisma;
use App\Models\RumahTangga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CatatanKeluargaExport implements FromCollection, WithHeadings, WithStyles
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

        // Informasi tentang keluarga
        // $keluargaFirst = $this->keluarga->rumah_tangga->first();
        // $rumahTangga = RumahTangga::find($keluargaFirst->rumahtangga_id);
        // $pdam = $rumahTangga->sumber_air_pdam ? 'PDAM' : '';
        // $sumur = $rumahTangga->sumber_air_sumur ? 'SUMUR' : '';
        // $lainnya = $rumahTangga->sumber_air_lainnya ? 'LAINNYA' : '';
        // $air = trim($pdam . ' ' . $sumur . ' ' . $lainnya);

        // $familyInfo = [
        //     'CATATAN KELUARGA DARI: ' => $this->keluarga->nama_kepala_keluarga,
        //     'ANGGOTA KELOMPOK DASAWISMA: ' => $this->dasawisma->nama_dasawisma,
        //     'TAHUN: ' => $this->keluarga->periode,
        //     'Kriteria Rumah: ' => $rumahTangga->kriteria_rumah_sehat ? 'LAYAK HUNI' : 'TIDAK LAYAK HUNI',
        //     'Jamban Keluarga: ' => $rumahTangga->punya_jamban ? 'ADA 1 BUAH' : 'TIDAK ADA',
        //     'Sumber Air: ' => $air,
        //     'Tempat Sampah: ' => $rumahTangga->punya_tempat_sampah ? 'ADA' : 'TIDAK ADA'
        // ];

        // // Tambahkan informasi keluarga ke koleksi data
        // $data[] = $familyInfo;
        // $data[] = []; // Baris kosong pertama
        // $data[] = []; // Baris kosong kedua

        // Informasi tentang setiap anggota keluarga dan kegiatan
        foreach ($this->keluarga->anggota as $index => $data_warga) {
            $memberInfo = [
                'No' => $index + 1,
                'Nama Anggota Keluarga' => $data_warga->warga->nama,
                'Status Perkawinan' => $data_warga->warga->status_perkawinan,
                'Jenis Kelamin' => $data_warga->warga->jenis_kelamin,
                'Tempat Lahir' => $data_warga->warga->tempat_lahir,
                'Tanggal Lahir/Umur' => $data_warga->warga->tgl_lahir ? Carbon::parse($data_warga->warga->tgl_lahir)->format('d/m/Y') . ' / ' . Carbon::parse($data_warga->warga->tgl_lahir)->age . ' Tahun' : '-',
                'Agama' => $data_warga->warga->agama,
                'Pendidikan' => $data_warga->warga->pendidikan,
                'Pekerjaan' => $data_warga->warga->pekerjaan,
                'Berkebutuhan Khusus' => $data_warga->warga->berkebutuhan_khusus
            ];

            // Tambahkan kegiatan untuk setiap anggota keluarga
            foreach ($this->dataKegiatan as $kegiatan) {
                $ada = false;
                foreach ($data_warga->warga->kegiatan as $wargaKegiatan) {
                    if ($wargaKegiatan->data_kegiatan_id == $kegiatan->id) {
                        $ada = true;
                        break;
                    }
                }
                $memberInfo[$kegiatan->name] = $ada ? ' ✓' : '0';

            }

            // Tambahkan informasi anggota keluarga ke koleksi data
            $data[] = $memberInfo;
            $data[] = []; // Baris kosong setelah setiap anggota keluarga
        }

        // Kembalikan koleksi data
        return collect($data);
    }

    public function headings(): array
    {

        $keluargaFirst = $this->keluarga->rumah_tangga->first();
        $rumahTangga = RumahTangga::find($keluargaFirst->rumahtangga_id);
        $pdam = $rumahTangga->sumber_air_pdam ? 'PDAM' : '';
        $sumur = $rumahTangga->sumber_air_sumur ? 'SUMUR' : '';
        $lainnya = $rumahTangga->sumber_air_lainnya ? 'LAINNYA' : '';
        $air = trim($pdam . ' ' . $sumur . ' ' . $lainnya);

        $headings = [
            'CATATAN KELUARGA DARI: ' . $this->keluarga->nama_kepala_keluarga,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'KRITERIA RUMAH: ' . ($rumahTangga->kriteria_rumah_sehat ? 'LAYAK HUNI' : 'TIDAK LAYAK HUNI'),
        ];
        $headings2 = [
            'ANGGOTA KELOMPOK DASAWISMA: ' . $this->dasawisma->nama_dasawisma,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'JAMBAN KELUARGA: ' . ($rumahTangga->punya_jamban ? 'ADA 1 BUAH' : 'TIDAK ADA'),
        ];

        $headings3 = [
            'TAHUN: ' . $this->keluarga->periode,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'SUMBER AIR: ' . ($air),
        ];

        $headings4 = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'TEMPAT SAMPAH: ' . ($rumahTangga->punya_tempat_sampah ? 'ADA' : 'TIDAK ADA'),
        ];

        $memberHeadings = [
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
            $memberHeadings[] = $item->name;
        }

        $keluargaFirst = $this->keluarga->rumah_tangga->first();
        $rumahTangga = RumahTangga::find($keluargaFirst->rumahtangga_id);
        $pdam = $rumahTangga->sumber_air_pdam ? 'PDAM' : '';
        $sumur = $rumahTangga->sumber_air_sumur ? 'SUMUR' : '';
        $lainnya = $rumahTangga->sumber_air_lainnya ? 'LAINNYA' : '';
        $air = trim($pdam . ' ' . $sumur . ' ' . $lainnya);

        return [
            ['CATATAN KELUARGA ' . strtoupper($this->keluarga->nama_kepala_keluarga)],
            $headings,
            $headings2,
            $headings3,
            $headings4,
            [''],
            $memberHeadings,
        ];

    }

    public function getBorderStyles()
    {
        return [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];


    }

    public function getStyles(): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function styles(Worksheet $sheet){
        $sheet->mergeCells('A1:R1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1:7')->getFont()->setBold(true);
        $sheet->getStyle('A7:R' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

         // Loop through each column from 'A' to 'R'
        for ($col = 'B'; $col <= 'R'; $col++) {
            $maxLength = 0;

            // Find the maximum length of text in the current column
            for ($row = 1; $row <= $sheet->getHighestRow(); $row++) {
                $cellValue = $sheet->getCell($col . $row)->getValue();
                $cellLength = strlen($cellValue);

                if ($cellLength > $maxLength) {
                    $maxLength = $cellLength;
                }
            }

            // Set the column width to accommodate the longest text plus some padding
            $sheet->getColumnDimension($col)->setWidth($maxLength + 2);
        }

        $sheet->getStyle('A7:A' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:A' . ($sheet->getHighestRow()))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        for ($col = 'K'; $col <= 'R'; $col++) {
            // Tentukan rentang kolom yang ingin diubah gaya (style)nya
            $columnRange = $col . '7:' . $col . ($sheet->getHighestRow());

            // Set alignment (penyelarasan) teks ke tengah horizontal dan vertikal untuk rentang kolom
            $sheet->getStyle($columnRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($columnRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
    }
}
