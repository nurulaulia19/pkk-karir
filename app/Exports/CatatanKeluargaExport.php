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
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            'KRITERIA RUMAH: ' . ($rumahTangga->kriteria_rumah_sehat ? 'LAYAK HUNI' : 'TIDAK LAYAK HUNI'),
        ];
        $headings2 = [
            'ANGGOTA KELOMPOK DASAWISMA: ' . $this->dasawisma->nama_dasawisma,
            '',
            '',
            '',
            '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            'JAMBAN KELUARGA: ' . ($rumahTangga->punya_jamban ? 'ADA 1 BUAH' : 'TIDAK ADA'),
        ];

        $headings3 = [
            'TAHUN: ' . $this->keluarga->periode,
            '',
            '',
            '',
            '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            'SUMBER AIR: ' . ($air),
        ];

        $headings4 = [
            '',
            '',
            '',
            '',
            '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            // '',
            'TEMPAT SAMPAH: ' . ($rumahTangga->punya_tempat_sampah ? 'ADA' : 'TIDAK ADA'),
        ];

        $headings5 = [
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
            'KEGIATAN PKK YANG DIIKUTI'
        ];

        $memberHeadings = [
            'NO',
            'NAMA ANGGOTA KELUARGA',
            'STATUS PERKAWINAN',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR/UMUR',
            'AGAMA',
            'PENDIDIKAN',
            'PEKERJAAN',
            'BERKEBUTUHAN KHUSUS',
        ];

        // Tambahkan judul kolom untuk setiap kegiatan
        foreach ($this->dataKegiatan as $item) {
            $memberHeadings[] = strtoupper($item->name);
        }

        $endHeadings = [
            'KETERANGAN'
        ];

         // Gabungkan array judul kolom
        $allHeadings = array_merge($memberHeadings, $endHeadings);

        return [
            ['CATATAN KELUARGA ' . strtoupper($this->keluarga->nama_kepala_keluarga)],
            $headings,
            $headings2,
            $headings3,
            $headings4,
            [''],
            $headings5,
            // $memberHeadings,
            $allHeadings
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
        $sheet->getStyle('1:8')->getFont()->setBold(true);

        // Menentukan rentang kolom untuk gaya (dari A7 sampai kolom terakhir yang berisi data)
        $dataRange = 'A7:' . $lastColumn . $sheet->getHighestRow();

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
        $sheet->getStyle('A7:A' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:A' . ($sheet->getHighestRow()))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

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
            $columnRange = $col . '7:' . $col . $sheet->getHighestRow();

            // Set alignment (penyelarasan) teks ke tengah horizontal dan vertikal untuk rentang kolom
            $sheet->getStyle($columnRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($columnRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Mengatur cells merged secara vertikal
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('J');

        for ($col = 'A'; $col <= 'J'; $col++) {
            // Simpan nilai sel sebelum digabungkan
            $value = $sheet->getCell($col . '8')->getValue();

            // Pindahkan nilai sel ke sel atas
            $sheet->setCellValue($col . '7', $value);

            // Gabungkan sel secara vertikal
            $sheet->mergeCells($col . '7:' . $col . '8');

            // Atur penyelarasan vertikal ke tengah
            $sheet->getStyle($col . '7:' . $col . '8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        $kolomAwal = 'K';
        $jumlahKegiatan = count($this->dataKegiatan);
        $kolomAkhir = chr(ord($kolomAwal[0]) + $jumlahKegiatan - 1);
        // dd($kolomAkhir);

        $sheet->mergeCells($kolomAwal . '7:' . $kolomAkhir . '7');
        $sheet->getStyle($kolomAwal . '7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($kolomAwal . '7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Mendapatkan huruf dari kolom terakhir yang berisi data
        $lastColumn = $sheet->getHighestColumn();

        // Mendapatkan nilai dari sel di baris 8 pada kolom terakhir
        $value = $sheet->getCell($lastColumn . '8')->getValue();

        // Pindahkan nilai sel di baris 8 ke sel di baris 7 pada kolom terakhir
        $sheet->setCellValue($lastColumn . '7', $value);

        // Gabungkan baris 7 dan 8 untuk kolom terakhir saja
        $sheet->mergeCells($lastColumn . '7:' . $lastColumn . '8');

        // Atur penyelarasan vertikal ke tengah untuk sel yang digabungkan
        $sheet->getStyle($lastColumn . '7:' . $lastColumn . '8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
}
