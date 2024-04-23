<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapKelompokDasaWismaExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $rumahtangga = [];
    protected $dasa_wisma;
    protected $nama_dasawisma;
    protected $totalKepalaRumahTangga;
    protected $totalJmlKK;
    protected $totalAnggotaLansia;
    protected $totalAnggotaIbuHamil;
    protected $totalAnggotaIbuMenyusui;
    protected $totalAnggotaLaki;
    protected $totalAnggotaBalitaLaki;
    protected $totalAnggotaBerkebutuhanKhusus;
    protected $totalMakanBeras;
    protected $totalMakanNonBeras;
    protected $totalKegiatanUP2K;
    protected $totalKegiatanIndustri;
    protected $totalKegiatanPemanfaatanPekarangan;
    protected $totalKegiatanLingkungan;
    protected $totalAnggotaPerempuan;
    protected $totalAnggotaBalitaPerempuan;
    protected $totalAnggotaPUS;
    protected $totalAnggotaWUS;
    protected $totalSheatLayakHuni;
    protected $totalTidakSheatLayakHuni;
    protected $totalPemSampah;
    protected $totalSPAL;
    protected $totalJamban;
    protected $totalStiker;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainya;

    public function __construct(array $data)
    {
        $this->rumahtangga = $data['rumahtangga'] ?? null;
        $this->dasa_wisma = $data['dasa_wisma'] ?? null;
        $this->totalKepalaRumahTangga = $data['totalKepalaRumahTangga'] ?? null;
        $this->totalJmlKK = $data['totalJmlKK'] ?? null;
        $this->totalAnggotaLansia = $data['totalAnggotaLansia'] ?? null;
        $this->totalAnggotaIbuHamil = $data['totalAnggotaIbuHamil'] ?? null;
        $this->totalAnggotaIbuMenyusui = $data['totalAnggotaIbuMenyusui'] ?? null;
        $this->totalAnggotaLaki = $data['totalAnggotaLaki'] ?? null;
        $this->totalAnggotaBalitaLaki = $data['totalAnggotaBalitaLaki'] ?? null;
        $this->totalAnggotaBerkebutuhanKhusus = $data['totalAnggotaBerkebutuhanKhusus'] ?? null;
        $this->totalMakanBeras = $data['totalMakanBeras'] ?? null;
        $this->totalMakanNonBeras = $data['totalMakanNonBeras'] ?? null;
        $this->totalKegiatanUP2K = $data['totalKegiatanUP2K'] ?? null;
        $this->totalKegiatanIndustri = $data['totalKegiatanIndustri'] ?? null;
        $this->totalKegiatanPemanfaatanPekarangan = $data['totalKegiatanPemanfaatanPekarangan'] ?? null;
        $this->totalKegiatanLingkungan = $data['totalKegiatanLingkungan'] ?? null;
        $this->totalAnggotaPerempuan = $data['totalAnggotaPerempuan'] ?? null;
        $this->totalAnggotaBalitaPerempuan = $data['totalAnggotaBalitaPerempuan'] ?? null;
        $this->totalAnggotaPUS = $data['totalAnggotaPUS'] ?? null;
        $this->totalAnggotaWUS = $data['totalAnggotaWUS'] ?? null;
        $this->totalSheatLayakHuni = $data['totalSheatLayakHuni'] ?? null;
        $this->totalTidakSheatLayakHuni = $data['totalTidakSheatLayakHuni'] ?? null;
        $this->totalPemSampah = $data['totalPemSampah'] ?? null;
        $this->totalSPAL = $data['totalSPAL'] ?? null;
        $this->totalJamban = $data['totalJamban'] ?? null;
        $this->totalStiker = $data['totalStiker'] ?? null;
        $this->totalAirPDAM = $data['totalAirPDAM'] ?? null;
        $this->totalAirSumur = $data['totalAirSumur'] ?? null;
        $this->totalAirLainya = $data['totalAirLainya'] ?? null;
        $this->totalKegiatanLingkungan = $data['totalKegiatanLingkungan'] ?? null;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $result = [];
        $i = 1;
        $catatan_keluarga = $this->rumahtangga;
        // dd($this->totalAnggotaIbuHamil);


        foreach ($catatan_keluarga as $keluarga) {
            $counts = app(
                'App\Http\Controllers\AdminController',
            )->countGenderMembers($keluarga);
            $data = [
                '_index' => $i,
                'nama_kepala_rumah_tangga' => $keluarga->nama_kepala_rumah_tangga,
                'jumlah_KK' =>   count($keluarga->anggotaRT)  ?: '0',
                'jumlah_laki' => ucfirst($counts['laki_laki']) ?: '0',
                'jumlah_perempuan' => ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' => ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['balitaPerempuan']) ?: '0',
                // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
                'jumlah_PUS' => ucfirst($counts['pus']) ?: '0',
                'jumlah_WUS' => ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['ibuHamil']) ?: '0',
                'jumlah_ibu_menyusui' =>  ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' =>ucfirst($counts['lansia']) ?: '0',
                'jumlah_kebutuhan_khusus' =>ucfirst($counts['kebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' => $keluarga->kriteria_rumah_sehat == '1' ? '1' : '',
                'tidak_sehat_layak_huni' => $keluarga->kriteria_rumah_sehat == '0' ? '1' : '0',
                'punya_tempat_sampah' => $keluarga->punya_tempat_sampah == '1' ? '1' : '0',
                'punya_saluran_air' => $keluarga->saluran_pembuangan_air_limbah == '1' ? '1' : '0',
                'punya_jamban' => $keluarga->punya_jamban == '1' ? '1' : '0',
                'tempel_stiker' => $keluarga->tempel_stiker == '1' ? '1' : '0',
                'sumber_air' => $keluarga->sumber_air_pdam == '1' ? '1' : '0',
                'sumber_air_2' => $keluarga->sumber_air_sumur == '1' ? '1' : '0',
                'sumber_air_4' => $keluarga->sumber_air_lainnya == '1' ? '1' : '0',
                'makanan_pokok_beras' =>  ucfirst($counts['MakanBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['MakanNonBeras']) ?: '0',
                'aktivitas_UP2K' =>ucfirst($counts['aktivitasUP2K']) ?: '0',
                'pemanfaatan' =>  ucfirst($counts['pemanfaatanPekarangan']) ?: '0',
                'industri' => ucfirst($counts['industriRumahTangga'])?: '0',
                'kesehatan_lingkungan' => ucfirst($counts['kesehatanLingkungan'])?: '0',
            ];

            $result[] = $data;
            $i++;
        }

        $result[] = [
            '_index' => 'Jumlah',
            'nama_kepala_rumah_tangga' => null,
            'jumlah_KK' => $this->totalJmlKK ?: '0',
            'jumlah_laki' => $this->totalAnggotaLaki ?: '0',
            'jumlah_perempuan' => $this->totalAnggotaPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalAnggotaBalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalAnggotaBalitaPerempuan ?: '0',
            'jumlah_PUS' => $this->totalAnggotaPUS ?: '0',
            'jumlah_WUS' => $this->totalAnggotaWUS ?: '0',
            'jumlah_ibu_hamil' => $this->totalAnggotaIbuHamil ?: '0',
            'jumlah_ibu_menyusui' => $this->totalAnggotaIbuMenyusui ?: '0',
            'jumlah_lansia' => $this->totalAnggotaLansia ?: '0',
            'jumlah_kebutuhan_khusus' => $this->totalAnggotaBerkebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalSheatLayakHuni ?: '0',
            'tidak_sehat_layak_huni' => $this->totalTidakSheatLayakHuni ?: '0',
            'punya_tempat_sampah' => $this->totalPemSampah ?: '0',
            'punya_saluran_air' => $this->totalSPAL ?: '0',
            'punya_jamban' => $this->totalJamban ?: '0',
            'tempel_stiker' => $this->totalStiker ?: '0',
            'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
            'sumber_air_sumur' => $this->totalAirSumur ?: '0',
            'sumber_air_lainnya' => $this->totalAirLainya ?: '0',
            'makan_beras' => $this->totalMakanBeras ?: '0',
            'makan_non_beras' => $this->totalMakanNonBeras ?: '0',
            'aktivitas_UP2K' => $this->totalKegiatanUP2K ?: '0',
            'pemanfaatan' => $this->totalKegiatanPemanfaatanPekarangan ?: '0',
            'industri' => $this->totalKegiatanIndustri ?: '0',
            'aktivitas_kesehatan_lingkungan' => $this->totalKegiatanLingkungan ?: '0'



            // 'makanan_pokok' => $catatan_keluarga->where('makanan_pokok', 1)->count() ?: '0',
            // 'makanan_pokok_0' => $catatan_keluarga->where('makanan_pokok', 0)->count() ?: '0',
            // 'aktivitas_UP2K' => $catatan_keluarga->sum('aktivitas_UP2K') ?: '0',
            // 'pemanfaatan' => $catatan_keluarga->sum('have_pemanfaatan') ?: '0',
            // 'industri' => $catatan_keluarga->sum('have_industri') ?: '0',
            // 'kerja_bakti' => $catatan_keluarga->sum('have_kegiatan') ?: '0',
        ];
        // dd($this->totalAnggotaIbuHamil);

        return $result;
    }

    public function headings(): array
    {
        // $headings = [
        //     '',
        //     'Nama Kepala Rumah Tangga',
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
        //     'Kriteria Rumah',
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
            'Nama Kepala Rumah Tangga',
            'Jml. KK',
            'Total L',
            'Total P',
            'Balita L',
            'Balita P',
            'PUS',
            'WUS',
            'Ibu Hamil',
            'Ibu Menyusui',
            'Lansia',
            'Berkebutuhan Khusus',
            'Sehat Layak Huni',
            'Tidak Sehat Layak Huni',
            'Memiliki Tmp. Pemb. Sampah',
            'Memiliki SPAL',
            'Memiliki Jamban Keluarga',
            'Menempel Stiker P4K',
            'PDAM',
            'Sumur',
            'DLL',
            'Beras',
            'Non Beras',
            'UP2K',
            'Pemanfaatan dan Pekarangan',
            'Industri Rumah Tangga',
            'Kesehatan Lingkungan',
        ];

        return [
            ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['KELOMPOK DASA WISMA'],
            ['Dasa Wisma : '.ucfirst($this->dasa_wisma->nama_dasawisma)],
            ['RT : ' . $this->dasa_wisma->rt->name],
            ['RW : ' . $this->dasa_wisma->rw->name],
            // ['Desa/Kel : ' . $this->desa->nama_desa],
            // ['Tahun : ' . $this->periode],
            [],
            // $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $event->sheet->getDelegate()->mergeCells('A1:AC1');
                // $event->sheet->getDelegate()->mergeCells('A2:AC2');
                // $event->sheet->getDelegate()->mergeCells('A3:AC3');
                // $event->sheet->getDelegate()->mergeCells('A4:AC4');
                // $event->sheet->getDelegate()->mergeCells('A5:AC5');
                // $event->sheet->getDelegate()->mergeCells('A6:AC6');
                // $event->sheet->getDelegate()->mergeCells('A7:AC7');
                // $event->sheet->getDelegate()->mergeCells('A8:AC8');

                // $event->sheet->getDelegate()->getStyle('A1:A8')->getAlignment()->setHorizontal('center');

                // $event->sheet->getDelegate()->mergeCells('A10:A11');
                // $event->sheet->getDelegate()->mergeCells('B10:B11');
                // $event->sheet->getDelegate()->mergeCells('C10:C11');

                // $event->sheet->getDelegate()->mergeCells('D10:N10');
                // $event->sheet->getDelegate()->mergeCells('O10:T10');
                // $event->sheet->getDelegate()->mergeCells('U10:W10');
                // $event->sheet->getDelegate()->mergeCells('X10:Y10');
                // $event->sheet->getDelegate()->mergeCells('Z10:AC10');

                // $event->sheet->getDelegate()->getStyle('D10:AC10')->getAlignment()->setHorizontal('center');

                $lastRow = count($this->rumahtangga) + 12;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
            },
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
        $lastColumn = $sheet->getHighestColumn();

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


    }
}
