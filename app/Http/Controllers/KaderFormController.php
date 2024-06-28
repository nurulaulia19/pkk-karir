<?php

namespace App\Http\Controllers;

use App\Models\DasaWisma;
use App\Models\DataKegiatan;
use App\Models\DataKegiatanWarga;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\CatatanKeluargaExport;
use App\Exports\WargaExport;
use App\Models\Periode;
use App\Models\RumahTangga;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class KaderFormController extends Controller
{
    // halaman dashboard
    public function dashboard_kader()
    {
        $user = Auth::user();
        $rekap = 0;
        $warga = 0;
        $kegiatan = 0;
        $pemanfaatan = 0;
        $industri = 0;
        $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '!=', null)
            ->count();
        $wargaBelumValid = DataWarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '=', null)
            ->count();

        $keluarga = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '!=', null)
            ->count();
        $keluargaBelumValid = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '=', null)
            ->count();

        $krt = RumahTangga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '!=', null)
            ->count();
        $krtBelumValid = RumahTangga::where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('is_valid', '=', null)
            ->count();

        $kegiatan = DataWarga::with('kegiatan')
            ->where('is_kegiatan', true)
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->get();

        $totalKegiatan = 0;
        $totalKegiatanBelumValid = 0;

        foreach ($kegiatan as $kg) {
            if ($kg->kegiatan) {
                foreach ($kg->kegiatan as $a) {
                    if (isset($a->is_valid) && $a->is_valid) {
                        $totalKegiatan++;
                    } else {
                        $totalKegiatanBelumValid++;
                    }
                }
            }
        }

        $kegiatan = DataKegiatanWarga::where('is_valid', '!=', null)
            ->where('periode', now()->year)
            ->whereHas('warga', function ($query) use ($user) {
                $query->where('id_dasawisma', $user->id_dasawisma);
            })
            ->count();

        $pemanfaatan = RumahTangga::with('pemanfaatanlahan.rumahtangga', 'pemanfaatanlahan.pemanfaatan')
            ->where('periode', now()->year)
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('is_pemanfaatan_lahan', true)
            ->where('is_valid_pemanfaatan_lahan', '!=', null)
            ->count();
        $pemanfaatanBelumValid = RumahTangga::with('pemanfaatanlahan.rumahtangga', 'pemanfaatanlahan.pemanfaatan')
            ->where('periode', now()->year)
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('is_pemanfaatan_lahan', true)
            ->where('is_valid_pemanfaatan_lahan', '=', null)
            ->count();

        $industri = DataKeluarga::with('industri')
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->where('industri_id', '!=', null)
            ->where('is_valid_industri', '!=', null)
            ->count();
        $industriBelumValid = DataKeluarga::with('industri')
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('industri_id', '!=', 0)
            ->where('is_valid_industri', '=', null)
            ->where('periode', now()->year)
            ->count();

        $rekap = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('is_valid', '!=', null)
            ->where('periode', now()->year)
            ->count();
        $rekapBelumValid = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('is_valid', '=', null)
            ->where('periode', now()->year)
            ->count();

        return view('kader.dashboard', compact('wargaBelumValid', 'warga', 'keluarga', 'keluargaBelumValid', 'krt', 'krtBelumValid', 'totalKegiatan', 'totalKegiatanBelumValid', 'pemanfaatan', 'pemanfaatanBelumValid', 'industri', 'industriBelumValid', 'rekapBelumValid', 'rekap'));
    }

    public function notif()
    {
        $message = Session::flash('sukses', 'Selamat Datang');
        return view('kader.dashboard', compact('message'));
    }

    // halaman login kader desa pendata
    public function login()
    {
        return view('kader.loginKaderDesa');
    }

    // halaman pengiriman data login kader desa pendata
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['email'] = $request->get('email');
        $credentials['password'] = $request->get('password');
        $credentials['user_type'] = 'kader_dasawisma';
        $remember = $request->get('remember');

        $attempt = Auth::attempt($credentials, $remember);

        if ($attempt) {
            return redirect('/dashboard_kader');
        } else {
            return back()->withErrors(['email' => ['Incorrect email / password.']]);
        }
    }

    // pengiriman data logout kader desa pendata
    public function logoutPost()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    // ngambil nama kepala keluarga
    public function rekap()
    {
        $user = Auth::user();

        $warga = DataWarga::with('keluarga')
            ->where('id_user', $user->id)
            ->get();
        return view('kader.rekap', compact('warga'));
    }

    public function catatan_keluarga(Request $request)
    {
        $user = Auth::user();
        $periode = $request->periode;
        if ($periode) {
            $keluarga = DataKeluarga::with('anggota.warga')
                ->where('periode', $periode)
                ->where('id_dasawisma', $user->id_dasawisma)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $keluarga = DataKeluarga::with('anggota.warga')
                ->where('periode', now()->year)
                ->where('id_dasawisma', $user->id_dasawisma)
                ->orderBy('id', 'DESC')
                ->get();
        }
        $dataPeriode = Periode::all();

        return view('kader.data_catatan_keluarga.rekap', compact('keluarga', 'dataPeriode'));
    }

    // halaman data rekap data warga pkk
    public function rekap_data_warga($id)
    {
        $dataKeluarga = DataKeluarga::with('anggota.warga')->findOrFail($id);
        return view('kader.data_rekap', compact('dataKeluarga'));
    }

    public function printExcel($id)
    {
        $keluarga = DataKeluarga::with(['anggota.warga.kegiatan', 'dasawisma', 'rumah_tangga.rumah_tangga'])->find($id);
        $warga = $keluarga->anggota->first();
        $dasawismaId = $warga->warga->id_dasawisma;
        $dasawisma = DasaWisma::find($dasawismaId);

        $dataKegiatan = DataKegiatan::all();
        return Excel::download(new WargaExport($keluarga, $dasawisma, $dataKegiatan), 'Data Warga.xlsx');
    }

    public function show($id)
    {
        $keluarga = DataKeluarga::findOrFail($id);

        return view('kader.data_catatan_keluarga.export', [
            'keluarga' => $keluarga,
        ]);
    }

    public function print_excel_cakel($id)
    {
        $userKader = Auth::user();

        $keluarga = DataKeluarga::with(['anggota.warga.kegiatan', 'dasawisma', 'rumah_tangga.rumah_tangga'])->find($id);
        // dd($keluarga);
        $warga = $keluarga->anggota->first();
        $dasawismaId = $warga->warga->id_dasawisma;
        $dasawisma = DasaWisma::find($dasawismaId);

        $dataKegiatan = DataKegiatan::all();
        // dd($keluarga);

        return Excel::download(new CatatanKeluargaExport($keluarga, $dasawisma, $dataKegiatan), 'catatan_keluarga.xlsx');
    }

    public function profil()
    {
        $data_kader = Auth::user();

        return view('kader.profil_kader', compact('data_kader'));
    }

    public function update_profil(Request $request, $id = null)
    {
        $data_kader = Auth::user();
        if ($request->hasFile('foto')) {
            // Menghapus foto lama jika ada
            if ($data_kader->foto && Storage::disk('public')->exists($data_kader->foto)) {
                Storage::disk('public')->delete($data_kader->foto);
            }

            $destinationPath = 'foto/';
            $image = $request->file('foto');
            $profileImage = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();

            // Menggunakan storeAs untuk menyimpan file
            $path = $image->storeAs($destinationPath, $profileImage, 'public');

            // Menggunakan query builder untuk memperbarui kolom foto
            DB::table('data_kaders') // Ganti 'data_kaders' dengan nama tabel yang sesuai jika berbeda
                ->where('id', $data_kader->id)
                ->update(['foto' => $path]);
        }
        Alert::success('Berhasil', 'Data berhasil di Ubah');
        return redirect()->back();
    }

    public function update_password(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'password' => 'required',
                'new_password' => 'required|confirmed',
            ],
            [
                'password.required' => 'Masukkan Kata Sandi Salah',
                'new_password.confirmed' => 'Konfirmasi Kata Sandi Baru tidak cocok',
            ],
        );
        $data_kader = Auth::user();

        if (!Hash::check($request->password, $data_kader->password)) {
            Alert::error('Gagal', 'Kata sandi lama tidak sesuai');
            return redirect()->back();
        }

        // Menggunakan query builder untuk memperbarui password
        DB::table('users') // Ganti 'users' dengan nama tabel yang sesuai jika berbeda
            ->where('id', $data_kader->id)
            ->update(['password' => Hash::make($request->new_password)]);

        Alert::success('Berhasil', 'Data berhasil di Ubah');
        return view('kader.profil_kader', compact('data_kader'));
    }
}
