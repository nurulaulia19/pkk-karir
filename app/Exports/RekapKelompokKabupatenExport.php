<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapKelompokKabupatenExport implements FromArray, WithHeadings, WithEvents
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
            '_index' => 'Jumlah',
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
        // $headings = ['No', 'Nama Kecamatan', 'Jml. Desa/Kelurahan', 'Jml. Dusun', 'Jml. RW', 'Jml. RT', 'Jml. Dasawisma', 'Jml. KRT', 'Jml. KK', 'Jumlah Anggota Keluarga', '', '', '', '', '', '', '', '', '', '', '', 'Kriteria Rumah', '', '', '', '', 'Sumber Air Keluarga', '', '', '', 'Jml. Jamban Keluarga', 'Makanan Pokok', '', 'Warga Mengikuti Kegiatan', '', '', ''];

        $headings2 = ['No', 'Nama Kecamatan', 'Jml. Desa/Kelurahan', 'Jml. RW', 'Jml. RT', 'Jml. Dasawisma', 'Jml. KRT', 'Jml. KK', 'Total L', 'Total P', 'Balita L', 'Balita P', 'PUS', 'WUS', 'Ibu Hamil', 'Ibu Menyusui', 'Lansia', 'Berkebutuhan Khusus', 'Sehat', 'Tidak Sehat', 'Memiliki Tmp. Pemb. Sampah', 'Memiliki SPAL', 'Memiliki jamban', 'Menempel Stiker P4K', 'PDAM', 'Sumur', 'DLL', 'Beras', 'Non Beras', 'UP2K', 'Pemanfaatan dan Pekarangan', 'Industri Rumah Tangga', 'Kesehatan Lingkungan'];

        return [
            ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['TP PKK KABUPATEN'],
            ['Tahun : ' . $this->periode],
            ['KAB/KOTA : INDRAMAYU'],
            ['PROVINSI : JAWA BARAT'], [], $headings2];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // $event->sheet->getDelegate()->mergeCells('A1:AG1');
                // $event->sheet->getDelegate()->mergeCells('A2:AG2');
                // $event->sheet->getDelegate()->mergeCells('A3:AG3');
                // $event->sheet->getDelegate()->mergeCells('A4:AG4');
                // $event->sheet->getDelegate()->mergeCells('A5:AG5');
                // $event->sheet->getDelegate()->mergeCells('A6:AG6');
                // $event->sheet->getDelegate()->mergeCells('A7:AG7');

                // $event->sheet->getDelegate()->getStyle('A1:A7')->getAlignment()->setHorizontal('center');

                // $event->sheet->getDelegate()->mergeCells('A8:A9');
                // $event->sheet->getDelegate()->mergeCells('B8:B9');
                // $event->sheet->getDelegate()->mergeCells('C8:C9');
                // $event->sheet->getDelegate()->mergeCells('D8:D9');
                // $event->sheet->getDelegate()->mergeCells('E8:E9');
                // $event->sheet->getDelegate()->mergeCells('F8:F9');
                // $event->sheet->getDelegate()->mergeCells('G8:G9');
                // $event->sheet->getDelegate()->mergeCells('H8:H9');
                // $event->sheet->getDelegate()->mergeCells('I8:I9');

                // $event->sheet->getDelegate()->mergeCells('J8:U8');
                // $event->sheet->getDelegate()->mergeCells('V8:Z8');
                // $event->sheet->getDelegate()->mergeCells('AA8:AD8');
                // $event->sheet->getDelegate()->mergeCells('AE8:AE9');
                // $event->sheet->getDelegate()->mergeCells('AF8:AG8');
                // $event->sheet->getDelegate()->mergeCells('AH8:AK8');

                // $event->sheet->getDelegate()->getStyle('J8:AK8')->getAlignment()->setHorizontal('center');

                $lastRow = count($this->kecamatans) + 10;
                $event->sheet->getDelegate()->mergeCells('A' . $lastRow . ':B' . $lastRow);
            },
        ];
    }
}
