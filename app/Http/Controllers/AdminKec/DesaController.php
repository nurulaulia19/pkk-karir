<?php

namespace App\Http\Controllers\AdminKec;

use Carbon\Carbon;
use App\Models\Dusun;
use App\Exports\RekapKelompokDesaExport;
use App\Models\User;
use App\Models\BeritaKab;
use App\Models\Data_Desa;
use App\Models\DataAgenda;
use App\Models\DataGaleri;
use Illuminate\Http\Request;
use App\Models\DataKecamatan;
use App\Http\Controllers\Controller;
use App\Models\DataDusun;
use App\Models\DataKeluarga;
use App\Models\Periode;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\Rw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DesaController extends Controller
{
    public function dashboard_kec(){
        $user = Auth::user();
        // $desaAll = Data_Desa::where('id_kecamatan',$user->id_kecamatan)->get();
        $desaTotal = Data_Desa::where('id_kecamatan',$user->id_kecamatan)->count();

        // dd($desaAll);
        $berita = BeritaKab::count();
        $desa = Data_Desa::count();
        $kecamatan = DataKecamatan::count();
        $user = User::count();
        $agenda = DataAgenda::count();
        $galeri = DataGaleri::count();
        // $kecamatan = DataKecamatan::count();
        // $user = User::count();
        return view('admin_kec.dashboard_kec', compact('desaTotal','berita', 'desa', 'kecamatan', 'user', 'agenda', 'galeri'));
    }

    public function desa(){
        $user = Auth::user();
        // dd($user);
        $desaAll = Data_Desa::where('id_kecamatan',$user->id_kecamatan)->get();
        // dd($desaAll);
        $berita = BeritaKab::count();
        $desa = Data_Desa::count();
        $kecamatan = DataKecamatan::count();
        $user = User::count();
        $agenda = DataAgenda::count();
        $galeri = DataGaleri::count();
        return view('admin_kec.desa', compact('desaAll','berita', 'desa', 'kecamatan', 'user', 'agenda', 'galeri'));

    }

    // public function rekapitulasi($id) {
    //     // Ambil data desa berdasarkan ID
    //     $desa = Data_Desa::find($id);
    //     // dd($desa);
    //     // Lakukan logika untuk menampilkan rekapitulasi desa
    //     // Misalnya, kembalikan view dengan data desa
    //     return view('admin_kec.rekapitulasi_desa', compact('desa'));
    // }

    // public function rekapitulasi($id) {
    //     // Ambil data desa berdasarkan ID
    //     $desa = Data_Desa::find($id);

    //     // Ambil data keluarga berdasarkan ID desa
    //     $keluarga = DB::table('data_keluarga')
    //         ->where('id_desa', $id)
    //         ->select('periode')
    //         ->distinct()
    //         ->get();

    //     return view('admin_kec.rekapitulasi_desa', compact('desa', 'keluarga'));
    // }

    // public function rekapitulasi(Request $request, $id)
    // {
    //     $user = Auth::user();
    //     $dasa_wisma = Rw::with(['dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga',
    //     'dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga',
    //     'dasawisma.desa.kecamatan'
    //     ])
    //         ->where('desa_id', $id)
    //         ->get();

    //     // dd($dasa_wisma);
    //     if ($dasa_wisma->isEmpty()) {
    //         dd('data rt masih belum ada jadi gada rekap');
    //     }

    //     // Hitung Total
    //     $totalRW = 0;
    //     $totalJmlKK = 0;
    //     $totalJmlKRT = 0;
    //     $totalAnggotaLansia = 0;
    //     $totalAnggotaIbuHamil = 0;
    //     $totalAnggotaIbuMenyusui = 0;
    //     $totalAnggotaLaki = 0;
    //     $totalAnggotaBalitaLaki = 0;
    //     $totalAnggotaBerkebutuhanKhusus = 0;
    //     $totalMakanBeras = 0;
    //     $totalMakanNonBeras = 0;
    //     $totalKegiatanUP2K = 0;
    //     $totalKegiatanIndustri = 0;
    //     $totalKegiatanPemanfaatanPekarangan = 0;
    //     $totalKegiatanLingkungan = 0;
    //     $totalAnggotaPerempuan = 0;
    //     $totalAnggotaBalitaPerempuan = 0;
    //     $totalAnggotaPUS = 0;
    //     $totalAnggotaWUS = 0;
    //     $totalSheatLayakHuni = 0;
    //     $totalTidakSheatLayakHuni = 0 ;
    //     $totalPemSampah = 0;
    //     $totalSPAL = 0;
    //     $totalJamban = 0;
    //     $totalStiker = 0;
    //     $totalAirPDAM = 0;
    //     $totalAirSumur = 0;
    //     $totalAirLainnya = 0;
    //     $totalRT = 0;
    //     $totalDasawisma = 0;
    //     $tahun = 0;

    //     $today = Carbon::now();
    //     foreach ($dasa_wisma as $index) {
    //         // Hitung jumlah RT yang valid
    //         foreach ($index->rt as $rt) {
    //             if ($rt) {
    //                 $totalRT++;
    //             }
    //         }
    //         // Hitung jumlah Dasawisma yang valid
    //         foreach ($index->dasawisma as $dasawisma) {
    //             if ($dasawisma) {
    //                 $totalDasawisma++;

    //                 // Iterasi melalui setiap rumahtangga dalam dasawisma
    //                 foreach ($dasawisma->rumahtangga as $rumahtangga) {
    //                     if ($rumahtangga) {
    //                         if($rumahtangga->pemanfaatanlahan){
    //                             foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
    //                                 $totalKegiatanPemanfaatanPekarangan++;
    //                             }
    //                         }

    //                         // Hitung jumlah KRT (Kepala Rumah Tangga)
    //                         if ($rumahtangga->sumber_air_pdam) {
    //                             $totalAirPDAM++;
    //                         }
    //                         if ($rumahtangga->sumber_air_sumur) {
    //                             $totalAirSumur++;
    //                         }
    //                         if ($rumahtangga->sumber_air_lainnya) {
    //                             $totalAirLainnya++;
    //                         }
    //                         if ($rumahtangga->tempel_stiker) {
    //                             $totalStiker++;
    //                         }
    //                         if ($rumahtangga->punya_jamban) {
    //                             $totalJamban++;
    //                         }
    //                         if ($rumahtangga->punya_tempat_sampah) {
    //                             $totalPemSampah++;
    //                         }
    //                         if ($rumahtangga->saluran_pembuangan_air_limbah) {
    //                             $totalSPAL++;
    //                         }
    //                         if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
    //                             $totalSheatLayakHuni++;
    //                         } else {
    //                             $totalTidakSheatLayakHuni++;
    //                         }

    //                         if($rumahtangga) {
    //                             $totalJmlKRT++;
    //                         }
    //                         // Hitung jumlah anggota RT dalam KRT
    //                         foreach ($rumahtangga->anggotaRT as $keluarga) {
    //                             if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
    //                                 $totalJmlKK++;
    //                             }
    //                             if($keluarga->keluarga->industri_id != 0) {
    //                                     $totalKegiatanIndustri++;
    //                                 }
    //                             // Iterasi melalui setiap anggota keluarga
    //                             foreach ($keluarga->keluarga->anggota as $anggota) {
    //                                 // Hitung jumlah kegiatan industri dari setiap anggota
    //                                 // foreach ($anggota->warga->industri as $indust) {
    //                                 //     $totalKegiatanIndustri++;
    //                                 // }
    //                                 // Hitung jumlah kegiatan pemanfaatan pekarangan dari setiap anggota
    //                                 // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
    //                                 //     $totalKegiatanPemanfaatanPekarangan++;
    //                                 // }
    //                                 // Hitung jumlah anggota yang merupakan lansia (umur >= 45 tahun)
    //                                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                 // dd($anggota->warga->tgl_lahir);
    //                                 $umurz = $tgl_lahir->diffInYears($today);
    //                                 // dd($umurz);
    //                                 if ($umurz >= 45) {
    //                                     $totalAnggotaLansia++;

    //                                 }
    //                                 if ($anggota->warga->ibu_hamil) {
    //                                     $totalAnggotaIbuHamil++;
    //                                 }
    //                                 if ($anggota->warga->ibu_menyusui) {
    //                                     $totalAnggotaIbuMenyusui++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
    //                                     $totalKegiatanLingkungan++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_UP2K) {
    //                                     $totalKegiatanUP2K++;
    //                                 }
    //                                 if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
    //                                     $totalAnggotaBerkebutuhanKhusus++;
    //                                 }
    //                                 if ($anggota->warga->makan_beras) {
    //                                     $totalMakanBeras++;
    //                                 } else {
    //                                     $totalMakanNonBeras++;
    //                                 }
    //                                 if ($anggota->warga->jenis_kelamin === 'laki-laki') {
    //                                     $totalAnggotaLaki++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur <= 5) {
    //                                         $totalAnggotaBalitaLaki++;
    //                                     }
    //                                 } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
    //                                     $totalAnggotaPerempuan++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur >= 15 && $umur <= 49) {
    //                                         $totalAnggotaWUS++;
    //                                     }
    //                                     if ($umur <= 5) {
    //                                         $totalAnggotaBalitaPerempuan++;
    //                                     }
    //                                 }
    //                                 if ($anggota->warga->status_perkawinan === 'menikah') {
    //                                     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
    //                                         $totalAnggotaPUS++;
    //                                     } else {
    //                                         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                         $umur = $tgl_lahir->diffInYears($today);
    //                                         if ($umur >= 15 && $umur <= 49) {
    //                                             $totalAnggotaPUS++;
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         $totalRW++;
    //     }
    //      // disini
    //     return view('admin_kec.rekapitulasi_desa', compact('dasa_wisma', 'totalRT', 'totalRW', 'totalJmlKK', 'totalDasawisma', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainnya', 'totalStiker', 'totalJamban', 'totalPemSampah', 'totalSPAL', 'totalSheatLayakHuni', 'totalTidakSheatLayakHuni', 'totalJmlKRT', 'totalKegiatanIndustri', 'totalKegiatanPemanfaatanPekarangan', 'totalAnggotaLansia', 'totalAnggotaIbuHamil', 'totalAnggotaIbuMenyusui', 'totalKegiatanLingkungan', 'totalKegiatanUP2K', 'totalAnggotaBerkebutuhanKhusus', 'totalMakanBeras', 'totalMakanNonBeras', 'totalAnggotaBalitaLaki', 'totalAnggotaPerempuan', 'totalAnggotaWUS', 'totalAnggotaPUS', 'totalAnggotaBalitaPerempuan', 'totalAnggotaLaki'));


    // }

    // bener
    public function rekapitulasi(Request $request,$id)
    {
        // $user = Auth::user();
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        // dd($periode);
        $dusun = Dusun::with(['rw', 'rt','desa.kecamatan'])
            ->where('desa_id', $id)
            ->get();
        $totalDusun = $dusun->count();
        $totalRw = Rw::where('dusun_id','!=',0)->where('desa_id', $id)->count();
        $totalRt = Rt::where('dusun_id','!=',0)->count();
        $dataRt =  Rt::where('dusun_id','!=',0)->get();
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

        $desa = Data_Desa::find($id);


        // dd($dataRt);
        // dd($dasawisma);
        foreach ($dataRt as $drt) {
            // $totalRt++;
            foreach ($drt->dasawisma as $item) {
                # code...
                $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->count();

                $totalDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->get();
                foreach ($rumah as $keluarga) {
                    $totalRumahTangga++;
                    if ($keluarga->pemanfaatanlahan) {
                        foreach ($keluarga->pemanfaatanlahan as $lahan) {
                            if ($lahan) {
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
                        if ($anggotaRumah->keluarga->industri_id != 0) {
                            $totalIndustri++;
                        }
                        foreach ($anggotaRumah->keluarga->anggota as $anggota) {
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
                            if ($anggota->warga->status_perkawinan === 'menikah') {
                                if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                    $totalPUS++;
                                } else {
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur >= 15 && $umur <= 49) {
                                        $totalPUS++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // dd($totalRw);
        // dd($dusun);
        $dataPeriode = Periode::all();
        return view('admin_kec.rekapitulasi_desa', compact(
            'periode',
            'dataPeriode',
            'desa',
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

    public function rekap_desa($id, Request $request)
    {
        // Dapatkan data desa berdasarkan ID
        $desa = Data_Desa::findOrFail($id);
        // dd($desa);
        $user = Auth::user();
        $kecamatan = $user->kecamatan;
        // Ambil data dari permintaan
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $dusun = $request->query('dusun');

        $periode = $request->query('periode');
        // dd($periode);

        // Dapatkan data dusun berdasarkan ID desa dan parameter lainnya
        $dusuns = DataDusun::getDusun($id, $dusun, $rw, $rt, $periode);
        // dd($dusuns);

        // Kirim data ke view
        return view('admin_kec.data_rekap_desa', compact(
            'dusuns',
            'dusun',
            'rw',
            'periode',
            'desa',
            'kecamatan'
        ));
    }

    // public function export(Request $request, $id)
    // {
    //         $user = Auth::user();
    //     $dasa_wisma = Rw::with(['dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga',
    //     'dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga',
    //     'dasawisma.desa.kecamatan'
    //     ])
    //         ->where('desa_id', $id)
    //         ->get();

    //     // dd($dasa_wisma);
    //     if ($dasa_wisma->isEmpty()) {
    //         dd('data rt masih belum ada jadi gada rekap');
    //     }

    //     // Hitung Total
    //     $totalRW = 0;
    //     $totalJmlKK = 0;
    //     $totalJmlKRT = 0;
    //     $totalAnggotaLansia = 0;
    //     $totalAnggotaIbuHamil = 0;
    //     $totalAnggotaIbuMenyusui = 0;
    //     $totalAnggotaLaki = 0;
    //     $totalAnggotaBalitaLaki = 0;
    //     $totalAnggotaBerkebutuhanKhusus = 0;
    //     $totalMakanBeras = 0;
    //     $totalMakanNonBeras = 0;
    //     $totalKegiatanUP2K = 0;
    //     $totalKegiatanIndustri = 0;
    //     $totalKegiatanPemanfaatanPekarangan = 0;
    //     $totalKegiatanLingkungan = 0;
    //     $totalAnggotaPerempuan = 0;
    //     $totalAnggotaBalitaPerempuan = 0;
    //     $totalAnggotaPUS = 0;
    //     $totalAnggotaWUS = 0;
    //     $totalSheatLayakHuni = 0;
    //     $totalTidakSheatLayakHuni = 0 ;
    //     $totalPemSampah = 0;
    //     $totalSPAL = 0;
    //     $totalJamban = 0;
    //     $totalStiker = 0;
    //     $totalAirPDAM = 0;
    //     $totalAirSumur = 0;
    //     $totalAirLainnya = 0;
    //     $totalRT = 0;
    //     $totalDasawisma = 0;
    //     $tahun = 0;

    //     $today = Carbon::now();
    //     foreach ($dasa_wisma as $index) {
    //         // Hitung jumlah RT yang valid
    //         foreach ($index->rt as $rt) {
    //             if ($rt) {
    //                 $totalRT++;
    //             }
    //         }
    //         // Hitung jumlah Dasawisma yang valid
    //         foreach ($index->dasawisma as $dasawisma) {
    //             if ($dasawisma) {
    //                 $totalDasawisma++;

    //                 // Iterasi melalui setiap rumahtangga dalam dasawisma
    //                 foreach ($dasawisma->rumahtangga as $rumahtangga) {
    //                     if ($rumahtangga) {
    //                         if($rumahtangga->pemanfaatanlahan){
    //                             foreach ($rumahtangga->pemanfaatanlahan as $pemanfaatan) {
    //                                 $totalKegiatanPemanfaatanPekarangan++;
    //                             }
    //                         }

    //                         // Hitung jumlah KRT (Kepala Rumah Tangga)
    //                         if ($rumahtangga->sumber_air_pdam) {
    //                             $totalAirPDAM++;
    //                         }
    //                         if ($rumahtangga->sumber_air_sumur) {
    //                             $totalAirSumur++;
    //                         }
    //                         if ($rumahtangga->sumber_air_lainnya) {
    //                             $totalAirLainnya++;
    //                         }
    //                         if ($rumahtangga->tempel_stiker) {
    //                             $totalStiker++;
    //                         }
    //                         if ($rumahtangga->punya_jamban) {
    //                             $totalJamban++;
    //                         }
    //                         if ($rumahtangga->punya_tempat_sampah) {
    //                             $totalPemSampah++;
    //                         }
    //                         if ($rumahtangga->saluran_pembuangan_air_limbah) {
    //                             $totalSPAL++;
    //                         }
    //                         if ($rumahtangga->punya_jamban && $rumahtangga->punya_tempat_sampah && $rumahtangga->saluran_pembuangan_air_limbah) {
    //                             $totalSheatLayakHuni++;
    //                         } else {
    //                             $totalTidakSheatLayakHuni++;
    //                         }

    //                         if($rumahtangga) {
    //                             $totalJmlKRT++;
    //                         }
    //                         // Hitung jumlah anggota RT dalam KRT
    //                         foreach ($rumahtangga->anggotaRT as $keluarga) {
    //                             if ($keluarga->keluarga && $keluarga->keluarga->nama_kepala_keluarga) {
    //                                 $totalJmlKK++;
    //                             }
    //                             if($keluarga->keluarga->industri_id != 0) {
    //                                     $totalKegiatanIndustri++;
    //                                 }
    //                             // Iterasi melalui setiap anggota keluarga
    //                             foreach ($keluarga->keluarga->anggota as $anggota) {
    //                                 // Hitung jumlah kegiatan industri dari setiap anggota
    //                                 // foreach ($anggota->warga->industri as $indust) {
    //                                 //     $totalKegiatanIndustri++;
    //                                 // }
    //                                 // Hitung jumlah kegiatan pemanfaatan pekarangan dari setiap anggota
    //                                 // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
    //                                 //     $totalKegiatanPemanfaatanPekarangan++;
    //                                 // }
    //                                 // Hitung jumlah anggota yang merupakan lansia (umur >= 45 tahun)
    //                                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                 // dd($anggota->warga->tgl_lahir);
    //                                 $umurz = $tgl_lahir->diffInYears($today);
    //                                 // dd($umurz);
    //                                 if ($umurz >= 45) {
    //                                     $totalAnggotaLansia++;

    //                                 }
    //                                 if ($anggota->warga->ibu_hamil) {
    //                                     $totalAnggotaIbuHamil++;
    //                                 }
    //                                 if ($anggota->warga->ibu_menyusui) {
    //                                     $totalAnggotaIbuMenyusui++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
    //                                     $totalKegiatanLingkungan++;
    //                                 }
    //                                 if ($anggota->warga->aktivitas_UP2K) {
    //                                     $totalKegiatanUP2K++;
    //                                 }
    //                                 if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
    //                                     $totalAnggotaBerkebutuhanKhusus++;
    //                                 }
    //                                 if ($anggota->warga->makan_beras) {
    //                                     $totalMakanBeras++;
    //                                 } else {
    //                                     $totalMakanNonBeras++;
    //                                 }
    //                                 if ($anggota->warga->jenis_kelamin === 'laki-laki') {
    //                                     $totalAnggotaLaki++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur <= 5) {
    //                                         $totalAnggotaBalitaLaki++;
    //                                     }
    //                                 } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
    //                                     $totalAnggotaPerempuan++;
    //                                     $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                     $umur = $tgl_lahir->diffInYears($today);
    //                                     if ($umur >= 15 && $umur <= 49) {
    //                                         $totalAnggotaWUS++;
    //                                     }
    //                                     if ($umur <= 5) {
    //                                         $totalAnggotaBalitaPerempuan++;
    //                                     }
    //                                 }
    //                                 if ($anggota->warga->status_perkawinan === 'menikah') {
    //                                     if ($anggota->warga->jenis_kelamin === 'laki-laki') {
    //                                         $totalAnggotaPUS++;
    //                                     } else {
    //                                         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
    //                                         $umur = $tgl_lahir->diffInYears($today);
    //                                         if ($umur >= 15 && $umur <= 49) {
    //                                             $totalAnggotaPUS++;
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         $totalRW++;
    //     }
    //     $export = new RekapKelompokDesaExport( compact('dasa_wisma', 'totalRT', 'totalRW', 'totalJmlKK', 'totalDasawisma', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainnya', 'totalStiker', 'totalJamban', 'totalPemSampah', 'totalSPAL', 'totalSheatLayakHuni', 'totalTidakSheatLayakHuni', 'totalJmlKRT', 'totalKegiatanIndustri', 'totalKegiatanPemanfaatanPekarangan', 'totalAnggotaLansia', 'totalAnggotaIbuHamil', 'totalAnggotaIbuMenyusui', 'totalKegiatanLingkungan', 'totalKegiatanUP2K', 'totalAnggotaBerkebutuhanKhusus', 'totalMakanBeras', 'totalMakanNonBeras', 'totalAnggotaBalitaLaki', 'totalAnggotaPerempuan', 'totalAnggotaWUS', 'totalAnggotaPUS', 'totalAnggotaBalitaPerempuan', 'totalAnggotaLaki'));

    //     return Excel::download($export, 'rekap-kelompok-desa.xlsx');
    //     }

    public function export(Request $request,$id)
    {
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $dusun = Dusun::with(['rw', 'rt'])
            ->where('desa_id', $id)
            ->get();
        $totalDusun = $dusun->count();
        $totalRw = Rw::where('dusun_id','!=',0)->where('desa_id', $id)->count();
        $totalRt = Rt::where('dusun_id','!=',0)->count();
        $dataRt =  Rt::where('dusun_id','!=',0)->get();
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

        // dd($dataRt);
        // dd($dasawisma);
        foreach ($dataRt as $drt) {
            // $totalRt++;
            foreach ($drt->dasawisma as $item) {
                # code...
                $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->count();

                $totalDasawisma++;
                $rumah = RumahTangga::where('id_dasawisma', $item->id)
                ->where('periode',$periode)
                ->get();
                foreach ($rumah as $keluarga) {
                    $totalRumahTangga++;
                    if ($keluarga->pemanfaatanlahan) {
                        foreach ($keluarga->pemanfaatanlahan as $lahan) {
                            if ($lahan) {
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
                        if ($anggotaRumah->keluarga->industri_id != 0) {
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
                            if ($anggota->warga->status_perkawinan === 'menikah') {
                                if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                    $totalPUS++;
                                } else {
                                    $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                    $umur = $tgl_lahir->diffInYears($today);
                                    if ($umur >= 15 && $umur <= 49) {
                                        $totalPUS++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        $export = new RekapKelompokDesaExport( compact(
            'periode',
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

        return Excel::download($export, 'rekap-kelompok-desa.xlsx');
    }

        public function profilAdminKec(){
            $adminKec = Auth::user();
            // dd($adminKec);
            return view('admin_kec.profil', compact('adminKec'));
        }

        public function update_profilAdminKec(Request $request, $id = null){
            $request->validate([
                'name' => 'required'
            ]);

            $adminKec = Auth::user();
            // dd($adminKec);
            $adminKec->name = $request->name;
            $adminKec->email = $request->email;

            if ($request->has('password')) {
                $adminKec->password = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $profileImage = Str::random(5) . date('YmdHis') . "." . $image->getClientOriginalExtension();
                $result = Storage::disk('public')->putFileAs('foto', $image, $profileImage);
                $adminKec->foto = $result;
            }

            $adminKec->save();

            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->back();
        }

        public function update_passwordAdminKec(Request $request){
            $request->validate([
                'password' => 'required',
                'new_password' => 'required|confirmed',
            ], [
                'password.required' => 'Masukkan Kata Sandi Lama',
                'new_password.confirmed' => 'Konfirmasi Kata Sandi Baru tidak cocok'
            ]);

            $adminKec = Auth::user();
            if (!Hash::check($request->password, $adminKec->password)) {
                Alert::error('Gagal', 'Kata sandi lama tidak sesuai');
                return redirect()->back();
            }

            $adminKec->password = Hash::make($request->new_password);
            $adminKec->save();

            Alert::success('Berhasil', 'Kata sandi berhasil diubah');
            return redirect()->route('profil_adminKec');
        }


}
