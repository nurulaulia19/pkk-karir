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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


class WargaExport implements FromCollection, WithHeadings, WithStyles
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

        // Informasi tentang setiap anggota keluarga dan kegiatan
        foreach ($this->keluarga->anggota as $index => $data_warga) {
            // dd($data_warga);
            $memberInfo = [
                'No' => $index + 1,
                'No Registrasi' => $data_warga->warga->no_registrasi,
                'Nama Anggota Keluarga' => $data_warga->warga->nama,
                'Status Dalam Keluarga' => $data_warga->status == 'kepala-keluarga'? 'Kepala Keluarga' : ucwords(strtolower($data_warga->status)),
                'Status Dalam Perkawinan' => $data_warga->warga->status_perkawinan,
                'Jenis Kelamin Laki' => $data_warga->warga->jenis_kelamin,
                // 'Jenis Kelamin Perempuan' => $data_warga->warga->jenis_kelamin  == 'perempuan' ? 1 : 0,
                // 'Tempat Lahir' => $data_warga->warga->tempat_lahir,
                'Tanggal Lahir/Umur' => $data_warga->warga->tgl_lahir ? Carbon::parse($data_warga->warga->tgl_lahir)->format('d/m/Y') . ' / ' . Carbon::parse($data_warga->warga->tgl_lahir)->age . ' Tahun' : '-',
                // 'Agama' => $data_warga->warga->agama,
                'Pendidikan' => $data_warga->warga->pendidikan == 'Pilih Pekerjaan'? '' : $data_warga->warga->pendidikan,
                'Pekerjaan' => $data_warga->warga->pekerjaan == 'Pilih Pekerjaan' ? '' : $data_warga->warga->pekerjaan,
            ];

            // Tambahkan informasi anggota keluarga ke koleksi data
            $data[] = $memberInfo;
            $data[] = []; // Baris kosong setelah setiap anggota keluarga
        }

        // Kembalikan koleksi data
        return collect($data);
    }

    public function headings(): array
    {
        $memberHeadings = [
            'NO',
            'NO REGISTRASI',
            'NAMA ANGGOTA KELUARGA',
            'STATUS KELUARGA',
            'STATUS PERKAWINAN',
            'JENIS KELAMIN',
            'TANGGAL LAHIR/UMUR',
            // 'AGAMA',
            'PENDIDIKAN',
            'PEKERJAAN',
        ];

        return [
            ['REKAPITULASI DATA WARGA KELUARGA'],
            [''],
            $memberHeadings,
            // $allHeadings
            // ['KETERANGAN']
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
        // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        $lastColumn = $sheet->getHighestColumn(); // Mendapatkan kolom terakhir yang berisi data
        $sheet->mergeCells('A1:' . $lastColumn . '1'); // Menggabungkan sel dari A1 sampai sel terakhir pada baris 1

        // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 ke tengah
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Mengatur teks pada baris 1 hingga 7 menjadi tebal (bold)
        $sheet->getStyle('1:3')->getFont()->setBold(true);

        // Menentukan rentang kolom untuk gaya (dari A7 sampai kolom terakhir yang berisi data)
        $dataRange = 'A3:' . $lastColumn . $sheet->getHighestRow();

        // Mengaplikasikan gaya pada rentang kolom yang telah ditentukan
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Warna hitam untuk border
                ],
            ],
        ]);

        // Mengatur Lebar kolom
        $lastColumn = $sheet->getHighestColumn();

        // Mendapatkan indeks numerik dari kolom terakhir (misalnya 18 untuk kolom 'R')
        $lastColumnIndex = Coordinate::columnIndexFromString($lastColumn);

        // Loop through each column from 'B' (indeks 2) to the last column (dynamically determined)
        for ($colIndex = 2; $colIndex <= $lastColumnIndex; $colIndex++) {
            // Konversi indeks numerik kolom kembali ke format huruf (misalnya 'B' untuk indeks 2)
            $col = Coordinate::stringFromColumnIndex($colIndex);

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
            $sheet->getColumnDimension($col)->setWidth($maxLength + 3);
        }

        // Mengatur Posisi Nomor di Tengah
        $sheet->getStyle('A3:B' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:B' . ($sheet->getHighestRow()))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Mengatur Posisi Nilai Kegiatan di Tengah
        // Mendapatkan kolom terakhir yang berisi data (dalam format huruf, misalnya 'R')
        $lastColumn = $sheet->getHighestColumn();

        // Mendapatkan indeks numerik dari kolom terakhir (misalnya 18 untuk kolom 'R')
        $lastColumnIndex = Coordinate::columnIndexFromString($lastColumn);

        // Loop through each column from 'K' (indeks 11) hingga kolom terakhir yang berisi data
        for ($colIndex = 11; $colIndex <= $lastColumnIndex; $colIndex++) {
            // Konversi indeks numerik kolom kembali ke format huruf (misalnya 'K' untuk indeks 11)
            $col = Coordinate::stringFromColumnIndex($colIndex);

            // Tentukan rentang kolom yang ingin diubah gaya (style)nya
            $columnRange = $col . '3:' . $col . $sheet->getHighestRow();

            // Set alignment (penyelarasan) teks ke tengah horizontal dan vertikal untuk rentang kolom
            $sheet->getStyle($columnRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($columnRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
    }
}
