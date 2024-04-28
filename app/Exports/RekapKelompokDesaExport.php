<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\WithStyles;

class RekapKelompokDesaExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $dasa_wisma = [];
    protected $totalRT;
    protected $totalRW;
    protected $totalJmlKK;
    protected $totalDasawisma;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainnya;
    protected $totalStiker;
    protected $totalJamban;
    protected $totalPemSampah;
    protected $totalSPAL;
    protected $totalSheatLayakHuni;
    protected $totalTidakSheatLayakHuni;
    protected $totalJmlKRT;
    protected $totalKegiatanIndustri;
    protected $totalKegiatanPemanfaatanPekarangan;
    protected $totalAnggotaLansia;
    protected $totalAnggotaIbuHamil;
    protected $totalAnggotaIbuMenyusui;
    protected $totalKegiatanLingkungan;
    protected $totalKegiatanUP2K;
    protected $totalAnggotaBerkebutuhanKhusus;
    protected $totalMakanBeras;
    protected $totalMakanNonBeras;
    protected $totalAnggotaBalitaLaki;
    protected $totalAnggotaPerempuan;
    protected $totalAnggotaWUS;
    protected $totalAnggotaPUS;
    protected $totalAnggotaBalitaPerempuan;
    protected $totalAnggotaLaki;

    public function __construct(array $data)
    {
        $this->dasa_wisma = $data['dasa_wisma'] ?? null;
        $this->totalRT = $data['totalRT'] ?? null;
        $this->totalRW = $data['totalRW'] ?? null;
        $this->totalJmlKK = $data['totalJmlKK'] ?? null;
        $this->totalDasawisma = $data['totalDasawisma'] ?? null;
        $this->totalAirPDAM = $data['totalAirPDAM'] ?? null;
        $this->totalAirSumur = $data['totalAirSumur'] ?? null;
        $this->totalAirLainnya = $data['totalAirLainnya'] ?? null;
        $this->totalStiker = $data['totalStiker'] ?? null;
        $this->totalJamban = $data['totalJamban'] ?? null;
        $this->totalPemSampah = $data['totalPemSampah'] ?? null;
        $this->totalSPAL = $data['totalSPAL'] ?? null;
        $this->totalSheatLayakHuni = $data['totalSheatLayakHuni'] ?? null;
        $this->totalTidakSheatLayakHuni = $data['totalTidakSheatLayakHuni'] ?? null;
        $this->totalJmlKRT = $data['totalJmlKRT'] ?? null;
        $this->totalKegiatanIndustri = $data['totalKegiatanIndustri'] ?? null;
        $this->totalKegiatanPemanfaatanPekarangan = $data['totalKegiatanPemanfaatanPekarangan'] ?? null;
        $this->totalAnggotaLansia = $data['totalAnggotaLansia'] ?? null;
        $this->totalAnggotaIbuHamil = $data['totalAnggotaIbuHamil'] ?? null;
        $this->totalAnggotaIbuMenyusui = $data['totalAnggotaIbuMenyusui'] ?? null;
        $this->totalKegiatanLingkungan = $data['totalKegiatanLingkungan'] ?? null;
        $this->totalKegiatanUP2K = $data['totalKegiatanUP2K'] ?? null;
        $this->totalAnggotaBerkebutuhanKhusus = $data['totalAnggotaBerkebutuhanKhusus'] ?? null;
        $this->totalMakanBeras = $data['totalMakanBeras'] ?? null;
        $this->totalMakanNonBeras = $data['totalMakanNonBeras'] ?? null;
        $this->totalAnggotaBalitaLaki = $data['totalAnggotaBalitaLaki'] ?? null;
        $this->totalAnggotaPerempuan = $data['totalAnggotaPerempuan'] ?? null;
        $this->totalAnggotaWUS = $data['totalAnggotaWUS'] ?? null;
        $this->totalAnggotaPUS = $data['totalAnggotaPUS'] ?? null;
        $this->totalAnggotaBalitaPerempuan = $data['totalAnggotaBalitaPerempuan'] ?? null;
        $this->totalAnggotaLaki = $data['totalAnggotaLaki'] ?? null;

    }

    public function array(): array
    {
        $result = [];
        $i = 1;
        $dasa_wisma = $this->dasa_wisma;

        foreach ($dasa_wisma as $desa) {
            $keluarga = $desa->keluarga;
            $counts = app(
                'App\Http\Controllers\AdminController',
            )->countRekapitulasiRWInDesa($desa->id);

            $data = [
                '_index' => $i,
                'kode_rw' => $desa->name  ?: '0',
                'jumlah_rt' => ucfirst($counts['rt']) ?: '0',
                'jumlah_dasa_wisma' => ucfirst($counts['countDasawisma']) ?: '0',
                'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                'jumlah_KK' =>  ucfirst($counts['countKK']) ?: '0',
                'jumlah_laki' => ucfirst($counts['laki_laki']) ?: '0',
                'jumlah_perempuan' =>  ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' =>ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['balitaPerempuan']) ?: '0',
                // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
                'jumlah_PUS' => ucfirst($counts['pus']) ?: '0',
                'jumlah_WUS' => ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['ibuHamil']) ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' =>  ucfirst($counts['lansia'])  ?: '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['kebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' =>ucfirst($counts['rumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['rumahNonSehat']) ?: '0',
                'punya_tempat_sampah' => ucfirst($counts['tempatSampah']) ?: '0',
                'punya_saluran_air' =>  ucfirst($counts['countSPAL']) ?: '0',
                'jumlah_punya_jamban' => ucfirst($counts['countJamban']) ?: '0',
                'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
                'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras']) ?: '0',
                'aktivitas_UP2K' => ucfirst($counts['aktivitasUP2K']) ?: '0',
                'pemanfaatan' => ucfirst($counts['pemanfaatanPekarangan']) ?: '0',
                'industri' =>ucfirst($counts['industriRumahTangga'])?: '0',
                'kesehatan_lingkungan' => ucfirst($counts['kesehatanLingkungan']) ?: '0',
            ];

            $result[] = $data;
            $i++;
        }

        $result[] = [
            '_index' => 'Jumlah',
            // 'dusun' => null,
            'jumlah_rw' => $this->totalRW ?: '0',
            'jumlah_rt' => $this->totalRT ?: '0',
            'jumlah_dasa_wisma' => $this->totalDasawisma ?: '0',
            'jumlah_KRT' => $this->totalJmlKRT ?: '0',
            'jumlah_KK' => $this->totalJmlKK ?: '0',
            'jumlah_laki' => $this->totalAnggotaLaki ?: '0',
            'jumlah_perempuan' => $this->totalAnggotaPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalAnggotaBalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalAnggotaBalitaPerempuan ?: '0',
            'jumlah_PUS' => $this->totalAnggotaPUS ?: '0',
            'jumlah_WUS' => $this->totalAnggotaWUS ?: '0',
            'jumlah_ibu_hamil' =>  $this->totalAnggotaIbuHamil ?: '0',
            'jumlah_ibu_menyusui' =>  $this->totalAnggotaIbuMenyusui ?: '0',
            'jumlah_lansia' =>  $this->totalAnggotaLansia ?: '0',
            'jumlah_kebutuhan_khusus' => $this->totalAnggotaBerkebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalSheatLayakHuni ?: '0',
            'tidak_sehat_layak_huni' => $this->totalTidakSheatLayakHuni ?: '0',
            'punya_tempat_sampah' => $this->totalPemSampah ?: '0',
            'punya_saluran_air' => $this->totalSPAL ?: '0',
            'jumlah_jamban' => $this->totalJamban ?: '0',
            'tempel_stiker' => $this->totalStiker ?: '0',
            'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
            'sumber_air_sumur' => $this->totalAirSumur ?: '0',
            'sumber_air_lainnya' => $this->totalAirLainnya ?: '0',
            'makanan_beras' => $this->totalMakanBeras ?: '0',
            'makanan_non_beras' => $this->totalMakanNonBeras ?: '0',
            'aktivitas_UP2K' => $this->totalKegiatanUP2K ?: '0',
            'pemanfaatan' => $this->totalKegiatanPemanfaatanPekarangan ?: '0',
            'industri' => $this->totalKegiatanIndustri ?: '0',
            'kesehatan_lingkungan' => $this->totalKegiatanLingkungan ?: '0',
        ];

        return $result;
    }

    public function headings(): array
    {
        // $headings = [
        //     'No',
        //     'Nama Dusun',
        //     'Jml. RW',
        //     'Jml. RT',
        //     'Jml. Dasawisma',
        //     'Jml. KRT',
        //     'Jml. KK',
        //     'Jumlah Anggota Keluarga',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     'Jumlah Rumah',
        //     '',
        //     '',
        //     '',
        //     '',
        //     '',
        //     'Sumber Air Keluarga',
        //     '',
        //     '',
        //     'Makanan Pokok',
        //     '',
        //     'Warga Mengikuti Kegiatan',
        //     '',
        //     '',
        //     '',
        // ];

        $headings2 = [
            'No',
            'Kode RW',
            'Jml RT',
            'Jml Dasawisma',
            'Jml Krt',
            'Jml KK',
            'Total L',
            'Total P',
            'Balita L',
            'Balita P',
            // '3 Buta',
            'PUS',
            'WUS',
            'Ibu Hamil',
            'Ibu Menyusui',
            'Lansia',
            'Berkebutuhan Khusus',
            'Sehat Layak Hunui',
            'Tidak Sehat Huni',
            'Memiliki Tmp. Pemb. Sampah',
            'Memiliki SPAL',
            'Memiliki Jamban Keluarga',
            'Menempel Stiker P4K',
            'Sumber air PDAM',
            'Sumber air sumur Sumur',
            'Sumber air lainya',
            'Beras',
            'Non Beras',
            'UP2K',
            'Pemanfaatan dan Pekarangan',
            'Industri Rumah Tangga',
            'Kesehatan Lingkungan',
        ];

        return [
            // ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['TP PKK DESA/KELURAHAN'],
            // ['Tahun : ' . $this->periode],
            [
                'TAHUN ' . strtoupper($this->dasa_wisma->first()->periode),
            ],
            // [
            //     'TP PKK Desa/Kelurahan : ' . strtoupper($this->dasa_wisma->dasawisma->desa->nama_desa),
            // ],
            // [
            //     'Kecamatan : ' . strtoupper($this->dasa_wisma->desa->kecamatan->nama_kecamatan),
            // ],
            // [
            //     'Kabupaten : ' . strtoupper($this->dasa_wisma->desa->kecamatan->kabupaten->name),
            // ],
            // [
            //     'Provinsi : ' . strtoupper($this->dasa_wisma->desa->kecamatan->kabupaten->provinsi->name),
            // ],
            // ['TP PKK Desa/Kelurahan : ' . $this->desa->nama_desa],
            // ['Kecamatan : ' . $this->kecamatan->nama_kecamatan],
            // ['Kabupaten : Indramayu'],
            // ['Provinsi : Jawa Barat'],
            [],
            // $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $event->sheet->getDelegate()->mergeCells('A1:AG1');
                // $event->sheet->getDelegate()->mergeCells('A2:AG2');
                // $event->sheet->getDelegate()->mergeCells('A3:AG3');
                // $event->sheet->getDelegate()->mergeCells('A4:AG4');
                // $event->sheet->getDelegate()->mergeCells('A5:AG5');
                // $event->sheet->getDelegate()->mergeCells('A6:AG6');
                // $event->sheet->getDelegate()->mergeCells('A7:AG7');
                // $event->sheet->getDelegate()->mergeCells('A8:AG8');

                // $event->sheet->getDelegate()->getStyle('A1:A8')->getAlignment()->setHorizontal('center');

                // $event->sheet->getDelegate()->mergeCells('A10:A11');
                // $event->sheet->getDelegate()->mergeCells('B10:B11');
                // $event->sheet->getDelegate()->mergeCells('C10:C11');
                // $event->sheet->getDelegate()->mergeCells('D10:D11');
                // $event->sheet->getDelegate()->mergeCells('E10:E11');
                // $event->sheet->getDelegate()->mergeCells('F10:F11');
                // $event->sheet->getDelegate()->mergeCells('G10:G11');

                // $event->sheet->getDelegate()->mergeCells('H10:R10');
                // $event->sheet->getDelegate()->mergeCells('S10:X10');
                // $event->sheet->getDelegate()->mergeCells('Y10:AA10');
                // $event->sheet->getDelegate()->mergeCells('AB10:AC10');
                // $event->sheet->getDelegate()->mergeCells('AD10:AG10');

                // $event->sheet->getDelegate()->getStyle('H10:AG10')->getAlignment()->setHorizontal('center');


                $lastRow = count($this->dasa_wisma) + 12;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
            },
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
        // $sheet->getStyle('A9:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($this->getBorderStyles());
        // // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        // $lastColumn = $sheet->getHighestColumn();
        // // // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        // // $lastColumn = $sheet->getHighestColumn();

        // // Menggabungkan sel dari A1 sampai A6 sampai dengan kolom terakhir yang berisi data
        // $sheet->mergeCells('A1:' . $lastColumn . '1');
        // $sheet->mergeCells('A2:' . $lastColumn . '2');
        // $sheet->mergeCells('A3:' . $lastColumn . '3');
        // $sheet->mergeCells('A4:' . $lastColumn . '4');
        // $sheet->mergeCells('A5:' . $lastColumn . '5');
        // $sheet->mergeCells('A6:' . $lastColumn . '6');
        // $sheet->mergeCells('A7:' . $lastColumn . '7');

        // // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 sampai A6 ke tengah
        // $sheet->getStyle('A1:A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // // Mengatur teks pada baris 1 hingga 7 menjadi tebal (bold)
        // $sheet->getStyle('1:9')->getFont()->setBold(true);

        // $lastColumnIndex = Coordinate::columnIndexFromString($lastColumn);

        // // Loop through each column from 'B' (indeks 2) to the last column (dynamically determined)
        // for ($colIndex = 2; $colIndex <= $lastColumnIndex; $colIndex++) {
        //     // Konversi indeks numerik kolom kembali ke format huruf (misalnya 'B' untuk indeks 2)
        //     $col = Coordinate::stringFromColumnIndex($colIndex);

        //     $maxLength = 0;

        //     // Find the maximum length of text in the current column
        //     for ($row = 1; $row <= $sheet->getHighestRow(); $row++) {
        //         $cellValue = $sheet->getCell($col . $row)->getValue();
        //         $cellLength = strlen($cellValue);

        //         if ($cellLength > $maxLength) {
        //             $maxLength = $cellLength;
        //         }
        //     }

        //     // Set the column width to accommodate the longest text plus some padding
        //     $sheet->getColumnDimension($col)->setWidth($maxLength + 6);
        //     $sheet->getStyle($col)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //     $sheet->getStyle($col)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        //     // // Lakukan merge pada sel D10 ke L10
        //     // $sheet->mergeCells('E9:N9');
        //     // $sheet->mergeCells('O9:T9');
        //     // $sheet->mergeCells('U9:W9');
        //     // $sheet->mergeCells('X9:Y9');
        //     // $sheet->mergeCells('Z9:AC9');

        // }

        // $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('D');

        // for ($col = 'A'; $col <= 'D'; $col++) {
        //     // Simpan nilai sel sebelum digabungkan
        //     $value = $sheet->getCell($col . '10')->getValue();

        //     // Pindahkan nilai sel ke sel atas
        //     $sheet->setCellValue($col . '9', $value);

        //     // Gabungkan sel secara vertikal
        //     $sheet->mergeCells($col . '9:' . $col . '10');

        //     // Atur penyelarasan vertikal ke tengah
        //     $sheet->getStyle($col . '9:' . $col . '10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // }

    }
}
