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
       $user = Auth::user();
    //    $industri = DataIndustriRumah::with('warga')->where('id', $user->id_dasawisma)->get();

        $industri = DataKeluarga::with('industri')->where('id_dasawisma', $user->id_dasawisma)->where('industri_id' ,'!=' , "0")->get();
        // dd($industri);
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
    // $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
    //  ->where('is_industri_rumah_tangga', false)
    //  ->get();

    $kateagoriIndustri = KategoriIndustriRumah::all();

   $warga = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
     ->where('industri_id', 0)
     ->get();

    return view('kader.data_industri_rumah_tangga.create', compact('kateagoriIndustri','kec','desas', 'warga', 'kad'));

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
    //    dd($request->all());
       // validasi data
       $request->validate([
           'warga_id' => 'required',
           'nama_kategori' => 'required'
       ], ['warga_id.required' => 'Lengkapi Nama Warga Yang Didata',
            'nama_kategori.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
       ]);

       $keluarga = DataKeluarga::find($request->warga_id);
       $keluarga->industri_id = $request->nama_kategori;
       $keluarga->save();
       return redirect('/data_industri');

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
    $user = Auth::user();
    // $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
    //  ->where('is_industri_rumah_tangga', false)
    //  ->get();

    $kateagoriIndustri = KategoriIndustriRumah::all();

    $keluarga = DataKeluarga::find($id);
    //    dd($warga);

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

       return view('kader.data_industri_rumah_tangga.edit', compact('keluarga','kateagoriIndustri', 'kec', 'desas', 'kad'));

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
    // dd($id);
    $request->validate([
        'keluarga_id' => 'required',
        'nama_kategori' => 'required'
    ], ['keluarga_id.required' => 'Lengkapi Nama Warga Yang Didata',
         'nama_kategori.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
    ]);
    // dd($request->all());

    $keluarga = DataKeluarga::find($id);
    $keluarga->industri_id = $request->nama_kategori;
    $keluarga->save();
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

      return redirect('/data_industri');



  }

   public function destroyz($id)
   {
       //temukan id data industri rumah tangga warga
    //    $inds::find($data_industri)->delete();
        // $industri = DataIndustriRumah::with('warga')->find($id);
        // $warga = DataWarga::find($industri->warga->id);
        // $warga->is_industri_rumah_tangga = 0;
        // $warga->save();
        // $industri->delete();
        $keluarga = DataKeluarga::find($id);
        $keluarga->industri_id = 0;
        $keluarga->save();
       Alert::success('Berhasil', 'Data berhasil di Hapus');

       return redirect('/data_industri');



   }
}
