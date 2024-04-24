<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapKelompokKecamatanExport implements FromArray, WithHeadings, WithEvents
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
            '_index' => 'Jumlah',
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
        // $headings = [
        //     'No',
        //     'Nama Desa/Kelurahan',
        //     'Jml. Dusun',
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
        //     '',
        //     'Kriteria Rumah',
        //     '',
        //     '',
        //     '',
        //     '',
        //     'Sumber Air Keluarga',
        //     '',
        //     '',
        //     '',
        //     'Jml. Jamban Keluarga',
        //     'Makanan Pokok',
        //     '',
        //     'Warga Mengikuti Kegiatan',
        //     '',
        //     '',
        //     '',
        // ];

        $headings2 = [
            'No',
            'Nama Desa',
            'Jml RW',
            'Jml RT',
            'Jml Dasawisma',
            'Jml KRT',
            'Jml KK',
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
            'Tidak Sehat Huni',
            'Memiliki Tmp. Pemb. Sampah',
            'Memiliki SPAL',
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
            ['TP PKK KECAMATAN'],
            // ['Tahun : ' . $this->periode],
            // ['Kecamatan : ' . $this->nama_kecamatan],
            ['Kabupaten : Indramayu'],
            ['Provinsi : Jawa Barat'],
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
                // $event->sheet->getDelegate()->mergeCells('A7:AG8');

                // $event->sheet->getDelegate()->getStyle('A1:A8')->getAlignment()->setHorizontal('center');

                // $event->sheet->getDelegate()->mergeCells('A9:A10');
                // $event->sheet->getDelegate()->mergeCells('B9:B10');
                // $event->sheet->getDelegate()->mergeCells('C9:C10');
                // $event->sheet->getDelegate()->mergeCells('D9:D10');
                // $event->sheet->getDelegate()->mergeCells('E9:E10');
                // $event->sheet->getDelegate()->mergeCells('F9:F10');
                // $event->sheet->getDelegate()->mergeCells('G9:G10');
                // $event->sheet->getDelegate()->mergeCells('H9:H10');

                // $event->sheet->getDelegate()->mergeCells('I9:T9');
                // $event->sheet->getDelegate()->mergeCells('U9:Y9');
                // $event->sheet->getDelegate()->mergeCells('Z9:AC9');
                // $event->sheet->getDelegate()->mergeCells('AD9:AD10');
                // $event->sheet->getDelegate()->mergeCells('AE9:AF9');
                // $event->sheet->getDelegate()->mergeCells('AG9:AJ9');

                // $event->sheet->getDelegate()->getStyle('I9:AJ9')->getAlignment()->setHorizontal('center');

                $lastRow = count($this->desaa) + 11;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
            },
        ];
    }
}
