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
use App\Models\Rw;
use App\Models\User;
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
    public function index()
    {
        $user = Auth::user();
        $warga=DataWarga::where('id_dasawisma', $user->id_dasawisma)->get();

        $dasawisma = DataKelompokDasawisma::all();

        return view('kader.data_warga.index', compact('warga', 'dasawisma'));
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
     $dasawisma = DataKelompokDasawisma::all();
     $kabupaten = DataKabupaten::first();
     $provinsi = DataProvinsi::first();

     return view('kader.data_warga.create', compact('desas', 'kader', 'kec', 'kel', 'kad', 'dasawisma','kabupaten','provinsi'));

 }

    // public function store(Request $request)
    // {
    //     // Validasi data
    //     $request->validate([
    //         // Kolom lainnya...
    //         'aktivitas_UP2K' => 'required|boolean',
    //         'aktivitas_kesehatan_lingkungan' => 'required|boolean',
    //     ], [
    //         // Pesan error validasi disesuaikan dengan kebutuhan
    //     ]);



    //     // Proses penyimpanan data
    //     $data = $request->only([
    //         'id_desa',
    //         'id_kecamatan',
    //         'id_dasawisma',
    //         'no_registrasi',
    //         'no_ktp',
    //         'nama',
    //         'jabatan',
    //         'jenis_kelamin',
    //         'tempat_lahir',
    //         'tgl_lahir',
    //         'status_perkawinan',
    //         'agama',
    //         'alamat',
    //         'kabupaten',
    //         'provinsi',
    //         'pendidikan',
    //         'pekerjaan',
    //         'akseptor_kb',
    //         'aktif_posyandu',
    //         'ikut_bkb',
    //         'memiliki_tabungan',
    //         'ikut_kelompok_belajar',
    //         'ikut_paud_sejenis',
    //         'ikut_koperasi',
    //         'periode',
    //         'berkebutuhan_khusus',
    //         'makan_beras',
    //         'provinsi',
    //         'aktivitas_UP2K',
    //         'aktivitas_kesehatan_lingkungan',
    //     ]);

    //     // Menambahkan kolom yang baru
    //     $data['pasangan_usia_subur'] = $request->pasangan_usia_subur === '1' ? true : false;
    //     // $data['tiga_buta'] = $request->tiga_buta === '1' ? true : false;
    //     $data['ibu_hamil'] = $request->ibu_hamil === '1' ? true : false;
    //     $data['ibu_menyusui'] = $request->ibu_menyusui === '1' ? true : false;
    //     $data['aktivitas_UP2K'] = $request->aktivitas_UP2K === '1' ? true : false;;
    //     $data['aktivitas_kesehatan_lingkungan'] = $request->aktivitas_kesehatan_lingkungan === '1' ? true : false;;

    //     // Simpan data
    //     $warga = DataWarga::create($data);

    //     return redirect('/data_warga')->with('success', 'Data berhasil ditambahkan.');
    // }

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
            'periode' => 'required',
            'berkebutuhan_khusus' => 'required',
            'makan_beras' => 'required',
            'provinsi' => 'required',
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
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
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
            'provinsi' => $request->provinsi,
            'aktivitas_UP2K' => $request->aktivitas_UP2K,
            'aktivitas_kesehatan_lingkungan' => $request->aktivitas_kesehatan_lingkungan,
        ];

        // Simpan data menggunakan model
        $warga = DataWarga::create($data);

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

        $kel = DataKeluarga::all();
        $dasawisma = DataKelompokDasawisma::all();
        $kader = User::with('dasawisma.rt.rw')
        ->where('id', auth()->user()->id)
        ->first();

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();

        return view('kader.data_warga.edit', compact('data_warga','desa','desas','kec', 'kel', 'kad', 'dasawisma','kader','kabupaten','provinsi'));

    }


    public function update(Request $request, DataWarga $data_warga)
    {
        // proses mengubah untuk tambah data pendidikan
        // dd($request->all());
        // validasi data
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
            'periode' => 'required',

        ], [
            'id_desa.required' => 'Lengkapi Alamat Desa Warga',
            'id_kecamatan' => 'Lengkapi Alamat Kecamatan Warga',
            'id_dasawisma.required' => 'Lengkapi Nama Dasawisma Yang Diikuti Warga',
            // 'id_keluarga.required' => 'Lengkapi Nama Kepala Rumah Tangga',
            'no_registrasi.required' => 'Lengkapi No. Registrasi',
            'no_ktp.required' => 'Lengkapi No. KTP/NIK',
            'nama.required' => 'Lengkapi Nama',
            'jabatan.required' => 'Lengkapi Jabatan dalam Struktur TP PKK',
            'jenis_kelamin.required' => 'Pilih Jenis Kelamin',
            'tempat_lahir.required' => 'Lengkapi Jumlah Tempat Lahir',
            'tgl_lahir.required' => 'Lengkapi Tanggal Lahir',
            // 'umur.required' => 'Lengkapi Umur',
            'status_perkawinan.required' => 'Pilih Status Perkawinan',
            // 'status_keluarga.required' => 'Pilih Status Keluarga',
            'agama.required' => 'Pilih Agama',
            'alamat.required' => 'Lengkapi Alamat',
            'kabupaten.required' => 'Lengkapi kabupaten',
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
            'periode.required' => 'Pilih Periode',

        ]);

        // update data
            $data_warga->update($request->all());
            Alert::success('Berhasil', 'Data berhasil di ubah');
            // dd($jml_kader);
            return redirect('/data_warga');

    }


    public function destroy($data_warga, DataWarga $warg)
    {
        //temukan id data warga
        $warg::find($data_warga)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/data_warga');

    }

    public function warga(){
        $warga = DataWarga::where('is_keluarga',false)->get();
        return response()->json([
            'warga' => $warga
        ]);
    }
}
