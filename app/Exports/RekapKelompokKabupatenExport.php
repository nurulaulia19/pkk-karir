<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapKelompokKabupatenExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $kecamatans;
    protected $totalDesa;
    protected $totalRw;
    protected $totalRt;
    protected $totalKK;
    protected $totalDasawisma;
    protected $totalRumahTangga;
    protected $totalTempatSampah;
    protected $totalSPAL;
    protected $totalJamban;
    protected $totalStiker;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainya;
    protected $totalKriteriaRumahSehat;
    protected $totalKriteriaRumahNonSehat;
    protected $totalIndustri;
    protected $totalPemanfaatanPekarangan;
    protected $totalBeras;
    protected $totalNonBeras;
    protected $totalLansia;
    protected $totalIbuHamil;
    protected $totalIbuMenyesui;
    protected $totalAktivitasKesehatanLingkungan;
    protected $totalAaktivitasUP2K;
    protected $totalKebutuhanKhusus;
    protected $totalLakiLaki;
    protected $totalBalitaLaki;
    protected $totalPerempuan;
    protected $totalWUS;
    protected $totalbalitaPerempuan;
    protected $totalPUS;
    protected $periode;

    public function __construct(array $data)
    {
        $this->kecamatans = $data['kecamatans'] ?? [];
        $this->totalDesa = $data['totalDesa'] ?? 0;
        $this->totalRw = $data['totalRw'] ?? 0;
        $this->totalRt = $data['totalRt'] ?? 0;
        $this->totalKK = $data['totalKK'] ?? 0;
        $this->totalDasawisma = $data['totalDasawisma'] ?? 0;
        $this->totalRumahTangga = $data['totalRumahTangga'] ?? 0;
        $this->totalTempatSampah = $data['totalTempatSampah'] ?? 0;
        $this->totalSPAL = $data['totalSPAL'] ?? 0;
        $this->totalJamban = $data['totalJamban'] ?? 0;
        $this->totalStiker = $data['totalStiker'] ?? 0;
        $this->totalAirPDAM = $data['totalAirPDAM'] ?? 0;
        $this->totalAirSumur = $data['totalAirSumur'] ?? 0;
        $this->totalAirLainya = $data['totalAirLainya'] ?? 0;
        $this->totalKriteriaRumahSehat = $data['totalKriteriaRumahSehat'] ?? 0;
        $this->totalKriteriaRumahNonSehat = $data['totalKriteriaRumahNonSehat'] ?? 0;
        $this->totalIndustri = $data['totalIndustri'] ?? 0;
        $this->totalPemanfaatanPekarangan = $data['totalPemanfaatanPekarangan'] ?? 0;
        $this->totalBeras = $data['totalBeras'] ?? 0;
        $this->totalNonBeras = $data['totalNonBeras'] ?? 0;
        $this->totalLansia = $data['totalLansia'] ?? 0;
        $this->totalIbuHamil = $data['totalIbuHamil'] ?? 0;
        $this->totalIbuMenyesui = $data['totalIbuMenyesui'] ?? 0;
        $this->totalAktivitasKesehatanLingkungan = $data['totalAktivitasKesehatanLingkungan'] ?? 0;
        $this->totalAaktivitasUP2K = $data['totalAaktivitasUP2K'] ?? 0;
        $this->totalKebutuhanKhusus = $data['totalKebutuhanKhusus'] ?? 0;
        $this->totalLakiLaki = $data['totalLakiLaki'] ?? 0;
        $this->totalBalitaLaki = $data['totalBalitaLaki'] ?? 0;
        $this->totalPerempuan = $data['totalPerempuan'] ?? 0;
        $this->totalWUS = $data['totalWUS'] ?? 0;
        $this->totalbalitaPerempuan = $data['totalbalitaPerempuan'] ?? 0;
        $this->totalPUS = $data['totalPUS'] ?? 0;
        $this->periode = $data['perioded'] ?? 0;
    }

    public function array(): array
    {
        $result = [];
        $i = 1;
        $kecamatan = $this->kecamatans;

        foreach ($kecamatan as $kec) {
            $counts = app('App\Http\Controllers\AdminKabController')->countRekapitulasiDesaInKecamatan($kec->id);

            $data = [
                '_index' => $i,
                'kecamatan' => $kec->nama_kecamatan,
                'jumlah_desa' => ucfirst($counts['totalDesa']) ?: '0',
                'jumlah_rw' => ucfirst($counts['countRW']) ?: '0',
                'jumlah_rt' => ucfirst($counts['rt']) ?: '0',
                'jumlah_dasa_wisma' => ucfirst($counts['countDasawisma']) ?: '0',
                'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                'jumlah_KK' => ucfirst($counts['countKK']) ?: '0',
                'jumlah_laki' => ucfirst($counts['laki_laki']) ?: '0',
                'jumlah_perempuan' => ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' => ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['balitaPerempuan']) ?: '0',
                'jumlah_PUS' => ucfirst($counts['pus']) ?: '0',
                'jumlah_WUS' => ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['ibuHamil']) ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' => ucfirst($counts['lansia']) ?: '0',
                'jumlah_tiga_buta' => '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['kebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' => ucfirst($counts['rumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['rumahNonSehat']) ?: '0',
                'punya_tempat_sampah' => ucfirst($counts['tempatSampah']) ?: '0',
                'punya_saluran_air' => ucfirst($counts['countSPAL']) ?: '0',
                'jumlah_punya_jamban' => ucfirst($counts['countJamban']) ?: '0',
                'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
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
            'kecamatan' => null,
            'jumlah_desa' => $this->totalDesa ?: '0',
            'jumlah_rw' => $this->totalRw ?: '0',
            'jumlah_rt' => $this->totalRt ?: '0',
            'jumlah_dasa_wisma' => $this->totalDasawisma ?: '0',
            'jumlah_KRT' => $this->totalRumahTangga ?: '0',
            'jumlah_KK' => $this->totalKK ?: '0',
            'jumlah_laki' => $this->totalLakiLaki ?: '0',
            'jumlah_perempuan' => $this->totalPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalBalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalbalitaPerempuan ?: '0',
            'jumlah_PUS' => $this->totalPUS ?: '0',
            'jumlah_WUS' => $this->totalWUS ?: '0',
            'jumlah_ibu_hamil' => $this->totalIbuHamil ?: '0',
            'jumlah_ibu_menyusui' => $this->totalIbuMenyesui ?: '0',
            'jumlah_lansia' => $this->totalLansia ?: '0',
            'jumlah_tiga_buta' => '0',
            'jumlah_kebutuhan_khusus' => $this->totalKebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalKriteriaRumahSehat ?: '0',
            'tidak_sehat_layak_huni' => $this->totalKriteriaRumahNonSehat ?: '0',
            'punya_tempat_sampah' => $this->totalTempatSampah ?: '0',
            'punya_saluran_air' => $this->totalSPAL ?: '0',
            'jumlah_jamban' => $this->totalJamban ?: '0',
            'tempel_stiker' => $this->totalStiker ?: '0',
            'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
            'sumber_air_sumur' => $this->totalAirSumur ?: '0',
            'sumber_air_lainya' => $this->totalAirLainya ?: '0',
            'makanan_pokok_beras' => $this->totalBeras ?: '0',
            'makanan_pokok_non_beras' => $this->totalNonBeras ?: '0',
            'aktivitas_UP2K' => $this->totalAaktivitasUP2K ?: '0',
            'pemanfaatan' => $this->totalPemanfaatanPekarangan ?: '0',
            'industri' => $this->totalIndustri ?: '0',
            'kesehatan_lingkungan' => $this->totalAktivitasKesehatanLingkungan ?: '0',
        ];

        return $result;
    }

    public function headings(): array
    {
        $headings = ['', '', '', '', '', '', '', '', 'JUMLAH ANGGOTA KELUARGA', '', '', '', '', '', '', '', '', '', '', 'KRITERIA RUMAH', '', '', '', '', '', 'SUMBER AIR KELUARGA', '', '', 'MAKANAN POKOK', '', 'WARGA MENGIKUTI KEGIATAN', '', '', ''];

        $headings2 = ['NO', 'NAMA KECAMATAN', 'JML. DESA/KELURAHAN', 'JML. RW', 'JML. RT', 'JML. DASAWISMA', 'JML. KRT', 'JML. KK', 'TOTAL L', 'TOTAL P', 'BALITA L', 'BALITA P', 'PUS', 'WUS', 'IBU HAMIL', 'IBU MENYUSUI', 'LANSIA', '3 BUTA', 'BERKEBUTUHAN KHUSUS', 'SEHAT', 'KURANG SEHAT', 'MEMILIKI TMP. PEMB. SAMPAH', 'MEMILIKI SPAL', 'MEMILIKI JAMBAN', 'MENEMPEL STIKER P4K', 'PDAM', 'SUMUR', 'DLL', 'BERAS', 'NON BERAS', 'UP2K', 'PEMANFAATAN DAN PEKARANGAN', 'INDUSTRI RUMAH TANGGA', 'KESEHATAN LINGKUNGAN'];

        return [
            ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['TP PKK KABUPATEN'],
            ['TAHUN : ' . $this->kecamatans->first()->desa->first()->rw->first()->periode],
            ['KAB/KOTA : INDRAMAYU'],
            ['PROVINSI : JAWA BARAT'], [], $headings, $headings2];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = count($this->kecamatans) + 10;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
                // $highestRow = $event->sheet->getHighestRow();
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
        $sheet->getStyle('A8:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($this->getBorderStyles());
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

        // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 sampai A6 ke tengah
        $sheet->getStyle('A1:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Mengatur teks pada baris 1 hingga 7 menjadi tebal (bold)
        $sheet->getStyle('1:8')->getFont()->setBold(true);

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

            $sheet->mergeCells('I8:S8');
            $sheet->mergeCells('T8:Y8');
            $sheet->mergeCells('Z8:AB8');
            $sheet->mergeCells('AC8:AD8');
            $sheet->mergeCells('AE8:AH8');

        }

        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('H');

        for ($col = 'A'; $col <= 'H'; $col++) {
            // Simpan nilai sel sebelum digabungkan
            $value = $sheet->getCell($col . '9')->getValue();

            // Pindahkan nilai sel ke sel atas
            $sheet->setCellValue($col . '8', $value);

            // Gabungkan sel secara vertikal
            $sheet->mergeCells($col . '8:' . $col . '9');

            // Atur penyelarasan vertikal ke tengah
            $sheet->getStyle($col . '8:' . $col . '9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

    }
}
