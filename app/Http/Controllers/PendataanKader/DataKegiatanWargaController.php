<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataKegiatan;
use Illuminate\Validation\Rule;
use App\Models\DataKegiatanWarga;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\DetailKegiatan;
use App\Models\KategoriKegiatan;
use App\Models\KeteranganKegiatan;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataKegiatanWargaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $periode = $request->periode;
        // halaman data kegiatan
        // $kegiatan=DataKegiatanWarga::all()->where('id_user', $user->id);
        if ($periode) {
            $kegiatan = DataWarga::with(['kegiatan.kegiatan'])->
            where('periode', $periode)->
            where('is_kegiatan', true)->where('id_dasawisma', $user->id_dasawisma)->orderBy('id', 'DESC')->get();
        } else {
            $kegiatan = DataWarga::with(['kegiatan.kegiatan'])->
            where('periode', now()->year)->
            where('is_kegiatan', true)->where('id_dasawisma', $user->id_dasawisma)->orderBy('id', 'DESC')->get();
            $periode = now()->year;
        }

        $dataPeriode = Periode::all();
        $nowYear = now()->year;
        // dd($kegiatan);
        return view('kader.data_kegiatan_warga.index', compact('kegiatan','dataPeriode','nowYear','periode', 'user'));
    }
    public function create()
    {
        $kegiatan = DataKegiatan::all();
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
        // $warga = DataWarga::all();
        $user = Auth::user();
        // $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
        //     ->where('is_kegiatan', false)
        //     ->get();
        $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
            ->where('is_kegiatan', false)
            ->where('is_valid', '!=', 0)
            ->where('periode', now()->year)
            ->get();
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
            'nama_kegiatan.required' => 'Pilih Kegiatan',
            'periode.required' => 'Pilih Periode',

        ]);

        $namaKegiatanValues = $request->nama_kegiatan;
        if (count($namaKegiatanValues)!== count(array_unique($namaKegiatanValues))) {
            return redirect()->back()->withErrors(['nama_kegiatan' => 'Kegiatan tidak boleh sama']);
        }
         foreach ($request->nama_kegiatan as $key => $item) {
            // dd($item);
            if ($item !== null && $item !== '') {
                DataKegiatanWarga::create([
                    'warga_id' => $request->id_warga,
                    'data_kegiatan_id' => $item,
                    'periode' => $request->periode,
                    'is_valid' => now()
                ]);
            }
         }

         // Set is_kegiatan menjadi true untuk data warga yang terkait
            $dataWarga = DataWarga::find($request->id_warga);
            if ($dataWarga) {
                $dataWarga->is_kegiatan = true;
                $dataWarga->save();
            }

            if (count($request->nama_kegiatan) !== count(array_unique($request->nama_kegiatan))) {
                return redirect()->back()->withErrors(['nama_kegiatan' => 'Kegiatan tidak boleh sama']);
            }

            Alert::success('Berhasil', 'Data berhasil di tambahkan');
            return redirect('/data_kegiatan');
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $kegiatan = DataKegiatan::get();
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
        $dataKegiatan = DataKegiatanWarga::get();
        $warga = DataWarga::with('kegiatan')->where('id', $id)
        ->where('is_kegiatan', true)
        ->first();
        if(!$warga){
            return redirect()->route('not-found')->with('error', 'Data warga tidak ditemukan');
        }
        // $keg = KategoriKegiatan::all();
        return view('kader.data_kegiatan_warga.edit', compact('dataKegiatan', 'keg', 'warga', 'desas', 'kec', 'kad', 'kel'));

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'id_warga' => 'required|exists:data_warga,id',
            'periode' => 'required',
            'nama_kegiatan' => 'required|array', // Pastikan ini diubah menjadi array karena akan menerima banyak nilai
        ], [
            'id_warga.required' => 'Lengkapi Nama Warga Yang Didata',
            'nama_kegiatan.required' => 'Pilih Kegiata',
            'periode.required' => 'Pilih Periode',
        ]);

        $dataWarga = DataWarga::find($request->id_warga);
        if (!$dataWarga->is_valid) {
            return redirect()
                ->back()
                ->withErrors(['warga_id' => 'Data warga belum divalidasi.'])
                ->withInput();
        }
        if ($dataWarga) {
            $dataWarga->is_kegiatan = true;
            $dataWarga->save();
        }

        // Check for duplicate values in nama_kegiatan array
        if (count($request->nama_kegiatan) !== count(array_unique($request->nama_kegiatan))) {
            return redirect()->back()->withErrors(['nama_kegiatan' => 'Kegiatan tidak boleh sama']);
        }
        // Mencari data kegiatan warga yang sudah ada
        $existingKegiatanWarga = DataKegiatanWarga::where('warga_id', $request->id_warga)->get();

        // Menghapus data kegiatan warga yang sudah ada
        DataKegiatanWarga::where('warga_id', $request->id_warga)->delete();

        // Memasukkan kembali data kegiatan warga sesuai permintaan yang baru
        foreach ($request->nama_kegiatan as $key => $item) {
            if ($item !== null && $item !== '') {
                DataKegiatanWarga::create([
                    'warga_id' => $request->id_warga,
                    'data_kegiatan_id' => $item,
                    'periode' => $request->periode,
                    'is_valid' => now()
                ]);
            }
        }



        Alert::success('Berhasil', 'Data berhasil diperbarui');
        return redirect('/data_kegiatan');
    }




    // public function destroy($id)
    // {
    //     // dd($id);
    //     //temukan id data kegiatan warga
    //     // $warg::find($data_kegiatan)->delete();
    //     $warga =  DataWarga::find($id);
    //     foreach($warga->kegiatan as $kegiatan){
    //         $kegiatan->delete();
    //     }
    //     Alert::success('Berhasil', 'Data berhasil di Hapus');

    //     return redirect('/data_kegiatan');

    public function destroy($id)
    {
        // Temukan DataWarga berdasarkan ID
        $warga = DataWarga::find($id);

        // Periksa apakah DataWarga ditemukan
        if (!$warga) {
            return redirect()->back()->with('error', 'Data warga tidak ditemukan');
        }

        // Loop melalui semua kegiatan yang terkait dengan DataWarga
        foreach ($warga->kegiatan as $kegiatan) {
            $kegiatan->delete();
        }

        // Periksa apakah DataWarga masih memiliki kegiatan terkait setelah penghapusan
        $isKegiatan = $warga->kegiatan()->exists();

        // Jika tidak ada lagi kegiatan terkait, atur is_kegiatan pada DataWarga menjadi false
        if (!$isKegiatan) {
            $warga->is_kegiatan = false;
            $warga->save();
        }

        // Hapus DataWarga jika perlu
        // $warga->delete(); // Uncomment ini jika Anda ingin menghapus DataWarga setelah semua kegiatannya dihapus

        Alert::success('Berhasil', 'Data berhasil di hapus');
        // Redirect kembali dengan pesan sukses
        return redirect('/data_kegiatan')->with('success', 'Data kegiatan berhasil dihapus');
    }

    public function kegiatanDesa($id){
        // $kegiatan = DataKegiatan::where('desa_id', $id)->get();
        $kegiatan = DataKegiatan::all();

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
        $wargaId = $kegiatan->warga_id;
        $kegiatan->delete();

        $kegiatanKu = DataKegiatanWarga::where('warga_id',$wargaId)->first();
        if(!$kegiatanKu){
            $warga = DataWarga::find($wargaId);
            $warga->is_kegiatan = false;
            $warga->save();
            Alert::success('Berhasil', 'Data berhasil di hapus');
            return redirect('/data_kegiatan')->with('success', 'Kegiatan deleted successfully');
        }



        Alert::success('Berhasil', 'Data berhasil di hapus');
        return redirect('/data_kegiatan/'.$wargaId.'/edit')->with('success', 'Kegiatan deleted successfully');

        // return redirect('/data_kegiatan')->with('success', 'Kegiatan deleted successfully');
    }



}
