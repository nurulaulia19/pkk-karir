<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataDasaWisma;
use App\Models\DataKabupaten;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataProvinsi;
use App\Models\DataWarga;
use App\Models\Keluargahaswarga;
use App\Models\Periode;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use App\Models\Rw;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $periode = $request->periode;
        // dd($periode);
        $user = Auth::user();
        // $warga=DataWarga::with('kepalaKeluarga')->where('id_dasawisma', $user->id_dasawisma)->get();
        if ($periode) {
            $warga = DataWarga::with('kepalaKeluarga.keluarga')
        ->where('id_dasawisma', $user->id_dasawisma)
        ->where('periode', $periode) // menambahkan kondisi where untuk tahun sekarang
        ->get();
        } else {
            $warga = DataWarga::with('kepalaKeluarga.keluarga')
        ->where('id_dasawisma', $user->id_dasawisma)
        ->where('periode', now()->year) // menambahkan kondisi where untuk tahun sekarang
        ->get();
        }
        $dataPeriode = Periode::all();

        return view('kader.data_warga.index', compact('warga', 'user','dataPeriode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $desas = DB::table('data_desa')
     ->where('id', auth()->user()->id_desa)
     ->get();


     $kec = DB::table('data_kecamatan')
     ->where('id', auth()->user()->id_kecamatan)
     ->get();

     $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();
     $kader = User::with('dasawisma.rt.rw')
        ->where('id', auth()->user()->id)
        ->first();

     $kel = DataKeluarga::all();
     //  $dasawisma = DataKelompokDasawisma::all();
     $user = Auth::user();
     $dasawisma = DataKelompokDasawisma::where('id', $user->id_dasawisma)->get();
     $kabupaten = DataKabupaten::first();
     $provinsi = DataProvinsi::first();

     return view('kader.data_warga.create', compact('desas', 'kader', 'kec', 'kel', 'kad', 'dasawisma','kabupaten','provinsi'));

 }


    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            // Definisi validasi disesuaikan dengan kebutuhan
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
            'id_dasawisma' => 'required',
            'no_registrasi' => 'required',
            'no_ktp' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'status_perkawinan' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            // 'kabupaten' => 'required',
            // 'provinsi' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'akseptor_kb' => 'required',
            'aktif_posyandu' => 'required',
            'ikut_bkb' => 'required',
            'memiliki_tabungan' => 'required',
            'ikut_kelompok_belajar' => 'required',
            'ikut_paud_sejenis' => 'required',
            'ikut_koperasi' => 'required',
            'periode' => 'required',
            'berkebutuhan_khusus' => 'required',
            'makan_beras' => 'required',
            // 'provinsi' => 'required',
            'aktivitas_UP2K' => 'required|boolean',
            'aktivitas_kesehatan_lingkungan' => 'required|boolean',
        ]);

        // Buat array data
        $data = [
            'id_desa' => $request->id_desa,
            'id_kecamatan' => $request->id_kecamatan,
            'id_dasawisma' => $request->id_dasawisma,
            'no_registrasi' => $request->no_registrasi,
            'no_ktp' => $request->no_ktp,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'status_perkawinan' => $request->status_perkawinan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            // 'kabupaten' => $request->kabupaten,
            // 'provinsi' => $request->provinsi,
            'ibu_hamil' => $request->ibu_hamil,
            'ibu_menyusui' => $request->ibu_menyusui,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'akseptor_kb' => $request->akseptor_kb,
            'aktif_posyandu' => $request->aktif_posyandu,
            'ikut_bkb' => $request->ikut_bkb,
            'memiliki_tabungan' => $request->memiliki_tabungan,
            'ikut_kelompok_belajar' => $request->ikut_kelompok_belajar,
            'ikut_paud_sejenis' => $request->ikut_paud_sejenis,
            'ikut_koperasi' => $request->ikut_koperasi,
            'periode' => $request->periode,
            'berkebutuhan_khusus' => $request->berkebutuhan_khusus,
            'makan_beras' => $request->makan_beras,
            // 'provinsi' => $request->provinsi,
            'aktivitas_UP2K' => $request->aktivitas_UP2K,
            'aktivitas_kesehatan_lingkungan' => $request->aktivitas_kesehatan_lingkungan,
        ];
        if ($request->jenis_kelamin == 'laki-laki') {
            $data['ibu_hamil'] = false;
            $data['ibu_menyusui'] = false;
        }

        // Simpan data menggunakan model
        $warga = DataWarga::create($data);
        $warga->is_valid = Carbon::now();
        $warga->save();

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect('/data_warga');
    }



    public function show(DataWarga $data_warga)
    {
        // menampilkan data warga
        // $warga=DataWarga::all();

        return view('kader.data_kegiatan.show.data_warga_show',compact('data_warga'));

    }


    public function edit(DataWarga $data_warga)
    {
        // halaman form edit data warga
        $desa = DataWarga::with('desa')->first(); // pemanggilan tabel data warga

        $desas = DB::table('data_desa')
        ->where('id', auth()->user()->id_desa)
        ->get();

        $kec = DB::table('data_kecamatan')
        ->where('id', auth()->user()->id_kecamatan)
        ->get();

        $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();

        $user = Auth::user();
        $kel = DataKeluarga::all();
        $dasawisma = DataKelompokDasawisma::where('id', $user->id_dasawisma)->get();
        // dd($dasawisma);
        $kader = User::with('dasawisma.rt.rw')
        ->where('id', auth()->user()->id)
        ->first();

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();

        return view('kader.data_warga.edit', compact('data_warga','desa','desas','kec', 'kel', 'kad', 'dasawisma','kader','kabupaten','provinsi'));

    }


    public function update(Request $request, DataWarga $data_warga)
    {
        // Validasi data
        $request->validate([
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
            'id_dasawisma' => 'required',
            'no_registrasi' => 'required',
            'no_ktp' => 'required|min:16',
            'nama' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'status_perkawinan' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'akseptor_kb' => 'required',
            'aktif_posyandu' => 'required',
            'ikut_bkb' => 'required',
            'memiliki_tabungan' => 'required',
            'ikut_kelompok_belajar' => 'required',
            'ikut_paud_sejenis' => 'required',
            'ikut_koperasi' => 'required',
            'berkebutuhan_khusus' => 'required',
            'makan_beras' => 'required',
            'aktivitas_UP2K' => 'required',
            'aktivitas_kesehatan_lingkungan' => 'required',
            'periode' => 'required',

        ], [
            'id_desa.required' => 'Lengkapi Alamat Desa Warga',
            'id_kecamatan.required' => 'Lengkapi Alamat Kecamatan Warga',
            'id_dasawisma.required' => 'Lengkapi Nama Dasawisma Yang Diikuti Warga',
            'no_registrasi.required' => 'Lengkapi No. Registrasi',
            'no_ktp.required' => 'Lengkapi No. KTP/NIK',
            'no_ktp.min' => 'No. KTP/NIK harus terdiri dari 16 karakter',
            'nama.required' => 'Lengkapi Nama',
            'jabatan.required' => 'Lengkapi Jabatan dalam Struktur TP PKK',
            'jenis_kelamin.required' => 'Pilih Jenis Kelamin',
            'tempat_lahir.required' => 'Lengkapi Tempat Lahir',
            'tgl_lahir.required' => 'Lengkapi Tanggal Lahir',
            'status_perkawinan.required' => 'Pilih Status Perkawinan',
            'berkebutuhan_khusus.required' => 'Pilih Berkebutuhan Khusus',
            'agama.required' => 'Pilih Agama',
            'alamat.required' => 'Lengkapi Alamat',
            'kabupaten.required' => 'Lengkapi Kabupaten',
            'provinsi.required' => 'Lengkapi Provinsi',
            'pendidikan.required' => 'Pilih Riwayat Pendidikan Warga',
            'pekerjaan.required' => 'Pilih Pekerjaan Warga',
            'akseptor_kb.required' => 'Pilih Akseptor KB Yang Diikuti Warga',
            'aktif_posyandu.required' => 'Pilih Kegiatan Aktif Posyandu',
            'ikut_bkb.required' => 'Pilih Kegiatan Mengikuti BKB (Bina Keluarga Balita)',
            'memiliki_tabungan.required' => 'Pilih Memiliki Tabungan Warga',
            'ikut_kelompok_belajar.required' => 'Pilih Kegiatan Kelompok Belajar Yang Diikuti',
            'ikut_paud_sejenis.required' => 'Pilih Kegiatan PAUD/Sejenis Yang Diikuti',
            'ikut_koperasi.required' => 'Pilih Kegiatan Koperasi Yang Diikuti',
            'makan_beras.required' => 'Pilih Makanan Pokok',
            'aktivitas_UP2K.required' => 'Pilih Aktivitas UP2K yang diikuti',
            'aktivitas_kesehatan_lingkungan.required' => 'Pilih Aktivitas Kesehatan Lingkungan yang diikuti',
            'periode.required' => 'Pilih Periode',
        ]);

        // Update data warga
        $data_warga->update($request->only([
            'id_desa',
            'id_kecamatan',
            'id_dasawisma',
            'no_registrasi',
            'no_ktp',
            'nama',
            'jabatan',
            'jenis_kelamin',
            'tempat_lahir',
            'tgl_lahir',
            'status_perkawinan',
            'agama',
            'makan_beras',
            'alamat',
            'kabupaten',
            'provinsi',
            'pendidikan',
            'pekerjaan',
            'ibu_hamil',
            'ibu_menyusui',
            'akseptor_kb',
            'aktif_posyandu',
            'ikut_bkb',
            'memiliki_tabungan',
            'ikut_kelompok_belajar',
            'ikut_paud_sejenis',
            'ikut_koperasi',
            'aktivitas_UP2K',
            'aktivitas_kesehatan_lingkungan',
            'berkebutuhan_khusus',
            'periode',
        ]));
        // dd($data_warga);

        if ($request->jenis_kelamin == 'laki-laki') {
            $data_warga['ibu_hamil'] = false;
            $data_warga['ibu_menyusui'] = false;
        }
        $data_warga->update(['is_valid' => Carbon::now()]);

        // Temukan ID keluarga terkait dengan DataWarga
        $id_keluarga = DB::table('keluarga_has_warga')
            ->where('warga_id', $data_warga->id)
            ->value('keluarga_id');

        // Periksa apakah ID keluarga ditemukan
        if ($id_keluarga) {
            // Cek status kepala keluarga sebelumnya
            $currentKepalaKeluargaId = DB::table('keluarga_has_warga')
                ->where('keluarga_id', $id_keluarga)
                ->where('status', 'kepala-keluarga')
                ->value('warga_id');

            // Jika ID kepala keluarga berubah, update nama_kepala_keluarga
            if ($currentKepalaKeluargaId == $data_warga->id) {
                DB::table('data_keluarga')
                    ->where('id', $id_keluarga)
                    ->update([
                        'nama_kepala_keluarga' => $request->nama,
                    ]);
            }
        }

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect('/data_warga');
    }

    // ini yg bener
    // public function destroy($data_warga, DataWarga $warg)
    // {
    //     //temukan id data warga
    //     $warg::find($data_warga)->delete();
    //     Alert::success('Berhasil', 'Data berhasil di Hapus');

    //     return redirect('/data_warga');

    // }

    public function destroy($data_warga, DataWarga $warg)
    {
        // Find the warga to be deleted
        $warga = $warg::find($data_warga);

        if (!$warga) {
            return redirect()->back()->withErrors(['error' => 'Warga tidak ditemukan']);
        }

        // Check if the warga is marked as a family
        if ($warga->is_keluarga != 0) {
            // If the warga is marked as a family, prevent deletion and show an error message
            Alert::error('Gagal', 'Warga terkait dengan keluarga dan tidak bisa dihapus');
        } else {
            // Delete the warga
            $warga->delete();
            Alert::success('Berhasil', 'Data berhasil dihapus');
        }

        return redirect('/data_warga');
    }



    // public function destroy($data_warga, DataWarga $warg)
    // {
    //     // Find the warga to be deleted
    //     $warga = $warg::find($data_warga);

    //     if (!$warga) {
    //         return redirect()->back()->withErrors(['error' => 'Warga tidak ditemukan']);
    //     }

    //     // Find the keluarga associated with this warga
    //     $keluargahaswarga = Keluargahaswarga::where('warga_id', $warga->id)->first();

    //     if ($keluargahaswarga) {
    //         $keluarga = DataKeluarga::find($keluargahaswarga->keluarga_id);

    //         if ($keluarga) {
    //             // If the warga is the kepala keluarga
    //             if ($keluarga->nama_kepala_keluarga == $warga->nama) {
    //                 // Check if there are other members in the keluarga
    //                 $otherMembers = Keluargahaswarga::where('keluarga_id', $keluarga->id)
    //                                 ->where('warga_id', '!=', $warga->id)
    //                                 ->get();

    //                 if ($otherMembers->isEmpty()) {
    //                     // If no other members, delete the keluarga
    //                     $keluarga->delete();
    //                 } else {
    //                     // If there are other members, promote the first other member to kepala keluarga
    //                     $newKepalaKeluarga = DataWarga::find($otherMembers->first()->warga_id);
    //                     $keluarga->nama_kepala_keluarga = $newKepalaKeluarga->nama;
    //                     $keluarga->nik_kepala_keluarga = $newKepalaKeluarga->no_ktp;
    //                     $keluarga->save();

    //                     // Update the status of the new kepala keluarga in Keluargahaswarga
    //                     $newKepalaKeluargaRelation = Keluargahaswarga::where('keluarga_id', $keluarga->id)
    //                                                                 ->where('warga_id', $newKepalaKeluarga->id)
    //                                                                 ->first();
    //                     $newKepalaKeluargaRelation->status = 'kepala-keluarga';
    //                     $newKepalaKeluargaRelation->save();
    //                 }
    //             }

    //             // Delete the Keluargahaswarga record for the deleted warga
    //             $keluargahaswarga->delete();
    //         }
    //     }

    //     // Delete the warga
    //     $warga->delete();

    //     Alert::success('Berhasil', 'Data berhasil di Hapus');
    //     return redirect('/data_warga');
    // }

    // public function destroy($data_warga, DataWarga $warg)
    // {
    //     // Find the warga to be deleted
    //     $warga = $warg::find($data_warga);

    //     if (!$warga) {
    //         return redirect()->back()->withErrors(['error' => 'Warga tidak ditemukan']);
    //     }

    //     // Find the keluarga associated with this warga
    //     $keluargahaswarga = Keluargahaswarga::where('warga_id', $warga->id)->first();

    //     if ($keluargahaswarga) {
    //         $keluarga = DataKeluarga::find($keluargahaswarga->keluarga_id);

    //         if ($keluarga) {
    //             // Jika warga adalah kepala keluarga
    //             if ($keluarga->nama_kepala_keluarga == $warga->nama) {
    //                 // Check jika ada anggota lain dalam keluarga
    //                 $otherMembers = Keluargahaswarga::where('keluarga_id', $keluarga->id)
    //                                 ->where('warga_id', '!=', $warga->id)
    //                                 ->get();

    //                 if ($otherMembers->isEmpty()) {
    //                     // Jika tidak ada anggota lain, hapus keluarga
    //                     $keluarga->delete();
    //                 } else {
    //                     // Jika ada anggota lain, promosikan anggota pertama menjadi kepala keluarga
    //                     $newKepalaKeluarga = DataWarga::find($otherMembers->first()->warga_id);
    //                     $keluarga->nama_kepala_keluarga = $newKepalaKeluarga->nama;
    //                     $keluarga->nik_kepala_keluarga = $newKepalaKeluarga->no_ktp;
    //                     $keluarga->save();

    //                     // Update status baru kepala keluarga di Keluargahaswarga
    //                     $newKepalaKeluargaRelation = Keluargahaswarga::where('keluarga_id', $keluarga->id)
    //                                                                 ->where('warga_id', $newKepalaKeluarga->id)
    //                                                                 ->first();
    //                     $newKepalaKeluargaRelation->status = 'kepala-keluarga';
    //                     $newKepalaKeluargaRelation->save();
    //                 }
    //             }
    //         }
    //     }

    //     // Hapus rumah tangga yang terkait dengan warga (jika ada)
    //     // if ($keluarga) {
    //     //     // Dapatkan ID rumah tangga terkait
    //     //     $rumahTangga = RumahTangga::where('nama_kepala_rumah_tangga', $warga->nama)->first();
    //     //     if ($rumahTangga) {
    //     //         // Hapus hubungan rumah tangga dengan keluarga
    //     //         RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)->delete();
    //     //         // Hapus rumah tangga
    //     //         $rumahTangga->delete();
    //     //     }
    //     // }

    //     // Hapus rumah tangga yang terkait dengan warga (jika ada)
    //     // Hapus rumah tangga yang terkait dengan warga (jika ada)
    //     if ($keluarga) {
    //         // Dapatkan ID rumah tangga terkait
    //         $rumahTangga = RumahTangga::where('nama_kepala_rumah_tangga', $warga->nama)->first();
    //         if ($rumahTangga) {
    //             // Hapus hubungan rumah tangga dengan keluarga
    //             RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)->delete();
    //             // Hapus rumah tangga
    //             $rumahTangga->delete();
    //         }

    //         // Periksa apakah warga ini adalah kepala keluarga dalam keluarga ini
    //         if ($keluarga->nama_kepala_keluarga == $warga->nama) {
    //             // Update status kepala keluarga di pivot table RumahTanggaHasKeluarga
    //             $rumahTanggaHasKeluarga = RumahTanggaHasKeluarga::where('keluarga_id', $keluarga->id)
    //                                                             ->where('rumahtangga_id', $rumahTangga->id)
    //                                                             ->first();
    //             if ($rumahTanggaHasKeluarga) {
    //                 $rumahTanggaHasKeluarga->status = 'kepala-rumah-tangga';
    //                 $rumahTanggaHasKeluarga->save();
    //             }

    //             // // Update nama kepala rumah tangga di tabel RumahTangga
    //             // $rumahTangga->nama_kepala_rumah_tangga = $warga->nama;
    //             // $rumahTangga->save();
    //         }
    //     }


    //     // Hapus semua hubungan keluarga dengan warga
    //     Keluargahaswarga::where('warga_id', $warga->id)->delete();

    //     // Hapus warga itu sendiri
    //     $warga->delete();

    //     Alert::success('Berhasil', 'Data berhasil dihapus');
    //     return redirect('/data_warga');
    // }


    public function warga(Request $request){
        $user = Auth::user();
        $warga = DataWarga::where('is_keluarga',false)->
        where('id_dasawisma', $user->id_dasawisma)->
        where('is_keluarga', false)->
        where('periode',now()->year)->
        get();
        return response()->json([
            'warga' => $warga
        ]);
    }
}
