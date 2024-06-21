<?php

namespace App\Exports;

use App\Models\DataKeluarga;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\Rw;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
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
    protected $desa;
    protected $dusun;
    protected $totalDusun;
    protected $totalRw;
    protected $totalRt;
    protected $totalDasawisma;
    protected $totalRumahTangga;
    protected $totalKeluarga;
    protected $totalPemanfaatanPekarangan;
    protected $totalTempatSampah;
    protected $totalSPAL;
    protected $totalJamban;
    protected $totalStiker;
    protected $totalAirPDAM;
    protected $totalAirSumur;
    protected $totalAirLainya;
    protected $totalRumahSehat;
    protected $totalRumahNonSehat;
    protected $totalIndustri;
    protected $today;
    protected $totalBeras;
    protected $totalNonBeras;
    protected $totalLansia;
    protected $totalIbuHamil;
    protected $totalIbuMenyusui;
    protected $totalAktivitasLingkungan;
    protected $totalAktivitasUP2K;
    protected $totalKebutuhanKhusus;
    protected $totalLakiLaki;
    protected $totalbalitaLaki;
    protected $totalPerempuan;
    protected $totalWUS;
    protected $totalbalitaPerempuan;
    protected $totalPUS;
    protected $periode;
    protected $rwsAll;
    protected $nonDusun;

    public function __construct(array $data)
    {
        $this->desa = $data['desa'] ?? null;
        $this->rwsAll = $data['rwsAll'] ?? null;
        $this->dusun = $data['dusun'] ?? null;
        $this->totalDusun = $data['totalDusun'] ?? null;
        $this->totalRw = $data['totalRw'] ?? null;
        $this->totalRt = $data['totalRt'] ?? null;
        $this->totalDasawisma = $data['totalDasawisma'] ?? null;
        $this->totalRumahTangga = $data['totalRumahTangga'] ?? null;
        $this->totalKeluarga = $data['totalKeluarga'] ?? null;
        $this->totalPemanfaatanPekarangan = $data['totalPemanfaatanPekarangan'] ?? null;
        $this->totalTempatSampah = $data['totalTempatSampah'] ?? null;
        $this->totalSPAL = $data['totalSPAL'] ?? null;
        $this->totalJamban = $data['totalJamban'] ?? null;
        $this->totalStiker = $data['totalStiker'] ?? null;
        $this->totalAirPDAM = $data['totalAirPDAM'] ?? null;
        $this->totalAirSumur = $data['totalAirSumur'] ?? null;
        $this->totalAirLainya = $data['totalAirLainya'] ?? null;
        $this->totalRumahSehat = $data['totalRumahSehat'] ?? null;
        $this->totalRumahNonSehat = $data['totalRumahNonSehat'] ?? null;
        $this->totalIndustri = $data['totalIndustri'] ?? null;
        $this->today = $data['today'] ?? null;
        $this->totalBeras = $data['totalBeras'] ?? null;
        $this->totalNonBeras = $data['totalNonBeras'] ?? null;
        $this->totalLansia = $data['totalLansia'] ?? null;
        $this->totalIbuHamil = $data['totalIbuHamil'] ?? null;
        $this->totalIbuMenyusui = $data['totalIbuMenyusui'] ?? null;
        $this->totalAktivitasLingkungan = $data['totalAktivitasLingkungan'] ?? null;
        $this->totalAktivitasUP2K = $data['totalAktivitasUP2K'] ?? null;
        $this->totalKebutuhanKhusus = $data['totalKebutuhanKhusus'] ?? null;
        $this->totalLakiLaki = $data['totalLakiLaki'] ?? null;
        $this->totalbalitaLaki = $data['totalbalitaLaki'] ?? null;
        $this->totalPerempuan = $data['totalPerempuan'] ?? null;
        $this->totalWUS = $data['totalWUS'] ?? null;
        $this->totalbalitaPerempuan = $data['totalbalitaPerempuan'] ?? null;
        $this->totalPUS = $data['totalPUS'] ?? null;
        $this->periode = $data['periode'] ?? Carbon::now()->year;
        $this->nonDusun = 0;
    }

    public function array(): array
    {
        $result = [];
        $i = 1;
        $dusun = $this->dusun;
        // dd($dusun);
        // $kiwkiw = 0;

        foreach ($dusun as $desa) {
            // $counts = app('App\Http\Controllers\AdminDesa\DusunController')->countDataInDusun($desa, $this->periode);
            $counts = app(
                'App\Http\Controllers\AdminDesa\DusunController',
            )->countDataInDusun($desa, $this->periode);
            $data = [
                '_index' => $i,
                'nama_dusun' => $desa->name ?: '0',
                'jumlah_rw' => ucfirst($counts['countRw']) ?: '0',
                'jumlah_rt' => ucfirst($counts['countRt']) ?: '0',
                'jumlah_dasa_wisma' => ucfirst($counts['countDasawisma']) ?: '0',
                'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                'jumlah_KK' => ucfirst($counts['countKK']) ?: '0',
                'jumlah_laki' => ucfirst($counts['countLakiLaki']) ?: '0',
                'jumlah_perempuan' => ucfirst($counts['countPerempuan']) ?: '0',
                'jumlah_balita_laki' => ucfirst($counts['countbalitaLaki']) ?: '0',
                'jumlah_balita_perempuan' => ucfirst($counts['countbalitaPerempuan']) ?: '0',
                // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
                'jumlah_PUS' => ucfirst($counts['countPUS']) ?: '0',
                'jumlah_WUS' => ucfirst($counts['countWUS']) ?: '0',
                'jumlah_ibu_hamil' => ucfirst($counts['countIbuHamil']) ?: '0',
                'jumlah_ibu_menyusui' => ucfirst($counts['countIbuMenyesui']) ?: '0',
                'jumlah_lansia' => ucfirst($counts['countLansia']) ?: '0',
                'jumlah_tiga_buta' => '0',
                'jumlah_kebutuhan_khusus' => ucfirst($counts['countKebutuhanKhusus']) ?: '0',
                'sehat_layak_huni' => ucfirst($counts['countKriteriaRumahSehat']) ?: '0',
                'tidak_sehat_layak_huni' => ucfirst($counts['countKriteriaRumahNonSehat']) ?: '0',
                'punya_tempat_sampah' => ucfirst($counts['countTempatSampah']) ?: '0',
                'punya_saluran_air' => ucfirst($counts['countSPAL']) ?: '0',
                'jumlah_punya_jamban' => ucfirst($counts['countJamban']) ?: '0',
                'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
                'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras']) ?: '0',
                'aktivitas_UP2K' => ucfirst($counts['aktivitasUP2K']) ?: '0',
                'pemanfaatan' => ucfirst($counts['data_pemanfaatan_pekarangan']) ?: '0',
                'industri' => ucfirst($counts['industri_rumah_tangga']) ?: '0',
                'kesehatan_lingkungan' => ucfirst($counts['aktivitasKesehatanLingkungan']) ?: '0',
            ];

            $result[] = $data;
            $i++;
        }
        foreach ($this->rwsAll as $item) {
            // $counts = app('App\Http\Controllers\AdminDesa\DusunController')->countDataInDusun($desa, $this->periode);
            $counts = app(
                'App\Http\Controllers\AdminDesa\RekapDusunInDesaController',
            )->rowRtInDesaWrapInRw($item->id, $this->periode);
            if($counts){
                $this->nonDusun ++;
                $data = [
                    '_index' => $i,
                    'nama_dusun' => ucfirst($counts['nama rw']) ?: '0',
                    'jumlah_rw' => ucfirst($counts['countRw']) ?: '0',
                    'jumlah_rt' => ucfirst($counts['countRt']) ?: '0',
                    'jumlah_dasa_wisma' => ucfirst($counts['countDasawisma']) ?: '0',
                    'jumlah_KRT' => ucfirst($counts['countRumahTangga']) ?: '0',
                    'jumlah_KK' => ucfirst($counts['countKK']) ?: '0',
                    'jumlah_laki' => ucfirst($counts['countLakiLaki']) ?: '0',
                    'jumlah_perempuan' => ucfirst($counts['countPerempuan']) ?: '0',
                    'jumlah_balita_laki' => ucfirst($counts['countbalitaLaki']) ?: '0',
                    'jumlah_balita_perempuan' => ucfirst($counts['countbalitaPerempuan']) ?: '0',
                    // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
                    'jumlah_PUS' => ucfirst($counts['countPUS']) ?: '0',
                    'jumlah_WUS' => ucfirst($counts['countWUS']) ?: '0',
                    'jumlah_ibu_hamil' => ucfirst($counts['countIbuHamil']) ?: '0',
                    'jumlah_ibu_menyusui' => ucfirst($counts['countIbuMenyesui']) ?: '0',
                    'jumlah_lansia' => ucfirst($counts['countLansia']) ?: '0',
                    'jumlah_tiga_buta' => '0',
                    'jumlah_kebutuhan_khusus' => ucfirst($counts['countKebutuhanKhusus']) ?: '0',
                    'sehat_layak_huni' => ucfirst($counts['countKriteriaRumahSehat']) ?: '0',
                    'tidak_sehat_layak_huni' => ucfirst($counts['countKriteriaRumahNonSehat']) ?: '0',
                    'punya_tempat_sampah' => ucfirst($counts['countTempatSampah']) ?: '0',
                    'punya_saluran_air' => ucfirst($counts['countSPAL']) ?: '0',
                    'jumlah_punya_jamban' => ucfirst($counts['countJamban']) ?: '0',
                    'tempel_stiker' => ucfirst($counts['countStiker']) ?: '0',
                    'sumber_air_pdam' => ucfirst($counts['countAirPDAM']) ?: '0',
                    'sumber_air_sumur' => ucfirst($counts['countAirSumur']) ?: '0',
                    'sumber_air_lainya' => ucfirst($counts['countAirLainya']) ?: '0',
                    'makanan_pokok_beras' => ucfirst($counts['countBeras']) ?: '0',
                    'makanan_pokok_non_beras' => ucfirst($counts['countNonBeras']) ?: '0',
                    'aktivitas_UP2K' => ucfirst($counts['aktivitasUP2K']) ?: '0',
                    'pemanfaatan' => ucfirst($counts['data_pemanfaatan_pekarangan']) ?: '0',
                    'industri' => ucfirst($counts['industri_rumah_tangga']) ?: '0',
                    'kesehatan_lingkungan' => ucfirst($counts['aktivitasKesehatanLingkungan']) ?: '0',
                ];

                $result[] = $data;
                $i++;
            }
        }
        // $dataNonDusun = [
        //     '_index' => $i + 1,
        //     'nama_dusun' => 'tidak ada dusun',
        //     'jumlah_rw' => 0,
        //     'jumlah_rt' => 0,
        //     'jumlah_dasa_wisma' => 0,
        //     'jumlah_KRT' => 0,
        //     'jumlah_KK' => 0,
        //     'jumlah_laki' => 0,
        //     'jumlah_perempuan' => 0,
        //     'jumlah_balita_laki' => 0,
        //     'jumlah_balita_perempuan' => 0,
        //     // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
        //     'jumlah_PUS' => 0,
        //     'jumlah_WUS' => 0,
        //     'jumlah_ibu_hamil' => 0,
        //     'jumlah_ibu_menyusui' => 0,
        //     'jumlah_lansia' => 0,
        //     'jumlah_tiga_buta' => 0,
        //     'jumlah_kebutuhan_khusus' => 0,
        //     'sehat_layak_huni' => 0,
        //     'tidak_sehat_layak_huni' => 0,
        //     'punya_tempat_sampah' => 0,
        //     'punya_saluran_air' => 0,
        //     'jumlah_punya_jamban' => 0,
        //     'tempel_stiker' => 0,
        //     'sumber_air_pdam' => 0,
        //     'sumber_air_sumur' => 0,
        //     'sumber_air_lainya' => 0,
        //     'makanan_pokok_beras' => 0,
        //     'makanan_pokok_non_beras' => 0,
        //     'aktivitas_UP2K' => 0,
        //     'pemanfaatan' => 0,
        //     'industri' => 0,
        //     'kesehatan_lingkungan' => 0,
        // ];
        // $dataNonDusun = [
        //     '_index' => $i,
        //     'nama_dusun' => 'tidak ada dusun',
        //     'totalRw' => '0',
        //     'totalRt' => '0',
        //     'totalDasawisma' => '0',
        //     'totalRumahTangga' => '0',
        //     'totalKeluarga' => '0',
        //     'totalLakiLaki' => '0',
        //     'totalPerempuan' => '0',
        //     'totalbalitaLaki' => '0',
        //     'totalbalitaPerempuan' => '0',
        //     'totalPUS' => '0',
        //     'totalWUS' => '0',
        //     'totalIbuHamil' => '0',
        //     'totalIbuMenyusui' => '0',
        //     'totalLansia' => '0',
        //     'totalTigaButa' => '0',
        //     'totalKebutuhanKhusus' => '0',
        //     'totalRumahSehat' => '0',
        //     'totalRumahNonSehat' => '0',
        //     'totalTempatSampah' => '0',
        //     'totalSPAL' => '0',
        //     'totalJamban' => '0',
        //     'totalStiker' => '0',
        //     'totalAirPDAM' => '0',
        //     'totalAirSumur' => '0',
        //     'totalAirLainya' => '0',
        //     'totalBeras' => '0',
        //     'totalNonBeras' => '0',
        //     'totalAktivitasUP2K' => '0',
        //     'totalPemanfaatanPekarangan' => '0',
        //     'totalIndustri' => '0',
        //     'totalAktivitasLingkungan' => '0',
        // ];
        $user = Auth::user();
        $rws = Rw::where('desa_id', $user->id_desa)
            ->where('dusun_id', 0)
            ->get();
        // $dataNonDusun['totalRw'] = $rws->count() ?: '0';
        $rtIds = Rt::whereIn('rw_id', $rws->pluck('id'))->pluck('id');
        // $dataRtNonDusun = Rt::whereIn('id', $rtIds)->get();
        // foreach ($dataRtNonDusun as $drt) {
        //     $dataNonDusun['totalRt']++;
        //     foreach ($drt->dasawisma as $item) {
        //         if ($item->periode <= $this->periode) {
        //             # code...

        //             $dataNonDusun['totalKeluarga'] += DataKeluarga::where('id_dasawisma', $item->id)
        //                 ->where('periode', $this->periode)
        //                 ->count();

        //             $dataNonDusun['totalDasawisma']++;

        //             // $totalDasawisma++;
        //             $rumah = RumahTangga::where('id_dasawisma', $item->id)
        //                 ->get()
        //                 ->where('periode', $this->periode);
        //             foreach ($rumah as $keluarga) {
        //                 if ($keluarga) {
        //                     if (!$keluarga->is_valid) {
        //                         return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
        //                     }
        //                     $dataNonDusun['totalRumahTangga']++;
        //                     if ($keluarga->pemanfaatanlahan) {
        //                         foreach ($keluarga->pemanfaatanlahan as $lahan) {
        //                             if ($lahan && $lahan->is_valid != null) {
        //                                 $dataNonDusun['totalPemanfaatanPekarangan']++;
        //                                 // $totalPemanfaatanPekarangan++;
        //                             }
        //                         }
        //                     }
        //                     if ($keluarga->punya_tempat_sampah) {
        //                         // $totalTempatSampah++;
        //                         $dataNonDusun['totalTempatSampah']++;
        //                     }
        //                     if ($keluarga->saluran_pembuangan_air_limbah) {
        //                         $dataNonDusun['totalSPAL']++;
        //                         // $totalSPAL++;
        //                     }
        //                     if ($keluarga->punya_jamban) {
        //                         // $totalJamban++;
        //                         $dataNonDusun['totalJamban']++;
        //                     }
        //                     if ($keluarga->tempel_stiker) {
        //                         // $totalStiker++;
        //                         $dataNonDusun['totalStiker']++;
        //                     }
        //                     //pdam
        //                     if ($keluarga->sumber_air_pdam) {
        //                         // $totalAirPDAM++;
        //                         $dataNonDusun['totalAirPDAM']++;
        //                     }
        //                     if ($keluarga->sumber_air_sumur) {
        //                         // $totalAirSumur++;
        //                         $dataNonDusun['totalAirSumur']++;
        //                     }
        //                     if ($keluarga->sumber_air_lainnya) {
        //                         // $totalAirLainya++;
        //                         $dataNonDusun['totalAirLainya']++;
        //                     }
        //                     //pdam
        //                     if ($keluarga->punya_tempat_sampah && $keluarga->punya_jamban && $keluarga->saluran_pembuangan_air_limbah) {
        //                         $dataNonDusun['totalRumahSehat']++;
        //                         // $totalRumahSehat++;
        //                     } else {
        //                         $dataNonDusun['totalRumahNonSehat']++;
        //                         // $totalRumahNonSehat++;
        //                     }

        //                     foreach ($keluarga->anggotaRT as $anggotaRumah) {
        //                         // $countKK++;
        //                         // if ($anggotaRumah->keluarga->industri_id != 0) {
        //                         //     $totalIndustri++;
        //                         // }
        //                         if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
        //                             $dataNonDusun['totalIndustri']++;
        //                             // $totalIndustri++;
        //                         }
        //                         foreach ($anggotaRumah->keluarga->anggota as $anggota) {
        //                             // foreach ($anggota->warga->industri as $industri) {
        //                             //     if ($industri) {
        //                             //         $industri_rumah_tangga++;
        //                             //     }
        //                             // }
        //                             // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
        //                             //     if ($pemanfaatan) {
        //                             //         $data_pemanfaatan_pekarangan++;
        //                             //     }
        //                             // }
        //                             $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
        //                             $umurz = $tgl_lahir->diffInYears($this->today);

        //                             if ($anggota->warga->makan_beras) {
        //                                 $dataNonDusun['totalBeras']++;
        //                                 // $totalBeras++;
        //                             } else {
        //                                 $dataNonDusun['totalNonBeras']++;
        //                                 // $totalNonBeras++;
        //                             }
        //                             if ($umurz >= 45) {
        //                                 $dataNonDusun['totalLansia']++;
        //                                 // $totalLansia++;
        //                             }
        //                             if ($anggota->warga->ibu_hamil) {
        //                                 // $totalIbuHamil++;
        //                                 $dataNonDusun['totalIbuHamil']++;
        //                             }
        //                             if ($anggota->warga->ibu_menyusui) {
        //                                 $dataNonDusun['totalIbuMenyusui']++;
        //                                 // $totalIbuMenyusui++;
        //                             }
        //                             if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
        //                                 $dataNonDusun['totalAktivitasLingkungan']++;
        //                                 // $totalAktivitasLingkungan++;
        //                             }
        //                             if ($anggota->warga->aktivitas_UP2K) {
        //                                 $dataNonDusun['totalAktivitasUP2K']++;
        //                                 // $totalAktivitasUP2K++;
        //                             }
        //                             if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
        //                                 $dataNonDusun['totalKebutuhanKhusus']++;
        //                                 // $totalKebutuhanKhusus++;
        //                             }

        //                             if ($anggota->warga->jenis_kelamin === 'laki-laki') {
        //                                 $dataNonDusun['totalLakiLaki']++;
        //                                 // $totalLakiLaki++;
        //                                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
        //                                 $umur = $tgl_lahir->diffInYears($this->today);
        //                                 if ($umur <= 5) {
        //                                     $dataNonDusun['totalbalitaLaki']++;
        //                                     // $totalbalitaLaki++;
        //                                 }
        //                             } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
        //                                 // $totalPerempuan++;
        //                                 $dataNonDusun['totalPerempuan']++;
        //                                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
        //                                 $umur = $tgl_lahir->diffInYears($this->today);
        //                                 if ($umur >= 15 && $umur <= 49) {
        //                                     $dataNonDusun['totalWUS']++;
        //                                     // $totalWUS++;
        //                                 }
        //                                 if ($umur <= 5) {
        //                                     // $totalbalitaPerempuan++;
        //                                     $dataNonDusun['totalbalitaPerempuan']++;
        //                                 }
        //                             }
        //                         }
        //                         $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
        //                             return $anggota->warga->jenis_kelamin === 'laki-laki' && $anggota->warga->status_perkawinan === 'menikah';
        //                         });

        //                         // Menghitung jumlah PUS (Pasangan Usia Subur)
        //                         $countPUS = 0;
        //                         if ($hasMarriedMen) {
        //                             $countPUS = $anggotaRumah->keluarga->anggota
        //                                 ->filter(function ($anggota) {
        //                                     $birthdate = new DateTime($anggota->warga->tgl_lahir);
        //                                     $today = new DateTime();
        //                                     $age = $today->diff($birthdate)->y;
        //                                     return $anggota->warga->jenis_kelamin === 'perempuan' && $age >= 15 && $age <= 49 && $anggota->warga->status_perkawinan === 'menikah';
        //                                 })
        //                                 ->count()
        //                                 ? 1
        //                                 : 0;
        //                         }
        //                         $dataNonDusun['totalPUS'] += $countPUS;
        //                         // $totalPUS += $countPUS;
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // dd($dataNonDusun);

        // $result[] = $dataNonDusun;

        $result[] = [
            '_index' => 'JUMLAH',
            'dusun' => null,
            'jumlah_rw' => $this->totalRw  ?: '0',
            'jumlah_rt' => $this->totalRt ?: '0',
            'jumlah_dasa_wisma' => $this->totalDasawisma ?: '0',
            'jumlah_KRT' => $this->totalRumahTangga ?: '0',
            'jumlah_KK' => $this->totalKeluarga ?: '0',
            'jumlah_laki' => $this->totalLakiLaki ?: '0',
            'jumlah_perempuan' => $this->totalPerempuan ?: '0',
            'jumlah_balita_laki' => $this->totalbalitaLaki ?: '0',
            'jumlah_balita_perempuan' => $this->totalbalitaPerempuan ?: '0',
            // 'jumlah_3_buta' => $keluarga->jumlah_3_buta ?: '0',
            'jumlah_PUS' => $this->totalPUS ?: '0',
            'jumlah_WUS' => $this->totalWUS ?: '0',
            'jumlah_ibu_hamil' => $this->totalIbuHamil ?: '0',
            'jumlah_ibu_menyusui' => $this->totalIbuMenyusui ?: '0',
            'jumlah_lansia' => $this->totalLansia ?: '0',
            'jumlah_tiga_buta' => '0',
            'jumlah_kebutuhan_khusus' => $this->totalKebutuhanKhusus ?: '0',
            'sehat_layak_huni' => $this->totalRumahSehat ?: '0',
            'tidak_sehat_layak_huni' => $this->totalRumahNonSehat ?: '0',
            'punya_tempat_sampah' => $this->totalTempatSampah ?: '0',
            'punya_saluran_air' => $this->totalSPAL ?: '0',
            'jumlah_punya_jamban' => $this->totalJamban ?: '0',
            'tempel_stiker' => $this->totalStiker ?: '0',
            'sumber_air_pdam' => $this->totalAirPDAM ?: '0',
            'sumber_air_sumur' => $this->totalAirSumur ?: '0',
            'sumber_air_lainya' => $this->totalAirLainya ?: '0',
            'makanan_pokok_beras' => $this->totalBeras ?: '0',
            'makanan_pokok_non_beras' => $this->totalNonBeras ?: '0',
            'aktivitas_UP2K' => $this->totalAktivitasUP2K ?: '0',
            'pemanfaatan' => $this->totalPemanfaatanPekarangan ?: '0',
            'industri' => $this->totalIndustri ?: '0',
            'kesehatan_lingkungan' => $this->totalAktivitasLingkungan ?: '0',
        ];

        return $result;
    }

    public function headings(): array
    {
        $headings = ['', '', '', '', '', '', '', 'JUMLAH ANGGOTA KELUARGA', '', '', '', '', '', '', '', '', '', '', 'KRITERIA RUMAH', '', '', '', '', '', 'SUMBER AIR KELUARGA', '', '', 'MAKANAN POKOK', '', 'WARGA MENGIKUTI KEGIATAN', '', '', '', 'KETERANGAN'];

        $headings2 = [
            'NO',
            'NAMA DUSUN',
            'JML RW',
            'JML RT',
            'JML DASAWISMA',
            'JML KRT',
            'JML KK',
            'TOTAL L',
            'TOTAL P',
            'BALITA L',
            'BALITA P',
            // '3 BUTA',
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
            'SUMBER AIR PDAM',
            'SUMBER AIR SUMUR',
            'SUMBER AIR LAINNYA',
            'BERAS',
            'NON BERAS',
            'UP2K',
            'PEMANFAATAN PEKARANGAN',
            'INDUSTRI RUMAH TANGGA',
            'KESEHATAN LINGKUNGAN',
        ];

        return [
            // ['REKAPITULASI'],
            ['CATATAN DATA DAN KEGIATAN WARGA'],
            ['TP PKK DESA/KELURAHAN'],
            ['TAHUN ' . $this->periode],
            ['TP PKK Desa/Kelurahan : ' . $this->desa->nama_desa],
            ['Kecamatan : ' . $this->desa->kecamatan->nama_kecamatan],
            //  [
            //      'Kabupaten : ' . ($this->dusun->first()->rt->first()->first()->dasawisma->first()->desa->kecamatan->kabupaten->name),
            //  ],
            // [
            //     'Provinsi : ' . ($this->dusun->first()->rt->first()->first()->dasawisma->first()->desa->kecamatan->kabupaten->provinsi->name),
            // ],
            ['Kabupaten : ' . (optional($this->desa->kecamatan->kabupaten)->name ?? '')],
            ['Provinsi : ' . (optional($this->desa->kecamatan->kabupaten->provinsi)->name ?? 'Jawa ')],
            [],
            $headings,
            $headings2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('AH9:AH10');
                $lastRow = count($this->dusun) + $this->nonDusun + 11;
                $event->sheet->getDelegate()->mergeCells('A' . $lastRow . ':B' . $lastRow);
                $highestRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A9:A' . $highestRow)->applyFromArray([
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

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A9:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($this->getBorderStyles());
        // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        $lastColumn = $sheet->getHighestColumn();
        // // Menggabungkan semua sel pada baris 1 (dari kolom A sampai kolom terakhir yang berisi data)
        // $lastColumn = $sheet->getHighestColumn();

        // Menggabungkan sel dari A1 sampai A6 sampai dengan kolom terakhir yang berisi data
        $sheet->mergeCells('A1:' . $lastColumn . '1');
        $sheet->mergeCells('A2:' . $lastColumn . '2');
        $sheet->mergeCells('A3:' . $lastColumn . '3');

        // Mengatur horizontal alignment (penyelarasan horizontal) pada sel A1 sampai A6 ke tengah
        $sheet
            ->getStyle('A1:A3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
            $sheet
                ->getStyle($col)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet
                ->getStyle($col)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->mergeCells('H9:R9');
            $sheet->mergeCells('S9:X9');
            $sheet->mergeCells('Y9:AA9');
            $sheet->mergeCells('AB9:AC9');
            $sheet->mergeCells('AD9:AG9');
        }

        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString('D');

        for ($col = 'A'; $col <= 'G'; $col++) {
            // Simpan nilai sel sebelum digabungkan
            $value = $sheet->getCell($col . '10')->getValue();

            // Pindahkan nilai sel ke sel atas
            $sheet->setCellValue($col . '9', $value);

            // Gabungkan sel secara vertikal
            $sheet->mergeCells($col . '9:' . $col . '10');

            // Atur penyelarasan vertikal ke tengah
            $sheet
                ->getStyle($col . '9:' . $col . '10')
                ->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }
    }
}
