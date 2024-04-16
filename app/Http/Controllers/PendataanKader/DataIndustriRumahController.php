<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\DataIndustriRumah;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\KategoriIndustriRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;

class DataIndustriRumahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // halaman data industri rumah tangga
    //    $user = Auth::user();

    //     $industri = DataIndustriRumah::all()->where('id_user', $user->id);
       $industri = DataIndustriRumah::with('warga')->get();
       return view('kader.data_industri_rumah_tangga.index', compact('industri'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       // halaman form tambah data industri rumah tangga
    // nama desa yang login
    $desas = DB::table('data_desa')
    ->where('id', auth()->user()->id_desa)
    ->get();
    // $kec = DB::table('data_kecamatan')->get();
    $kec = DB::table('data_kecamatan')
    ->where('id', auth()->user()->id_kecamatan)
    ->get();

    $kad = DB::table('users')
    ->where('id', auth()->user()->id)
    ->get();

    $user = Auth::user();
    $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
     ->where('is_industri_rumah_tangga', false)
     ->get();
    // $kel = DataKeluarga::all(); // pemanggilan tabel data warga
    // $katin = KategoriIndustriRumah::all(); // pemanggilan tabel data kategori industri rumah tangga
    // $data['kategori'] = [
    //     'Pangan' => 'Pangan',
    //     'Konveksi' => 'Konveksi',
    //     'Sandang' => 'Sandang',
    //     'Jasa' => 'Jasa',
    //     'Lain-lain' => 'Lain-lain',
    // ];

    return view('kader.data_industri_rumah_tangga.create', compact('kec','desas', 'warga', 'kad'));

}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
   public function store(Request $request)
   {
       // proses penyimpanan untuk tambah data data industri rumah tangga
       // dd($request->all());
       // validasi data
       $request->validate([
           'warga_id' => 'required',
           'id_desa' => 'required',
           'id_kecamatan' => 'required',
        //    'id_user' => 'required',
           'nama_kategori' => 'required',
           'komoditi' => 'required',
           'volume' => 'required',
           'periode' => 'required',
       ], [
            'id_desa.required' => 'Lengkapi Alamat Desa Industri Rumah Tangga Warga Yang Didata',
            'id_kecamatan.required' => 'Lengkapi Alamat Kecamatan Industri Rumah Tangga Warga Yang Didata',
            'warga_id.required' => 'Lengkapi Nama Warga Yang Didata',
            'nama_kategori.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
            'komoditi.required' => 'Lengkapi Komoditi Industri Rumah Tangga Warga',
            'volume.required' => 'Lengkapi Volume Industri Rumah Tangga Warga',
            'periode.required' => 'Pilih Periode',

       ]);

       // pengkondisian tabel
       $insert=DB::table('data_industri_rumah')->where('warga_id', $request->warga_id)->first();
       if ($insert != null) {
           Alert::error('Gagal', 'Data Tidak Berhasil Di Tambah. Warga TP PKK Sudah Ada ');

           return redirect('/data_industri');
       }
       else {
           $industris = new DataIndustriRumah();
           $industris->id_desa = $request->id_desa;
           $industris->id_kecamatan = $request->id_kecamatan;
           $industris->warga_id = $request->warga_id;
        //    $industris->id_user = $request->id_user;
           $industris->nama_kategori = $request->nama_kategori;
           $industris->komoditi = $request->komoditi;
           $industris->volume = $request->volume;
           $industris->periode = $request->periode;

           // simpan data
           $industris->save();

           $warga = DataWarga::find($request->warga_id);
           if ($warga) {
                $warga->is_industri_rumah_tangga = true;
                $warga->save();
            }

           Alert::success('Berhasil', 'Data berhasil di tambahkan');

           return redirect('/data_industri');
           }
   }

   /**
    * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
       //halaman form edit data industri rumah tangga
    //    $kel = DataKeluarga::all();
       $data_industri = DataIndustriRumah::with('warga')->find($id);
    //    $katins = KategoriIndustriRumah::all();
        // $data['kategori'] = [
        //     'Pangan' => 'Pangan',
        //     'Konveksi' => 'Konveksi',
        //     'Sandang' => 'Sandang',
        //     'Jasa' => 'Jasa',
        //     'Lain-lain' => 'Lain-lain',
        // ];

       $desas = DB::table('data_desa')
       ->where('id', auth()->user()->id_desa)
       ->get();
       // $kec = DB::table('data_kecamatan')->get();
       $kec = DB::table('data_kecamatan')
       ->where('id', auth()->user()->id_desa)
       ->get();

       $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();
       // dd($kel);

       return view('kader.data_industri_rumah_tangga.edit', compact('data_industri', 'kec', 'desas', 'kad'));

   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
       // proses mengubah untuk data industri rumah tangga
       // dd($request->all());
       // validasi data
       $request->validate([
        'warga_id' => 'required',
        'id_desa' => 'required',
        'id_kecamatan' => 'required',
        'nama_kategori' => 'required',
        'komoditi' => 'required',
        'volume' => 'required',
        'periode' => 'required',

    ], [
         'id_desa.required' => 'Lengkapi Alamat Desa Industri Rumah Tangga Warga Yang Didata',
         'id_kecamatan.required' => 'Lengkapi Alamat Kecamatan Industri Rumah Tangga Warga Yang Didata',
         'warga_id.required' => 'Lengkapi Nama Warga Yang Didata',
         'nama_kategori.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
         'komoditi.required' => 'Lengkapi Komoditi Industri Rumah Tangga Warga',
         'volume.required' => 'Lengkapi Volume Industri Rumah Tangga Warga',
         'periode.required' => 'Pilih Periode',

    ]);
    // update data
    $data_industri = DataIndustriRumah::find($id);

    if (!$data_industri) {
        // Jika data tidak ditemukan
        Alert::error('Error', 'Data tidak ditemukan.');
        return Redirect::back()->withInput();
    }

    // Memperbarui data pemanfaatan berdasarkan input request
    $data_industri->update($request->all());

    // Menampilkan notifikasi sukses
    Alert::success('Berhasil', 'Data berhasil diubah.');
    return redirect('/data_industri');

   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
       //temukan id data industri rumah tangga warga
    //    $inds::find($data_industri)->delete();
        $industri = DataIndustriRumah::with('warga')->find($id);
        $warga = DataWarga::find($industri->warga->id);
        $warga->is_industri_rumah_tangga = 0;
        $warga->save();
        $industri->delete();
       Alert::success('Berhasil', 'Data berhasil di Hapus');

       return redirect('/data_industri');



   }
}
