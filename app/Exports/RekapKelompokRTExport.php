<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class RekapKelompokRTExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $dasa_wisma = [];
    protected $totalDasawisma;
    protected $totalJmlKRT;
    protected $totalJmlKK;
    protected $totalAnggotaLansia;
    protected $totalAnggotaIbuHamil;
    protected $totalAnggotaIbuMenyusui;
    protected $totalKegiatanUP2K;
    protected $totalAnggotaBerkebutuhanKhusus;
    protected $totalMakanBeras;
    protected $totalMakanNonBeras;
    protected $totalKegiatanLingkungan;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainnya;
    protected $totalPemSampah;
    protected $totalSPAL;
    protected $totalJamban;
    protected $totalStiker;
    protected $totalSheatLayakHuni;
    protected $totalTidakSheatLayakHuni;
    protected $totalKegiatanIndustri;
    protected $totalKegiatanPemanfaatanPekarangan;
    protected $totalAnggotaBalitaLaki;
    protected $totalAnggotaLaki;
    protected $totalAnggotaPerempuan;
    protected $totalAnggotaWUS;
    protected $totalAnggotaBalitaPerempuan;
    protected $totalAnggotaPUS;
    protected $periode;

    public function __construct(array $data)
{
    $this->dasa_wisma = $data['dasa_wisma'] ?? null;
    $this->totalDasawisma = $data['totalDasawisma'] ?? null;
    $this->totalJmlKRT = $data['totalJmlKRT'] ?? null;
    $this->totalJmlKK = $data['totalJmlKK'] ?? null;
    $this->totalAnggotaLansia = $data['totalAnggotaLansia'] ?? null;
    $this->totalAnggotaIbuHamil = $data['totalAnggotaIbuHamil'] ?? null;
    $this->totalAnggotaIbuMenyusui = $data['totalAnggotaIbuMenyusui'] ?? null;
    $this->totalKegiatanUP2K = $data['totalKegiatanUP2K'] ?? null;
    $this->totalAnggotaBerkebutuhanKhusus = $data['totalAnggotaBerkebutuhanKhusus'] ?? null;
    $this->totalMakanBeras = $data['totalMakanBeras'] ?? null;
    $this->totalMakanNonBeras = $data['totalMakanNonBeras'] ?? null;
    $this->totalKegiatanLingkungan = $data['totalKegiatanLingkungan'] ?? null;
    $this->totalAirPDAM = $data['totalAirPDAM'] ?? null;
    $this->totalAirSumur = $data['totalAirSumur'] ?? null;
    $this->totalAirLainnya = $data['totalAirLainnya'] ?? null;
    $this->totalPemSampah = $data['totalPemSampah'] ?? null;
    $this->totalSPAL = $data['totalSPAL'] ?? null;
    $this->totalJamban = $data['totalJamban'] ?? null;
    $this->totalStiker = $data['totalStiker'] ?? null;
    $this->totalSheatLayakHuni = $data['totalSheatLayakHuni'] ?? null;
    $this->totalTidakSheatLayakHuni = $data['totalTidakSheatLayakHuni'] ?? null;
    $this->totalKegiatanIndustri = $data['totalKegiatanIndustri'] ?? null;
    $this->totalKegiatanPemanfaatanPekarangan = $data['totalKegiatanPemanfaatanPekarangan'] ?? null;
    $this->totalAnggotaBalitaLaki = $data['totalAnggotaBalitaLaki'] ?? null;
    $this->totalAnggotaLaki = $data['totalAnggotaLaki'] ?? null;
    $this->totalAnggotaPerempuan = $data['totalAnggotaPerempuan'] ?? null;
    $this->totalAnggotaWUS = $data['totalAnggotaWUS'] ?? null;
    $this->totalAnggotaBalitaPerempuan = $data['totalAnggotaBalitaPerempuan'] ?? null;
    $this->totalAnggotaPUS = $data['totalAnggotaPUS'] ?? null;
    $this->periode = $data['periode'] ?? Carbon::now()->year;
}


    /**
    * @return array
    */
    public function array(): array
    {
        $result = [];
        $i = 1;
        $dasa_wisma = $this->dasa_wisma;
        // dd($this->periode);

        foreach ($dasa_wisma as $dasawisma) {
            $counts = app(
                'App\Http\Controllers\AdminController',
            )->countRekapitulasiDasawismaInRt($dasawisma->id, $this->periode);
            $data = [
                '_index' => $i,
                'nama' => $dasawisma->nama_dasawisma,
                'jumlah_KRT' => ucfirst($counts['countRumahTangga'])?: '0',
                'jumlah_KK' =>  ucfirst($counts['countKK']) ?: '0',
                'jumlah_laki' =>ucfirst($counts['laki_laki']) ?: '0',
                'jumlah_perempuan' => ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' => ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['balitaPerempuan'])  ?: '0',
                // 'jumlah_3_buta' => $dasawisma->jumlah_3_buta ?: '0',
                'jumlah_PUS' =>ucfirst($counts['pus'])  ?: '0',
                'jumlah_WUS' => ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' =>  ucfirst($counts['ibuHamil']) ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' => ucfirst($counts['lansia'])  ?: '0',
                'tiga_buta' =>  '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['kebutuhanKhusus'])  ?: '0',
                'sehat_layak_huni' => ucfirst($counts['rumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['rumahNonSehat']) ?: '0',
                'punya_tempat_sampah' =>  ucfirst($counts['tempatSampah']) ?: '0',
                'punya_saluran_air' =>ucfirst($counts['countSPAL'])  ?: '0',
                'punya_jamban' => ucfirst($counts['countJamban']) ?: '0',
                'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' =>ucfirst($counts['countAirLainya']) ?: '0',
                'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras']) ?: '0',
                'aktivitas_UP2K' => ucfirst($counts['aktivitasUP2K']) ?: '0',
                'pemanfaatan' => ucfirst($counts['pemanfaatanPekarangan']) ?: '0',
                'industri' => ucfirst($counts['industriRumahTangga']) ?: '0',
                'kesehatan_lingkungan' => ucfirst($counts['kesehatanLingkungan']) ?: '0',
            ];

            $result[] = $data;
            $i++;
        }

        $result[] = [
            '_index' => 'JUMLAH',
            'nama' => null,
            'jumlah_KRT' => $this->totalJmlKRT ?: '0',
            'jumlah_KK' => $this->totalJmlKK ?: '0',
            'jumlah_laki' => $this->totalAnggotaLaki ?: '0',
            'jumlah_perempuan' => $this->totalAnggotaPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalAnggotaBalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalAnggotaBalitaPerempuan ?: '0',
            // 'jumlah_3_buta' => $dasa_wisma->sum('jumlah_3_buta') ?: '0',
            'jumlah_PUS' => $this->totalAnggotaPUS ?: '0',
            'jumlah_WUS' => $this->totalAnggotaWUS ?: '0',
            'jumlah_ibu_hamil' => $this->totalAnggotaIbuHamil ?: '0',
            'jumlah_ibu_menyusui' => $this->totalAnggotaIbuMenyusui ?: '0',
            'jumlah_lansia' => $this->totalAnggotaLansia ?: '0',
            'jumlah_tiga_buta' =>  '0',
            'jumlah_kebutuhan_khusus' => $this->totalAnggotaBerkebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalSheatLayakHuni ?: '0',
            'tidak_sehat_layak_huni' => $this->totalTidakSheatLayakHuni ?: '0',
            'punya_tempat_sampah' => $this->totalPemSampah ?: '0',
            'punya_saluran_air' => $this->totalSPAL ?: '0',
            'punya_jamban' => $this->totalJamban ?: '0',
            'tempel_stiker' => $this->totalStiker ?: '0',
            'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
            'sumber_air_sumur' => $this->totalAirSumur ?: '0',
            'sumber_air_lainya' => $this->totalAirLainnya ?: '0',
            'makanan_pokok_beras' => $this->totalMakanBeras ?: '0',
            'makanan_pokok_non_beras' => $this->totalMakanNonBeras ?: '0',
            'aktivitas_UP2K' => $this->totalKegiatanUP2K ?: '0',
            'pemanfaatan' => $this->totalKegiatanPemanfaatanPekarangan ?: '0',
            'industri' => $this->totalKegiatanIndustri ?: '0',
            'aktivitas_kesehatan_lingkungan' => $this->totalKegiatanLingkungan ?: '0',
        ];

        return $result;
    }

    public function headings(): array
    {
        $headings = [
            '',
            '',
            '',
            '',
            'JUMLAH ANGGOTA KELUARGA',
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
            'KRITERIA RUMAH',
            '',
            '',
            '',
            '',
            '',
            'SUMBER AIR KELUARGA',
            '',
            '',
            'MAKANAN POKOK',
            '',
            'WARGA MENGIKUTI KEGIATAN',
            '',
            '',
            '',
            'KETERANGAN'
        ];

        $headings2 = [
            'NO',
            'NAMA DASAWISMA',
            'JUMLAH KRT',
            'JUMLAH KK',
            'TOTAL L',
            'TOTAL P',
            'BALITA L',
            'BALITA P',
            'PUS',
            'WUS',
            'IBU HAMIL',
            'IBU MENYUSUI',
            'LANSIA',
            '3 BUTA',
            'BERKEBUTUHAN KHUSUS',
            'SEHAT',
            'KURANG SEHAT',
            'MEMILIKI TMP. PEMB. SAMPAH',
            'MEMILIKI SPAL',
            'MEMILIKI JAMBAN KELUARGA',
            'MENEMPEL STIKER P4K',
            'PDAM',
            'SUMUR',
            'DLL',
            'BERAS',
            'NON BERAS',
            'UP2K',
            'PEMANFAATAN PEKARANGAN',
            'INDUSTRI RUMAH TANGGA',
            'KESEHATAN LINGKUNGAN',
        ];


        return [
            ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['KELOMPOK PKK RT'],
            [
                'RT : ' . strtoupper($this->dasa_wisma->first()->rt->name),
            ],
            [
                'RW : ' . strtoupper($this->dasa_wisma->first()->rw->name),
            ],
            [
                'DESA/KELURAHAN : ' . strtoupper($this->dasa_wisma->first()->desa->nama_desa),
            ],
            [
                'TAHUN : ' . strtoupper($this->periode),
            ],
            [],
            $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('AE9:AE10');
                $lastRow = count($this->dasa_wisma) + 11; // Nomor baris terakhir data + 11 (sesuaikan dengan kebutuhan)
                // Lakukan merge langsung pada objek lembar kerja (worksheet)
                $event->sheet->mergeCells('A'.$lastRow.':B'.$lastRow);

                // Atur style untuk judul "JUMLAH"
                $event->sheet->getStyle('A'.$lastRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
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
        $sheet->getStyle('A9:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($this->getBorderStyles());
        // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        $lastColumn = $sheet->getHighestColumn();
        // // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        // $lastColumn = $sheet->getHighestColumn();

        // Menggabungkan sel dari A1 sampai A6 sampai dengan kolom terakhir yang berisi data
        $sheet->mergeCells('A1:' . $lastColumn . '1');
        $sheet->mergeCells('A2:' . $lastColumn . '2');
        $sheet->mergeCells('A3:' . $lastColumn . '3');
        $sheet->mergeCells('A4:' . $lastColumn . '4');
        $sheet->mergeCells('A5:' . $lastColumn . '5');
        $sheet->mergeCells('A6:' . $lastColumn . '6');
        $sheet->mergeCells('A7:' . $lastColumn . '7');

        // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 sampai A6 ke tengah
        $sheet->getStyle('A1:A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Mengatur teks pada baris 1 hingga 7 menjadi tebal (bold)
        $sheet->getStyle('1:9')->getFont()->setBold(true);

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
            $sheet->getColumnDimension($col)->setWidth($maxLength + 6);
            $sheet->getStyle($col)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


            // // Lakukan merge pada sel D10 ke L10
            $sheet->mergeCells('E9:O9');
            $sheet->mergeCells('P9:U9');
            $sheet->mergeCells('V9:X9');
            $sheet->mergeCells('Y9:Z9');
            $sheet->mergeCells('AA9:AD9');

        }

        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('D');

        for ($col = 'A'; $col <= 'D'; $col++) {
            // Simpan nilai sel sebelum digabungkan
            $value = $sheet->getCell($col . '10')->getValue();

            // Pindahkan nilai sel ke sel atas
            $sheet->setCellValue($col . '9', $value);

            // Gabungkan sel secara vertikal
            $sheet->mergeCells($col . '9:' . $col . '10');

            // Atur penyelarasan vertikal ke tengah
            $sheet->getStyle($col . '9:' . $col . '10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

    }


}
