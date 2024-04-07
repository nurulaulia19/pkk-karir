<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataKegiatan;
use App\Models\DataKegiatanWarga;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\DetailKegiatan;
use App\Models\KategoriKegiatan;
use App\Models\KeteranganKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataKegiatanWargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // halaman data kegiatan
        // $kegiatan=DataKegiatanWarga::all()->where('id_user', $user->id);
        $kegiatan = DataKegiatanWarga::with(['warga','kegiatan'])->get();
        // dd($kegiatan);

        return view('kader.data_kegiatan.data_kegiatan', compact('kegiatan'));
    }
    public function create()
    {
        $kegiatan = DataKegiatan::with('detail_kegiatan')->get();
        // dd($kegiatan);
        $keg = $kegiatan;
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
        $warga = DataWarga::all();
        // $keg = KategoriKegiatan::all();
        return view('kader.data_kegiatan_warga.create', compact('keg', 'warga', 'desas', 'kec', 'kad', 'kel'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:data_warga,id',
            'periode' => 'required',
            'nama_kegiatan' => 'required',

        ], [
            'id_warga.required' => 'Lengkapi Nama Warga Yang Didata',
            'nama_kegiatan.required' => 'Pilih Kegiata',
            'periode.required' => 'Pilih Periode',

        ]);
        // dd($request->all());

         foreach ($request->nama_kegiatan as $key => $item) {
            // dd($item);
            if ($item !== null && $item !== '') {
                DataKegiatanWarga::create([
                    'warga_id' => $request->id_warga,
                    'data_kegiatan_id' => $item,
                    'periode' => $request->periode,
                ]);
            }
         }
         dd(' berhasil er');



        // proses penyimpanan untuk tambah data data kegiatan warga
        // dd($request->all());
        // validasi data


        // pengkondisian tabel
            $kegiatans = new DataKegiatanWarga;
            $kegiatans->id_desa = $request->id_desa;
            $kegiatans->id_kecamatan = $request->id_kecamatan;
            $kegiatans->id_warga = $request->id_warga;
            // $kegiatans->nama_kegiatan = $request->nama_kegiatan;
            $kegiatans->id_kategori = $request->id_kategori;
            $kegiatans->id_user = $request->id_user;

            $kegiatans->aktivitas = $request->aktivitas;
            // $kegiatans->keterangan = $request->keterangan;
            $kegiatans->id_keterangan = $request->id_keterangan;
            $kegiatans->periode = $request->periode;

            // simpan data
            $kegiatans->save();

            Alert::success('Berhasil', 'Data berhasil di tambahkan');

            return redirect('/data_kegiatan');
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $kegiatan = DataKegiatan::with('detail_kegiatan')->get();
        // dd($kegiatan);
        $keg = $kegiatan;
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
        $warga = DataWarga::with('kegiatan')->where('id', $id)->first();
        // $keg = KategoriKegiatan::all();
        return view('kader.data_kegiatan_warga.edit', compact('keg', 'warga', 'desas', 'kec', 'kad', 'kel'));

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'id_warga' => 'required|exists:data_warga,id',
            'periode' => 'required',
            'nama_kegiatan' => 'required',

        ], [
            'id_warga.required' => 'Lengkapi Nama Warga Yang Didata',
            'nama_kegiatan.required' => 'Pilih Kegiata',
            'periode.required' => 'Pilih Periode',

        ]);
        // dd($request->all());

         foreach ($request->nama_kegiatan as $key => $item) {
            // dd($item);
            if ($item !== null && $item !== '') {

                $kegiatanWarga = DataKegiatanWarga::where('data_kegiatan_id', $item)->first();
                if(!$kegiatanWarga){
                    DataKegiatanWarga::create([
                        'warga_id' => $request->id_warga,
                        'data_kegiatan_id' => $item,
                        'periode' => $request->periode,
                    ]);
                }

            }
         }
         dd(' berhasil er');

    }

    public function destroy($data_kegiatan, DataKegiatanWarga $warg)
    {
        //temukan id data kegiatan warga
        $warg::find($data_kegiatan)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/data_kegiatan');



    }


    public function kegiatanDesa($id){
        $kegiatan = DataKegiatan::where('desa_id', $id)->get();

        return response()->json([
            'message' => 'success',
            'data' => $kegiatan
        ]);
    }
    public function detailKegiatan($id){
        $kegiatan = DetailKegiatan::where('kegiatan_id', $id)->get();

        return response()->json([
            'message' => 'success',
            'data' => $kegiatan
        ]);
    }

    public function deleteKegiatanWarga($id){
        $kegiatan = DataKegiatanWarga::find($id);
        if(!$kegiatan){
            return response()->json([
                'message' => 'error',
                'message' => 'nyasar'
            ]);
        }
        $kegiatan->delete();
        return redirect()->back()->with('success', 'Kegiatan deleted successfully');
    }
}
