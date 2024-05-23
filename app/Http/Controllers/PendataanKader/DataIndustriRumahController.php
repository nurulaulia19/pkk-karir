<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\DataIndustriRumah;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\KategoriIndustriRumah;
use App\Models\Periode;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
       // halaman data industri rumah tangga
       $user = Auth::user();
       $periode = $request->periode;

    //    $industri = DataIndustriRumah::with('warga')->where('id', $user->id_dasawisma)->get();
        if ($periode) {
            $industri = DataKeluarga::with('industri')
            ->where('periode', $periode)
            ->where('id_dasawisma', $user->id_dasawisma)->where('industri_id' ,'!=' , "0")->get();

        } else {
            $industri = DataKeluarga::with('industri')
            ->where('periode', now()->year)
            ->where('id_dasawisma', $user->id_dasawisma)->where('industri_id' ,'!=' , "0")->get();

        }
        $dataPeriode = Periode::all();

        // dd($industri);
       return view('kader.data_industri_rumah_tangga.index', compact('industri','dataPeriode'));
   }


   public function create()
   {
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

    $kategoriIndustri = KategoriIndustriRumah::all();

    //    $keluarga = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
    //      ->where('industri_id', 0)
    //      ->get();
    $keluarga = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
    ->where('industri_id', 0)
    ->where('is_valid', '!=', 0)
    ->where('periode', now()->year)
    ->get();

    return view('kader.data_industri_rumah_tangga.create', compact('kategoriIndustri','kec','desas', 'keluarga', 'kad'));

}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
   public function store(Request $request)
   {
       $request->validate([
           'keluarga_id' => 'required',
           'kategori_industri_rumah_id' => 'required'
       ], ['keluarga_id.required' => 'Lengkapi Nama Warga Yang Didata',
            'kategori_industri_rumah_id.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
       ]);


        $keluarga = DataKeluarga::find($request->keluarga_id);
        $keluarga->industri_id = $request->kategori_industri_rumah_id;
        $keluarga->is_valid_industri = Carbon::now();
        $keluarga->save();

        //tambahan
        // DataIndustriRumah::create([
        //     'id_desa' => $request->id_desa,
        //     'id_kecamatan' => $request->id_kecamatan,
        //     'keluarga_id' => $request->keluarga_id,
        //     'kategori_industri_rumah_id' => $request->kategori_industri_rumah_id,
        //     'periode' => $request->periode,
        //     'is_valid' => $request->is_valid,
        //     // Add other necessary fields here
        // ]);
        Alert::success('Berhasil', 'Data berhasil di Tambah');
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
    $user = Auth::user();
    $kategoriIndustri = KategoriIndustriRumah::all();
    $keluarga = DataKeluarga::find($id);

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

       return view('kader.data_industri_rumah_tangga.edit', compact('keluarga','kategoriIndustri', 'kec', 'desas', 'kad'));

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
        'kategori_industri_rumah_id' => 'required'
    ], ['keluarga_id.required' => 'Lengkapi Nama Warga Yang Didata',
         'kategori_industri_rumah_id.required' => 'Pilih Kategori Industri Rumah Tangga Warga',
    ]);
    // dd($request->all());

    $keluarga = DataKeluarga::find($id);
    $keluarga->industri_id = $request->kategori_industri_rumah_id;
    $keluarga->is_valid_industri = Carbon::now();

    $keluarga->save();

    $dataIndustriRumah = DataIndustriRumah::where('keluarga_id', $id)->first();

    if ($dataIndustriRumah) {
        // Update the DataIndustriRumah record
        $dataIndustriRumah->id_desa = $request->id_desa;
        $dataIndustriRumah->id_kecamatan = $request->id_kecamatan;
        $dataIndustriRumah->kategori_industri_rumah_id = $request->kategori_industri_rumah_id;
        $dataIndustriRumah->periode = $request->periode;
        $dataIndustriRumah->is_valid = $request->is_valid;
        // Update other necessary fields here
        $dataIndustriRumah->save();
    }
    Alert::success('Berhasil', 'Data berhasil di Ubah');
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
    $keluarga = DataKeluarga::find($id);

    if ($keluarga) {
        // Update the industri_id of DataKeluarga record
        $keluarga->industri_id = 0;
        $keluarga->save();

        // Find and delete the corresponding DataIndustriRumah records
        DataIndustriRumah::where('keluarga_id', $id)->delete();

        // Display a success alert
        Alert::success('Berhasil', 'Data berhasil dihapus');
    } else {
        // Handle the case where the DataKeluarga record is not found
        Alert::error('Gagal', 'Data Keluarga tidak ditemukan');
    }

        // Redirect to the specified route
        return redirect('/data_industri');
  }


//    public function destroyz($id)
//    {
//         $keluarga = DataKeluarga::find($id);
//         $keluarga->industri_id = 0;
//         $keluarga->save();
//        Alert::success('Berhasil', 'Data berhasil di Hapus');

//        return redirect('/data_industri');
//    }

}
