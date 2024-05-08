<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapKelompokDusunExport implements FromArray, WithHeadings, WithEvents
{
    // protected $rw;
    // protected $periode;
    // protected $desa;
    protected $dusun;
    /**
    * @return \Illuminate\Supporw\Collection
    */
    // public function collection()
    // {
    //     //
    // }

    public function __construct(array $data)
    {
        // $this->rw = $data['rws'] ?? [];
        $this->dusun = $data['dusun'] ?? [];
        // $this->periode = $data['periode'] ?? null;
        // $this->desa = $data['desa'] ?? null;
    }

    public function array(): array
    {
        // $result = [];
        $i = 1;
        $dusun = $this->dusun;

        foreach ($dusun as $dsn) {
            $data = [
                '_index' => $i,
                'rw' => $dsn->rw_name,
                'jumlah_rt' => count($dsn->rt),
                'jumlah_dasa_wisma' => $dsn->total_dasawisma ?: '0',
                'jumlah_KRT' => $dsn->total_rumah_tangga ?: '0',
                'jumlah_KK' => $dsn->total_jml_kk ?: '0',
                'jumlah_laki' => $dsn->total_anggota_laki ?: '0',
                'jumlah_perempuan' => $dsn->total_anggota_perempuan ?: '0',
                'jumlah_balita_laki' => $dsn->total_anggota_balita_laki ?: '0',
                'jumlah_balita_perempuan' => $dsn->total_anggota_balita_perempuan ?: '0',
                'jumlah_3_buta_laki' => '0',
                'jumlah_3_buta_perempuan' => '0',
                'jumlah_PUS' => $dsn->total_anggota_pus ?: '0' ,
                'jumlah_WUS' => $dsn->total_anggota_wus ?: '0' ,
                'jumlah_ibu_hamil' => $dsn->total_anggota_ibu_hamil ?: '0' ,
                'jumlah_ibu_menyusui' => $dsn->total_anggota_ibu_menyusui ?: '0' ,
                'jumlah_lansia' => $dsn->total_anggota_lansia ?: '0' ,
                'jumlah_kebutuhan_khusus' => $dsn->total_anggota_berkebutuhan_khusus ?: '0' ,
                'sehat_layak_huni' => $dsn->total_sheat_layak_huni ?: '0' ,
                'tidak_sehat_layak_huni' => $dsn->total_tidak_sheat_layak_huni ?: '0' ,
                'punya_tempat_sampah' => $dsn->total_pem_sampah ?: '0' ,
                'punya_saluran_air' => $dsn->total_spal ?: '0' ,
                'tempel_stiker' => $dsn->total_stiker ?: '0' ,
                'sumber_air' => $dsn->total_air_pdam ?: '0' ,
                'sumber_air_2' => $dsn->total_air_sumur ?: '0' ,
                'sumber_air_3' => '0' ,
                'sumber_air_4' => $dsn->total_air_lainnya ?: '0' ,
                'jumlah_punya_jamban' => $dsn->total_jamban ?: '0' ,
                'makanan_pokok' => $dsn->total_makan_beras ?: '0' ,
                'makanan_pokok_0' => $dsn->total_makan_non_beras ?: '0' ,
                'aktivitas_UP2K' => $dsn->total_kegiatan_up2k ?: '0' ,
                'pemanfaatan' => $dsn->total_kegiatan_pemanfaatan_pekarangan ?: '0' ,
                'industri' => $dsn->total_kegiatan_industri ?:  '0' ,
                'kesehatan_lingkungan' => '0' ,
            ];

            $result[] = $data;
            $i++;
        }


        // $result[] = [
        //     '_index' => 'Jumlah',
        //     'rw' => null,
        //     'jumlah_rt' => $rw->sum('jumlah_rt') ?: '0',
        //     'jumlah_dasa_wisma' => $rw->sum('jumlah_dasa_wisma') ?: '0',
        //     'jumlah_KRT' => $rw->sum('jumlah_KRT') ?: '0',
        //     'jumlah_KK' => $rw->sum('jumlah_KK') ?: '0',
        //     'jumlah_laki' => $rw->sum('jumlah_laki_laki') ?: '0',
        //     'jumlah_perempuan' => $rw->sum('jumlah_perempuan') ?: '0',
        //     'jumlah_balita_laki' => $rw->sum('jumlah_balita_laki') ?: '0',
        //     'jumlah_balita_perempuan' => $rw->sum('jumlah_balita_perempuan') ?: '0',
        //     'jumlah_3_buta_laki' => $rw->sum('jumlah_3_buta_laki') ?: '0',
        //     'jumlah_3_buta_perempuan' => $rw->sum('jumlah_3_buta_perempuan') ?: '0',
        //     'jumlah_PUS' => $rw->sum('jumlah_PUS') ?: '0',
        //     'jumlah_WUS' => $rw->sum('jumlah_WUS') ?: '0',
        //     'jumlah_ibu_hamil' => $rw->sum('jumlah_ibu_hamil') ?: '0',
        //     'jumlah_ibu_menyusui' => $rw->sum('jumlah_ibu_menyusui') ?: '0',
        //     'jumlah_lansia' => $rw->sum('jumlah_lansia') ?: '0',
        //     'jumlah_kebutuhan_khusus' => $rw->sum('jumlah_kebutuhan_khusus') ?: '0',
        //     'sehat_layak_huni' => $rw->sum('jumlah_kriteria_rumah_sehat') ?: '0',
        //     'tidak_sehat_layak_huni' => $rw->sum('jumlah_kriteria_rumah_tidak_sehat') ?: '0',
        //     'punya_tempat_sampah' => $rw->sum('jumlah_punya_tempat_sampah') ?: '0',
        //     'punya_saluran_air' => $rw->sum('jumlah_punya_saluran_air') ?: '0',
        //     'tempel_stiker' => $rw->sum('jumlah_tempel_stiker') ?: '0',
        //     'sumber_air' => $rw->sum('jumlah_sumber_air_pdam') ?: '0',
        //     'sumber_air_2' => $rw->sum('jumlah_sumber_air_sumur') ?: '0',
        //     'sumber_air_3' => $rw->sum('jumlah_sumber_air_sungai') ?: '0',
        //     'sumber_air_4' => $rw->sum('jumlah_sumber_air_dll') ?: '0',
        //     'jumlah_punya_jamban' => $rw->sum('punya_jamban') ?: '0',
        //     'makanan_pokok' => $rw->sum('jumlah_makanan_pokok_beras') ?: '0',
        //     'makanan_pokok_0' => $rw->sum('jumlah_makanan_pokok_non_beras') ?: '0',
        //     'aktivitas_UP2K' => $rw->sum('jumlah_aktivitas_UP2K') ?: '0',
        //     'pemanfaatan' => $rw->sum('jumlah_have_pemanfaatan') ?: '0',
        //     'industri' => $rw->sum('jumlah_have_industri') ?: '0',
        //     'kesehatan_lingkungan' => $rw->sum('jumlah_have_kegiatan') ?: '0',
        // ];

        return $result;
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'No. RW',
            'Jml. RT',
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
            'Kriteria Rumah',
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
            '',
            '',
            '',
            '',
            '',
            '',
            'Total L',
            'Total P',
            'Balita L',
            'Balita P',
            '3 Buta Laki-laki',
            '3 Buta Perempuan',
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
            '',
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
            ['KELOMPOK PKK DUSUN'],
            ['Dusun : ' . 'x'],
            ['Desa/Kel : ' . 'x'],
            ['Tahun : ' . 'x'],
            [],
            $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:AI1');
                $event->sheet->getDelegate()->mergeCells('A2:AI2');
                $event->sheet->getDelegate()->mergeCells('A3:AI3');
                $event->sheet->getDelegate()->mergeCells('A4:AI4');
                $event->sheet->getDelegate()->mergeCells('A5:AI5');
                $event->sheet->getDelegate()->mergeCells('A6:AI6');

                $event->sheet->getDelegate()->getStyle('A1:A6')->getAlignment()->setHorizontal('center');

                $event->sheet->getDelegate()->mergeCells('A8:A9');
                $event->sheet->getDelegate()->mergeCells('B8:B9');
                $event->sheet->getDelegate()->mergeCells('C8:C9');
                $event->sheet->getDelegate()->mergeCells('D8:D9');
                $event->sheet->getDelegate()->mergeCells('E8:E9');
                $event->sheet->getDelegate()->mergeCells('F8:F9');

                $event->sheet->getDelegate()->mergeCells('G8:R8');
                $event->sheet->getDelegate()->mergeCells('S8:W8');
                $event->sheet->getDelegate()->mergeCells('X8:AA8');
                $event->sheet->getDelegate()->mergeCells('AB8:AB9');
                $event->sheet->getDelegate()->mergeCells('AC8:AD8');
                $event->sheet->getDelegate()->mergeCells('AE8:AI8');

                $event->sheet->getDelegate()->getStyle('G8:AH8')->getAlignment()->setHorizontal('center');

                $lastRow = count($this->dusun) + 10;
                $event->sheet->getDelegate()->mergeCells('A'.$lastRow.':B'.$lastRow);
            },
        ];
    }
}
