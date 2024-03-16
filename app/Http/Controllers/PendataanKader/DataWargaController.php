<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataDasaWisma;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
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
        // dd($user);

        //halaman data warga
        // $warga=DataWarga::all()->where('id_user', $user->id);
        $warga=DataWarga::where('id_dasawisma',$user->id)->get();
        // dd($warga);

        $dasawisma = DataKelompokDasawisma::all();

        return view('kader.data_kegiatan.data_warga', compact('warga', 'dasawisma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     // nama desa yang login
    //  $user = Auth::user();
    //  dd($user);
    $rt = [];
    $rw = [];
    for ($i=1; $i < 30; $i++) {
        $rt[] =  $i;
        $rw[] = $i;
    }

     $desas = DB::table('data_desa')
     ->where('id', auth()->user()->id_desa)
     ->get();


     $kec = DB::table('data_kecamatan')
     ->where('id', auth()->user()->id_kecamatan)
     ->get();

     $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();
        $kader = DB::table('users')
        ->where('id', auth()->user()->id)
        ->first();

     $kel = DataKeluarga::all();
     $dasawisma = DataKelompokDasawisma::all();
    //  dd($dasawisma);

     return view('kader.data_kegiatan.form.create_data_warga', compact('desas', 'kader', 'kec', 'kel', 'kad', 'dasawisma','rt','rw'));

 }

 public function store(Request $request)
{

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
        // Pesan error validasi disesuaikan dengan kebutuhan
    ]);

    // cek apakah no_ktp sudah ada
    $existingWarga = DataWarga::where('no_ktp', strtoupper($request->no_ktp))->first();
    if ($existingWarga) {
        return redirect('/data_warga')->with('error', 'Gagal! Data tidak berhasil ditambahkan. No. KTP sudah terdaftar.');
    }

    $fillable = (new DataWarga)->getFillable(); // Mendapatkan kolom yang dapat diisi dari model

    // Penambahan kolom yang baru
    $fillable[] = 'pasangan_usia_subur';
    $fillable[] = 'tiga_buta';
    $fillable[] = 'ibu_hamil';
    $fillable[] = 'ibu_menyusui';

    $data = $request->only($fillable); // Mengambil hanya data yang ada di kolom yang dapat diisi

    // Memeriksa apakah status keluarga adalah 'kepala keluarga', jika ya, maka set status anggota keluarga menjadi 'kepala keluarga'
    // $data['status_anggota_keluarga'] = $request->status_keluarga == 'kepala keluarga' ? 'kepala keluarga' : $request->status_anggota_keluarga;

    // Simpan data
    $warga = DataWarga::create($data);

    return redirect('/data_warga')->with('success', 'Data berhasil ditambahkan.');
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
         // nama desa yang login
        // $desas = DB::table('data_desa')->get();
        // $kec = DB::table('data_kecamatan')->get();
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

        return view('kader.data_kegiatan.form.edit_data_warga', compact('data_warga','desa','desas','kec', 'kel', 'kad', 'dasawisma'));

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
        $warga = DataWarga::all();
        return response()->json([
            'warga' => $warga
        ]);
    }
}
