<?php

namespace App\Http\Controllers;

use App\Exports\RekapKelompokKabupatenExport;
use App\Exports\RekapKelompokKecamatanExport;
use App\Models\BeritaKab;
use App\Models\DasaWisma;
use App\Models\Data_Desa;
use App\Models\DataAgenda;
use App\Models\DataGaleri;
use App\Models\DataKabupaten;
use App\Models\DataKecamatan;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataPemanfaatanPekarangan;
use App\Models\DataRekapDesa;
use App\Models\DataRekapKecamatan;
use App\Models\DataWarga;
use DateTime;
use App\Models\Keluargahaswarga;
use App\Models\Periode;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use App\Models\Rw;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKabController extends Controller
{
    // halaman dashboard
    public function migrate(){
        $periode = Periode::where('tahun',now()->year)->first();
        if(!$periode){
            $nowPeriode = Periode::create([
                'tahun' => now()->year
            ]);
            $dataWarga = DataWarga::with('kegiatan')->where('periode', $nowPeriode->tahun - 1)->get();

            foreach ($dataWarga as $warga) {
                // Replicate DataWarga record
                $wargaBaru = $warga->replicate();
                $wargaBaru->periode = Carbon::now()->year; // Set current year
                $wargaBaru->is_valid = null; // Reset is_valid

                echo "Periode Sebelum: " . $warga->periode . "\n"; // Print previous period
                echo "Periode Sesudah: " . $wargaBaru->periode . "\n"; // Print new period

                // Save the new DataWarga record
                $wargaBaru->save();

                // Check if there are related kegiatan
                if ($warga->kegiatan) {
                    foreach ($warga->kegiatan as $kegiatan) {
                        // Replicate each kegiatan
                        $kegiatanBaru = $kegiatan->replicate();
                        $kegiatanBaru->warga_id = $wargaBaru->id; // Update warga_id to the new record's ID
                        $kegiatanBaru->periode = Carbon::now()->year; // Set current year
                        $kegiatanBaru->is_valid = null; // Reset is_valid

                        // Save the new kegiatan record
                        $kegiatanBaru->save();
                    }
                }
            }
            $datakeluarga = DataKeluarga::with('anggota.warga')->where('periode', $nowPeriode->tahun - 1 )->get();

            foreach ($datakeluarga as $keluarga) {

                $wargaBaru = $keluarga->replicate();
                $wargaBaru->periode = Carbon::now()->year;
                $wargaBaru->is_valid = null;
                $wargaBaru->is_valid_industri = null;
                $wargaBaru->save();
                foreach($keluarga->anggota as $anggota){
                    $wargaFind = DataWarga::where('periode',now()->year)
                    ->where('no_ktp',$anggota->warga->no_ktp)->first();
                    Keluargahaswarga::create([
                        'keluarga_id' => $wargaBaru->id,
                        'warga_id' => $wargaFind->id
                    ]);
                }

            }
            $dataRumahTangga = RumahTangga::with(['anggotaRT.keluarga','pemanfaatanlahan'])->where('periode', $nowPeriode->tahun - 1 )->get();
            foreach ($dataRumahTangga as $rumahtangga) {
                $wargaBaru = $rumahtangga->replicate();
                $wargaBaru->periode = Carbon::now()->year;
                $wargaBaru->is_valid = null;
                $wargaBaru->is_valid_pemanfaatan_lahan = null;

                $wargaBaru->save();
                foreach($rumahtangga->anggotaRT as $anggota){
                    // $keluargaFind = DataKeluarga::find($anggota->keluarga_id);
                    $keluargaFind = DataKeluarga::where('periode',now()->year)
                    ->where('nama_kepala_keluarga',$anggota->keluarga->nama_kepala_keluarga)->first();
                    RumahTanggaHasKeluarga::create([
                        'rumahtangga_id' => $wargaBaru->id,
                        'keluarga_id' => $keluargaFind->id,
                        'status' => $anggota->status
                    ]);
                }
                foreach($rumahtangga->pemanfaatanlahan as $lahan){
                    DataPemanfaatanPekarangan::create([
                        'id_desa' =>1,
                        'id_kecamatan' =>1 ,
                        'rumah_tangga_id' => $wargaBaru->id,
                        'kategori_id' => $lahan->kategori_id,
                        'periode' => now()->year(),
                        'is_valid' => null
                    ]);
                }

                //PR PEMANFATAAN LAHAN BELUM DI LOOPONG
            }


        }
        Alert::success('Berhasil', 'Data Berhasil di Migrate');
        return redirect('/dashboard_kab');

    }

    public function dashboard_kab()
    {
        $berita = BeritaKab::count();
        $desa = Data_Desa::count();
        $kecamatan = DataKecamatan::count();
        $user = User::count();
        $agenda = DataAgenda::count();
        $galeri = DataGaleri::count();
        $periode = Periode::where('tahun',now()->year)->first();
        $currentYear = now()->year;
        // dd($periode);
        $newPeriode = false;
        if(!$periode){
            $newPeriode = true;
        }
        // dd($newPeriode);
        // $kecamatan = DataKecamatan::count();
        // $user = User::count();
        return view('admin_kab.dashboard_kab', compact('currentYear', 'newPeriode', 'periode', 'berita', 'desa', 'kecamatan', 'user', 'agenda', 'galeri'));
    }

    // halaman login admin kabupaten
    public function login()
    {
        return view('admin_kab.login');
    }

    // // halaman pengiriman data login admin kabupaten
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['email'] = $request->get('email');
        $credentials['password'] = $request->get('password');
        $credentials['user_type'] = 'admin_kabupaten';
        $remember = $request->get('remember');

        $attempt = Auth::attempt($credentials, $remember);
        // dd($attempt);

        if ($attempt) {
            return redirect('/dashboard_kab');
        } else {
            return back()->withErrors(['email' => ['Incorrect email / password.']]);
        }
    }

    // pengiriman data logout admin kabupaten
    public function logoutPost()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    // data catatan data dan kegiatan warga kelompok tp pkk kecamatan
    public function data_kelompok_pkk_kec()
    {
        /** @var User */
        $user = Auth::user();
        // $kecamatan = DataKecamatan::where('id', $user->id)->get();
        $kecamatanId = $user->id_kecamatan;

        // Get all records from DataKelompokDasawisma table where id_desa matches the logged-in user's desa ID
        // $dasawisma = DataKelompokDasawisma::where('id_kecamatan', $kecamatanId)
        //     ->with(['rw', 'rt'])
        //     ->get();

        // return view('admin_desa.data_rekap.data_kelompok_dasa_wisma');
        $kecamatan = DataKecamatan::all();

        // $kecamatan = DB::table('data_keluarga')
        // ->join('data_kecamatan', 'data_keluarga.id_kecamatan', '=', 'data_kecamatan.id')
        // ->select('name', 'periode')
        // ->distinct()
        // ->get();
        $periode = Periode::all();
        return view('admin_kab.data_rekap.rekap_kecamatan.data_kecamatan', compact('kecamatan','periode'));
    }
    // rekap catatan data dan keluarga dan kegiatan warga admin kec
    public function rekap_pkk_kec(Request $request, $id)
    {
        $user = Auth::user();
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $desaa = Data_Desa::with(['dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga', 'dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga', 'dasawisma.desa.kecamatan', 'rw'])
            ->where('id_kecamatan', $id)
            ->get();
        if ($desaa->isEmpty()) {
            dd('data rt masih belum ada jadi gada rekap');
        }

        // dd($desaa);

        // Hitung Total
        $totalRW = 0;
        $totalJmlKK = 0;
        $totalJmlKRT = 0;
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
        $totalTidakSheatLayakHuni = 0;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainnya = 0;
        $totalRT = 0;
        $totalDasawisma = 0;
        $tahun = 0;
        $totalDesa = 0;

        $today = Carbon::now();

        foreach ($desaa as $des) {
            $totalDesa++;
            // $totalRW += Rw::where('desa_id', $des->id)->count() ;
            // $totalRT += Rt::where('rw_id', $des->id)->count() ;
            $rws = Rw::where('desa_id', $des->id)->get();
            $totalRW += $rws->count();
            foreach ($rws as $rw) {
                $totalRT += Rt::where('rw_id', $rw->id)->count();
            }
            if ($des->dasawisma) {
                foreach ($des->dasawisma as $dasawisma) {
                    if ($dasawisma->periode <= $periode) {
                        $totalJmlKK += DataKeluarga::where('id_dasawisma', $dasawisma->id)
                        ->where('periode',$periode)->count();
                        $totalDasawisma++;

                        // Iterasi melalui setiap rumahtangga dalam dasawisma
                        foreach ($dasawisma->rumahtangga as $rumahtangga) {
                            if ($rumahtangga->periode == $periode) {
                                if(!$rumahtangga->is_valid){
                                    return redirect()->route('belum.vaidasi');
                                }
                                if($rumahtangga->pemanfaatanlahan){
                                    foreach ($rumahtangga->pemanfaatanlahan as $lahan){
                                        if($lahan){
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
                                    // $totalJmlKK++;

                                     if ($keluarga->keluarga->industri_id != 0) {
                                            $totalKegiatanIndustri++;
                                        }
                                    // Iterasi melalui setiap anggota keluarga
                                    foreach ($keluarga->keluarga->anggota as $anggota) {
                                        // Hitung jumlah kegiatan industri dari setiap anggota
                                        // foreach ($anggota->warga->industri as $indust) {
                                        //     $totalKegiatanIndustri++;
                                        // }
                                        // // Hitung jumlah kegiatan pemanfaatan pekarangan dari setiap anggota
                                        // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                                        //     $totalKegiatanPemanfaatanPekarangan++;
                                        //}
                                        // Hitung jumlah anggota yang merupakan lansia (umur >= 45 tahun)
                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                        // dd($anggota->warga->tgl_lahir);
                                        $umurz = $tgl_lahir->diffInYears($today);
                                        // dd($umurz);
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
                                    $hitung = $keluarga->keluarga->anggota->first(function($anggota) {
                                        // Calculate age based on birthdate
                                        $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                        $today = new DateTime();
                                        $age = $today->diff($birthdate)->y;

                                        // Check if the member is married and female, and age is between 15 and 49
                                        return $anggota->warga->status_perkawinan === 'menikah' &&
                                               $anggota->warga->jenis_kelamin === 'perempuan' &&
                                               $age >= 15 && $age <= 49;
                                    }) ? 1 : 0;
                                    $totalAnggotaPUS += $hitung;
                                }
                            }
                        }
                    }
                }
            }
        }
        if($totalDasawisma <= 0){
                dd('dasawisma masih belum ada jadi gada rekap');
        }
        // dd($desaa);

        return view('admin_kab.data_rekap.rekap_kecamatan.index', compact('periode','desaa', 'totalDesa', 'totalRT', 'totalRW', 'totalJmlKK', 'totalDasawisma', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainnya', 'totalStiker', 'totalJamban', 'totalPemSampah', 'totalSPAL', 'totalSheatLayakHuni', 'totalTidakSheatLayakHuni', 'totalJmlKRT', 'totalKegiatanIndustri', 'totalKegiatanPemanfaatanPekarangan', 'totalAnggotaLansia', 'totalAnggotaIbuHamil', 'totalAnggotaIbuMenyusui', 'totalKegiatanLingkungan', 'totalKegiatanUP2K', 'totalAnggotaBerkebutuhanKhusus', 'totalMakanBeras', 'totalMakanNonBeras', 'totalAnggotaBalitaLaki', 'totalAnggotaPerempuan', 'totalAnggotaWUS', 'totalAnggotaPUS', 'totalAnggotaBalitaPerempuan', 'totalAnggotaLaki'));
    }

    // export rekap kecamatan
    public function export_rekap_kec(Request $request,$id)
    {
        $user = Auth::user();
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $desaa = Data_Desa::with(['dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga', 'dasawisma.rumahtangga.anggotaRT.keluarga.anggota.warga', 'dasawisma.desa.kecamatan', 'rw'])
            ->where('id_kecamatan', $id)
            ->get();
        if ($desaa->isEmpty()) {
            dd('data rt masih belum ada jadi gada rekap');
        }
        // dd($desa);

        // Hitung Total
        $totalRW = 0;
        $totalJmlKK = 0;
        $totalJmlKRT = 0;
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
        $totalTidakSheatLayakHuni = 0;
        $totalPemSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainnya = 0;
        $totalRT = 0;
        $totalDasawisma = 0;
        $tahun = 0;
        $totalDesa = 0;

        $today = Carbon::now();

        foreach ($desaa as $des) {
            $totalDesa++;
            // $totalRW += Rw::where('desa_id', $des->id)->count() ;
            // $totalRT += Rt::where('rw_id', $des->id)->count() ;
            $rws = Rw::where('desa_id', $des->id)->get();
            $totalRW += $rws->count();
            foreach ($rws as $rw) {
                $totalRT += Rt::where('rw_id', $rw->id)->count();
            }
            if ($des->dasawisma) {
                foreach ($des->dasawisma as $dasawisma) {
                    if ($dasawisma->periode <= $periode) {
                        $totalJmlKK += DataKeluarga::where('id_dasawisma', $dasawisma->id)
                        ->where('periode',$periode)->count();
                        $totalDasawisma++;

                        // Iterasi melalui setiap rumahtangga dalam dasawisma
                        foreach ($dasawisma->rumahtangga as $rumahtangga) {
                            if ($rumahtangga->periode == $periode) {
                                if($rumahtangga->pemanfaatanlahan){
                                    foreach ($rumahtangga->pemanfaatanlahan as $lahan){
                                        if($lahan){
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
                                    // if ($keluarga->keluarga) {
                                    //     $totalJmlKK++;
                                    // }
                                     if ($keluarga->keluarga->industri_id != 0) {
                                            $totalKegiatanIndustri++;
                                        }
                                    // Iterasi melalui setiap anggota keluarga
                                    foreach ($keluarga->keluarga->anggota as $anggota) {
                                        // Hitung jumlah kegiatan industri dari setiap anggota
                                        // foreach ($anggota->warga->industri as $indust) {
                                        //     $totalKegiatanIndustri++;
                                        // }
                                        // // Hitung jumlah kegiatan pemanfaatan pekarangan dari setiap anggota
                                        // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                                        //     $totalKegiatanPemanfaatanPekarangan++;
                                        //}
                                        // Hitung jumlah anggota yang merupakan lansia (umur >= 45 tahun)
                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                        // dd($anggota->warga->tgl_lahir);
                                        $umurz = $tgl_lahir->diffInYears($today);
                                        // dd($umurz);
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
                                    $hitung = $anggota->keluarga->anggota->first(function($anggota) {
                                        // Calculate age based on birthdate
                                        $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                        $today = new DateTime();
                                        $age = $today->diff($birthdate)->y;

                                        // Check if the member is married and female, and age is between 15 and 49
                                        return $anggota->warga->status_perkawinan === 'menikah' &&
                                               $anggota->warga->jenis_kelamin === 'perempuan' &&
                                               $age >= 15 && $age <= 49;
                                    }) ? 1 : 0;
                                    $totalAnggotaPUS += $hitung;

                                }
                            }
                        }
                    }
                }
            }
        }
        $export = new RekapKelompokKecamatanExport(compact('periode','desaa', 'totalDesa', 'totalRT', 'totalRW', 'totalJmlKK', 'totalDasawisma', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainnya', 'totalStiker', 'totalJamban', 'totalPemSampah', 'totalSPAL', 'totalSheatLayakHuni', 'totalTidakSheatLayakHuni', 'totalJmlKRT', 'totalKegiatanIndustri', 'totalKegiatanPemanfaatanPekarangan', 'totalAnggotaLansia', 'totalAnggotaIbuHamil', 'totalAnggotaIbuMenyusui', 'totalKegiatanLingkungan', 'totalKegiatanUP2K', 'totalAnggotaBerkebutuhanKhusus', 'totalMakanBeras', 'totalMakanNonBeras', 'totalAnggotaBalitaLaki', 'totalAnggotaPerempuan', 'totalAnggotaWUS', 'totalAnggotaPUS', 'totalAnggotaBalitaPerempuan', 'totalAnggotaLaki'));

        return Excel::download($export, 'rekap-kelompok-kecamatan.xlsx');
    }

    public function data_kelompok_pkk_kab()
    {
        /** @var User */
        $user = Auth::user();
        $kabupaten = DataKabupaten::where('id', $user->id)->get();
        $periode = Periode::all();

        // $kabupaten = DB::table('data_keluarga')
        // ->join('data_kecamatan', 'data_keluarga.id_kecamatan', '=', 'data_kecamatan.id')
        // ->select('periode')
        // ->distinct()
        // ->get();

        return view('admin_kab.data_rekap.rekap_kabupaten.data_kabupaten', compact('kabupaten','periode'));
    }
    // rekap catatan data dan keluarga dan kegiatan warga admin kec
    public function rekap_pkk_kab(Request $request)
    {
        $user = Auth::user();
        // woi
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $kecamatans = DataKecamatan::with('desa')->get();
        $totalDesa = 0;
        $totalRw = 0;
        $totalRt = 0;
        $totalKK = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalTempatSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;
        $totalKriteriaRumahSehat = 0;
        $totalKriteriaRumahNonSehat = 0;
        $totalIndustri = 0;
        $totalPemanfaatanPekarangan = 0;
        $totalBeras = 0;
        $totalNonBeras = 0;
        $totalLansia = 0;
        $totalIbuHamil = 0;
        $totalIbuMenyesui = 0;
        $totalAktivitasKesehatanLingkungan = 0;
        $totalAaktivitasUP2K = 0;
        $totalKebutuhanKhusus = 0;
        $totalLakiLaki = 0;
        $totalBalitaLaki = 0;
        $totalPerempuan = 0;
        $totalBalitaLaki = 0;
        $totalWUS = 0;
        $totalbalitaPerempuan = 0;
        $totalPUS = 0;
        $today = Carbon::now();


        // dd($kecamatans);
        // $kecamatan = DataKecamatan::with('desa')->find($id);
        foreach ($kecamatans as $kecamatan){
            if ($kecamatan->desa) {
                foreach ($kecamatan->desa as $desa) {
                    $totalDesa++;
                    $dasawisma = DasaWisma::where('id_desa', $desa->id)->get();
                    $rws = Rw::where('desa_id', $desa->id)->get();
                    foreach($rws as $rw){
                        $totalRw++;
                        $totalRt += Rt::where('rw_id', $rw->id)->count();
                    }
                    // rt  belum
                    foreach ($dasawisma as $item) {
                        if($item->periode <= $periode) {
                            $totalKK += DataKeluarga::where('id_dasawisma', $item->id)->where('periode', $periode)->count();
                        $totalDasawisma++;
                        $rumah = RumahTangga::where('id_dasawisma', $item->id)->where('periode', $periode)->get();
                        foreach ($rumah as $keluarga) {
                            if($keluarga->pemanfaatanlahan){
                                if(!$keluarga->is_valid){
                                    return redirect()->route('belum.vaidasi');
                                }
                                foreach ($keluarga->pemanfaatanlahan as $lahan) {
                                        if ($lahan) {
                                            $totalPemanfaatanPekarangan++;
                                        }
                                    }
                            }
                            $totalRumahTangga++;
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
                                $totalKriteriaRumahSehat++;
                            } else {
                                $totalKriteriaRumahNonSehat++;
                            }

                            foreach ($keluarga->anggotaRT as $anggotaRumah) {
                                      if ($anggotaRumah->keluarga->industri_id != 0) {
                                            $totalIndustri++;
                                        }
                                // $countKK++;
                                foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                                    // foreach ($anggota->warga->industri as $industri) {
                                    //     if ($industri) {
                                    //         $totalIndustri++;
                                    //     }
                                    // }
                                    // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                                    //     if ($pemanfaatan) {
                                    //         $totalPemanfaatanPekarangan++;
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
                                        $totalIbuMenyesui++;
                                    }
                                    if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                        $totalAktivitasKesehatanLingkungan++;
                                    }
                                    if ($anggota->warga->aktivitas_UP2K) {
                                        $totalAaktivitasUP2K++;
                                    }
                                    if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                        $totalKebutuhanKhusus++;
                                    }


                                    if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                        $totalLakiLaki++;
                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                        $umur = $tgl_lahir->diffInYears($today);
                                        if ($umur <= 5) {
                                            $totalBalitaLaki++;
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
                                $hitung = $anggota->keluarga->anggota->first(function($anggota) {
                                    // Calculate age based on birthdate
                                    $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                    $today = new DateTime();
                                    $age = $today->diff($birthdate)->y;

                                    // Check if the member is married and female, and age is between 15 and 49
                                    return $anggota->warga->status_perkawinan === 'menikah' &&
                                           $anggota->warga->jenis_kelamin === 'perempuan' &&
                                           $age >= 15 && $age <= 49;
                                }) ? 1 : 0;
                                $totalPUS += $hitung;

                            }
                        }
                        }
                    }
                }
            }
        }
        // dd($kecamatans);
        // admin_kab.data_rekap.data_rekap_pkk_kab
        return view('admin_kab.data_rekap.rekap_kabupaten.index', compact(
            'periode',
            'kecamatans',
            'totalDesa',
            'totalRw',
            'totalRt',
            'totalKK',
            'totalDasawisma',
            'totalRumahTangga',
            'totalTempatSampah',
            'totalSPAL',
            'totalJamban',
            'totalStiker',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainya',
            'totalKriteriaRumahSehat',
            'totalKriteriaRumahNonSehat',
            'totalIndustri',
            'totalPemanfaatanPekarangan',
            'totalBeras',
            'totalNonBeras',
            'totalLansia',
            'totalIbuHamil',
            'totalIbuMenyesui',
            'totalAktivitasKesehatanLingkungan',
            'totalAaktivitasUP2K',
            'totalKebutuhanKhusus',
            'totalLakiLaki',
            'totalBalitaLaki',
            'totalPerempuan',
            'totalWUS',
            'totalbalitaPerempuan',
            'totalPUS',
        ));
    }

    // export rekap kecamatan
    public function export_rekap_kab(Request $request)
    {
        $user = Auth::user();
        if($request->periode){
            $periode = $request->periode;
        }else{
            $periode = Carbon::now()->year;
        }
        $kecamatans = DataKecamatan::with('desa')->get();
        $totalDesa = 0;
        $totalRw = 0;
        $totalRt = 0;
        $totalKK = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalTempatSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;
        $totalKriteriaRumahSehat = 0;
        $totalKriteriaRumahNonSehat = 0;
        $totalIndustri = 0;
        $totalPemanfaatanPekarangan = 0;
        $totalBeras = 0;
        $totalNonBeras = 0;
        $totalLansia = 0;
        $totalIbuHamil = 0;
        $totalIbuMenyesui = 0;
        $totalAktivitasKesehatanLingkungan = 0;
        $totalAaktivitasUP2K = 0;
        $totalKebutuhanKhusus = 0;
        $totalLakiLaki = 0;
        $totalBalitaLaki = 0;
        $totalPerempuan = 0;
        $totalBalitaLaki = 0;
        $totalWUS = 0;
        $totalbalitaPerempuan = 0;
        $totalPUS = 0;
        $today = Carbon::now();

        // $periode = 0 ;
        // dd($periode);


        // dd($kecamatans);
        // $kecamatan = DataKecamatan::with('desa')->find($id);
        foreach ($kecamatans as $kecamatan){
            if ($kecamatan->desa) {
                foreach ($kecamatan->desa as $desa) {
                    $totalDesa++;
                    $dasawisma = DasaWisma::where('id_desa', $desa->id)->get();
                    $rws = Rw::where('desa_id', $desa->id)->get();
                    foreach($rws as $rw){
                        $totalRw++;
                        $totalRt += Rt::where('rw_id', $rw->id)->count();
                    }
                    // rt  belum
                    foreach ($dasawisma as $item) {
                        if($item->periode <= $periode) {
                            // $periode = $item->periode;
                        $totalKK += DataKeluarga::where('id_dasawisma', $item->id)->where('periode', $periode)->count();
                        $totalDasawisma++;
                        $rumah = RumahTangga::where('id_dasawisma', $item->id)->where('periode', $periode)->get();
                        foreach ($rumah as $keluarga) {
                            if($keluarga->pemanfaatanlahan){
                                foreach ($keluarga->pemanfaatanlahan as $pemanfaatan){
                                    if($pemanfaatan){
                                        $totalPemanfaatanPekarangan++;
                                    }
                                }
                            }
                            $totalRumahTangga++;
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
                                $totalKriteriaRumahSehat++;
                            } else {
                                $totalKriteriaRumahNonSehat++;
                            }

                            foreach ($keluarga->anggotaRT as $anggotaRumah) {
                                if($anggotaRumah->keluarga->industri_id != 0){
                                    $totalIndustri++;
                                }
                                // $countKK++;
                                foreach ($anggotaRumah->keluarga->anggota as $anggota) {
                                    // foreach ($anggota->warga->industri as $industri) {
                                    //     if ($industri) {
                                    //         $totalIndustri++;
                                    //     }
                                    // }
                                    // foreach ($anggota->warga->pemanfaatan as $pemanfaatan) {
                                    //     if ($pemanfaatan) {
                                    //         $totalPemanfaatanPekarangan++;
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
                                        $totalIbuMenyesui++;
                                    }
                                    if ($anggota->warga->aktivitas_kesehatan_lingkungan) {
                                        $totalAktivitasKesehatanLingkungan++;
                                    }
                                    if ($anggota->warga->aktivitas_UP2K) {
                                        $totalAaktivitasUP2K++;
                                    }
                                    if ($anggota->warga->berkebutuhan_khusus != null && $anggota->warga->berkebutuhan_khusus != 'Tidak') {
                                        $totalKebutuhanKhusus++;
                                    }


                                    if ($anggota->warga->jenis_kelamin === 'laki-laki') {
                                        $totalLakiLaki++;
                                        $tgl_lahir = Carbon::parse($anggota->warga->tgl_lahir);
                                        $umur = $tgl_lahir->diffInYears($today);
                                        if ($umur <= 5) {
                                            $totalBalitaLaki++;
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
                                $totalPUS += $hitung;

                            }
                        }
                        }
                    }
                }
            }
        }
        // dd($periode);

        $export = new RekapKelompokKabupatenExport(compact(
            'periode',
            'kecamatans',
            'totalDesa',
            'totalRw',
            'totalRt',
            'totalKK',
            'totalDasawisma',
            'totalRumahTangga',
            'totalTempatSampah',
            'totalSPAL',
            'totalJamban',
            'totalStiker',
            'totalAirPDAM',
            'totalAirSumur',
            'totalAirLainya',
            'totalKriteriaRumahSehat',
            'totalKriteriaRumahNonSehat',
            'totalIndustri',
            'totalPemanfaatanPekarangan',
            'totalBeras',
            'totalNonBeras',
            'totalLansia',
            'totalIbuHamil',
            'totalIbuMenyesui',
            'totalAktivitasKesehatanLingkungan',
            'totalAaktivitasUP2K',
            'totalKebutuhanKhusus',
            'totalLakiLaki',
            'totalBalitaLaki',
            'totalPerempuan',
            'totalWUS',
            'totalbalitaPerempuan',
            'totalPUS',
            'periode'
        ));

        return Excel::download($export, 'rekap-kelompok-kabupaten.xlsx');
    }

    public function profilAdminKabupaten()
    {
        $adminKabupaten = Auth::user();
        // dd($adminKabupaten);
        return view('admin_kab.profil', compact('adminKabupaten'));
    }

    public function update_profilAdminKabupaten(Request $request, $id = null)
    {
        $adminKabupaten = Auth::user();
        // dd($adminKabupaten);
        // $adminKabupaten->name = $request->name;
        // $adminKabupaten->email = $request->email;

        // if ($request->has('password')) {
        //     $adminKabupaten->password = Hash::make($request->password);
        // }

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $profileImage = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/foto', $profileImage);
            $adminKabupaten->foto = 'foto/' . $profileImage;
        }

        // Simpan perubahan pada model adminKabupaten
        $adminKabupaten->save();

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->back();
    }

    public function update_passwordAdminKabupaten(Request $request)
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

        $adminKabupaten = Auth::user();
        if (!Hash::check($request->password, $adminKabupaten->password)) {
            Alert::error('Gagal', 'Kata sandi lama tidak sesuai');
            return redirect()->back();
        }

        $adminKabupaten->password = Hash::make($request->new_password);
        $adminKabupaten->save();

        Alert::success('Berhasil', 'Kata sandi berhasil diubah');
        return redirect()->route('profil_adminKabupaten');
    }

    public function countRekapitulasiRWInDesa($id,$periode)
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
        // $countRW = 0;
        $today = Carbon::now();

        // $rws = Rw::where('desa_id', $id)->get();
        // $idw = $rws->first()->id;
        // dd($idw);
        $dasawisma = DasaWisma::where('id_desa', $id)->get();
        $countRW = Rw::where('desa_id', $id)->count();
        // $firstRw = $rws->first();
        $rt = Rt::where('rw_id', $id)->count();
        // dd($rt);
        // dd($dasawisma);
        foreach ($dasawisma as $item) {
           if ($item->periode <= $periode) {
             # code...
             $countKK += DataKeluarga::where('id_dasawisma', $item->id)->
             where('periode',$periode)
             ->count();

             $countDasawisma++;
             $rumah = RumahTangga::where('id_dasawisma', $item->id)->
             where('periode',$periode)->get();
             foreach ($rumah as $keluarga) {
                           if ($keluarga->pemanfaatanlahan) {
                                 foreach ($keluarga->pemanfaatanlahan as $lahan){
                                     if ($lahan) {
                                         $data_pemanfaatan_pekarangan++;
                                     }
                                 }
                             }
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
                         if ($anggotaRumah->keluarga->industri_id != 0) {
                                 $industri_rumah_tangga++;
                             }
                     // $countKK++;
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
                     $hitung = $anggota->keluarga->anggota->first(function($anggota) {
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
            'countRW' => $countRW,
        ];
    }

    public function countRekapitulasiDesaInKecamatan($id, $periode)
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
        $countRW = 0;
        $rt = 0;
        $totalDesa = 0;
        $today = Carbon::now();

        // $rws = Rw::where('desa_id', $id)->get();
        // $idw = $rws->first()->id;
        // dd($idw);
        $kecamatan = DataKecamatan::with('desa')->find($id);
        if ($kecamatan->desa) {
            foreach ($kecamatan->desa as $desa) {
                $totalDesa++;
                $dasawisma = DasaWisma::where('id_desa', $desa->id)->get();
                $rws = Rw::where('desa_id', $desa->id)->get();
                foreach($rws as $rw){
                    $countRW++;
                    $rt += Rt::where('rw_id', $rw->id)->count();
                }
                // rt  belum
                foreach ($dasawisma as $item) {
                   if($item->periode <= $periode) {
                    $countKK += DataKeluarga::where('id_dasawisma', $item->id)->where('periode', $periode)->count();
                    $countDasawisma++;
                    $rumah = RumahTangga::where('id_dasawisma', $item->id)->where('periode', $periode)->get();
                    foreach ($rumah as $keluarga) {
                        if($keluarga->pemanfaatanlahan){
                            foreach ($keluarga->pemanfaatanlahan as $lahan) {
                                    if ($lahan) {
                                        $data_pemanfaatan_pekarangan++;
                                    }
                                }
                        }
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
                            if($anggotaRumah->keluarga->industri_id != 0){
                                $industri_rumah_tangga++;
                            }
                            // $countKK++;
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
            'countRW' => $countRW,
            'totalDesa' => $totalDesa
        ];
    }
}
