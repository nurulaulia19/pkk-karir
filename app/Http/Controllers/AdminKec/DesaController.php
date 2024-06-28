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
use App\Models\DataWarga;
use App\Models\Periode;
use App\Models\Rt;
use App\Models\RumahTangga;
use App\Models\Rw;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesaController extends Controller
{
    public function dashboard_kec()
    {
        $user = Auth::user();
        $desaTotal = Data_Desa::where('id_kecamatan', $user->id_kecamatan)->count();
        $berita = BeritaKab::count();
        $desa = Data_Desa::count();
        $kecamatan = DataKecamatan::count();
        $user = User::count();
        $agenda = DataAgenda::count();
        $galeri = DataGaleri::count();
        return view('admin_kec.dashboard_kec', compact('desaTotal', 'berita', 'desa', 'kecamatan', 'user', 'agenda', 'galeri'));
    }

    public function desa()
    {
        $user = Auth::user();
        // dd($user);
        $desaAll = Data_Desa::where('id_kecamatan', $user->id_kecamatan)->get();
        // dd($desaAll);
        $berita = BeritaKab::count();
        $desa = Data_Desa::count();
        $kecamatan = DataKecamatan::count();
        $user = User::count();
        $agenda = DataAgenda::count();
        $galeri = DataGaleri::count();
        return view('admin_kec.desa', compact('desaAll', 'berita', 'desa', 'kecamatan', 'user', 'agenda', 'galeri'));
    }

    public function rekapitulasi(Request $request, $id)
    {
        if ($request->periode) {
            $periode = $request->periode;
        } else {
            $periode = Carbon::now()->year;
        }
        $today = Carbon::now();

        $dusun = Dusun::with(['rw', 'rt'])
            ->where('desa_id', $id)
            ->get();
        $totalDusun = $dusun->count();
        $desa = Data_Desa::with('kecamatan')->find($id);
        $rwsz = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();
        // Menghitung total rw
        $totalRw = $rwsz->count();

        // Menghitung total rt
        $totalRt = 0;
        foreach ($rwsz as $rw) {
            $totalRt += $rw->rt->count();
        }
        $dataRt = Rt::where('dusun_id', '!=', 0)->get();

        $rws = Rw::where('desa_id', $id)
            ->where('dusun_id', 0)
            ->get();
        $dataNonDusun['totalRw'] = $rws->count();
        $rtIds = Rt::whereIn('rw_id', $rws->pluck('id'))->pluck('id');
        $dataRtNonDusun = Rt::whereIn('id', $rtIds)->get();

        $total = 0;
        $rwsAll = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();
        $totalRtNonDusun = 0;
        foreach ($rwsAll as $rw) {
            foreach ($rw->rt as $rt) {
                if ($rt->dusun_id == 0) {
                    $totalRtNonDusun++;
                }
            }
        }

        $totalKeluarga = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalPemanfaatanPekarangan = 0;
        $totalTempatSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;
        $totalRumahSehat = 0;
        $totalRumahNonSehat = 0;
        $totalIndustri = 0;
        $totalBeras = 0;
        $totalNonBeras = 0;
        $totalLansia = 0;
        $totalIbuHamil = 0;
        $totalIbuMenyusui = 0;
        $totalAktivitasLingkungan = 0;
        $totalAktivitasUP2K = 0;
        $totalKebutuhanKhusus = 0;
        $totalLakiLaki = 0;
        $totalbalitaLaki = 0;
        $totalPerempuan = 0;
        $totalWUS = 0;
        $totalbalitaPerempuan = 0;
        $totalPUS = 0;

        $periodeAll = Periode::all();
        $rwsAll = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();

        foreach($rwsAll as $rw){
            foreach ($rw->rt as $drt) {
                foreach ($drt->dasawisma as $item) {
                    if ($item->periode <= $periode) {
                        // $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
                        //     ->where('periode', $periode)
                        //     ->count();
                        $totalDasawisma++;
                        $rumah = RumahTangga::where('id_dasawisma', $item->id)
                            ->get()
                            ->where('periode', $periode);
                        foreach ($rumah as $keluarga) {
                            if ($keluarga) {
                                if (!$keluarga->is_valid) {
                                    return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
                                }
                                $totalRumahTangga++;
                                if ($keluarga->pemanfaatanlahan) {
                                    foreach ($keluarga->pemanfaatanlahan as $lahan) {
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
                                    $totalKeluarga++;
                                    if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
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
                                    }
                                    $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
                                        return $anggota->warga->jenis_kelamin === 'laki-laki' && $anggota->warga->status_perkawinan === 'menikah';
                                    });

                                    $countPUS = 0;
                                    if ($hasMarriedMen) {
                                        $countPUS = $anggotaRumah->keluarga->anggota
                                            ->filter(function ($anggota) {
                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                $today = new DateTime();
                                                $age = $today->diff($birthdate)->y;
                                                return $anggota->warga->jenis_kelamin === 'perempuan' && $age >= 15 && $age <= 49 && $anggota->warga->status_perkawinan === 'menikah';
                                            })
                                            ->count()
                                            ? 1
                                            : 0;
                                    }
                                    $totalPUS += $countPUS;
                                }
                            }
                        }
                    }
                }
            }
        }
        $dataPeriode = Periode::all();
        return view('admin_kec.rekapitulasi_desa', compact('rwsAll','dataNonDusun', 'desa', 'periode', 'dataPeriode', 'desa', 'dusun', 'totalDusun', 'totalRw', 'totalRt', 'totalDasawisma', 'totalRumahTangga', 'totalKeluarga', 'totalPemanfaatanPekarangan', 'totalTempatSampah', 'totalSPAL', 'totalJamban', 'totalStiker', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainya', 'totalRumahSehat', 'totalRumahNonSehat', 'totalIndustri', 'today', 'totalBeras', 'totalNonBeras', 'totalLansia', 'totalIbuHamil', 'totalIbuMenyusui', 'totalAktivitasLingkungan', 'totalAktivitasUP2K', 'totalKebutuhanKhusus', 'totalLakiLaki', 'totalbalitaLaki', 'totalPerempuan', 'totalWUS', 'totalbalitaPerempuan', 'totalPUS'));
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
        return view('admin_kec.data_rekap_desa', compact('dusuns', 'dusun', 'rw', 'periode', 'desa', 'kecamatan'));
    }

    public function export(Request $request, $id)
    {
        if ($request->periode) {
            $periode = $request->periode;
        } else {
            $periode = Carbon::now()->year;
        }
        $today = Carbon::now();

        $dusun = Dusun::with(['rw', 'rt'])
            ->where('desa_id', $id)
            ->get();
        // dd($dusun);
        $totalDusun = $dusun->count();
        $desa = Data_Desa::with('kecamatan')->find($id);

        // if ($totalDusun <= 0) {
        //     return redirect()->route('not-found')->with('error', 'Data rekap tidak tersedia');
        // }

        // $totalRw = Rw::with('rt')->where('desa_id', $user->id_desa)->count();
        // $totalRt = 0;
        $rwsz = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();
        // Menghitung total rw
        $totalRw = $rwsz->count();

        // Menghitung total rt
        $totalRt = 0;
        foreach ($rwsz as $rw) {
            $totalRt += $rw->rt->count();
        }
        $dataRt = Rt::where('dusun_id', '!=', 0)->get();

        $rws = Rw::where('desa_id', $id)
            ->where('dusun_id', 0)
            ->get();
        $dataNonDusun['totalRw'] = $rws->count();
        $rtIds = Rt::whereIn('rw_id', $rws->pluck('id'))->pluck('id');
        $dataRtNonDusun = Rt::whereIn('id', $rtIds)->get();

        $total = 0;
        $rwsAll = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();
        $totalRtNonDusun = 0;
        foreach ($rwsAll as $rw) {
            foreach ($rw->rt as $rt) {
                if ($rt->dusun_id == 0) {
                    $totalRtNonDusun++;
                }
            }
        }

        $totalKeluarga = 0;
        $totalDasawisma = 0;
        $totalRumahTangga = 0;
        $totalPemanfaatanPekarangan = 0;
        $totalTempatSampah = 0;
        $totalSPAL = 0;
        $totalJamban = 0;
        $totalStiker = 0;
        $totalAirPDAM = 0;
        $totalAirSumur = 0;
        $totalAirLainya = 0;
        $totalRumahSehat = 0;
        $totalRumahNonSehat = 0;
        $totalIndustri = 0;
        $totalBeras = 0;
        $totalNonBeras = 0;
        $totalLansia = 0;
        $totalIbuHamil = 0;
        $totalIbuMenyusui = 0;
        $totalAktivitasLingkungan = 0;
        $totalAktivitasUP2K = 0;
        $totalKebutuhanKhusus = 0;
        $totalLakiLaki = 0;
        $totalbalitaLaki = 0;
        $totalPerempuan = 0;
        $totalWUS = 0;
        $totalbalitaPerempuan = 0;
        $totalPUS = 0;

        $periodeAll = Periode::all();

        // dd($dataRt);
        // dd($dasawisma);
        $rwsAll = Rw::with('rt')
            ->where('desa_id', $id)
            ->get();

        foreach($rwsAll as $rw){
            foreach ($rw->rt as $drt) {
                foreach ($drt->dasawisma as $item) {
                    if ($item->periode <= $periode) {
                        // $totalKeluarga += DataKeluarga::where('id_dasawisma', $item->id)
                        //     ->where('periode', $periode)
                        //     ->count();
                        $totalDasawisma++;
                        $rumah = RumahTangga::where('id_dasawisma', $item->id)
                            ->get()
                            ->where('periode', $periode);
                        foreach ($rumah as $keluarga) {
                            if ($keluarga) {
                                if (!$keluarga->is_valid) {
                                    return redirect()->route('not-found')->with('error', 'Data Belum divalidasi');
                                }
                                $totalRumahTangga++;
                                if ($keluarga->pemanfaatanlahan) {
                                    foreach ($keluarga->pemanfaatanlahan as $lahan) {
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
                                    $totalKeluarga++;
                                    if ($anggotaRumah->keluarga->industri_id != 0 && $anggotaRumah->keluarga->is_valid_industri != null) {
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
                                    }
                                    $hasMarriedMen = $anggotaRumah->keluarga->anggota->contains(function ($anggota) {
                                        return $anggota->warga->jenis_kelamin === 'laki-laki' && $anggota->warga->status_perkawinan === 'menikah';
                                    });

                                    $countPUS = 0;
                                    if ($hasMarriedMen) {
                                        $countPUS = $anggotaRumah->keluarga->anggota
                                            ->filter(function ($anggota) {
                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                $today = new DateTime();
                                                $age = $today->diff($birthdate)->y;
                                                return $anggota->warga->jenis_kelamin === 'perempuan' && $age >= 15 && $age <= 49 && $anggota->warga->status_perkawinan === 'menikah';
                                            })
                                            ->count()
                                            ? 1
                                            : 0;
                                    }
                                    $totalPUS += $countPUS;
                                }
                            }
                        }
                    }
                }
            }
        }
        $export = new RekapKelompokDesaExport(compact('rwsAll', 'desa', 'periode', 'dusun', 'totalDusun', 'totalRw', 'totalRt', 'totalDasawisma', 'totalRumahTangga', 'totalKeluarga', 'totalPemanfaatanPekarangan', 'totalTempatSampah', 'totalSPAL', 'totalJamban', 'totalStiker', 'totalAirPDAM', 'totalAirSumur', 'totalAirLainya', 'totalRumahSehat', 'totalRumahNonSehat', 'totalIndustri', 'today', 'totalBeras', 'totalNonBeras', 'totalLansia', 'totalIbuHamil', 'totalIbuMenyusui', 'totalAktivitasLingkungan', 'totalAktivitasUP2K', 'totalKebutuhanKhusus', 'totalLakiLaki', 'totalbalitaLaki', 'totalPerempuan', 'totalWUS', 'totalbalitaPerempuan', 'totalPUS'));

        return Excel::download($export, 'rekap-kelompok-desa.xlsx');
    }

    public function profilAdminKec()
    {
        $adminKec = Auth::user();
        // dd($adminKec);
        return view('admin_kec.profil', compact('adminKec'));
    }

    public function update_profilAdminKec(Request $request, $id = null)
    {

        $adminKec = Auth::user();

        if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $profileImage = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
        // Gunakan storeAs untuk menyimpan file
        $path = $image->storeAs('foto', $profileImage, 'public');
        // Update properti 'foto' pada objek $adminKec
        $adminKec->foto = $path;

        // Menyimpan perubahan pada objek $adminKec tanpa menggunakan metode save
        DB::table('users')->where('id', $adminKec->id)->update(['foto' => $path]);
    }

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->back();
    }

    public function update_passwordAdminKec(Request $request)
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
        $adminKec = Auth::user();
        if (!Hash::check($request->password, $adminKec->password)) {
            Alert::error('Gagal', 'Kata sandi lama tidak sesuai');
            return redirect()->back();
        }

        $newPassword = Hash::make($request->new_password);

        // Menggunakan query builder untuk memperbarui kolom password di tabel users
        DB::table('users')->where('id', $adminKec->id)->update(['password' => $newPassword]);


        Alert::success('Berhasil', 'Kata sandi berhasil diubah');
        return redirect()->route('profil_adminKec');
    }
}
