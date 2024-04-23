<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapKelompokRWExport implements FromArray, WithHeadings, WithEvents
{
    protected $dasa_wisma = [];
    protected $totalJmlKK;
    protected $totalKegiatanIndustri;
    protected $totalKegiatanPemanfaatanPekarangan;
    protected $totalDasawisma;
    protected $totalJmlKRT;
    protected $totalSheatLayakHuni;
    protected $totalTidakSheatLayakHuni;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainnya;
    protected $totalStiker;
    protected $totalJamban;
    protected $totalPemSampah;
    protected $totalSPAL;
    protected $totalAnggotaLansia;
    protected $totalAnggotaIbuHamil;
    protected $totalAnggotaIbuMenyusui;
    protected $totalKegiatanLingkungan;
    protected $totalKegiatanUP2K;
    protected $totalAnggotaBerkebutuhanKhusus;
    protected $totalMakanBeras;
    protected $totalMakanNonBeras;
    protected $totalAnggotaLaki;
    protected $totalAnggotaBalitaLaki;
    protected $totalAnggotaPerempuan;
    protected $totalAnggotaWUS;
    protected $totalAnggotaBalitaPerempuan;
    protected $totalAnggotaPUS;



    public function __construct(array $data)
    {
        $this->dasa_wisma = $data['dasa_wisma'] ?? [];
        $this->totalJmlKK = $data['totalJmlKK'] ?? 0;
        $this->totalKegiatanIndustri = $data['totalKegiatanIndustri'] ?? 0;
        $this->totalKegiatanPemanfaatanPekarangan = $data['totalKegiatanPemanfaatanPekarangan'] ?? 0;
        $this->totalDasawisma = $data['totalDasawisma'] ?? 0;
        $this->totalJmlKRT = $data['totalJmlKRT'] ?? 0;
        $this->totalSheatLayakHuni = $data['totalSheatLayakHuni'] ?? 0;
        $this->totalTidakSheatLayakHuni = $data['totalTidakSheatLayakHuni'] ?? 0;
        $this->totalAirPDAM = $data['totalAirPDAM'] ?? 0;
        $this->totalAirSumur = $data['totalAirSumur'] ?? 0;
        $this->totalAirLainnya = $data['totalAirLainnya'] ?? 0;
        $this->totalStiker = $data['totalStiker'] ?? 0;
        $this->totalJamban = $data['totalJamban'] ?? 0;
        $this->totalPemSampah = $data['totalPemSampah'] ?? 0;
        $this->totalSPAL = $data['totalSPAL'] ?? 0;
        $this->totalAnggotaLansia = $data['totalAnggotaLansia'] ?? 0;
        $this->totalAnggotaIbuHamil = $data['totalAnggotaIbuHamil'] ?? 0;
        $this->totalAnggotaIbuMenyusui = $data['totalAnggotaIbuMenyusui'] ?? 0;
        $this->totalKegiatanLingkungan = $data['totalKegiatanLingkungan'] ?? 0;
        $this->totalKegiatanUP2K = $data['totalKegiatanUP2K'] ?? 0;
        $this->totalAnggotaBerkebutuhanKhusus = $data['totalAnggotaBerkebutuhanKhusus'] ?? 0;
        $this->totalMakanBeras = $data['totalMakanBeras'] ?? 0;
        $this->totalMakanNonBeras = $data['totalMakanNonBeras'] ?? 0;
        $this->totalAnggotaLaki = $data['totalAnggotaLaki'] ?? 0;
        $this->totalAnggotaBalitaLaki = $data['totalAnggotaBalitaLaki'] ?? 0;
        $this->totalAnggotaPerempuan = $data['totalAnggotaPerempuan'] ?? 0;
        $this->totalAnggotaWUS = $data['totalAnggotaWUS'] ?? 0;
        $this->totalAnggotaBalitaPerempuan = $data['totalAnggotaBalitaPerempuan'] ?? 0;
        $this->totalAnggotaPUS = $data['totalAnggotaPUS'] ?? 0;
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
            )->countRekapitulasiDasawismaInRt($desa->id);

            $data = [
                '_index' => $i,
                'rt' => $desa->rt->name ,
                'nama_dasa_wisma' => $desa->nama_dasawisma ?: 'null',

                'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                'jumlah_KK' => ucfirst($counts['countKK'])  ?: '0',
                'jumlah_laki' =>  ucfirst($counts['laki_laki'])  ?: '0',
                'jumlah_perempuan' =>ucfirst($counts['perempuan']) ?: '0',
                'jumlah_balita_laki' =>  ucfirst($counts['balitaLaki']) ?: '0',
                'jumlah_balita_perempuan' =>ucfirst($counts['balitaPerempuan']) ?: '0',
                // 'jumlah_3_buta_laki' => $keluarga->jumlah_3_buta_laki ?: '0',
                // 'jumlah_3_buta_perempuan' => ucfirst($counts['pus']) ?: '0',
                'jumlah_PUS' => ucfirst($counts['pus']) ?: '0',
                'jumlah_WUS' =>ucfirst($counts['wus']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['ibuHamil']) ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['ibuMenyusui']) ?: '0',
                'jumlah_lansia' => ucfirst($counts['lansia']) ?: '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['kebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' =>  ucfirst($counts['rumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['rumahNonSehat']) ?: '0',
                'punya_tempat_sampah' =>  ucfirst($counts['tempatSampah']) ?: '0',
                'punya_saluran_air' => ucfirst($counts['countSPAL']) ?: '0',
                'jumlah_punya_jamban' => ucfirst($counts['countJamban'])?: '0',
                'tempel_stiker' =>   ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
                'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras']) ?: '0',
                'aktivitas_UP2K' => ucfirst($counts['aktivitasUP2K']) ?: '0',
                'pemanfaatan' =>ucfirst($counts['pemanfaatanPekarangan']) ?: '0',
                'industri' =>  ucfirst($counts['industriRumahTangga']) ?: '0',
                'kesehatan_lingkungan' => ucfirst($counts['kesehatanLingkungan']) ?: '0',
            ];

            $result[] = $data;
            $i++;
        }

        $result[] = [
            '_index' => 'Jumlah',
            'rt' => null,
            'jumlah_dasa_wisma' => $this->totalDasawisma ?: '0',
            'jumlah_KRT' => $this->totalJmlKRT ?: '0',
            'jumlah_KK' => $this->totalJmlKK ?: '0',
            'jumlah_laki' => $this->totalAnggotaLaki ?: '0',
            'jumlah_perempuan' => $this->totalAnggotaPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalAnggotaBalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalAnggotaBalitaPerempuan ?: '0',
            // 'jumlah_3_buta_laki' => $rt->sum('jumlah_3_buta_laki') ?: '0',
            // 'jumlah_3_buta_perempuan' => $rt->sum('jumlah_3_buta_perempuan') ?: '0',
            'jumlah_PUS' => $this->totalAnggotaPUS ?: '0',
            'jumlah_WUS' => $this->totalAnggotaWUS?: '0',
            'jumlah_ibu_hamil' => $this->totalAnggotaIbuHamil ?: '0',
            'jumlah_ibu_menyusui' => $this->totalAnggotaIbuMenyusui ?: '0',
            'jumlah_lansia' => $this->totalAnggotaLansia ?: '0',
            'jumlah_kebutuhan_khusus' => $this->totalAnggotaBerkebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalSheatLayakHuni ?: '0',
            'tidak_sehat_layak_huni' => $this->totalTidakSheatLayakHuni ?: '0',
            'punya_tempat_sampah' => $this->totalPemSampah  ?: '0',
            'punya_saluran_air' => $this->totalSPAL  ?: '0',
            'tempel_stiker' => $this->totalStiker  ?: '0',
            'jumlah_punya_jamban' => $this->totalJamban ?: '0',
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
        $headings = [
            'No',
            'Kode. RT',
            'Jml. Dasawisma',
            'Jml. KRT',
            'Jml. KK',
            'Jumlah Anggota Keluarga',
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
            'Jumlah Rumah',
            '',
            '',
            '',
            '',
            'Sumber Air Keluarga',
            '',
            '',
            '',
            'Jumlah Jamban Keluarga',
            'Makanan Pokok',
            '',
            'Warga Mengikuti Kegiatan',
            '',
            '',
            '',
        ];

        $headings2 = [
            'No',
            'Kode RT',
            'Nama Dasawisma',
            'Jml KRT',
            'Jml KK',
            'Total L',
            'Total P',
            'Balita L',
            'Balita P',
            // '3 Buta Laki-laki',
            // '3 Buta Perempuan',
            'PUS',
            'WUS',
            'Ibu Hamil',
            'Ibu Menyusui',
            'Lansia',
            'Berkebutuhan Khusus',
            'Sehat',
            'Tidak Sehat',
            'Memiliki Tmp. Pemb. Sampah',
            'Memiliki SPAL',
            'Menempel Stiker P4K',
            'PDAM',
            'Sumur',
            'Sungai',
            'DLL',
            // '',
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
            ['KELOMPOK PKK RW'],
            // ['RW : ' . $this->rw],
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
            // AfterSheet::class => function(AfterSheet $event) {
            //     $event->sheet->getDelegate()->mergeCells('A1:AH1');
            //     $event->sheet->getDelegate()->mergeCells('A2:AH2');
            //     $event->sheet->getDelegate()->mergeCells('A3:AH3');
            //     $event->sheet->getDelegate()->mergeCells('A4:AH4');
            //     $event->sheet->getDelegate()->mergeCells('A5:AH5');
            //     $event->sheet->getDelegate()->mergeCells('A6:AH6');

            //     $event->sheet->getDelegate()->getStyle('A1:A6')->getAlignment()->setHorizontal('center');

            //     $event->sheet->getDelegate()->mergeCells('A8:A9');
            //     $event->sheet->getDelegate()->mergeCells('B8:B9');
            //     $event->sheet->getDelegate()->mergeCells('C8:C9');
            //     $event->sheet->getDelegate()->mergeCells('D8:D9');
            //     $event->sheet->getDelegate()->mergeCells('E8:E9');

            //     $event->sheet->getDelegate()->mergeCells('F8:Q8');
            //     $event->sheet->getDelegate()->mergeCells('R8:V8');
            //     $event->sheet->getDelegate()->mergeCells('W8:Z8');
            //     $event->sheet->getDelegate()->mergeCells('AA8:AA9');
            //     $event->sheet->getDelegate()->mergeCells('AB8:AC8');
            //     $event->sheet->getDelegate()->mergeCells('AD8:AH8');

            //     $event->sheet->getDelegate()->getStyle('F8:AH8')->getAlignment()->setHorizontal('center');

            //     $lastRow = count($this->rt) + 10;
            //     $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
            // },
        ];
    }
}
