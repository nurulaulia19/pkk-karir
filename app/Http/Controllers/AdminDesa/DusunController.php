<?php

namespace App\Http\Controllers\AdminDesa;

use App\Http\Controllers\Controller;
use App\Models\DasaWisma;
use App\Models\DataDasaWisma;
use App\Models\DataKeluarga;
use App\Models\Dusun;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\Rw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class DusunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd($user);
        $dusun = Dusun::with(['rw', 'rt'])
            ->where('desa_id', $user->id_desa)
            ->get();
        // dd($dusun);
        return view('admin_desa.dusun.index', compact('dusun'));
    }

    public function countDataInDusun(Dusun $dusun,$periode)
    {
        $countRw = Rw::where('dusun_id', $dusun->id)->count();
        $countRt = Rt::where('dusun_id', $dusun->id)->count();

        $dataRt = Rt::where('dusun_id', $dusun->id)->get();
        // dd($dataRt);
        $countDasawisma = 0;
        $countKK = 0;
        $countRumahTangga = 0;
        $data_pemanfaatan_pekarangan = 0;
        $countTempatSampah = 0;
        $countSPAL = 0;
        $countJamban = 0;
        $countStiker = 0;
        $countAirPDAM = 0;
        $countAirSumur = 0;
        $countAirLainya = 0;
        $countKriteriaRumahSehat = 0;
        $countKriteriaRumahNonSehat = 0;
        $industri_rumah_tangga = 0;
        $countBeras = 0;
        $countNonBeras = 0;
        $countLansia = 0;
        $countIbuHamil = 0;
        $countIbuMenyesui = 0;
        $today = Carbon::now();
        $aktivitasKesehatanLingkungan = 0;
        $aktivitasUP2K = 0;
        $countKebutuhanKhusus = 0;
        $countMakanBeras = 0;
        $countMakanNNonBeras = 0;
        $countLakiLaki = 0;
        $countbalitaLaki = 0;
        $countWUS = 0;
        $countPerempuan = 0;
        $countPUS = 0;
        $countbalitaPerempuan = 0;

        foreach ($dataRt as $rt) {
            $dasawisma = DasaWisma::where('id_rt', $rt->id)->get();
            foreach ($dasawisma as $item) {
                if($item->periode <= $periode) {
                    # code...
                $countKK += DataKeluarga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->count()
                ;

                $countDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->get();
                foreach ($rumah as $keluarga) {
                    $countRumahTangga++;
                    if ($keluarga->pemanfaatanlahan) {
                        foreach ($keluarga->pemanfaatanlahan as $lahan) {
                            // if ($lahan) {
                            //     $data_pemanfaatan_pekarangan++;
                            // }
                            if ($lahan && $lahan->is_valid != null) {
                                $data_pemanfaatan_pekarangan++;
                            }
                        }
                    }
                    if ($keluarga->punya_tempat_sampah) {
                        $countTempatSampah++;
                    }
                    if ($keluarga->saluran_pembuangan_air_limbah) {
                        $countSPAL++;
                    }
                    if ($keluarga->punya_jamban) {
                        $countJamban++;
                    }
                    if ($keluarga->tempel_stiker) {
                        $countStiker++;
                    }
                    //pdam
                    if ($keluarga->sumber_air_pdam) {
                        $countAirPDAM++;
                    }
                    if ($keluarga->sumber_air_sumur) {
                        $countAirSumur++;
                    }
                    if ($keluarga->sumber_air_lainnya) {
                        $countAirLainya++;
                    }
                    //pdam
                    if ($keluarga->punya_tempat_sampah && $keluarga->punya_jamban && $keluarga->saluran_pembuangan_air_limbah) {
                        $countKriteriaRumahSehat++;
                    } else {
                        $countKriteriaRumahNonSehat++;
                    }

                    foreach ($keluarga->anggotaRT as $anggotaRumah) {
                        // $countKK++;
                        // if ($anggotaRumah->keluarga->industri_id != 0) {
                        //     $industri_rumah_tangga++;
                        // }
                        if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
                            $industri_rumah_tangga++;
                        }
                        foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                            // foreach ($anggota->warga->industri as $industri) {
                            //     if ($industri) {
                            //         $industri_rumah_tangga++;
                            //     }
                            // }
                            // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                            //     if ($pemanfaatan) {
                            //         $data_pemanfaatan_pekarangan++;
                            //     }
                            // }
                            $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            $umurz = $tgl_lahir->diffInYears($today);

                            if ($anggota->warga->makan_beras) {
                                $countBeras++;
                            } else {
                                $countNonBeras++;
                            }
                            if ($umurz >= 45) {
                                $countLansia++;
                            }
                            if ($anggota->warga->ibu_hamil) {
                                $countIbuHamil++;
                            }
                            if ($anggota->warga->ibu_menyusui) {
                                $countIbuMenyesui++;
                            }
                            if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                $aktivitasKesehatanLingkungan++;
                            }
                            if ($anggota->warga->aktivitas_UP2K) {
                                $aktivitasUP2K++;
                            }
                            if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                $countKebutuhanKhusus++;
                            }
                            if ($anggota->warga->makan_beras) {
                                $countMakanBeras++;
                            } else {
                                $countMakanNNonBeras++;
                            }

                            if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                $countLakiLaki++;
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                $umur = $tgl_lahir->diffInYears($today);
                                if ($umur <= 5) {
                                    $countbalitaLaki++;
                                }
                            } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                $countPerempuan++;
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                $umur = $tgl_lahir->diffInYears($today);
                                if ($umur >= 15 && $umur <= 49) {
                                    $countWUS++;
                                }
                                if ($umur <= 5) {
                                    $countbalitaPerempuan++;
                                }
                            }
                            // if ($anggota->warga->status_perkawinan === 'menikah') {
                            //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                            //         $countPUS++;
                            //     } else {
                            //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            //         $umur = $tgl_lahir->diffInYears($today);
                            //         if ($umur >= 15 && $umur <= 49) {
                            //             $countPUS++;
                            //         }
                            //     }
                            // }
                        }
                        $hitung = $anggotaRumah->keluarga->anggota->first(function($anggota) {
                            // Calculate age based on birthdate
                            $birthdate = new DateTime($anggota->warga->tgl_lahir);
                            $today = new DateTime();
                            $age = $today->diff($birthdate)->y;

                            // Check if the member is married and female, and age is between 15 and 49
                            return $anggota->warga->status_perkawinan === 'menikah' &&
                                   $anggota->warga->jenis_kelamin === 'perempuan' &&
                                   $age >= 15 && $age <= 49;
                        }) ? 1 : 0;
                        $countPUS += $hitung;

                    }
                }
                }
            }
        }

        return [
            'countRw' => $countRw,
            'countRt' => $countRt,
            'countDasawisma' => $countDasawisma,
            'countKK' => $countKK,
            'countRumahTangga' => $countRumahTangga,
            'data_pemanfaatan_pekarangan' => $data_pemanfaatan_pekarangan,
            'countTempatSampah' => $countTempatSampah,
            'countSPAL' => $countSPAL,
            'countJamban' => $countJamban,
            'countStiker' => $countStiker,
            'countAirPDAM' => $countAirPDAM,
            'countAirSumur' => $countAirSumur,
            'countAirLainya' => $countAirLainya,
            'countKriteriaRumahSehat' => $countKriteriaRumahSehat,
            'countKriteriaRumahNonSehat' => $countKriteriaRumahNonSehat,
            'industri_rumah_tangga' => $industri_rumah_tangga,
            'countBeras' => $countBeras,
            'countNonBeras' => $countNonBeras,
            'countLansia' => $countLansia,
            'countIbuHamil' => $countIbuHamil,
            'countIbuMenyesui' => $countIbuMenyesui,
            'today' => $today,
            'aktivitasKesehatanLingkungan' => $aktivitasKesehatanLingkungan,
            'aktivitasUP2K' => $aktivitasUP2K,
            'countKebutuhanKhusus' => $countKebutuhanKhusus,
            'countMakanBeras' => $countMakanBeras,
            'countMakanNNonBeras' => $countMakanNNonBeras,
            'countLakiLaki' => $countLakiLaki,
            'countbalitaLaki' => $countbalitaLaki,
            'countWUS' => $countWUS,
            'countPerempuan' => $countPerempuan,
            'countPUS' => $countPUS,
            'countbalitaPerempuan' => $countbalitaPerempuan,
        ];
    }
}
