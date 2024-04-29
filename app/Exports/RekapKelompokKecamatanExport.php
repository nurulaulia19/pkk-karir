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



class RekapKelompokKecamatanExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $desaa;
    protected $totalDesa;
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
        $this->desaa = $data['desaa'] ?? null;
        $this->totalDesa = $data['totalDesa'] ?? null;
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
        $desa = $this->desaa;

        foreach ($desa as $des) {
            $counts = app(
                'App\Http\Controllers\AdminKabController',
            )->countRekapitulasiRWInDesa($des->id);

            $data = [
                '_index' => $i,
                'desa' => $des->nama_desa,
                'jumlah_rw' => ucfirst($counts['countRW']) ?: '0',
                'jumlah_rt' => ucfirst($counts['rt']) ?: '0',
                'jumlah_dasa_wisma' => ucfirst($counts['countDasawisma']) ?: '0',
                'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                'jumlah_KK' => ucfirst($counts['countKK'])?: '0',
                'jumlah_laki' => ucfirst($counts['laki_laki']) ?: '0',
                'jumlah_perempuan' => ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' => ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['balitaPerempuan']) ?: '0',
                'jumlah_PUS' => ucfirst($counts['pus'])?: '0',
                'jumlah_WUS' => ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['ibuHamil'])  ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' => ucfirst($counts['lansia']) ?: '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['kebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' => ucfirst($counts['rumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['rumahNonSehat']) ?: '0',
                'punya_tempat_sampah' => ucfirst($counts['tempatSampah']) ?: '0',
                'punya_saluran_air' => ucfirst($counts['countSPAL']) ?: '0',
                'jumlah_jamban' => ucfirst($counts['countJamban']) ?: '0',
                'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
                'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras'])  ?: '0',
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
            'desa' => ' ',
                'jumlah_rw' => $this->totalRW ?: '0',
                'jumlah_rt' => $this->totalRT ?: '0',
                'jumlah_dasa_wisma' => $this->totalDasawisma ?: '0',
                'jumlah_KRT' =>$this->totalJmlKRT ?: '0',
                'jumlah_KK' =>  $this->totalJmlKK ?: '0',
                'jumlah_laki' => $this->totalAnggotaLaki ?: '0',
                'jumlah_perempuan' => $this->totalAnggotaPerempuan ?: '0',
                'jumlah_balita_laki' => $this->totalAnggotaBalitaLaki ?: '0',
                'jumlah_balita_perempuan' => $this->totalAnggotaBalitaPerempuan ?: '0',
                'jumlah_PUS' => $this->totalAnggotaPUS ?: '0',
                'jumlah_WUS' => $this->totalAnggotaWUS ?: '0',
                'jumlah_ibu_hamil' => $this->totalAnggotaIbuHamil ?: '0',
                'jumlah_ibu_menyusui' => $this->totalAnggotaIbuHamil ?: '0',
                'jumlah_lansia' => $this->totalAnggotaLansia ?: '0',
                'jumlah_kebutuhan_khusus' => $this->totalAnggotaBerkebutuhanKhusus ?: '0',
                'sehat_layak_huni' => $this->totalSheatLayakHuni ?: '0',
                'tidak_sehat_layak_huni' => $this->totalTidakSheatLayakHuni ?: '0',
                'punya_tempat_sampah' => $this->totalPemSampah ?: '0',
                'punya_saluran_air' => $this->totalSPAL ?: '0',
                'jumlah_jamban' => $this->totalJamban ?: '0',
                'tempel_stiker' => $this->totalStiker ?: '0',
                'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
                'sumber_air_sumur' => $this->totalAirSumur ?: '0',
                'sumber_air_lainya' => $this->totalAirLainnya ?: '0',
                'makanan_pokok_beras' => $this->totalMakanBeras ?: '0',
                'makanan_pokok_non_beras' =>$this->totalMakanNonBeras  ?: '0',
                'aktivitas_UP2K' => $this->totalKegiatanUP2K ?: '0',
                'pemanfaatan' => $this->totalKegiatanPemanfaatanPekarangan ?: '0',
                'industri' => $this->totalKegiatanIndustri ?: '0',
                'kesehatan_lingkungan' => $this->totalKegiatanLingkungan ?: '0',
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
            '',
        ];

        $headings2 = [
            'NO',
            'NAMA DESA',
            'JML RW',
            'JML RT',
            'JML DASAWISMA',
            'JML KRT',
            'JML KK',
            'TOTAL L',
            'TOTAL P',
            'BALITA L',
            'BALITA P',
            'PUS',
            'WUS',
            'IBU HAMIL',
            'IBU MENYUSUI',
            'LANSIA',
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
            'PEMANFAATAN DAN PEKARANGAN',
            'INDUSTRI RUMAH TANGGA',
            'KESEHATAN LINGKUNGAN',
        ];

        return [

            ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['TP PKK KECAMATAN'],
            ['TAHUN ' . $this->desaa->first()->dasawisma->first()->periode],
            ['Kecamatan : ' . $this->desaa->first()->dasawisma->first()->desa->kecamatan->nama_kecamatan],
            ['Kabupaten : Indramayu'],
            ['Provinsi : Jawa Barat'],
            [],
            $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = count($this->desaa) + 11;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
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
        $sheet->mergeCells('A1:' . $lastColumn . '1');
        $sheet->mergeCells('A2:' . $lastColumn . '2');
        $sheet->mergeCells('A3:' . $lastColumn . '3');
        $sheet->mergeCells('A4:' . $lastColumn . '4');
        $sheet->mergeCells('A5:' . $lastColumn . '5');
        $sheet->mergeCells('A6:' . $lastColumn . '6');
        $sheet->mergeCells('A7:' . $lastColumn . '7');

        // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 sampai A6 ke tengah
        $sheet->getStyle('A1:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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

            $sheet->mergeCells('G9:Q9');
            $sheet->mergeCells('R9:W9');
            $sheet->mergeCells('X9:Z9');
            $sheet->mergeCells('AA9:AB9');
            $sheet->mergeCells('AC9:AF9');

        }

        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('F');

        for ($col = 'A'; $col <= 'F'; $col++) {
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
