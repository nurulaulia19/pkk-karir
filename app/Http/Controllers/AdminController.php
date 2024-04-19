<?php

namespace App\Http\Controllers;

use App\Exports\RekapKelompokDasaWismaExport;
use App\Exports\RekapKelompokDesaExport;
use App\Exports\RekapKelompokDusunExport;
use App\Exports\RekapKelompokRTExport;
use App\Exports\RekapKelompokRWExport;
use App\Models\DasaWisma;
use App\Models\Data_Desa;
use App\Models\DataDasaWisma;
use App\Models\DataDusun;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataRT;
use App\Models\DataRW;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\Rw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // halaman dashboard
    public function dashboard()
    {
        $kader = User::where('user_type', 'kader_dasawisma')
            ->where('id_desa', auth()->user()->id_desa)
            ->get()
            ->count();

        $dasaWismas = DataKelompokDasawisma::count();

        return view('admin_desa.dashboard', compact('kader', 'dasaWismas'));
    }

    // halaman data pokja4
    public function data_pengguna()
    {
        return view('admin_desa.data_pengguna');
    }

    // halaman login admin desa
    public function login()
    {
        return view('admin_desa.login');
    }

    // halaman pengiriman data login admin desa
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['email'] = $request->get('email');
        $credentials['password'] = $request->get('password');
        $credentials['user_type'] = 'admin_desa';
        $remember = $request->get('remember');

        $attempt = Auth::attempt($credentials, $remember);
        // dd($attempt);

        if ($attempt) {
            return redirect('/dashboard');
        } else {
            return back()->withErrors(['email' => ['Incorrect email / password.']]);
        }
    }

    // pengiriman data logout admin desa
    public function logoutPost()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    // data catatan data dan kegiatan warga kelompok dasa wisma admin desa
    public function data_kelompok_dasa_wisma()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's ID
        $userId = $user->id;

        // Get the desa ID associated with the user
        $desaId = $user->id_desa;

        // Get all records from DataKelompokDasawisma table where id_desa matches the logged-in user's desa ID
        $dasawisma = DataKelompokDasawisma::where('id_desa', $desaId)
            ->with(['rw', 'rt'])
            ->get();
        // dd($dasawisma);

        // Pass the variables to the view
        return view('admin_desa.data_rekap.data_kelompok_dasa_wisma', compact('dasawisma'));

        // return view('admin_desa.data_rekap.data_kelompok_dasa_wisma');
    }

    // rekap catatan data dan kegiatan warga kelompok dasa wisma admin desa
    public function rekap_kelompok_dasa_wisma(Request $request, $id)
    {
        $user = Auth::user();

        $dasa_wisma = DataKelompokDasawisma::with('desa')->find($id);
        $rumahtangga = RumahTangga::with(['anggotaRT.keluarga.anggota.warga.pemanfaatan', 'anggotaRT.keluarga.anggota.warga.industri'])
            ->where('id_dasawisma', $dasa_wisma->id)
            ->get();
            // dd($rumahtangga);
            // kik
        // $totalKepalaRumahTangga = RumahTangga::where('id_dasawisma', $dasa_wisma->id)
        // ->count();
        $totalKepalaRumahTangga = 0;
        $totalJmlKK = 0;
        $totalAnggotaLansia = 0;
        $totalAnggotaIbuHamil = 0;
        $totalAnggotaIbuMenyusui = 0;
        $totalAnggotaLaki = 0;
        $totalAnggotaBalitaLaki = 0;
        $totalAnggotaBerkebutuhanKhusus = 0;
        $totalMakanBeras = 0;
        $totalMakanNonBeras = 0;
        $totalKegiatanUP2K = 0;
        $totalKegiatanIndustri = 0;
        $totalKegiatanPemanfaatanPekarangan = 0;
        $totalKegiatanLingkungan = 0;
        $totalAnggotaPerempuan = 0;
        $totalAnggotaBalitaPerempuan = 0;
        $totalAnggotaPUS = 0;
        $totalAnggotaWUS = 0;
        $totalSheatLayakHuni = 0;
        $totalTidakSheatLayakHuni = 0 ;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;



        $today = Carbon::now();
        foreach ($rumahtangga as $tangga){
            if($tangga->sumber_air_pdam){
                $totalAirPDAM++;
                // dd($totalAirPDAM++);
            }
            if($tangga->sumber_air_sumur){
                $totalAirSumur++;
            }
            if($tangga->sumber_air_lainnya){
                $totalAirLainya++;
            }
            // dd($tangga);
            if($tangga->tempel_stiker){
                $totalStiker++;
            }
            if($tangga->punya_jamban){
                $totalJamban++;
            }

            if($tangga->punya_tempat_sampah){
                $totalPemSampah++;
            }
            // dd($tangga);
            if($tangga->saluran_pembuangan_air_limbah){
                $totalSPAL++;
            }
            if($tangga->punya_jamban && $tangga->punya_tempat_sampah && $tangga->saluran_pembuangan_air_limbah){
                $totalSheatLayakHuni++;
            }else{
                $totalTidakSheatLayakHuni++;
            }
            $totalKepalaRumahTangga++;
            foreach($tangga->anggotaRT as $tangg){
                $totalJmlKK++;
                foreach ($tangg->keluarga->anggota as $anggota) {
                    foreach ($anggota->warga->industri as $industri) {
                        if ($industri) {
                            $totalKegiatanIndustri++;
                        }
                    }
                    foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                        if ($pemanfaatan) {
                            $totalKegiatanPemanfaatanPekarangan++;
                        }
                    }
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
                    if ($anggota->warga->status_perkawinan === 'menikah') {
                        if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                            $totalAnggotaPUS++;
                        } else {
                            $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            $umur = $tgl_lahir->diffInYears($today);
                            if ($umur >= 15 && $umur <= 49) {
                                $totalAnggotaPUS++;
                            }
                        }
                    }
                }
            }

        }





        // dd($rumahtangga);

        // $catatan_keluarga = DataKeluarga::query()
        //     ->with(['industri', 'pemanfaatan','dasawisma'
        //         ])
        //     ->where('id_desa', $user->id_desa)
        //     ->whereHas('dasawisma', function ($q) use ($nama_dasawisma) {
        //         $q->where('nama_dasawisma', $nama_dasawisma);
        //     })
        //     ->where('rt', $rt)
        //     ->where('rw', $rw)
        //     ->where('periode', $periode)
        //     ->get();

        // $desa = $user->desa;

        return view('admin_desa.data_rekap.data_rekap_dasa_wisma', compact(
            'rumahtangga',
            'dasa_wisma',
            'totalKepalaRumahTangga',
            'totalJmlKK',
            'totalAnggotaLansia',
            'totalAnggotaIbuHamil',
            'totalAnggotaIbuMenyusui',
            'totalAnggotaLaki',
            'totalAnggotaBalitaLaki',
            'totalAnggotaBerkebutuhanKhusus',
            'totalMakanBeras',
            'totalMakanNonBeras',
            'totalKegiatanUP2K',
            'totalKegiatanIndustri',
            'totalKegiatanPemanfaatanPekarangan',
            'totalKegiatanLingkungan',
            'totalAnggotaPerempuan',
            'totalAnggotaBalitaPerempuan',
            'totalAnggotaPUS',
            'totalAnggotaWUS',
            'totalSheatLayakHuni',
            'totalTidakSheatLayakHuni',
            'totalPemSampah',
            'totalSPAL',
            'totalJamban',
            'totalStiker',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainya'
        ));

    }

    // export rekap dasawisma
    public function export_rekap_dasawisma(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        $nama_dasawisma = $request->query('nama_dasawisma');
        $dasa_wisma = DataKelompokDasawisma::where('nama_dasawisma', $nama_dasawisma)->firstOrFail();
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $periode = $request->query('periode');

        $catatan_keluarga = DataKeluarga::query()
            ->with(['industri', 'pemanfaatan', 'dasawisma'])
            ->where('id_desa', $user->id_desa)
            ->whereHas('dasawisma', function ($q) use ($nama_dasawisma) {
                $q->where('nama_dasawisma', $nama_dasawisma);
            })
            ->where('rt', $rt)
            ->where('rw', $rw)
            ->where('periode', $periode)
            ->get();

        $desa = $user->desa;

        $export = new RekapKelompokDasaWismaExport(compact('dasa_wisma', 'rt', 'rw', 'periode', 'catatan_keluarga', 'desa', 'nama_dasawisma'));

        return Excel::download($export, 'rekap-kelompok-dasa-wisma.xlsx');
    }

    // data catatan data dan kegiatan warga kelompok pkk rt admin desa
    public function data_rw(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's ID
        $userId = $user->id;

        // Get the desa ID associated with the user
        $desaId = $user->id_desa;

        // Get all records from DataKelompokDasawisma table where id_desa matches the logged-in user's desa ID
        $dasawisma = DataKelompokDasawisma::where('id_desa', $desaId)
            ->with(['rw', 'rt'])
            ->get();

        // return view('admin_desa.data_rekap.data_kelompok_dasa_wisma');
        $rw = Rw::where('desa_id', $desaId)->get();
        // dd($rw);
        // $user = Auth::user();

        // $rt = DB::table('data_keluarga')
        //     ->select('rt', 'rw', 'periode')
        //     ->where('id_desa', $user->id_desa)
        //     ->distinct()
        //     ->get();

        // return view('admin_desa.data_rekap.data_kelompok_pkk_rt', compact('rt'));
        return view('admin_desa.data_rekap.rekapRT.data_rw', compact('rw'));
    }

    public function data_rt($id)
    {
        /** @var User */
        $rt = Rw::with('rt')->find($id);
        if (!$rt) {
            dd('tidak ada rw');
        }

        // dd($dasaWismas);
        return view('admin_desa.data_rekap.rekapRT.data_rt', compact('rt'));
    }

    // rekap catatan data dan kegiatan warga kelompok rt admin desa
    public function rekap_kelompok_pkk_rt(Request $request, $id)
    {
        // calon kopi plek
        $user = Auth::user();
        $dasa_wisma = DataKelompokDasawisma::with(['rumahtangga.anggotaRT.keluarga.anggota.warga.pemanfaatan', 'rumahtangga.anggotaRT.keluarga.anggota.warga.industri'])
            ->where('id_rt', $id)
            ->with('desa')
            ->get();
        // dd($dasa_wisma);

        // $rumahtangga = RumahTangga::with(['anggotaRT.keluarga.anggota.warga.pemanfaatan','anggotaRT.keluarga.anggota.warga.industri'])
        //     ->where('id_dasawisma', $dasa_wisma->first()->id)
        //     ->get();

        // return view('admin_desa.data_rekap.data_rekap_dasa_wisma', compact('rumahtangga', 'dasa_wisma'));
        $totalDasawisma = 0;
        $totalKepalaRumahTangga = 0;
        $totalJmlKK = 0;
        $totalAnggotaLansia = 0;
        $totalAnggotaIbuHamil = 0;
        $totalAnggotaIbuMenyusui = 0;
        $totalAnggotaLaki = 0;
        $totalAnggotaBalitaLaki = 0;
        $totalAnggotaBerkebutuhanKhusus = 0;
        $totalMakanBeras = 0;
        $totalMakanNonBeras = 0;
        $totalKegiatanUP2K = 0;
        $totalKegiatanIndustri = 0;
        $totalKegiatanPemanfaatanPekarangan = 0;
        $totalKegiatanLingkungan = 0;
        $totalAnggotaPerempuan = 0;
        $totalAnggotaBalitaPerempuan = 0;
        $totalAnggotaPUS = 0;
        $totalAnggotaWUS = 0;
        $totalSheatLayakHuni = 0;
        $totalTidakSheatLayakHuni = 0 ;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainnya = 0;

        $today = Carbon::now();
        foreach ($dasa_wisma as $index){
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->sumber_air_pdam) {
                    $totalAirPDAM++;
                }
            }
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->sumber_air_sumur) {
                    $totalAirSumur++;
                }
            }
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->sumber_air_lainnya) {
                    $totalAirLainnya++;
                }
            }
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->tempel_stiker) {
                    $totalStiker++;
                }
            }
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->punya_jamban) {
                    $totalJamban++;
                }
            }
            foreach ($index->rumahtangga as $rumahtangga) {
                if ($rumahtangga->punya_tempat_sampah) {
                    $totalPemSampah++;
                }
            }
            // // dd($index);
            // if($index->rumahtangga->saluran_pembuangan_air_limbah){
            //     $totalSPAL++;
            // }
            // if($index->rumahtangga->punya_jamban && $index->rumahtangga->punya_tempat_sampah && $index->rumahtangga->saluran_pembuangan_air_limbah){
            //     $totalSheatLayakHuni++;
            // }else{
            //     $totalTidakSheatLayakHuni++;
            // }
            // $totalKepalaRumahTangga++;
            // foreach($index->anggotaRT as $tangg){
            //     $totalJmlKK++;
            //     foreach ($tangg->keluarga->anggota as $anggota) {
            //         foreach ($anggota->warga->industri as $industri) {
            //             if ($industri) {
            //                 $totalKegiatanIndustri++;
            //             }
            //         }
            //         foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
            //             if ($pemanfaatan) {
            //                 $totalKegiatanPemanfaatanPekarangan++;
            //             }
            //         }
            //         $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
            //         $umurz = $tgl_lahir->diffInYears($today);
            //         if ($umurz >= 45) {
            //             $totalAnggotaLansia++;
            //         }
            //         if ($anggota->warga->ibu_hamil) {
            //             $totalAnggotaIbuHamil++;
            //         }
            //         if ($anggota->warga->ibu_menyusui) {
            //             $totalAnggotaIbuMenyusui++;
            //         }
            //         if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
            //             $totalKegiatanLingkungan++;
            //         }
            //         if ($anggota->warga->aktivitas_UP2K) {
            //             $totalKegiatanUP2K++;
            //         }
            //         if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
            //             $totalAnggotaBerkebutuhanKhusus++;
            //         }
            //         if ($anggota->warga->makan_beras) {
            //             $totalMakanBeras++;
            //         } else {
            //             $totalMakanNonBeras++;
            //         }

            //         if ($anggota->warga->jenis_kelamin === 'laki-laki') {
            //             $totalAnggotaLaki++;
            //             $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
            //             $umur = $tgl_lahir->diffInYears($today);
            //             if ($umur <= 5) {
            //                 $totalAnggotaBalitaLaki++;
            //             }
            //         } elseif ($anggota->warga->jenis_kelamin === 'perempuan') {
            //             $totalAnggotaPerempuan++;
            //             $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
            //             $umur = $tgl_lahir->diffInYears($today);
            //             if ($umur >= 15 && $umur <= 49) {
            //                 $totalAnggotaWUS++;
            //             }
            //             if ($umur <= 5) {
            //                 $totalAnggotaBalitaPerempuan++;
            //             }
            //         }
            //         if ($anggota->warga->status_perkawinan === 'menikah') {
            //             if ($anggota->warga->jenis_kelamin === 'laki-laki') {
            //                 $totalAnggotaPUS++;
            //             } else {
            //                 $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
            //                 $umur = $tgl_lahir->diffInYears($today);
            //                 if ($umur >= 15 && $umur <= 49) {
            //                     $totalAnggotaPUS++;
            //                 }
            //             }
            //         }
            //     }
            // }

        }

        return view('admin_desa.data_rekap.rekapRT.index', compact('dasa_wisma','totalAirPDAM', 'totalAirSumur', 'totalAirLainnya', 'totalPemSampah', 'totalSPAL', 'totalJamban', 'totalStiker', 'totalAirPDAM', 'totalAirSumur'));
    }

    // export rekap rt
    public function export_rekap_rt(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $periode = $request->query('periode');

        $desa = $user->desa;

        $dasaWismas = DataDasaWisma::getDasaWismas($desa->id, $rw, $rt, $periode);

        $export = new RekapKelompokRTExport(compact('dasaWismas', 'desa', 'rt', 'rw', 'periode'));

        return Excel::download($export, 'rekap-kelompok-rt.xlsx');
    }
    // data catatan data dan kegiatan warga kelompok pkk rw admin desa
    public function data_kelompok_pkk_rw()
    {
        // $user = Auth::user();

        // $rw = DB::table('data_keluarga')
        //     ->select('rw', 'periode')
        //     ->where('id_desa', $user->id_desa)
        //     ->distinct()
        //     ->get();

        $user = Auth::user();
        $rw = Rw::where('desa_id', $user->id_desa)->get();

        return view('admin_desa.data_rekap.rekapRW.data_rw', compact('rw'));
    }

    // rekap catatan data dan kegiatan warga kelompok rw admin desa
    public function rekap_kelompok_pkk_rw(Request $request, $id)
    {
        $user = Auth::user();
        $dasa_wisma = DataKelompokDasawisma::with(['rumahtangga.anggotaRT.keluarga.anggota.warga.pemanfaatan', 'rumahtangga.anggotaRT.keluarga.anggota.warga.industri'])
            ->where('id_rw', $id)
            ->with('desa', 'rt')
            ->get();
        // dd($dasa_wisma);
        if ($dasa_wisma->isEmpty()) {
            dd('data rt masih belum ada jadi gada rekap');
        }

        // $rumahtangga = RumahTangga::with(['anggotaRT.keluarga.anggota.warga.pemanfaatan','anggotaRT.keluarga.anggota.warga.industri'])
        //     ->where('id_dasawisma', $dasa_wisma->first()->id)
        //     ->get();

        // return view('admin_desa.data_rekap.data_rekap_dasa_wisma', compact('rumahtangga', 'dasa_wisma'));
        // return view('admin_desa.data_rekap.rekapRT.index', compact( 'dasa_wisma'));
        return view('admin_desa.data_rekap.data_rekap_pkk_rw', compact('dasa_wisma'));

        $user = Auth::user();
        $desa = $user->desa;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        // $rw = $request->query('rw');
        $rw = Rw::with('rt')->find($id);
        dd($rw);
        $periode = $request->query('periode');

        $rts = DataRT::getRT($desa->id, $rw, $rt, $periode);

        // dd($rts);
        // return view('admin_desa.data_rekap.data_rekap_pkk_rw', compact('rts', 'rw', 'periode', 'desa'));
    }

    // export rekap rw
    public function export_rekap_rw(Request $request)
    {
        /** @var User */
        $user = Auth::user();
        $desa = $user->desa;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $periode = $request->query('periode');

        $rts = DataRT::getRT($desa->id, $rw, $rt, $periode);

        $export = new RekapKelompokRWExport(compact('rts', 'rw', 'periode', 'desa'));

        return Excel::download($export, 'rekap-kelompok-rw.xlsx');
    }

    // data catatan data dan kegiatan warga kelompok pkk dusun admin desa
    public function data_kelompok_pkk_dusun()
    {
        $user = Auth::user();

        $dusun = DB::table('data_keluarga')
            ->select('dusun', 'periode')
            ->where('id_desa', $user->id_desa)
            ->distinct()
            ->get();
        return view('admin_desa.data_rekap.data_kelompok_pkk_dusun', compact('dusun'));
    }

    // rekap catatan data dan kegiatan warga kelompok dusun admin desa
    public function rekap_kelompok_pkk_dusun(Request $request)
    {
        $user = Auth::user();
        $desa = $user->desa;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $dusun = $request->query('dusun');
        $periode = $request->query('periode');

        $rws = DataRW::getRW($desa->id, $dusun, $rw, $rt, $periode);

        return view('admin_desa.data_rekap.data_rekap_pkk_dusun', compact('rws', 'dusun', 'rt', 'rw', 'periode', 'desa'));
    }

    // export rekap dusun
    public function export_rekap_dusun(Request $request)
    {
        /** @var User */
        $user = Auth::user();
        $desa = $user->desa;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $dusun = $request->query('dusun');
        $periode = $request->query('periode');

        $rws = DataRW::getRW($desa->id, $dusun, $rw, $rt, $periode);
        $export = new RekapKelompokDusunExport(compact('rws', 'dusun', 'rt', 'rw', 'periode', 'desa'));

        return Excel::download($export, 'rekap-kelompok-dusun.xlsx');
    }

    // data catatan data dan kegiatan warga kelompok pkk desa admin desa
    public function data_kelompok_pkk_desa()
    {
        $user = Auth::user();

        // $desa = DB::table('data_keluarga')
        //     ->select('id_desa', 'periode')
        //     ->where('id_desa', $user->id_desa)
        //     ->distinct()
        //     ->get();
        $desa = Data_Desa::where('id', $user->id_desa)->get();
        return view('admin_desa.data_rekap.rekapDesa.data_desa', compact('desa'));
    }

    // rekap catatan data dan kegiatan warga kelompok desa admin desa
    public function rekap_pkk_desa(Request $request, $id)
    {
        $user = Auth::user();
        $dasa_wisma = Rw::with(['dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga.pemanfaatan', 'dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga.industri'])
            ->where('desa_id', $id)
            ->get();
        // $dasa_wisma = Rw::with(['dasawisma.rumahtangga'])->where('desa_id', $id)->get();
        // $dasa_wisma = Rw::where('desa_id', $id)->get();

        // dd($dasa_wisma);
        if ($dasa_wisma->isEmpty()) {
            dd('data rt masih belum ada jadi gada rekap');
        }

        // $rumahtangga = RumahTangga::with(['anggotaRT.keluarga.anggota.warga.pemanfaatan','anggotaRT.keluarga.anggota.warga.industri'])
        //     ->where('id_dasawisma', $dasa_wisma->first()->id)
        //     ->get();

        // return view('admin_desa.data_rekap.data_rekap_dasa_wisma', compact('rumahtangga', 'dasa_wisma'));
        // return view('admin_desa.data_rekap.rekapRT.index', compact( 'dasa_wisma'));
        // return view('admin_desa.data_rekap.data_rekap_pkk_rw', compact('dasa_wisma'));
        return view('admin_desa.data_rekap.rekapDesa.index', compact('dasa_wisma'));

        // dd($request->all());

        $user = Auth::user();

        $desa = $user->desa;
        $kecamatan = $user->kecamatan;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $dusun = $request->query('dusun');
        // dd($dusun);
        $periode = $request->query('periode');

        $dusuns = DataDusun::getDusun($desa->id, $dusun, $rw, $rt, $periode);
        // dd($dusuns);
        return view('admin_desa.data_rekap.rekapDesa.index', compact('dusuns', 'dusun', 'kecamatan', 'rw', 'periode', 'desa'));
    }

    // export rekap rt
    public function export_rekap_desa(Request $request)
    {
        /** @var User */
        $user = Auth::user();
        $desa = $user->desa;
        $kecamatan = $user->kecamatan;
        $dasa_wisma = $request->query('dasa_wisma');
        $rt = $request->query('rt');
        $rw = $request->query('rw');
        $dusun = $request->query('dusun');
        $periode = $request->query('periode');

        $dusuns = DataDusun::getDusun($desa->id, $dusun, $rw, $rt, $periode);
        $export = new RekapKelompokDesaExport(compact('dusuns', 'dusun', 'kecamatan', 'rw', 'periode', 'desa'));

        return Excel::download($export, 'rekap-kelompok-desa.xlsx');
    }

    public function profilAdminDesa()
    {
        $adminDesa = Auth::user();
        // dd($adminDesa);
        return view('admin_desa.profil', compact('adminDesa'));
    }

    public function update_profilAdminDesa(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $adminDesa = Auth::user();
        // dd($adminDesa);
        $adminDesa->name = $request->name;
        $adminDesa->email = $request->email;

        if ($request->has('password')) {
            $adminDesa->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $profileImage = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $result = Storage::disk('public')->putFileAs('foto', $image, $profileImage);
            $adminDesa->foto = $result;
        }

        $adminDesa->save();

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->back();
    }

    public function update_passwordAdminDesa(Request $request)
    {
        $request->validate(
            [
                'password' => 'required',
                'new_password' => 'required|confirmed',
            ],
            [
                'password.required' => 'Masukkan Kata Sandi Lama',
                'new_password.confirmed' => 'Konfirmasi Kata Sandi Baru tidak cocok',
            ],
        );

        $adminDesa = Auth::user();
        if (!Hash::check($request->password, $adminDesa->password)) {
            Alert::error('Gagal', 'Kata sandi lama tidak sesuai');
            return redirect()->back();
        }

        $adminDesa->password = Hash::make($request->new_password);
        $adminDesa->save();

        Alert::success('Berhasil', 'Kata sandi berhasil diubah');
        return redirect()->route('profil_adminDesa');
    }

    public function countGenderMembers(RumahTangga $keluarga)
    {
        $countLakiLaki = 0;
        $countPerempuan = 0;
        // $countbalita = 0;
        $countbalitaLaki = 0;
        $countbalitaPerempuan = 0;
        $countPUS = 0;
        $countWUS = 0;
        $countIbuHamil = 0;
        $countIbuMenyesui = 0;
        $countLansia = 0;
        $countKebutuhanKhusus = 0;
        $countKriteriaRumahSehat = 0;
        $countMakanBeras = 0;
        $countMakanNNonBeras = 0;
        $aktivitasUP2K = 0;
        $data_pemanfaatan_pekarangan = 0;
        $industri_rumah_tangga = 0;
        $aktivitasKesehatanLingkungan = 0;
        $today = Carbon::now();

        if ($keluarga->punya_tempat_sampah && $keluarga->punya_jamban && $keluarga->saluran_pembuangan_air_limbah) {
            $countKriteriaRumahSehat++;
        }

        $countKik = 0;
        foreach ($keluarga->anggotaRT as $anggotaRumah) {
            // $countKik++;
            foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                foreach ($anggota->warga->industri as $industri) {
                    if ($industri) {
                        $industri_rumah_tangga++;
                    }
                }
                foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                    if ($pemanfaatan) {
                        $data_pemanfaatan_pekarangan++;
                    }
                }
                $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                $umurz = $tgl_lahir->diffInYears($today);
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
                if ($anggota->warga->status_perkawinan === 'menikah') {
                    if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                        $countPUS++;
                    } else {
                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                        $umur = $tgl_lahir->diffInYears($today);
                        if ($umur >= 15 && $umur <= 49) {
                            $countPUS++;
                        }
                    }
                }
            }
        }

        return [
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
            'MakanBeras' => $countMakanBeras,
            'MakanNonBeras' => $countMakanNNonBeras,
            'aktivitasUP2K' => $aktivitasUP2K,
            'pemanfaatanPekarangan' => $data_pemanfaatan_pekarangan,
            'industriRumahTangga' => $industri_rumah_tangga,
            'kesehatanLingkungan' => $aktivitasKesehatanLingkungan,
            'countKik' => $countKik,
        ];
    }

    public function countRekapitulasiDasawismaInRt($id)
    {
        $countLakiLaki = 0;
        $countPerempuan = 0;
        // $countbalita = 0;
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
        $today = Carbon::now();

        $rumah = RumahTangga::where('id_dasawisma', $id)->get();

        foreach ($rumah as $keluarga) {
            $countRumahTangga++;
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
                $countKK++;
                foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                    foreach ($anggota->warga->industri as $industri) {
                        if ($industri) {
                            $industri_rumah_tangga++;
                        }
                    }
                    foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                        if ($pemanfaatan) {
                            $data_pemanfaatan_pekarangan++;
                        }
                    }
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
                    if ($anggota->warga->status_perkawinan === 'menikah') {
                        if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                            $countPUS++;
                        } else {
                            $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            $umur = $tgl_lahir->diffInYears($today);
                            if ($umur >= 15 && $umur <= 49) {
                                $countPUS++;
                            }
                        }
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
            'countNonBeras' => $countBeras,

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

    public function countRekapitulasiRWInDesa($id)
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
        $today = Carbon::now();

        // $rws = Rw::where('desa_id', $id)->get();
        // $idw = $rws->first()->id;
        // dd($idw);
        $dasawisma = DasaWisma::where('id_rw', $id)->get();
        // $firstRw = $rws->first();
        $rt = Rt::where('rw_id', $id)->count();
        // dd($rt);
        // dd($dasawisma);
        foreach ($dasawisma as $item) {
            # code...
            $countKK += DataKeluarga::where('id_dasawisma', $item->id)->count();

            $countDasawisma++;
        $rumah = RumahTangga::where('id_dasawisma', $item->id)->get();
        foreach ($rumah as $keluarga) {
            $countRumahTangga++;
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
                foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                    foreach ($anggota->warga->industri as $industri) {
                        if ($industri) {
                            $industri_rumah_tangga++;
                        }
                    }
                    foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                        if ($pemanfaatan) {
                            $data_pemanfaatan_pekarangan++;
                        }
                    }
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
                    if ($anggota->warga->status_perkawinan === 'menikah') {
                        if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                            $countPUS++;
                        } else {
                            $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                            $umur = $tgl_lahir->diffInYears($today);
                            if ($umur >= 15 && $umur <= 49) {
                                $countPUS++;
                            }
                        }
                    }
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
            'countNonBeras' => $countBeras,

            'rt' => $rt,
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
}
