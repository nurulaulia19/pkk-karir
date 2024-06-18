<?php

namespace App\Http\Controllers\AdminDesa;

use App\Exports\RekapKelompokDusunExport;
use App\Http\Controllers\Controller;
use App\Models\DataKeluarga;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Dusun;
use App\Models\DasaWisma;
use App\Models\Data_Desa;
use App\Models\Periode;
use App\Models\RumahTangga;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RekapDusunInDesaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $dusun = Dusun::with(['rw', 'rt'])
            ->where('desa_id', $user->id_desa)
            ->get();
        // dd($dusun);
        $totalDusun = $dusun->count();
        $desa = Data_Desa::with('kecamatan')->find($user->id_desa);

        if ($totalDusun <=0) {
            return redirect()->route('not-found')->with('error', 'Data rekap tidak tersedia');
        }
        $totalRw = Rw::where('dusun_id','!=',0)->where('desa_id', $user->id_desa)->count();
        $totalRt = Rt::where('dusun_id','!=',0)->count();
        $dataRt =  Rt::where('dusun_id','!=',0)->get();

        // $rws = Rw::where('desa_id', $user->id_desa)->get();
        // $totalRw = $rws->count();
        // $rtIds = Rt::whereIn('rw_id', $rws->pluck('id'))->pluck('id');
        // $totalRt = $rtIds->count();
        // $dataRt = Rt::whereIn('id', $rtIds)->get();
        // $totalRt = 0 ;
        $totalKeluarga = 0 ;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalPemanfaatanPekarangan = 0 ;
        $totalTempatSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0 ;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;
        $totalRumahSehat = 0;
        $totalRumahNonSehat = 0;
        $totalIndustri = 0;
        $today = Carbon::now();
        $totalBeras = 0;
        $totalNonBeras = 0;
        $totalLansia = 0 ;
        $totalIbuHamil = 0;
        $totalIbuMenyusui = 0 ;
        $totalAktivitasLingkungan = 0;
        $totalAktivitasUP2K = 0;
        $totalKebutuhanKhusus = 0;
        $totalLakiLaki = 0 ;
        $totalbalitaLaki = 0;
        $totalPerempuan = 0;
        $totalWUS = 0;
        $totalbalitaPerempuan = 0;
        $totalPUS= 0 ;
        $periodeAll = Periode::all();

        // dd($dataRt);
        // dd($dasawisma);
        foreach ($dataRt as $drt) {
            // $totalRt++;
            foreach ($drt->dasawisma as $item) {
                if ($item->periode <= $periode) {
                    # code...
                $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->count();

                $totalDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)->get()
                ->where('periode',$periode);
                foreach ($rumah as $keluarga) {
                    if($keluarga){
                        if(!$keluarga->is_valid){
                            return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
                        }
                        $totalRumahTangga++;
                    if ($keluarga->pemanfaatanlahan) {
                        foreach ($keluarga->pemanfaatanlahan as $lahan) {
                            // if ($lahan) {
                            //     $totalPemanfaatanPekarangan++;
                            // }
                            if ($lahan && $lahan->is_valid != null) {
                                $totalPemanfaatanPekarangan++;
                            }
                        }
                    }
                    if ($keluarga->punya_tempat_sampah) {
                        $totalTempatSampah++;
                    }
                    if ($keluarga->saluran_pembuangan_air_limbah) {
                        $totalSPAL++;
                    }
                    if ($keluarga->punya_jamban) {
                        $totalJamban++;
                    }
                    if ($keluarga->tempel_stiker) {
                        $totalStiker++;
                    }
                    //pdam
                    if ($keluarga->sumber_air_pdam) {
                        $totalAirPDAM++;
                    }
                    if ($keluarga->sumber_air_sumur) {
                        $totalAirSumur++;
                    }
                    if ($keluarga->sumber_air_lainnya) {
                        $totalAirLainya++;
                    }
                    //pdam
                    if ($keluarga->punya_tempat_sampah && $keluarga->punya_jamban && $keluarga->saluran_pembuangan_air_limbah) {
                        $totalRumahSehat++;
                    } else {
                        $totalRumahNonSehat++;
                    }

                    foreach ($keluarga->anggotaRT as $anggotaRumah) {
                        // $countKK++;
                        // if ($anggotaRumah->keluarga->industri_id != 0) {
                        //     $totalIndustri++;
                        // }
                        if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
                            $totalIndustri++;
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
                                $totalBeras++;
                            } else {
                                $totalNonBeras++;
                            }
                            if ($umurz >= 45) {
                                $totalLansia++;
                            }
                            if ($anggota->warga->ibu_hamil) {
                                $totalIbuHamil++;
                            }
                            if ($anggota->warga->ibu_menyusui) {
                                $totalIbuMenyusui++;
                            }
                            if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                $totalAktivitasLingkungan++;
                            }
                            if ($anggota->warga->aktivitas_UP2K) {
                                $totalAktivitasUP2K++;
                            }
                            if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                $totalKebutuhanKhusus++;
                            }


                            if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                $totalLakiLaki++;
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                $umur = $tgl_lahir->diffInYears($today);
                                if ($umur <= 5) {
                                    $totalbalitaLaki++;
                                }
                            } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                $totalPerempuan++;
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                $umur = $tgl_lahir->diffInYears($today);
                                if ($umur >= 15 && $umur <= 49) {
                                    $totalWUS++;
                                }
                                if ($umur <= 5) {
                                    $totalbalitaPerempuan++;
                                }
                            }
                            // if ($anggota->warga->status_perkawinan === 'menikah') {
                            //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                            //         $totalPUS++;
                            //     } else {
                            //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            //         $umur = $tgl_lahir->diffInYears($today);
                            //         if ($umur >= 15 && $umur <= 49) {
                            //             $totalPUS++;
                            //         }
                            //     }
                            // }
                        }
                        // $hitung = $anggotaRumah->keluarga->anggota->first(function($anggota) {
                        //     // Calculate age based on birthdate
                        //     $birthdate = new DateTime($anggota->warga->tgl_lahir);
                        //     $today = new DateTime();
                        //     $age = $today->diff($birthdate)->y;

                        //     // Check if the member is married and female, and age is between 15 and 49
                        //     return $anggota->warga->status_perkawinan === 'menikah' &&
                        //            $anggota->warga->jenis_kelamin === 'perempuan' &&
                        //            $age >= 15 && $age <= 49;
                        // }) ? 1 : 0;
                        // $totalPUS += $hitung;
                        $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
                            return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                $anggota->warga->status_perkawinan === 'menikah';
                        });

                        // Menghitung jumlah PUS (Pasangan Usia Subur)
                        $countPUS = 0;
                        if ($hasMarriedMen) {
                            $countPUS = $anggotaRumah->keluarga->anggota->filter(function ($anggota) {
                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                $today = new DateTime();
                                $age = $today->diff($birthdate)->y;
                                return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                    $age >= 15 &&
                                    $age <= 49 &&
                                    $anggota->warga->status_perkawinan === 'menikah';
                            })->count() ? 1 : 0;
                        }
                        $totalPUS += $countPUS;

                    }
                    }
                }
                }
            }
        }
        // dd($totalRw);
        // dd($dusun);
        return view('admin_desa.data_rekap.rekap_desa.index', compact(
            'desa',
            'periode',
            'periodeAll',
            'dusun',
            'totalDusun',
            'totalRw',
            'totalRt',
            'totalDasawisma',
            'totalRumahTangga',
            'totalKeluarga',
            'totalPemanfaatanPekarangan',
            'totalTempatSampah',
            'totalSPAL',
            'totalJamban',
            'totalStiker',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainya',
            'totalRumahSehat',
            'totalRumahNonSehat',
            'totalIndustri',
            'today',
            'totalBeras',
            'totalNonBeras',
            'totalLansia',
            'totalIbuHamil',
            'totalIbuMenyusui',
            'totalAktivitasLingkungan',
            'totalAktivitasUP2K',
            'totalKebutuhanKhusus',
            'totalLakiLaki',
            'totalbalitaLaki',
            'totalPerempuan',
            'totalWUS',
            'totalbalitaPerempuan',
            'totalPUS'
        ));

    }


    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     $periode = $request->periode ?? Carbon::now()->year;
    //     $dusun = Dusun::with(['rw', 'rt'])
    //         ->where('desa_id', $user->id_desa)
    //         ->get();

    //     $totalDusun = $dusun->count();
    //     $desa = Data_Desa::with('kecamatan')->find($user->id_desa);

    //     if ($totalDusun <= 0) {
    //         return redirect()->route('not-found')->with('error', 'Data rekap tidak tersedia');
    //     }

    //     $rws = Rw::where('desa_id', $user->id_desa)->get();
    //     $totalRw = $rws->count();
    //     $rtIds = Rt::whereIn('rw_id', $rws->pluck('id'))->pluck('id');
    //     $totalRt = $rtIds->count();
    //     $dataRt = Rt::whereIn('id', $rtIds)->get();


    //     $totalKeluarga = 0;
    //     $totalDasawisma = 0;
    //     $totalRumahTangga = 0;
    //     $totalPemanfaatanPekarangan = 0;
    //     $totalTempatSampah = 0;
    //     $totalSPAL = 0;
    //     $totalJamban = 0;
    //     $totalStiker = 0;
    //     $totalAirPDAM = 0;
    //     $totalAirSumur = 0;
    //     $totalAirLainya = 0;
    //     $totalRumahSehat = 0;
    //     $totalRumahNonSehat = 0;
    //     $totalIndustri = 0;
    //     $today = Carbon::now();
    //     $totalBeras = 0;
    //     $totalNonBeras = 0;
    //     $totalLansia = 0;
    //     $totalIbuHamil = 0;
    //     $totalIbuMenyusui = 0;
    //     $totalAktivitasLingkungan = 0;
    //     $totalAktivitasUP2K = 0;
    //     $totalKebutuhanKhusus = 0;
    //     $totalLakiLaki = 0;
    //     $totalbalitaLaki = 0;
    //     $totalPerempuan = 0;
    //     $totalWUS = 0;
    //     $totalbalitaPerempuan = 0;
    //     $totalPUS = 0;
    //     $periodeAll = Periode::all();

    //     foreach ($dataRt as $drt) {
    //         foreach ($drt->dasawisma as $item) {
    //             if ($item->periode <= $periode) {
    //                 $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
    //                     ->where('periode', $periode)
    //                     ->count();

    //                 $totalDasawisma++;
    //                 $rumah = RumahTangga::where('id_dasawisma', $item->id)
    //                     ->where('periode', $periode)
    //                     ->get();

    //                 foreach ($rumah as $keluarga) {
    //                     if ($keluarga) {
    //                         if (!$keluarga->is_valid) {
    //                             return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
    //                         }
    //                         $totalRumahTangga++;

    //                         if ($keluarga->pemanfaatanlahan) {
    //                             foreach ($keluarga->pemanfaatanlahan as $lahan) {
    //                                 if ($lahan && $lahan->is_valid != null) {
    //                                     $totalPemanfaatanPekarangan++;
    //                                 }
    //                             }
    //                         }
    //                         if ($keluarga->punya_tempat_sampah) {
    //                             $totalTempatSampah++;
    //                         }
    //                         if ($keluarga->saluran_pembuangan_air_limbah) {
    //                             $totalSPAL++;
    //                         }
    //                         if ($keluarga->punya_jamban) {
    //                             $totalJamban++;
    //                         }
    //                         if ($keluarga->tempel_stiker) {
    //                             $totalStiker++;
    //                         }
    //                         if ($keluarga->sumber_air_pdam) {
    //                             $totalAirPDAM++;
    //                         }
    //                         if ($keluarga->sumber_air_sumur) {
    //                             $totalAirSumur++;
    //                         }
    //                         if ($keluarga->sumber_air_lainnya) {
    //                             $totalAirLainya++;
    //                         }
    //                         if ($keluarga->punya_tempat_sampah && $keluarga->punya_jamban && $keluarga->saluran_pembuangan_air_limbah) {
    //                             $totalRumahSehat++;
    //                         } else {
    //                             $totalRumahNonSehat++;
    //                         }

    //                         foreach ($keluarga->anggotaRT as $anggotaRumah) {
    //                             if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
    //                                 $totalIndustri++;
    //                             }
    //                             foreach ($anggotaRumah->keluarga->anggota as $anggota) {
    //                                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                 $umurz = $tgl_lahir->diffInYears($today);

    //                                 if ($anggota->warga->makan_beras) {
    //                                     $totalBeras++;
    //                                 } else {
    //                                     $totalNonBeras++;
    //                                 }
    //                                 if ($umurz >= 45) {
    //                                     $totalLansia++;
    //                                 }
    //                                 if ($anggota->warga->ibu_hamil) {
    //                                     $totalIbuHamil++;
    //                                 }
    //                                 if ($anggota->warga->ibu_menyusui) {
    //                                     $totalIbuMenyusui++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
    //                                     $totalAktivitasLingkungan++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_UP2K) {
    //                                     $totalAktivitasUP2K++;
    //                                 }
    //                                 if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
    //                                     $totalKebutuhanKhusus++;
    //                                 }

    //                                 if ($anggota->warga->jenis_kelamin === 'laki-laki') {
    //                                     $totalLakiLaki++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur <= 5) {
    //                                         $totalbalitaLaki++;
    //                                     }
    //                                 } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
    //                                     $totalPerempuan++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur >= 15 && $umur <= 49) {
    //                                         $totalWUS++;
    //                                     }
    //                                     if ($umur <= 5) {
    //                                         $totalbalitaPerempuan++;
    //                                     }
    //                                 }
    //                             }

    //                             $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
    //                                 return $anggota->warga->jenis_kelamin === 'laki-laki' &&
    //                                     $anggota->warga->status_perkawinan === 'menikah';
    //                             });

    //                             $countPUS = 0;
    //                             if ($hasMarriedMen) {
    //                                 $countPUS = $anggotaRumah->keluarga->anggota->filter(function ($anggota) {
    //                                     $birthdate = new DateTime($anggota->warga->tgl_lahir);
    //                                     $today = new DateTime();
    //                                     $age = $today->diff($birthdate)->y;
    //                                     return $anggota->warga->jenis_kelamin === 'perempuan' &&
    //                                         $age >= 15 &&
    //                                         $age <= 49 &&
    //                                         $anggota->warga->status_perkawinan === 'menikah';
    //                                 })->count() ? 1 : 0;
    //                             }
    //                             $totalPUS += $countPUS;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return view('admin_desa.data_rekap.rekap_desa.index', compact(
    //         'desa',
    //         'periode',
    //         'periodeAll',
    //         'dusun',
    //         'totalDusun',
    //         'totalRw',
    //         'totalRt',
    //         'totalDasawisma',
    //         'totalRumahTangga',
    //         'totalKeluarga',
    //         'totalPemanfaatanPekarangan',
    //         'totalTempatSampah',
    //         'totalSPAL',
    //         'totalJamban',
    //         'totalStiker',
    //         'totalAirPDAM',
    //         'totalAirSumur',
    //         'totalAirLainya',
    //         'totalRumahSehat',
    //         'totalRumahNonSehat',
    //         'totalIndustri',
    //         'today',
    //         'totalBeras',
    //         'totalNonBeras',
    //         'totalLansia',
    //         'totalIbuHamil',
    //         'totalIbuMenyusui',
    //         'totalAktivitasLingkungan',
    //         'totalAktivitasUP2K',
    //         'totalKebutuhanKhusus',
    //         'totalLakiLaki',
    //         'totalbalitaLaki',
    //         'totalPerempuan',
    //         'totalWUS',
    //         'totalbalitaPerempuan',
    //         'totalPUS'
    //     ));
    // }


    public function countDataInDusun(Dusun $dusun)
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
                # code...
                $countKK += DataKeluarga::where('id_dasawisma', $item->id)->count();

                $countDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)->get();
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
                        $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
                            return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                $anggota->warga->status_perkawinan === 'menikah';
                        });

                        // Menghitung jumlah PUS (Pasangan Usia Subur)
                        $hitung = 0;
                        if ($hasMarriedMen) {
                            $hitung = $anggotaRumah->keluarga->anggota->filter(function ($anggota) {
                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                $today = new DateTime();
                                $age = $today->diff($birthdate)->y;
                                return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                    $age >= 15 &&
                                    $age <= 49 &&
                                    $anggota->warga->status_perkawinan === 'menikah';
                            })->count() ? 1 : 0;
                        }
                        $countPUS += $hitung;
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

    public function dataDusun()
    {
        $dusun = Dusun::all();
        $periode = Periode::all();
        // return response()->json($dusun);
        return view('admin_desa.dusun.index', compact('dusun','periode'));
    }

    public function rekapDusun(Request $request,$id)
    {
        // dd('hello world');
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $result = $this->rtrwdusun($id,$periode);
        $user = Auth::user();

        $dusun = $result;
        $dusun_data = Dusun::find($id);
        $dataRt = Rt::with('dasawisma')->where('dusun_id', $id)->get();
        $totalRt = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalKegiatanPemanfaatanPekarangan = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainnya = 0 ;
        $totalStiker = 0;
        $totalJamban = 0;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalSheatLayakHuni = 0;
        $totalTidakSheatLayakHuni = 0;
        $totalJmlKRT = 0;
        $totalJmlKK = 0;
        $totalKegiatanIndustri = 0;
        $totalAnggotaLansia = 0;
        $today = Carbon::now();
        $totalAnggotaIbuHamil = 0;
        $totalAnggotaIbuMenyusui = 0;
        $totalKegiatanLingkungan = 0;
        $totalKegiatanUP2K = 0;
        $totalAnggotaBerkebutuhanKhusus = 0 ;
        $totalMakanBeras = 0;
        $totalMakanNonBeras = 0;
        $totalAnggotaLaki = 0;
        $totalAnggotaBalitaLaki = 0;
        $totalAnggotaPerempuan = 0;
        $totalAnggotaWUS = 0;
        $totalAnggotaBalitaPerempuan = 0;
        $totalAnggotaPUS = 0;
        foreach ($dataRt as $item) {
            $totalRt++;
            foreach ($item->dasawisma as $dasawisma) {
                if($dasawisma->periode <= $periode){
                    $totalDasawisma++;
                foreach ($dasawisma->rumahtangga as $rumahtangga) {
                    // $totalRumahTangga++;
                    if ($rumahtangga->periode == $periode) {

                        if(!$rumahtangga->is_valid){
                            return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
                        }
                        $totalRumahTangga++;
                        // dd($totalRumahTangga++);

                        if ($rumahtangga->pemanfaatanlahan) {
                            // foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                            //     $totalKegiatanPemanfaatanPekarangan++;
                            // }
                            foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                if ($pemanfaatan->is_valid != null) {
                                    $totalKegiatanPemanfaatanPekarangan++;
                                }
                            }
                        }

                        // Hitung jumlah KRT (Kepala Rumah Tangga)
                        if ($rumahtangga->sumber_air_pdam) {
                            $totalAirPDAM++;
                        }
                        if ($rumahtangga->sumber_air_sumur) {
                            $totalAirSumur++;
                        }
                        if ($rumahtangga->sumber_air_lainnya) {
                            $totalAirLainnya++;
                        }
                        if ($rumahtangga->tempel_stiker) {
                            $totalStiker++;
                        }
                        if ($rumahtangga->punya_jamban) {
                            $totalJamban++;
                        }
                        if ($rumahtangga->punya_tempat_sampah) {
                            $totalPemSampah++;
                        }
                        if ($rumahtangga->saluran_pembuangan_air_limbah) {
                            $totalSPAL++;
                        }
                        if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
                            $totalSheatLayakHuni++;
                        } else {
                            $totalTidakSheatLayakHuni++;
                        }

                        if ($rumahtangga) {
                            $totalJmlKRT++;
                        }
                        // Hitung jumlah anggota RT dalam KRT
                        foreach ($rumahtangga->anggotaRT as $keluarga) {
                            if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
                                $totalJmlKK++;
                            }
                            // if ($keluarga->keluarga->industri_id != 0) {
                            //     $totalKegiatanIndustri++;
                            // }
                            if ($keluarga->keluarga->industri_id != 0 && $keluarga->keluarga->is_valid_industri != null) {
                                $totalKegiatanIndustri++;
                            }
                            // Iterasi melalui setiap anggota keluarga
                            foreach ($keluarga->keluarga->anggota as $anggota) {
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);

                                $umurz = $tgl_lahir->diffInYears($today);
                                if ($umurz >= 45) {
                                    $totalAnggotaLansia++;
                                }
                                if ($anggota->warga->ibu_hamil) {
                                    $totalAnggotaIbuHamil++;
                                }
                                if ($anggota->warga->ibu_menyusui) {
                                    $totalAnggotaIbuMenyusui++;
                                }
                                if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                    $totalKegiatanLingkungan++;
                                }
                                if ($anggota->warga->aktivitas_UP2K) {
                                    $totalKegiatanUP2K++;
                                }
                                if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                    $totalAnggotaBerkebutuhanKhusus++;
                                }
                                if ($anggota->warga->makan_beras) {
                                    $totalMakanBeras++;
                                } else {
                                    $totalMakanNonBeras++;
                                }
                                if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                    $totalAnggotaLaki++;
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur <= 5) {
                                        $totalAnggotaBalitaLaki++;
                                    }
                                } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                    $totalAnggotaPerempuan++;
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur >= 15 && $umur <= 49) {
                                        $totalAnggotaWUS++;
                                    }
                                    if ($umur <= 5) {
                                        $totalAnggotaBalitaPerempuan++;
                                    }
                                }
                                // if ($anggota->warga->status_perkawinan === 'menikah') {
                                //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                //         $totalAnggotaPUS++;
                                //     } else {
                                //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                //         $umur = $tgl_lahir->diffInYears($today);
                                //         if ($umur >= 15 && $umur <= 49) {
                                //             $totalAnggotaPUS++;
                                //         }
                                //     }
                                // }
                            }
                            $hasMarriedMen = $keluarga->keluarga->anggota->contains(function ($anggota) {
                                return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                    $anggota->warga->status_perkawinan === 'menikah';
                            });

                            // Menghitung jumlah PUS (Pasangan Usia Subur)
                            $countPUS = 0;
                            if ($hasMarriedMen) {
                                $countPUS = $keluarga->keluarga->anggota->filter(function ($anggota) {
                                    $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                    $today = new DateTime();
                                    $age = $today->diff($birthdate)->y;
                                    return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                        $age >= 15 &&
                                        $age <= 49 &&
                                        $anggota->warga->status_perkawinan === 'menikah';
                                })->count() ? 1 : 0;
                            }
                            $totalAnggotaPUS += $countPUS;

                            // $hitung = $keluarga->keluarga->anggota->first(function($anggota) {
                            //     // Calculate age based on birthdate
                            //     $birthdate = new DateTime($anggota->warga->tgl_lahir);
                            //     $today = new DateTime();
                            //     $age = $today->diff($birthdate)->y;

                            //     // Check if the member is married and female, and age is between 15 and 49
                            //     return $anggota->warga->status_perkawinan === 'menikah' &&
                            //            $anggota->warga->jenis_kelamin === 'perempuan' &&
                            //            $age >= 15 && $age <= 49;
                            // }) ? 1 : 0;
                            // $totalAnggotaPUS += $hitung;
                        }
                    }
                }
                }
            }
            # code...
        }

        // dd($dusun_data);
        return view('admin_desa.dusun.rekap', compact(
            'periode',
            'dusun',
            'dusun_data',
            'totalRt',
            'totalDasawisma',
            'totalRumahTangga',
            'totalKegiatanPemanfaatanPekarangan',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainnya',
            'totalStiker',
            'totalJamban',
            'totalPemSampah',
            'totalSPAL',
            'totalSheatLayakHuni',
            'totalTidakSheatLayakHuni',
            'totalJmlKRT',
            'totalJmlKK',
            'totalKegiatanIndustri',
            'totalAnggotaLansia',
            'totalAnggotaIbuHamil',
            'totalAnggotaIbuMenyusui',
            'totalKegiatanLingkungan',
            'totalKegiatanUP2K',
            'totalAnggotaBerkebutuhanKhusus',
            'totalMakanBeras',
            'totalMakanNonBeras',
            'totalAnggotaLaki',
            'totalAnggotaBalitaLaki',
            'totalAnggotaPerempuan',
            'totalAnggotaWUS',
            'totalAnggotaBalitaPerempuan',
            'totalAnggotaPUS'
        ));

    }

    public function rtrwdusun($id,$periode)
    {
        $rwInRtDusun = [];
        $rt = Rt::with('rw.desa')->where('dusun_id', $id)->get();
        // dd($rt);
        $tempuniqueRwInRtDusun = [];
        $dataRw = [];

        foreach ($rt as $rttt) {
            $nameObject = '';

            if ($rttt->dusun_id != $rttt->rw->dusun_id) {
                $nameObject = '';
                // $rt = $rttt->where('dusun_id', '!=', $rttt->rw->dusun_id)->get();
                // dd($tempuniqueRwInRtDusun);
                // if(!in_array($rttt->rw->id, $tempuniqueRwInRtDusun)){
                //     dd($tempuniqueRwInRtDusun);
                // }
                if (!in_array($rttt->rw->id, $tempuniqueRwInRtDusun)) {
                    $rtz = Rt::with('dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga')
                        ->where('dusun_id', $id)
                        ->where('rw_id', $rttt->rw->id)
                        ->get();
                    // dd($rtz);
                    $totalRT = 0;
                    $totalDasawisma = 0;
                    $totalKegiatanPemanfaatanPekarangan = 0;
                    $totalAirPDAM = 0;
                    $totalAirSumur = 0;
                    $totalAirLainnya = 0;
                    $totalStiker = 0;
                    $totalJamban = 0;
                    $totalPemSampah = 0;
                    $totalSPAL = 0;
                    $totalSheatLayakHuni = 0;
                    $totalTidakSheatLayakHuni = 0;
                    $totalJmlKRT = 0;
                    $totalJmlKK = 0;
                    $totalKegiatanIndustri = 0;
                    $totalAnggotaLansia = 0;
                    $totalAnggotaIbuHamil = 0;
                    $totalAnggotaIbuMenyusui = 0;
                    $totalKegiatanUP2K = 0;
                    $totalAnggotaBerkebutuhanKhusus = 0;
                    $totalMakanBeras = 0;
                    $totalMakanNonBeras = 0;
                    $totalAnggotaBalitaLaki = 0;
                    $totalKegiatanLingkungan = 0;
                    $totalAnggotaPerempuan = 0;
                    $totalAnggotaWUS = 0;
                    $totalAnggotaBalitaPerempuan = 0;
                    $totalAnggotaPUS = 0;
                    $totalAnggotaPUS = 0;
                    $totalAnggotaLaki = 0;
                    $totalRumahTangga = 0;
                    $today = Carbon::now();

                    foreach ($rtz as $item) {
                        $totalRT++;
                        foreach ($item->dasawisma as $dasawisma) {
                            if($dasawisma->periode <= $periode){
                                $totalDasawisma++;
                            foreach ($dasawisma->rumahtangga as $rumahtangga) {
                                if ($rumahtangga->periode == $periode) {
                                // $totalRumahTangga++;
                                    $totalRumahTangga++;
                                    // dd($totalRumahTangga);
                                    if ($rumahtangga->pemanfaatanlahan) {
                                        // foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                        //     $totalKegiatanPemanfaatanPekarangan++;
                                        // }
                                        foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                            if ($pemanfaatan->is_valid != null) {
                                                $totalKegiatanPemanfaatanPekarangan++;
                                            }
                                        }
                                    }
                                    // Hitung jumlah KRT (Kepala Rumah Tangga)
                                    if ($rumahtangga->sumber_air_pdam) {
                                        $totalAirPDAM++;
                                    }
                                    if ($rumahtangga->sumber_air_sumur) {
                                        $totalAirSumur++;
                                    }
                                    if ($rumahtangga->sumber_air_lainnya) {
                                        $totalAirLainnya++;
                                    }
                                    if ($rumahtangga->tempel_stiker) {
                                        $totalStiker++;
                                    }
                                    if ($rumahtangga->punya_jamban) {
                                        $totalJamban++;
                                    }
                                    if ($rumahtangga->punya_tempat_sampah) {
                                        $totalPemSampah++;
                                    }
                                    if ($rumahtangga->saluran_pembuangan_air_limbah) {
                                        $totalSPAL++;
                                    }
                                    if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
                                        $totalSheatLayakHuni++;
                                    } else {
                                        $totalTidakSheatLayakHuni++;
                                    }

                                    if ($rumahtangga) {
                                        $totalJmlKRT++;
                                    }
                                    // Hitung jumlah anggota RT dalam KRT
                                    foreach ($rumahtangga->anggotaRT as $keluarga) {
                                        if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
                                            $totalJmlKK++;
                                        }
                                        // if ($keluarga->keluarga->industri_id != 0) {
                                        //     $totalKegiatanIndustri++;
                                        // }
                                        if ($keluarga->keluarga->industri_id != 0 && $keluarga->keluarga->is_valid_industri != null) {
                                            $totalKegiatanIndustri++;
                                        }
                                        // Iterasi melalui setiap anggota keluarga
                                        foreach ($keluarga->keluarga->anggota as $anggota) {
                                            $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);

                                            $umurz = $tgl_lahir->diffInYears($today);
                                            if ($umurz >= 45) {
                                                $totalAnggotaLansia++;
                                            }
                                            if ($anggota->warga->ibu_hamil) {
                                                $totalAnggotaIbuHamil++;
                                            }
                                            if ($anggota->warga->ibu_menyusui) {
                                                $totalAnggotaIbuMenyusui++;
                                            }
                                            if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                                $totalKegiatanLingkungan++;
                                            }
                                            if ($anggota->warga->aktivitas_UP2K) {
                                                $totalKegiatanUP2K++;
                                            }
                                            if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                                $totalAnggotaBerkebutuhanKhusus++;
                                            }
                                            if ($anggota->warga->makan_beras) {
                                                $totalMakanBeras++;
                                            } else {
                                                $totalMakanNonBeras++;
                                            }
                                            if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                                $totalAnggotaLaki++;
                                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                $umur = $tgl_lahir->diffInYears($today);
                                                if ($umur <= 5) {
                                                    $totalAnggotaBalitaLaki++;
                                                }
                                            } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                                $totalAnggotaPerempuan++;
                                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                $umur = $tgl_lahir->diffInYears($today);
                                                if ($umur >= 15 && $umur <= 49) {
                                                    $totalAnggotaWUS++;
                                                }
                                                if ($umur <= 5) {
                                                    $totalAnggotaBalitaPerempuan++;
                                                }
                                            }
                                            // if ($anggota->warga->status_perkawinan === 'menikah') {
                                            //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                            //         $totalAnggotaPUS++;
                                            //     } else {
                                            //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                            //         $umur = $tgl_lahir->diffInYears($today);
                                            //         if ($umur >= 15 && $umur <= 49) {
                                            //             $totalAnggotaPUS++;
                                            //         }
                                            //     }
                                            // }
                                        }
                                        $hasMarriedMen = $keluarga->keluarga->anggota->contains(function ($anggota) {
                                            return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                                $anggota->warga->status_perkawinan === 'menikah';
                                        });

                                        // Menghitung jumlah PUS (Pasangan Usia Subur)
                                        $countPUS = 0;
                                        if ($hasMarriedMen) {
                                            $countPUS = $keluarga->keluarga->anggota->filter(function ($anggota) {
                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                $today = new DateTime();
                                                $age = $today->diff($birthdate)->y;
                                                return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                                    $age >= 15 &&
                                                    $age <= 49 &&
                                                    $anggota->warga->status_perkawinan === 'menikah';
                                            })->count() ? 1 : 0;
                                        }
                                        $totalAnggotaPUS += $countPUS;
                                        // $hitung = $keluarga->keluarga->anggota->first(function($anggota) {
                                        //     // Calculate age based on birthdate
                                        //     $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                        //     $today = new DateTime();
                                        //     $age = $today->diff($birthdate)->y;

                                        //     // Check if the member is married and female, and age is between 15 and 49
                                        //     return $anggota->warga->status_perkawinan === 'menikah' &&
                                        //            $anggota->warga->jenis_kelamin === 'perempuan' &&
                                        //            $age >= 15 && $age <= 49;
                                        // }) ? 1 : 0;
                                        // $totalAnggotaPUS += $hitung;

                                    }
                                }
                            }
                            }
                        }
                    }
                    $rwInRtDusun[] = (object) [
                        'rw_id' => $rttt->rw->id,
                        'rw_name' => $rttt->rw->name,
                        'total_rt' => $totalRT,
                        'total_dasawisma' => $totalDasawisma,
                        'total_rumah_tangga' => $totalRumahTangga,
                        'total_kegiatan_pemanfaatan_pekarangan' => $totalKegiatanPemanfaatanPekarangan,
                        'total_air_pdam' => $totalAirPDAM,
                        'total_air_sumur' => $totalAirSumur,
                        'total_air_lainnya' => $totalAirLainnya,
                        'total_stiker' => $totalStiker,
                        'total_jamban' => $totalJamban,
                        'total_pem_sampah' => $totalPemSampah,
                        'total_spal' => $totalSPAL,
                        'total_sheat_layak_huni' => $totalSheatLayakHuni,
                        'total_tidak_sheat_layak_huni' => $totalTidakSheatLayakHuni,
                        'total_jml_krt' => $totalJmlKRT,
                        'total_jml_kk' => $totalJmlKK,
                        'total_kegiatan_industri' => $totalKegiatanIndustri,
                        'total_anggota_lansia' => $totalAnggotaLansia,
                        'total_anggota_ibu_hamil' => $totalAnggotaIbuHamil,
                        'total_anggota_ibu_menyusui' => $totalAnggotaIbuMenyusui,
                        'total_kegiatan_up2k' => $totalKegiatanUP2K,
                        'total_anggota_berkebutuhan_khusus' => $totalAnggotaBerkebutuhanKhusus,
                        'total_makan_beras' => $totalMakanBeras,
                        'total_makan_non_beras' => $totalMakanNonBeras,
                        'total_anggota_balita_laki' => $totalAnggotaBalitaLaki,
                        'total_kesehatan_lingkungan' => $totalKegiatanLingkungan,
                        'total_anggota_perempuan' => $totalAnggotaPerempuan,
                        'total_anggota_wus' => $totalAnggotaWUS,
                        'total_anggota_balita_perempuan' => $totalAnggotaBalitaPerempuan,
                        'total_anggota_pus' => $totalAnggotaPUS,
                        'total_anggota_laki' => $totalAnggotaLaki,
                        'rt' => $rtz,
                    ];
                } else {
                    $rtz = Rt::with('dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga')
                    ->where('rw_id', '!=', $rttt->rw->id)
                            ->get();
                            $totalRT = 0;
                            $totalDasawisma = 0;
                            $totalKegiatanPemanfaatanPekarangan = 0;
                            $totalAirPDAM = 0;
                            $totalAirSumur = 0;
                            $totalAirLainnya = 0;
                            $totalStiker = 0;
                            $totalJamban = 0;
                            $totalPemSampah = 0;
                            $totalSPAL = 0;
                            $totalSheatLayakHuni = 0;
                            $totalTidakSheatLayakHuni = 0;
                            $totalJmlKRT = 0;
                            $totalJmlKK = 0;
                            $totalKegiatanIndustri = 0;
                            $totalAnggotaLansia = 0;
                            $totalAnggotaIbuHamil = 0;
                            $totalAnggotaIbuMenyusui = 0;
                            $totalKegiatanUP2K = 0;
                            $totalAnggotaBerkebutuhanKhusus = 0;
                            $totalMakanBeras = 0;
                            $totalMakanNonBeras = 0;
                            $totalAnggotaBalitaLaki = 0;
                            $totalKegiatanLingkungan = 0;
                            $totalAnggotaPerempuan = 0;
                            $totalAnggotaWUS = 0;
                            $totalAnggotaBalitaPerempuan = 0;
                            $totalAnggotaPUS = 0;
                            $totalAnggotaPUS = 0;
                            $totalAnggotaLaki = 0;
                            $totalRumahTangga = 0;
                            $today = Carbon::now();

                            foreach ($rtz as $item) {
                                $totalRT++;
                                foreach ($item->dasawisma as $dasawisma) {
                                    $totalDasawisma++;
                                    foreach ($dasawisma->rumahtangga as $rumahtangga) {
                                        // if ($rumahtangga) {
                                        if ($rumahtangga->periode == $periode) {
                                            $totalRumahTangga++;
                                            // dd($totalRumahTangga);
                                            if ($rumahtangga->pemanfaatanlahan) {
                                                // foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                                //     $totalKegiatanPemanfaatanPekarangan++;
                                                // }
                                                foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                                    if ($pemanfaatan->is_valid != null) {
                                                        $totalKegiatanPemanfaatanPekarangan++;
                                                    }
                                                }
                                            }

                                            // Hitung jumlah KRT (Kepala Rumah Tangga)
                                            if ($rumahtangga->sumber_air_pdam) {
                                                $totalAirPDAM++;
                                            }
                                            if ($rumahtangga->sumber_air_sumur) {
                                                $totalAirSumur++;
                                            }
                                            if ($rumahtangga->sumber_air_lainnya) {
                                                $totalAirLainnya++;
                                            }
                                            if ($rumahtangga->tempel_stiker) {
                                                $totalStiker++;
                                            }
                                            if ($rumahtangga->punya_jamban) {
                                                $totalJamban++;
                                            }
                                            if ($rumahtangga->punya_tempat_sampah) {
                                                $totalPemSampah++;
                                            }
                                            if ($rumahtangga->saluran_pembuangan_air_limbah) {
                                                $totalSPAL++;
                                            }
                                            if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
                                                $totalSheatLayakHuni++;
                                            } else {
                                                $totalTidakSheatLayakHuni++;
                                            }

                                            if ($rumahtangga) {
                                                $totalJmlKRT++;
                                            }
                                            // Hitung jumlah anggota RT dalam KRT
                                            foreach ($rumahtangga->anggotaRT as $keluarga) {
                                                if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
                                                    $totalJmlKK++;
                                                }
                                                // if ($keluarga->keluarga->industri_id != 0) {
                                                //     $totalKegiatanIndustri++;
                                                // }
                                                if ($keluarga->keluarga->industri_id != 0 && $keluarga->keluarga->is_valid_industri != null) {
                                                    $totalKegiatanIndustri++;
                                                }
                                                // Iterasi melalui setiap anggota keluarga
                                                foreach ($keluarga->keluarga->anggota as $anggota) {
                                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);

                                                    $umurz = $tgl_lahir->diffInYears($today);
                                                    if ($umurz >= 45) {
                                                        $totalAnggotaLansia++;
                                                    }
                                                    if ($anggota->warga->ibu_hamil) {
                                                        $totalAnggotaIbuHamil++;
                                                    }
                                                    if ($anggota->warga->ibu_menyusui) {
                                                        $totalAnggotaIbuMenyusui++;
                                                    }
                                                    if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                                        $totalKegiatanLingkungan++;
                                                    }
                                                    if ($anggota->warga->aktivitas_UP2K) {
                                                        $totalKegiatanUP2K++;
                                                    }
                                                    if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                                        $totalAnggotaBerkebutuhanKhusus++;
                                                    }
                                                    if ($anggota->warga->makan_beras) {
                                                        $totalMakanBeras++;
                                                    } else {
                                                        $totalMakanNonBeras++;
                                                    }
                                                    if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                                        $totalAnggotaLaki++;
                                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                        $umur = $tgl_lahir->diffInYears($today);
                                                        if ($umur <= 5) {
                                                            $totalAnggotaBalitaLaki++;
                                                        }
                                                    } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                                        $totalAnggotaPerempuan++;
                                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                        $umur = $tgl_lahir->diffInYears($today);
                                                        if ($umur >= 15 && $umur <= 49) {
                                                            $totalAnggotaWUS++;
                                                        }
                                                        if ($umur <= 5) {
                                                            $totalAnggotaBalitaPerempuan++;
                                                        }
                                                    }
                                                    // if ($anggota->warga->status_perkawinan === 'menikah') {
                                                    //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                                    //         $totalAnggotaPUS++;
                                                    //     } else {
                                                    //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                    //         $umur = $tgl_lahir->diffInYears($today);
                                                    //         if ($umur >= 15 && $umur <= 49) {
                                                    //             $totalAnggotaPUS++;
                                                    //         }
                                                    //     }
                                                    // }
                                                }

                                                $hasMarriedMen = $keluarga->keluarga->anggota->contains(function ($anggota) {
                                                    return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                                        $anggota->warga->status_perkawinan === 'menikah';
                                                });

                                                // Menghitung jumlah PUS (Pasangan Usia Subur)
                                                $countPUS = 0;
                                                if ($hasMarriedMen) {
                                                    $countPUS = $keluarga->keluarga->anggota->filter(function ($anggota) {
                                                        $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                        $today = new DateTime();
                                                        $age = $today->diff($birthdate)->y;
                                                        return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                                            $age >= 15 &&
                                                            $age <= 49 &&
                                                            $anggota->warga->status_perkawinan === 'menikah';
                                                    })->count() ? 1 : 0;
                                                }
                                                $totalAnggotaPUS += $countPUS;
                                            }
                                        }
                                    }
                                }
                            }

                    $rwInRtDusun[] = (object) [
                        'rw_id' => $nameObject,
                        'rw_name' => '',
                        'total_rt' => $totalRT,
                        'total_dasawisma' => $totalDasawisma,
                        'total_rumah_tangga' => $totalRumahTangga,
                        'total_kegiatan_pemanfaatan_pekarangan' => $totalKegiatanPemanfaatanPekarangan,
                        'total_air_pdam' => $totalAirPDAM,
                        'total_air_sumur' => $totalAirSumur,
                        'total_air_lainnya' => $totalAirLainnya,
                        'total_stiker' => $totalStiker,
                        'total_jamban' => $totalJamban,
                        'total_pem_sampah' => $totalPemSampah,
                        'total_spal' => $totalSPAL,
                        'total_sheat_layak_huni' => $totalSheatLayakHuni,
                        'total_tidak_sheat_layak_huni' => $totalTidakSheatLayakHuni,
                        'total_jml_krt' => $totalJmlKRT,
                        'total_jml_kk' => $totalJmlKK,
                        'total_kegiatan_industri' => $totalKegiatanIndustri,
                        'total_anggota_lansia' => $totalAnggotaLansia,
                        'total_anggota_ibu_hamil' => $totalAnggotaIbuHamil,
                        'total_anggota_ibu_menyusui' => $totalAnggotaIbuMenyusui,
                        'total_kegiatan_up2k' => $totalKegiatanUP2K,
                        'total_anggota_berkebutuhan_khusus' => $totalAnggotaBerkebutuhanKhusus,
                        'total_makan_beras' => $totalMakanBeras,
                        'total_makan_non_beras' => $totalMakanNonBeras,
                        'total_anggota_balita_laki' => $totalAnggotaBalitaLaki,
                        'total_kesehatan_lingkungan' => $totalKegiatanLingkungan,
                        'total_anggota_perempuan' => $totalAnggotaPerempuan,
                        'total_anggota_wus' => $totalAnggotaWUS,
                        'total_anggota_balita_perempuan' => $totalAnggotaBalitaPerempuan,
                        'total_anggota_pus' => $totalAnggotaPUS,
                        'total_anggota_laki' => $totalAnggotaLaki,
                        'rt' => $rtz,
                    ];
                }
            } else {
                $nameObject = $rttt->rw_id;

                // Jika rw_id tidak null, tambahkan objek ke dalam $rwInRtDusun
                if ($nameObject !== null && !in_array($nameObject, $tempuniqueRwInRtDusun)) {
                    $rt =
                    Rt::with('dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga')
                    ->where('dusun_id', $rttt->rw->dusun_id)
                        ->where('rw_id', $rttt->rw->id)->get();
                        $totalRT = 0;
                        $totalDasawisma = 0;
                        $totalKegiatanPemanfaatanPekarangan = 0;
                        $totalAirPDAM = 0;
                        $totalAirSumur = 0;
                        $totalAirLainnya = 0;
                        $totalStiker = 0;
                        $totalJamban = 0;
                        $totalPemSampah = 0;
                        $totalSPAL = 0;
                        $totalSheatLayakHuni = 0;
                        $totalTidakSheatLayakHuni = 0;
                        $totalJmlKRT = 0;
                        $totalJmlKK = 0;
                        $totalKegiatanIndustri = 0;
                        $totalAnggotaLansia = 0;
                        $totalAnggotaIbuHamil = 0;
                        $totalAnggotaIbuMenyusui = 0;
                        $totalKegiatanUP2K = 0;
                        $totalAnggotaBerkebutuhanKhusus = 0;
                        $totalMakanBeras = 0;
                        $totalMakanNonBeras = 0;
                        $totalAnggotaBalitaLaki = 0;
                        $totalKegiatanLingkungan = 0;
                        $totalAnggotaPerempuan = 0;
                        $totalAnggotaWUS = 0;
                        $totalAnggotaBalitaPerempuan = 0;
                        $totalAnggotaPUS = 0;
                        $totalAnggotaPUS = 0;
                        $totalAnggotaLaki = 0;
                        $totalRumahTangga = 0;
                        $today = Carbon::now();

                        foreach ($rt as $item) {
                            $totalRT++;
                            foreach ($item->dasawisma as $dasawisma) {
                                $totalDasawisma++;
                                foreach ($dasawisma->rumahtangga as $rumahtangga) {
                                    if ($rumahtangga->periode == $periode) {
                                        $totalRumahTangga++;
                                        // dd($totalRumahTangga);
                                        if ($rumahtangga->pemanfaatanlahan) {
                                            // foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                            //     $totalKegiatanPemanfaatanPekarangan++;
                                            // }
                                            foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                                if ($pemanfaatan->is_valid != null) {
                                                    $totalKegiatanPemanfaatanPekarangan++;
                                                }
                                            }
                                        }

                                        // Hitung jumlah KRT (Kepala Rumah Tangga)
                                        if ($rumahtangga->sumber_air_pdam) {
                                            $totalAirPDAM++;
                                        }
                                        if ($rumahtangga->sumber_air_sumur) {
                                            $totalAirSumur++;
                                        }
                                        if ($rumahtangga->sumber_air_lainnya) {
                                            $totalAirLainnya++;
                                        }
                                        if ($rumahtangga->tempel_stiker) {
                                            $totalStiker++;
                                        }
                                        if ($rumahtangga->punya_jamban) {
                                            $totalJamban++;
                                        }
                                        if ($rumahtangga->punya_tempat_sampah) {
                                            $totalPemSampah++;
                                        }
                                        if ($rumahtangga->saluran_pembuangan_air_limbah) {
                                            $totalSPAL++;
                                        }
                                        if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
                                            $totalSheatLayakHuni++;
                                        } else {
                                            $totalTidakSheatLayakHuni++;
                                        }

                                        if ($rumahtangga) {
                                            $totalJmlKRT++;
                                        }
                                        // Hitung jumlah anggota RT dalam KRT
                                        foreach ($rumahtangga->anggotaRT as $keluarga) {
                                            if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
                                                $totalJmlKK++;
                                            }
                                            // if ($keluarga->keluarga->industri_id != 0) {
                                            //     $totalKegiatanIndustri++;
                                            // }
                                            if ($keluarga->keluarga->industri_id != 0 && $keluarga->keluarga->is_valid != null) {
                                                $totalKegiatanIndustri++;
                                            }
                                            // Iterasi melalui setiap anggota keluarga
                                            foreach ($keluarga->keluarga->anggota as $anggota) {
                                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);

                                                $umurz = $tgl_lahir->diffInYears($today);
                                                if ($umurz >= 45) {
                                                    $totalAnggotaLansia++;
                                                }
                                                if ($anggota->warga->ibu_hamil) {
                                                    $totalAnggotaIbuHamil++;
                                                }
                                                if ($anggota->warga->ibu_menyusui) {
                                                    $totalAnggotaIbuMenyusui++;
                                                }
                                                if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                                    $totalKegiatanLingkungan++;
                                                }
                                                if ($anggota->warga->aktivitas_UP2K) {
                                                    $totalKegiatanUP2K++;
                                                }
                                                if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                                    $totalAnggotaBerkebutuhanKhusus++;
                                                }
                                                if ($anggota->warga->makan_beras) {
                                                    $totalMakanBeras++;
                                                } else {
                                                    $totalMakanNonBeras++;
                                                }
                                                if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                                    $totalAnggotaLaki++;
                                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                    $umur = $tgl_lahir->diffInYears($today);
                                                    if ($umur <= 5) {
                                                        $totalAnggotaBalitaLaki++;
                                                    }
                                                } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                                    $totalAnggotaPerempuan++;
                                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                    $umur = $tgl_lahir->diffInYears($today);
                                                    if ($umur >= 15 && $umur <= 49) {
                                                        $totalAnggotaWUS++;
                                                    }
                                                    if ($umur <= 5) {
                                                        $totalAnggotaBalitaPerempuan++;
                                                    }
                                                }
                                                // if ($anggota->warga->status_perkawinan === 'menikah') {
                                                //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                                //         $totalAnggotaPUS++;
                                                //     } else {
                                                //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                                //         $umur = $tgl_lahir->diffInYears($today);
                                                //         if ($umur >= 15 && $umur <= 49) {
                                                //             $totalAnggotaPUS++;
                                                //         }
                                                //     }
                                                // }
                                            }

                                            $hasMarriedMen = $keluarga->keluarga->anggota->contains(function ($anggota) {
                                                return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                                    $anggota->warga->status_perkawinan === 'menikah';
                                            });

                                            // Menghitung jumlah PUS (Pasangan Usia Subur)
                                            $countPUS = 0;
                                            if ($hasMarriedMen) {
                                                $countPUS = $keluarga->keluarga->anggota->filter(function ($anggota) {
                                                    $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                    $today = new DateTime();
                                                    $age = $today->diff($birthdate)->y;
                                                    return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                                        $age >= 15 &&
                                                        $age <= 49 &&
                                                        $anggota->warga->status_perkawinan === 'menikah';
                                                })->count() ? 1 : 0;
                                            }
                                            $totalAnggotaPUS += $countPUS;
                                        }
                                    }
                                }
                            }
                        }
                    $rwInRtDusun[] = (object) [
                        'rw_name' => $rttt->rw->name,
                        'rw_id' => $nameObject,
                        'total_rt' => $totalRT,
                        'total_dasawisma' => $totalDasawisma,
                        'total_rumah_tangga'    => $totalRumahTangga,
                        'total_kegiatan_pemanfaatan_pekarangan' => $totalKegiatanPemanfaatanPekarangan,
                        'total_air_pdam' => $totalAirPDAM,
                        'total_air_sumur' => $totalAirSumur,
                        'total_air_lainnya' => $totalAirLainnya,
                        'total_stiker' => $totalStiker,
                        'total_jamban' => $totalJamban,
                        'total_pem_sampah' => $totalPemSampah,
                        'total_spal' => $totalSPAL,
                        'total_sheat_layak_huni' => $totalSheatLayakHuni,
                        'total_tidak_sheat_layak_huni' => $totalTidakSheatLayakHuni,
                        'total_jml_krt' => $totalJmlKRT,
                        'total_jml_kk' => $totalJmlKK,
                        'total_kegiatan_industri' => $totalKegiatanIndustri,
                        'total_anggota_lansia' => $totalAnggotaLansia,
                        'total_anggota_ibu_hamil' => $totalAnggotaIbuHamil,
                        'total_anggota_ibu_menyusui' => $totalAnggotaIbuMenyusui,
                        'total_kegiatan_up2k' => $totalKegiatanUP2K,
                        'total_anggota_berkebutuhan_khusus' => $totalAnggotaBerkebutuhanKhusus,
                        'total_makan_beras' => $totalMakanBeras,
                        'total_makan_non_beras' => $totalMakanNonBeras,
                        'total_anggota_balita_laki' => $totalAnggotaBalitaLaki,
                        // 'total_kesehatan_lingkungan' => $totalKegiatanLingkungan,
                        'total_anggota_perempuan' => $totalAnggotaPerempuan,
                        'total_anggota_wus' => $totalAnggotaWUS,
                        'total_anggota_balita_perempuan' => $totalAnggotaBalitaPerempuan,
                        'total_anggota_pus' => $totalAnggotaPUS,
                        'total_anggota_laki' => $totalAnggotaLaki,
                        'total_kesehatan_lingkungan' => $totalKegiatanLingkungan,
                        'rt' => $rt,
                    ];

                    // Tambahkan rw_id ke dalam $tempuniqueRwInRtDusun untuk memastikan keunikan
                    $tempuniqueRwInRtDusun[] = $nameObject;
                }
            }
        }

        // dd($rwInRtDusun);
        return $rwInRtDusun;
    }

    public function returnRtRelation()
    {
        return (object) [
            'ayam' => 'geprel',
            'keju' => 'larve',
        ];
    }

    public function countRekapitulasiRWInDusun($id)
    {
        $countLakiLaki = 0;
        $countPerempuan = 0;
        $countTempatSampah = 0;
        $countbalitaLaki = 0;
        $countbalitaPerempuan = 0;
        $countPUS = 0;
        $countWUS = 0;
        $countIbuHamil = 0;
        $countIbuMenyesui = 0;
        $countLansia = 0;
        $countKebutuhanKhusus = 0;
        $countKriteriaRumahSehat = 0;
        $countKriteriaRumahNonSehat = 0;
        $countMakanBeras = 0;
        $countMakanNNonBeras = 0;
        $countKK = 0;
        $countRumahTangga = 0;
        $aktivitasUP2K = 0;
        $data_pemanfaatan_pekarangan = 0;
        $industri_rumah_tangga = 0;
        $aktivitasKesehatanLingkungan = 0;
        $countSPAL = 0;
        $countJamban = 0;
        $countStiker = 0;
        $countAirPDAM = 0;
        $countAirSumur = 0;
        $countAirLainya = 0;
        $countBeras = 0;
        $countNonBeras = 0;
        $countAirLainya = 0;
        $countDasawisma = 0;
        $countRt = 0;
        $today = Carbon::now();

        $rw = Rw::find($id);
        $dataRt = Rt::with('dasawisma')
            ->where('rw_id', $rw->id)
            ->get();

        foreach ($dataRt as $drt) {
            $countRt++;
            foreach ($drt->dasawisma as $item) {
                # code...
                $countKK += DataKeluarga::where('id_dasawisma', $item->id)->count();

                $countDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)->get();
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

                        $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
                            return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                $anggota->warga->status_perkawinan === 'menikah';
                        });

                        // Menghitung jumlah PUS (Pasangan Usia Subur)
                        $hitung = 0;
                        if ($hasMarriedMen) {
                            $hitung = $anggotaRumah->keluarga->anggota->filter(function ($anggota) {
                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                $today = new DateTime();
                                $age = $today->diff($birthdate)->y;
                                return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                    $age >= 15 &&
                                    $age <= 49 &&
                                    $anggota->warga->status_perkawinan === 'menikah';
                            })->count() ? 1 : 0;
                        }
                        $countPUS += $hitung;
                    }
                }
            }
        }

        return [
            'countRumahTangga' => $countRumahTangga,
            'countKK' => $countKK,
            'tempatSampah' => $countTempatSampah,
            'countSPAL' => $countSPAL,
            'countJamban' => $countJamban,
            'countStiker' => $countStiker,
            'countAirPDAM' => $countAirPDAM,
            'countAirSumur' => $countAirSumur,
            'countAirLainya' => $countAirLainya,
            'countBeras' => $countBeras,
            'countNonBeras' => $countNonBeras,
            'countRt' => $countRt,
            'countDasawisma' => $countDasawisma,
            'laki_laki' => $countLakiLaki,
            'perempuan' => $countPerempuan,
            'balitaLaki' => $countbalitaLaki,
            'balitaPerempuan' => $countbalitaPerempuan,
            'pus' => $countPUS,
            'wus' => $countWUS,
            'ibuHamil' => $countIbuHamil,
            'ibuMenyusui' => $countIbuMenyesui,
            'kebutuhanKhusus' => $countKebutuhanKhusus,
            'lansia' => $countLansia,
            'rumahSehat' => $countKriteriaRumahSehat,
            'rumahNonSehat' => $countKriteriaRumahNonSehat,
            'MakanBeras' => $countMakanBeras,
            'MakanNonBeras' => $countMakanNNonBeras,
            'aktivitasUP2K' => $aktivitasUP2K,
            'pemanfaatanPekarangan' => $data_pemanfaatan_pekarangan,
            'industriRumahTangga' => $industri_rumah_tangga,
            'kesehatanLingkungan' => $aktivitasKesehatanLingkungan,
        ];
    }

    public function export_rekap_dusun(Request $request, $id)
    {
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $result = $this->rtrwdusun($id,$periode);
        // $periode = $periode;
        $user = Auth::user();
        $dusun = $result;
        $dusun_data = Dusun::find($id);
        $dataRt = Rt::with('dasawisma')->where('dusun_id', $id)->get();
        $totalRt = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalKegiatanPemanfaatanPekarangan = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainnya = 0 ;
        $totalStiker = 0;
        $totalJamban = 0;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalSheatLayakHuni = 0;
        $totalTidakSheatLayakHuni = 0;
        $totalJmlKRT = 0;
        $totalJmlKK = 0;
        $totalKegiatanIndustri = 0;
        $totalAnggotaLansia = 0;
        $today = Carbon::now();
        $totalAnggotaIbuHamil = 0;
        $totalAnggotaIbuMenyusui = 0;
        $totalKegiatanLingkungan = 0;
        $totalKegiatanUP2K = 0;
        $totalAnggotaBerkebutuhanKhusus = 0 ;
        $totalMakanBeras = 0;
        $totalMakanNonBeras = 0;
        $totalAnggotaLaki = 0;
        $totalAnggotaBalitaLaki = 0;
        $totalAnggotaPerempuan = 0;
        $totalAnggotaWUS = 0;
        $totalAnggotaBalitaPerempuan = 0;
        $totalAnggotaPUS = 0;
        foreach ($dataRt as $item) {
            $totalRt++;
            foreach ($item->dasawisma as $dasawisma) {
                if($dasawisma->periode <= $periode) {
                    $totalDasawisma++;
                foreach ($dasawisma->rumahtangga as $rumahtangga) {
                    // $totalRumahTangga++;
                    if ($rumahtangga->periode == $periode) {
                        $totalRumahTangga++;
                        if ($rumahtangga->pemanfaatanlahan) {
                            // foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                            //     $totalKegiatanPemanfaatanPekarangan++;
                            // }
                            foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
                                if ($pemanfaatan->is_valid != null) {
                                    $totalKegiatanPemanfaatanPekarangan++;
                                }
                            }
                        }

                        // Hitung jumlah KRT (Kepala Rumah Tangga)
                        if ($rumahtangga->sumber_air_pdam) {
                            $totalAirPDAM++;
                        }
                        if ($rumahtangga->sumber_air_sumur) {
                            $totalAirSumur++;
                        }
                        if ($rumahtangga->sumber_air_lainnya) {
                            $totalAirLainnya++;
                        }
                        if ($rumahtangga->tempel_stiker) {
                            $totalStiker++;
                        }
                        if ($rumahtangga->punya_jamban) {
                            $totalJamban++;
                        }
                        if ($rumahtangga->punya_tempat_sampah) {
                            $totalPemSampah++;
                        }
                        if ($rumahtangga->saluran_pembuangan_air_limbah) {
                            $totalSPAL++;
                        }
                        if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
                            $totalSheatLayakHuni++;
                        } else {
                            $totalTidakSheatLayakHuni++;
                        }

                        if ($rumahtangga) {
                            $totalJmlKRT++;
                        }
                        // Hitung jumlah anggota RT dalam KRT
                        foreach ($rumahtangga->anggotaRT as $keluarga) {
                            if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
                                $totalJmlKK++;
                            }
                            // if ($keluarga->keluarga->industri_id != 0) {
                            //     $totalKegiatanIndustri++;
                            // }
                            if ($keluarga->keluarga->industri_id != 0 && $keluarga->keluarga->is_valid_industri != null) {
                                $totalKegiatanIndustri++;
                            }
                            // Iterasi melalui setiap anggota keluarga
                            foreach ($keluarga->keluarga->anggota as $anggota) {
                                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);

                                $umurz = $tgl_lahir->diffInYears($today);
                                if ($umurz >= 45) {
                                    $totalAnggotaLansia++;
                                }
                                if ($anggota->warga->ibu_hamil) {
                                    $totalAnggotaIbuHamil++;
                                }
                                if ($anggota->warga->ibu_menyusui) {
                                    $totalAnggotaIbuMenyusui++;
                                }
                                if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                    $totalKegiatanLingkungan++;
                                }
                                if ($anggota->warga->aktivitas_UP2K) {
                                    $totalKegiatanUP2K++;
                                }
                                if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                    $totalAnggotaBerkebutuhanKhusus++;
                                }
                                if ($anggota->warga->makan_beras) {
                                    $totalMakanBeras++;
                                } else {
                                    $totalMakanNonBeras++;
                                }
                                if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                    $totalAnggotaLaki++;
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur <= 5) {
                                        $totalAnggotaBalitaLaki++;
                                    }
                                } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
                                    $totalAnggotaPerempuan++;
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur >= 15 && $umur <= 49) {
                                        $totalAnggotaWUS++;
                                    }
                                    if ($umur <= 5) {
                                        $totalAnggotaBalitaPerempuan++;
                                    }
                                }
                                // if ($anggota->warga->status_perkawinan === 'menikah') {
                                //     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                //         $totalAnggotaPUS++;
                                //     } else {
                                //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                //         $umur = $tgl_lahir->diffInYears($today);
                                //         if ($umur >= 15 && $umur <= 49) {
                                //             $totalAnggotaPUS++;
                                //         }
                                //     }
                                // }
                            }
                            // $hitung = $keluarga->keluarga->anggota->first(function($anggota) {
                            //     // Calculate age based on birthdate
                            //     $birthdate = new DateTime($anggota->warga->tgl_lahir);
                            //     $today = new DateTime();
                            //     $age = $today->diff($birthdate)->y;

                            //     // Check if the member is married and female, and age is between 15 and 49
                            //     return $anggota->warga->status_perkawinan === 'menikah' &&
                            //            $anggota->warga->jenis_kelamin === 'perempuan' &&
                            //            $age >= 15 && $age <= 49;
                            // }) ? 1 : 0;
                            // $totalAnggotaPUS += $hitung;

                        }$hasMarriedMen = $keluarga->keluarga->anggota->contains(function ($anggota) {
                            return $anggota->warga->jenis_kelamin === 'laki-laki' &&
                                $anggota->warga->status_perkawinan === 'menikah';
                        });

                        // Menghitung jumlah PUS (Pasangan Usia Subur)
                        $countPUS = 0;
                        if ($hasMarriedMen) {
                            $countPUS = $keluarga->keluarga->anggota->filter(function ($anggota) {
                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                $today = new DateTime();
                                $age = $today->diff($birthdate)->y;
                                return $anggota->warga->jenis_kelamin === 'perempuan' &&
                                    $age >= 15 &&
                                    $age <= 49 &&
                                    $anggota->warga->status_perkawinan === 'menikah';
                            })->count() ? 1 : 0;
                        }
                        $totalAnggotaPUS += $countPUS;
                    }
                }
                }
            }
            # code...
        }

        $export = new RekapKelompokDusunExport(compact(
            'periode',
            'dusun',
            'dusun_data',
            'totalRt',
            'totalDasawisma',
            'totalRumahTangga',
            'totalKegiatanPemanfaatanPekarangan',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainnya',
            'totalStiker',
            'totalJamban',
            'totalPemSampah',
            'totalSPAL',
            'totalSheatLayakHuni',
            'totalTidakSheatLayakHuni',
            'totalJmlKRT',
            'totalJmlKK',
            'totalKegiatanIndustri',
            'totalAnggotaLansia',
            'totalAnggotaIbuHamil',
            'totalAnggotaIbuMenyusui',
            'totalKegiatanLingkungan',
            'totalKegiatanUP2K',
            'totalAnggotaBerkebutuhanKhusus',
            'totalMakanBeras',
            'totalMakanNonBeras',
            'totalAnggotaLaki',
            'totalAnggotaBalitaLaki',
            'totalAnggotaPerempuan',
            'totalAnggotaWUS',
            'totalAnggotaBalitaPerempuan',
            'totalAnggotaPUS'
        ));
        return Excel::download($export, 'rekap-kelompok-dusun.xlsx');
    }
}


